<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Auth;
use Illuminate\Http\Request;
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['check'=>false,'msg'=>$validator->errors()->first()]);
        }
        $conversations = Conversation::create([
            'user_id' =>  Auth::id(),
            'name' => 'New Chat',
            'model'=>$request->model,
        ]);
        $conversations = Conversation::where('user_id', Auth::id())->get();
        return response()->json(['check' => true, 'data' => $conversations]);
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
