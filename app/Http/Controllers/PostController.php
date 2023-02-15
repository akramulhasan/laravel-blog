<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function editPost(Post $post, Request $request){
        $incomingFields = $request-> validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return back()->with('success', 'Post successfully updated');
    }
    public function showEditForm(Post $post){
        return view('edit-post', ['post'=>$post]);
    }
    public function delete(Post $post){
        $post->delete();
        return redirect('/profile/'.auth()->user()->username)->with('success','Post successfully deleted');   
     }
    public function createPostForm(){
        return view('create-post-form');
    }

    public function storePost(Request $request){
        // $incomingFields = $request-> validate([
        //     'title' => 'required',
        //     'body' => 'requried'
        // ]);

        $incomingFields = $request-> validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success','New post successfully created');
    }

    public function singlePost(Post $post){
        return view('single-post', ['post'=>$post]);
    }
}
