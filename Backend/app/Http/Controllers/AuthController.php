<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request){
        $data = $request->all();
        $validated = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|string|email|unique:users,email',
            'phone' => ['nullable', 'regex:/^(?:\+88)?01[3-9]\d{8}$/'],  // BD phone validation
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/',  // Password with at least one lowercase, uppercase, and special character
            ],
        ]);

        $hashedPassword = Hash::make($request->password);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $hashedPassword,
        ]);

        $token = $user->createToken('authentication')->plainTextToken;

        $verificationCode = rand(10000, 99999);

        // Store the verification code and set expiration (3 minutes)
        $user->verification_code = $verificationCode;
        $user->verification_code_expires_at = Carbon::now()->addMinutes(3);
        $user->save();

        $user->notify(new VerifyEmail($user));

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Login user
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6', // Ensure password is a string with at least 6 characters
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            if ($user) {
                $token = $user->createToken('authentication')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'token' => $token,
                ]);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No authenticated user found'
        ], 401);
    }
}
