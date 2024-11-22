<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Characters;
use App\Models\Conversation;
use App\Models\Messages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

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
            return response()->json(['status'=>false,'msg'=>$validator->errors()->first()]);
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
    private function create_thread()
    {
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/threads', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' .  env('OPENAI_API_KEY'),
                'OpenAI-Beta'   => 'assistants=v2'
            ],
            'body' => ''
        ]);

        Log::debug($response->getBody());

        return json_decode($response->getBody());
    }

    private function add_message_to_thread($thread_id, $message)
    {
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/threads/' . $thread_id . '/messages', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'OpenAI-Beta'   => 'assistants=v2'
            ],
            'json' => [
                'role' => 'user',
                'content' => $message
            ]
        ]);

        return json_decode($response->getBody());
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
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }
        // Retrieve the conversation
        $conversation = Conversation::where('id',$request->conversation_id)->first();

        if (!$conversation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid conversation ID.',
            ], 404);
        }
        if (!$conversation->thread_id) {
            // Create a new thread if not existing
            $thread_id = $this->create_thread();

            $conversation->thread_id = $thread_id->id;
            $conversation->save();
        }

        // Add the user's message to the thread
        $this->add_message_to_thread($conversation->thread_id, $request->content);
        // Trigger AI response
        $run_ai = $this->run_assistant($conversation->assistant_id, $conversation->thread_id);
        sleep(2);

        // Retrieve messages from the thread
        $messages = $this->list_message_in_thread($conversation->thread_id);

        while ($messages[0]->role != 'assistant' || empty($messages[0]->content)) {
            sleep(2);
            $messages = $this->list_message_in_thread($conversation->thread_id);
        }

        if ($messages[0]->role == 'assistant') {
            // Save user's message
            Messages::create([
                'room_id' => $conversation->id,
                'character_id' => null, // Null for user messages
                'message' => $request->content,
                'is_read' => 1,
                'sort' => 0,
            ]);

            // Save assistant's message
            $assistant_message_content = $messages[0]->content[0]->text->value;
            Messages::create([
                'room_id' => $conversation->id,
                'character_id' => $conversation->assistant_id ?? null, // Use assistant ID if available
                'message' => $assistant_message_content,
                'is_read' => 0,
                'sort' => 1,
            ]);

            // Update conversation's last message and timestamp
            $conversation->last_message = substr($assistant_message_content, 0, 30);
            $conversation->last_message_at = now();
            $conversation->save();

            // Return response with the assistant's message
            $message = [
                'message' => $assistant_message_content,
                'created_at' => \Carbon\Carbon::parse(now())->toISOString(),
                'is_lover' => 1,
                'is_image' => 0,
                'image_url' => '',
            ];

            return response()->json(['status' => 'success', 'message' => $message]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve assistant response.',
        ], 500);
    }

    private function run_assistant($assistant_id, $thread_id) {
        $character = Characters::where('assistant_id', $assistant_id)->first();
        if($character->assistant_intro) {
           $introduction = $character->assistant_intro;
        } else {
            $introduction = "Your name is ". $character->fullname ." , a ". $character->introduction.". ";
            if ($character->conversational) {
                $introduction .= "Your conversational style is ". $character->conversational .". ";
            }
            $introduction .= "Your answer is limited to 30 words.";
        }
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/threads/' . $thread_id . '/runs', [
            'headers' => [
                'Authorization' => 'Bearer ' .  env('OPENAI_API_KEY'),
                'Content-Type'  => 'application/json',
                'OpenAI-Beta'   => 'assistants=v2'
            ],
            'json' => [
                'assistant_id' => $character->assistant_id,
                'instructions' => $introduction,
                'model' => 'gpt-4o-mini',
            ]
        ]);

        return json_decode($response->getBody());
    }
        /**
     * Store a newly created resource in storage.
     */
    private function list_message_in_thread($thread_id) {
        $client = new Client();
        $response = $client->get('https://api.openai.com/v1/threads/' . $thread_id . '/messages', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' .env('OPENAI_API_KEY'),
                'OpenAI-Beta'   => 'assistants=v2'
            ],
        ]);

        return json_decode($response->getBody())->data;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function getRoom(Request $request){
        $conversations = Conversation::where('user_id', Auth::id())->get();
        return response()->json(['status' => 'success', 'data' => $conversations]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function getMessages($id){
        $id_user=Auth::id();
        $conversation = Conversation::where('id',$id)->where('user_id',$id_user)->first();
        if(!$conversation){
            return response()->json(['status'=>'error','message'=>'Not Found'],404);
        }
        $messages=Messages::where('room_id',$id)->get();
        return response()->json($messages);
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
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()], 422);
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
                    'user_id' =>Auth::id(),
                    'name' => 'New Chat',
                    'assistant_id' =>  $assistant->assistant_id,
                    'thread_id' => $apiData['thread_id'],
                    'run_id' => $apiData['id'] ?? null,
                    'last_message_at' => now(),
                    'is_active' => 1,
                ]);
                $conversations = Conversation::where('user_id', Auth::id())->get();

                return response()->json(['status' => 'success', 'data' => $conversations]);
            } else {
                // Log and return API error response
                \Log::error('Failed to create OpenAI thread', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return response()->json([
                    'status' => false,
                    'msg' => 'Failed to create OpenAI thread. Please try again later.',
                ], 500);
            }
        } catch (\Exception $e) {
            // Log and handle unexpected exceptions
            \Log::error('Error creating conversation', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
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
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        }
        $conversation = Conversation::find($id);
        if(!$conversation){
            return response()->json(['status' => false, 'msg' => 'Không tìm thấy cuộc trò chuyện']);
        }
        $conversation->name = $request->name;
        $conversation->updated_at = now();
        $conversation->save();
        $conversations = Conversation::where('user_id', Auth::id())->get();
        return response()->json(['status' => 'success', 'data' => $conversation,'conversations'=>$conversations]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
