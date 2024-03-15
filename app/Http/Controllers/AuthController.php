<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Add
use App\Models\User;
// Response makes us able to make a custom response.
use Illuminate\Http\Response;
// So we can hash the password
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
        - When we need to make request in protected routes:
            * We need to go to Authorization.
            * Make the type (Bearer Token).
            * Paste the token in the Token input.
    */

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            // Unique to user table and email field.
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        /* 
            - Creating a token to user.
            - createToken param could be any custom name.
            - The (->plainTextToken) will fetch the plain text only (createToken will return more than just the plain text). 
        */ 
        $token = $user->createToken('myapptoken')->plainTextToken;

        // The custom response.
        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds',
                401
            ]);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        // The custom response.
        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    public function logout() {
        // Thats will destroy the token so it will be useless.
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
