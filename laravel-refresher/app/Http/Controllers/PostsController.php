<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;

class PostsController extends Controller
{

    // private $posts = [
    //     1 => [
    //         'title' => 'Intro to Laravel',
    //         'content' => 'This is a short intro to Laravel',
    //         'is_new' => true,
    //         'has_comments' => true
    //     ],
    //     2 => [
    //         'title' => 'Intro to PHP',
    //         'content' => 'This is a short intro to PHP',
    //         'is_new' => false
    //     ],
    // ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return view('posts.index', ['posts' => $this->posts]);
        return view('posts.index', ['posts' => BlogPost::all()]);
        //using query builder
        //return view('posts.index', ['posts' => BlogPost::orderBy('created_at', 'desc')->take(5)->get()]); //take limits number of items
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request)
    {
       // dd($request);
       //validation
    //    $request->validate([
    //     'title' => 'bail|required|min:5|max:100',
    //     'content' => 'required|min:10'
    //    ]);
       
    //using a request class for validation
    $validated =  $request->validated();
    $post = BlogPost::create($validated);


    //    $post = new BlogPost();
    //    $post->title = $validated['title'];
    //    $post->content = $validated['content'];
    //    $post->save();

       $request->session()->flash('status', 'The blog post was created');

       return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       // abort_if(!isset($this->posts[$id]) , 404); 
        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, string $id)
    {
        $post = BlogPost::findOrFail($id); //check if model with the given id exists
        $validated = $request->validated(); //validated data
        $post->fill($validated); //apply new input data to the model
        $post->save(); //used to save and update models
        $request->session()->flash('status', 'Blog post was updated'); //display flash messages
        return redirect()->route('posts.show', ['post' => $post->id]);//redirect to the updated post page, ['post' => $post->id] - newly created post with id
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //dd($id);
        $post = BlogPost::findOrFail($id);//get model instance of the id to delete
        $post->delete();//call delete method
        session()->flash('status', 'Blog post was deleted');//show flash messages
        return redirect()->route('posts.index'); //redirect to list of all posts
    }
}
