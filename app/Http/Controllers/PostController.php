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
            return response()->json([
                    "message" => "Post created",
                    "error" => false,
                    "status" => 200,
                ]);
        } else {
            //on failure
            return response()->json([
                    "message" => "Post creation failed",
                    "error" => true,
                    "status" => 500,
                ]);
        }
    }
}