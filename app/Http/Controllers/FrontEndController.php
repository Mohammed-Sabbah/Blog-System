<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FrontEndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(){
        $posts = Post::all();
        return view('frontend.home' , compact('posts'));
    }

    public function make_post(Request $request){
        $validator = validator($request->all() ,[
            'text'=> 'required|string|min:3',
        ]);

        if ( ! $validator->fails()){
            $post = new Post();
            $post->text = $request->get('text');
            $post->user_id = Auth::id();

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
}
