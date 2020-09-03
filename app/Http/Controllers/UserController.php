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
        $userPassword = password_hash($req->password, PASSWORD_DEFAULT);
        $newUser->password = $userPassword;
            
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

    //Verify user for login
    public function verifyUser(Request $req)    
    {
        $this->validate($req, [
            "email" => ["email", "required"],
            "password" => ["min:8", "required"]
        ]);

        $user = User::where("email", $req->email)->first();
        // dd($user->email);
        if(password_verify($req->password, $user->password)) {
            return onResponse([
                    "message" => "User verified",
                    "error" => false,
                    "status" => 200
            ], [
                "userId" => $user->id,
                "name" => $user->name
            ]);
        } else {
            return onResponse([
                    "message" => "User verification failed",
                    "error" => true,
                    "errorMessage" => ["Password is not correct"],
                    "status" => 403
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
