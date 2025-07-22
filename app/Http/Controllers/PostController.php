<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ]);
        Post::create([
        'title'   => $request->title,
        'content' => $request->content,
        'file' => $request->file,
        'user_id' => Auth::id(), 

    ]);
        return redirect()->route('posts.index');
        
        $file = $request->file('file');
        $fileName = time().$file->getClientOriginalName();
        $file->storeAs('ulploads', $fileName, 'public');
        return redirect()->back()->with('status', 'file uploaded successfully');
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
