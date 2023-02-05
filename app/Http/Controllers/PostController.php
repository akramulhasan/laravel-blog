<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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