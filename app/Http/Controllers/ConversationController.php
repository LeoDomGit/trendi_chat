<?php

namespace App\Http\Controllers;

use App\Models\Characters;
use App\Models\Conversation;
use App\Models\Messages;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['check'=>false,'msg'=>$validator->errors()->first()]);
        }
        $conversation = Conversation::where('user_id', Auth::id())->where('model',$request->model)->get();
        if(count($conversation)==0){
            Conversation::create([
                'user_id' =>  Auth::id(),
                'name' => 'New Chat',
                'model'=>$request->model,
            ]);

        }
        $conversations = Conversation::where('model',$request->model)->where('user_id', Auth::id())->get();
        return response()->json($conversations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function send_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id', // Ensure conversation exists
            'content' => 'required|string',  // User's message content
        ]);

        if ($validator->fails()) {
            return response()->json([
                'check' => false,
                'msg' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Retrieve the conversation
            $conversation = Conversation::find($request->conversation_id);

            if (!$conversation) {
                return response()->json([
                    'check' => false,
                    'msg' => 'Invalid conversation ID.'
                ], 404);
            }

            // User message
            $userMessage = [
                'role' => 'user',
                'content' => $request->content,
            ];

            // Prepare messages for the conversation
            $previousMessages = Messages::where('room_id', $conversation->id)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($message) {
                    return [
                        'role' => $message->character_id ? 'assistant' : 'user',
                        'content' => $message->message,
                    ];
                })->toArray();

            // Append the new message
            $messages = array_merge($previousMessages, [$userMessage]);

            // Call the ChatGPT API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (!isset($data['choices'][0]['message']['content'])) {
                    return response()->json([
                        'check' => false,
                        'msg' => 'Invalid response from ChatGPT API.',
                    ], 500);
                }

                // Extract assistant's reply
                $assistantMessage = $data['choices'][0]['message']['content'];

                // Save user's message
                Messages::create([
                    'room_id' => $conversation->id,
                    'character_id' => null, // Null for user messages
                    'message' => $request->content,
                    'is_read' => 1,
                    'sort' => 0,
                ]);

                // Save assistant's reply
                Messages::create([
                    'room_id' => $conversation->id,
                    'character_id' => $conversation->assistant_id ?? null, // Use assistant ID if available
                    'message' => $assistantMessage,
                    'is_read' => 0,
                    'sort' => 1,
                ]);
                $data=Messages::where('room_id',$conversation->id)->get();
                // Return the assistant's reply
                return response()->json([
                    'check' => true,
                    'data' => $data,
                ]);
            } else {
                // Log API error
                \Log::error('ChatGPT API error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return response()->json([
                    'check' => false,
                    'msg' => 'Failed to communicate with ChatGPT. Please try again later.',
                ], 500);
            }
        } catch (\Exception $e) {
            // Log unexpected error
            \Log::error('Error sending message', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'check' => false,
                'msg' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assistant_id' => 'required|exists:characters,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()], 422);
        }

        try {
            $assistant=Characters::where('id',$request->assistant_id)->first();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'OpenAI-Beta' => 'assistants=v2',
            ])->post('https://api.openai.com/v1/threads/runs', [
                "assistant_id" => $assistant->assistant_id,
                "thread" => [
                    "messages" => [
                        ["role" => "user", "content" => $assistant->instructions]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $apiData = $response->json();
                $conversation = Conversation::create([
                    'user_id' =>1,
                    'name' => 'New Chat',
                    'assistant_id' =>  $assistant->assistant_id,
                    'thread_id' => $apiData['thread_id'],
                    'run_id' => $apiData['id'] ?? null,
                    'last_message_at' => now(),
                    'is_active' => 1,
                ]);
                $conversations = Conversation::where('user_id', 1)->get();

                return response()->json(['check' => true, 'data' => $conversations]);
            } else {
                // Log and return API error response
                \Log::error('Failed to create OpenAI thread', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return response()->json([
                    'check' => false,
                    'msg' => 'Failed to create OpenAI thread. Please try again later.',
                ], 500);
            }
        } catch (\Exception $e) {
            // Log and handle unexpected exceptions
            \Log::error('Error creating conversation', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'check' => false,
                'msg' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conversation $conversation,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ], [
            'name.required' => 'Chưa có tên của chat box',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }
        $conversation = Conversation::find($id);
        if(!$conversation){
            return response()->json(['check' => false, 'msg' => 'Không tìm thấy cuộc trò chuyện']);
        }
        $conversation->name = $request->name;
        $conversation->updated_at = now();
        $conversation->save();
        $conversations = Conversation::where('user_id', Auth::id())->get();
        return response()->json(['check' => true, 'data' => $conversation,'conversations'=>$conversations]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
