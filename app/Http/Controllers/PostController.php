<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    
    //Post creation
    public function createPost(Request $req) {
        $this->validate($req, [
            "userId" => ["required", "numeric"],
            "title" => "required",
            "content" => "required"
        ]);

        $newPost = new Post;
        $newPost->title = $req->title;
        $newPost->content = $req->content;
        $newPost->user_id = $req->userId;

        $result = $newPost->save();
        if($result) {
            //on success
            return onResponse([
                "message" => "Post created",
                "error" => false,
                "status" => 200,
            ], $newPost);
        } else {
            //on failure
            return onResponse([
                    "message" => "Post creation failed",
                    "error" => true,
                    "status" => 500,
            ], []);
        }
    }

    //updating post
    public function updatePost(Request $req)
    {
        $this->validate($req, [
            "postId" => ["required", "numeric"],
            "userId" => ["required", "numeric"]
        ]);

        //request should have "title" and "content", but it's not necessary.
        $post = Post::where("id", $req->postId)->where("user_id", $req->userId)->first();
        // dd($post);
        if(!empty($post)) {
            if(strlen($req->title.$req->content) > 0) {
                if(strlen($req->title) > 0) {
                    $post->title = $req->title;
                }
                if(strlen($req->content) > 0) {
                    $post->content = $req->content;
                }
                $post->save();

                return onResponse([
                    "message" => "Post updated",
                    "error" => false,
                    "status" => 200
                ], $post);
            } else {
                return onResponse([
                    "message" => "No title and content received",
                    "error" => true,
                    "status" => 402
                ], []);
            }
        } else {
            return onResponse([
                    "message" => "This post does not exist",
                    "error" => true,
                    "status" => 404
                ], []);
        }
    }


}
