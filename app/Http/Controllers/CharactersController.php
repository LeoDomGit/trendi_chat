<?php

namespace App\Http\Controllers;

use App\Models\Characters;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CharactersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'seed' => 'nullable|string|max:255',
            'assistant_id' => 'required|string|max:255',
            'assistant_intro' => 'nullable|string',
            'slug' => 'nullable|string|max:255',  // Allow slug to be nullable
            'opening_greeting' => 'nullable|string',
            'avatar' => 'nullable|string',
            'is_public' => 'required|integer|in:0,1', // 0 or 1
            'is_active' => 'required|integer|in:0,1', // 0 or 1
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get all the data from the request
        $data = $request->all();

        // Generate the slug if it's not provided
        $data['slug'] = $data['slug'] ?: Str::slug($data['fullname']);

        // Store the character in the database
        $character = Characters::create([
            'fullname' => $data['fullname'],
            'seed' => $data['seed'],
            'assistant_id' => $data['assistant_id'],
            'assistant_intro' => $data['assistant_intro'],
            'slug' => $data['slug'],
            'id_lover_type' => $data['id_lover_type'],
            'opening_greeting' => $data['opening_greeting'],
            'avatar' => $data['avatar'],
            'is_public' => $data['is_public'],
            'is_active' => $data['is_active'],
        ]);

        return response()->json([
            'message' => 'Character created successfully!',
            'character' => $character,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Charaters  $charaters
     * @return \Illuminate\Http\Response
     */
    public function show(Characters $Characters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Characters  $Characters
     * @return \Illuminate\Http\Response
     */
    public function edit(Characters $Characters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Characters  $Characters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Characters $Characters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Characters  $Characters
     * @return \Illuminate\Http\Response
     */
    public function destroy(Characters $Characters)
    {
        //
    }
}
