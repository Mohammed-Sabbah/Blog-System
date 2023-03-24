<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::all();
        return view('admin.posts.index' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users =User::all();
        return view('admin.posts.create' , compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all() ,[
            'user_id' => 'required|string',
            'text'=> 'required|string|min:3',

        ]);

        if ( ! $validator->fails()){
            $post = new Post();
            $post->text = $request->get('text');
            $post->user_id = $request->get('user_id');

            $saved = $post->save();

            return response()->json([
                'message'=> $saved ? 'Post created successfully' : 'Post creating failed',
                'icon'=>$saved ?'success':'error'
            ],$saved ?Response::HTTP_OK : Response::HTTP_BAD_REQUEST );
        }
        else{
            return response()->json([
                'message'=> $validator->getMessageBag()->first()
            ] , Response::HTTP_BAD_REQUEST );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $users = User::all();
        return view('admin.posts.edit', compact('post','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = validator($request->all() ,[
            'user_id' => 'required|string',
            'text'=> 'required|string|min:3',

        ]);

        if ( ! $validator->fails()){

            $post->text = $request->get('text');
            $post->user_id = $request->get('user_id');

            $saved = $post->save();

            return response()->json([
                'message'=> $saved ? 'Post created successfully' : 'Post creating failed',
                'icon'=>$saved ?'success':'error'
            ],$saved ?Response::HTTP_OK : Response::HTTP_BAD_REQUEST );
        }
        else{
            return response()->json([
                'message'=> $validator->getMessageBag()->first()
            ] , Response::HTTP_BAD_REQUEST );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $deleted = $post -> delete();
        return response()->json([
            'message' => $deleted ? 'Post Deleted Successfully' : 'Post deleting failed',
            'icon' => $deleted ? 'success' : 'error'
        ],$deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);

    }
}
