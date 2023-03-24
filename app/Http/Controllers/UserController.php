<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return view('admin.users.index' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'name' => 'required|string|unique:users|min:3|max:30',
            'password'=> 'required|string|min:3',
            'cover'=> 'nullable|image|mimes:png,jpg'
        ]);

        if ( ! $validator->fails()){
            $user = new User();
            $user->name = $request->get('name');
            $user->password = Hash::make($request->get('password'));
            if ($request->has('cover')){
                $image = $request->file('cover');
                $imageName = time() . $user->name .'.'.$image->getClientOriginalExtension();
                $image->storePubliclyAs('users',$imageName , ['disk'=>'public']);
                $user->cover =$imageName;
            }
            $saved = $user->save();

            return response()->json([
                'message'=> $saved ? 'user created successfully' : 'user creating failed',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return \response(view('admin.users.edit' , compact('user')));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all() ,[
            'name' => "required|string|unique:users,name,$id,id|min:3|max:30",
            'cover'=> 'nullable|image|mimes:png,jpg'
        ]);

        if ( ! $validator->fails()){
            $user = User::find($id);
            $user->name = $request->get('name');
            if ($request->has('cover')){
                $image = $request->file('cover');
                $imageName = time() . $user->name .'.'.$image->getClientOriginalExtension();
                $image->storePubliclyAs('users',$imageName , ['disk'=>'public']);
                $user->cover =$imageName;
            }
            $saved = $user->save();

            return response()->json([
                'message'=> $saved ? 'user Updated successfully' : 'user Updating failed',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        Storage::disk('public')->delete(["users/$user->cover"]);
        $deleted = $user -> delete();
        return response()->json([
            'message' => $deleted ? 'User Deleted Successfully' : 'User deleting failed',
            'icon' => $deleted ? 'success' : 'error'
        ],$deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);

    }
}
