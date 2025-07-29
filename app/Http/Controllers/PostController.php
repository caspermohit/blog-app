<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\CreatePostEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Events\PostCreated; 

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    
    {
    try{
        $posts = Post::all();  
        return view('posts.index', compact('posts'));

        
    }
    catch(\Throwable $th)
    {
            return response()->view('errors.404', ['message' => 'Posts not found'], 404);
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('posts.create');  
            
            
        }
        catch(\Throwable $th)
        {
                return response()->view('errors.404', ['message' => 'Post not created'], 404);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post,)
    {
        try{
        //$this->authorize('create', Post::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',

        ]);
        $filepath = $request->file('file')->store('uploads' , 'public');
        $post = Post::create([
            'title'   => $request->title,
            'content' => $request->content,
            'file' => $filepath,
            'user_id' => Auth::id(), 
        ]);
        
        // Fire the PostCreated event
        event(new PostCreated($post, Auth::user()));
        
        Mail::to(Auth::user()->email)->send(new CreatePostEmail($post));    
        return redirect()->route('posts.index');
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Post not created'], 404);
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
    {  try{ 
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));

    }
    catch(\Throwable $th)
    {
        return response()->view('errors.404', ['message' => 'Post not found'], 404);
    }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,Post $post)
    {
        try{
            $this->authorize('update', $post); // Check if allowed
            $post->update($request->only('title', 'content'));
            return redirect()->route('posts.index');
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Post not updated'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Post $post)
    {
        try{
            $this->authorize('delete', $post); // Check if allowed
            $post->delete();
            return redirect()->route('posts.index');
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'You are not authorized to delete this post'], 404);
        }
    }
}
