<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    // Creating User by name and email and password
    public function createUser(Request $req) {
        $this->validate($req, [
            "name" => "required",
            "email" => ["email", "required"],
            "password" => ["min:8", "required"]
        ]);

        $newUser = new User;
        $newUser->name = $req->name;
        $newUser->email = $req->email;
        $newUser->password = $req->password;
            
        $result = $newUser->save();
        if($result) {
            return response()->json([
                    "message" => "User created",
                    "error" => false,
                    "status" => 200,
                    "user" => $newUser
                ]);
        } else {
            return response()->json([
                    "message" => "User creation failed",
                    "error" => true,
                    "status" => 500
            ]);
        }
    }

    //Get users post by id
    public function getUserPost(Request $req) {
        $this->validate($req, [
            "userId" => "required"
        ]);

        $userId = $req->userId;
        $user = User::find($userId);
        $posts = $user->posts;
        if ($posts) {
            return response()->json([
                "data" => $posts,
                "message" => "Posts sent",
                "status" => 200,
                "error" => false
            ]);
        } else {
            return response()->json([
                "message" => "Posts not found",
                "status" => 404,
                "error" => false
            ]);
        }
    }

    
}
