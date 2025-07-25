<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $validatedData = $request->validate([
            // 'name' => 'required|max:55',
            // 'email' => 'email|required|unique:users',
            // 'password' => 'required|confirmed'
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'date_of_birth' => 'required|before:13 years ago',
            'password' => 'required|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response(['success' => false, 
                'message' => 'Validation failed',
                'reponse' => $validator->errors()]);
        }

        $validatedData = $request->only(['name', 'email', 'date_of_birth', 'password']);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['success' => true, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response(['success' => false, 'message' => 'Validation failed',
                'reponse' => $validator->errors()]);
        }

        if (!auth()->attempt($request->only(['email', 'password']))) {
            return response(['success' => false, 'message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['success' => true, 'message' => 'Success', 
            'access_token' => $accessToken]);

    }
}
