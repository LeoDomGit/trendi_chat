<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Conversation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $validator = Validator::make(request()->all(), [
            'model'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['check'=>false,'msg'=>$validator->errors()->first()]);
        }
        $userId = Auth::id();
        $conversation = Conversation::where('user_id', $userId)->orderBy('created_at', 'desc')->firstOrCreate(['user_id' => $userId]);
        $conversations= Conversation::where('user_id',$userId)->get();
        $chat=Chat::where('conversation_id',$conversation->id)->get()->toArray();
        $this->conversation = $conversation;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required',
            'content' => 'required',
        ], [
            'conversation_id.required' => 'Chưa có tên của chat box',
            'content.required' => 'Chưa có tên của chat box',

        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }
        $data=$request->all();
        if($request->has('sender_id')){
            $data['sender_id']= Auth::id();
        }
        $data['created_at']=now();
        Chat::create($data);
        $data=Chat::where('conversation_id',$data['conversation_id'])->get();
        return response()->json(['check' => true, 'data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $conversation = Chat::where('conversation_id', $id)->orderBy('created_at', 'asc')->get();
        return response()->json($conversation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
