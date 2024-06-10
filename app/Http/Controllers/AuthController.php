<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|max:255',
            'password'  => 'required|string'
          ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $permissions = $user->getAllPermissions();
        $roles = $user->getRoleNames();
        return response()->json([
            'message' => 'Login success',
            'data' =>$user,
        ]);
    }


       /** 
    * register user
    * @param Request $request
    * @return user
    */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),
            [
                'name' =>'required|string|max:255',
                'email' =>'required|string|email|max:255|unique:users,email',
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'validator' => 'validator error',
                    'error' => $validator->errors()
                ], 401);            
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' =>  Hash::make($request->password),
                'remember_token' => Str::random(20),
            ]);
            
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ],201);
        }catch(\Throwable $th){
            return response()->json([
               'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
        
    }
}
