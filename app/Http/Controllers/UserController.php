<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function fetchAllUsers(){
        try{

            $users = User::all();

            return response([
                'user' => $users
            ],Response::HTTP_OK);


        }catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }

    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $res = $user->save();

            return response()->json($res, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            $email = $request['email'];
            $user = User::where('email', $email)->firstOrFail();

            $credentials = $request->only('email', 'password');


            if (Auth::attempt($credentials)) {

                if ($user) {
                    $token = $user->createToken('UserAuthentication')->plainTextToken;
                    return response([
                        'success' => true,
                        'message' => 'User logged in successfully',
                        'token' => $token,
                        'user' => $user
                    ],Response::HTTP_OK);
                } else {
                    Auth::logout(); 
                    return response([
                        'success' => false,
                        'message' => 'Please verify your email before logging in.'
                    ], 401);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
