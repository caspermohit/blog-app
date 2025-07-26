<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\CreatePostEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();  
        return view('posts.index', compact('posts'));

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');    
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post,)
    {
        //$this->authorize('create', Post::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',

        ]);
        $filepath = $request->file('file')->store('uploads' , 'public');
        Post::create([
        'title'   => $request->title,
        'content' => $request->content,
        'file' => $filepath,
        'user_id' => Auth::id(), 
    ]);
        Mail::to(Auth::user()->email)->send(new CreatePostEmail($post));    
        return redirect()->route('posts.index');
        
        
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
       return "view not found";
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
        $this->authorize('update', $post); // Check if allowed
        $post->update($request->only('title', 'content'));
          return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Post $post)
    {
        $this->authorize('delete', $post); // Check if allowed
        $post->delete();
        return redirect()->route('posts.index');
    }
}
