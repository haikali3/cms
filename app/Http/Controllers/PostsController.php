<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return view('posts.index')->with('posts', Post::all());
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    return view('posts.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CreatePostRequest $request) {
    // upload the image to storage
    $image = $request->image->store('posts');

    // create the post
    Post::create([
      'title'        => $request->title,
      'description'  => $request->description,
      'content'      => $request->content,
      'image'        => $image,
      'published_at' => $request->published_at,
    ]);

    // flash message
    session()->flash('success', 'Post created succesfully.');

    // redirect user
    return redirect(route('posts.index'));
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Post $post) {
    return view('posts.create')->with('post', $post);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdatePostRequest $request, Post $post) {

    $data = $request->only(['title', 'description', 'published_at', 'content']);
    //check if new image
    if ($request->hasFile('image')) {
      //upload it
      $image = $request->image->store('posts');
      //delete old one
      Storage::delete($post->image);

      $data['image'] = $image;
    }

    //update attribute
    $post->updated($data);

    //flash message
    session()->flash('success', 'Post updated successfully.');

    //redirect user to original screen
    return redirect(route('posts.index'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id) {
    $post = Post::withTrashed()->where('id', $id)->firstOrFail();

    if ($post->trashed()) {
      Storage::delete($post->image);
      $post->forceDelete();
    } else {
      $post->delete();
    }

    session()->flash('success', 'Post deleted succesfully.');

    return redirect(route('posts.index'));
  }

  public function trashed(Post $post) {
    $trashed = Post::withTrashed()->get();

    return view('posts.index')->with('posts', $trashed);
  }
}
