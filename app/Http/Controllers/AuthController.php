<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Login user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login success"),
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string'
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

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

       /**
 * @OA\Get(
 *     path="/me",
 *     summary="Get current user details",
 *     tags={"User"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
 *         )
 *     )
 * )
 */


    public function index(Request $request)
    {
        $user = $request->user();
        $permissions = $user->getAllPermissions();
        $roles = $user->getRoleNames();
        return response()->json([
            'message' => 'Login success',
            'data' => $user,
        ]);
    }
     /**
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User created successfully"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="object")
     *         )
     *     )
     * )
     */

    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'password' => 'nullable|string|min:8',
                ]
            );

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
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Logout user",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     )
     * )
     */
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
     /**
     * @OA\Post(
     *     path="/forgot-password",
     *     summary="Forgot password",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset link sent",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="passwords.sent")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'data' => [
                    'message' => __($status)
                ]
            ]);
        } else {
            // Random new password
            $OTP = Str::random(5);

            // update the password with the new password
            $user = User::where('email', $request->email)->firstOrFail();

            $newUser = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'OTP' => $OTP,
                'email_verified_at' => now(),
                'password' => $user->password,
                'remember_token' => $user->remember_token,
                'updated_at' => now(),
                'created_at' => $user->created_at,
            ];

            $user->update($newUser);

            $email = $user->email;

            $toEmail = $email;
            $message = 'Your password has been reset';
            $subject = 'Here is your new password';

            $response = Mail::to($toEmail)->send(new WelcomeEmail($message,$subject));
            dd($response);

            return response()->json([
                'data' => [
                    'message' => 'Please check your email to get your new password',
                    'New Password' => $OTP
                ]
            ]);

        }
    }
     /**
     * @OA\Post(
     *     path="/confirm-password",
     *     summary="Confirm code for password reset",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"confirm_code"},
     *             @OA\Property(property="confirm_code", type="string", example="12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Code confirmed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Code not matched",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function comfirmCode(Request $request){
        try{
            $confirm_code = $request->confirm_code;
            $user = User::where('OTP',$confirm_code)->firstOrFail();
            return response()->json(['token' => $user->createToken('API TOKEN')->plainTextToken]);
        }catch (\Throwable) {
            return response()->json([
                'status' => false,
                'error' => 'Your code is not matches'
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/reset-password",
     *     summary="Reset password",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"new_password", "confirm_password"},
     *             @OA\Property(property="new_password", type="string", example="newpassword123"),
     *             @OA\Property(property="confirm_password", type="string", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Your password has been reset")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Password not matched",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function resetPassword(Request $request){
        try{
            if($request->new_password === $request->confirm_password){
                $user_id = Auth()->user()->id;
                $user = User::find($user_id);
                $user->update(['password' => Hash::make($request->new_password)]);
                return response()->json([
                   'status' => true,
                   'message' => 'Your password has been reset'
                ]);
            }
        }catch(\Throwable $e){
            return response()->json([
                'status' => false,
                'message' => 'Your password not match'
             ]);
        };
    }
}
