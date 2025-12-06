<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;

class PostViewController
{
    public function view(Request $request, Post $post)
    {
       $data = [
           'ip' => $request->ip(),
           'user_id' => $request->user()->id,
           'post_id' => $post->id,
       ];

       if (!PostView::query()->where([
           ['ip' , $request->ip()],
           ['user_id' , $request->user()->id],
           ['post_id' , $post->id]
       ])->exists()) {
           $postView = new PostView();
           $postView->user_id = $data['user_id'];
           $postView->post_id = $data['post_id'];
           $postView->ip = $data['ip'];
           $postView->save();

           return response()->json([], 201);
       }
    }
}
