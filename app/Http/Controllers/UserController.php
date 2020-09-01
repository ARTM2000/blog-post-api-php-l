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
            return onResponse([
                    "message" => "User created",
                    "error" => false,
                    "status" => 200,
            ], $newUser);
        } else {
            return onResponse([
                    "message" => "User creation failed",
                    "error" => true,
                    "status" => 500
            ], []);
        }
    }

    //Get users post by id
    public function getUserPost(Request $req) {
        $this->validate($req, [
            "userId" => "required"
        ]);

        $userId = $req->userId;

        $user = User::find($userId);

        if ($user != null) {
            $posts = $user->posts;
            return onResponse(
                [
                    "message" => "Posts sent",
                    "status" => 200,
                    "error" => false
                ], $posts);
        } else {
            return onResponse(
                [
                    "message" => "user id is not exist",
                    "status" => 404,
                    "error" => false
                ], []);
        }
    }


}
