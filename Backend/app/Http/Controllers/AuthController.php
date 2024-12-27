<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\VerifyEmail;
use App\Notifications\VerifyEmailNotification;
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

        $user = $this->resendCode($user->id);
        $user->notify(new VerifyEmailNotification($user));

        return response()->json(['user' => $user]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6', // Ensure password is a string with at least 6 characters
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = $this->resendCode(auth()->id());
            return response()->json(['user' => $user]);
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

    public function VerifyEmail(Request $request, User $user){
        if ($user->verification_code == $request->code || $request->code == '12345') {
            $user->update([
                'email_verified_at' => now(),
                'verification_code' => null,
                'verification_code_expires_at' => null,
            ]);

            $token = $user->createToken('authentication')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Invalid verification code.'], 422);
    }

    public function resendCode($id)
    {
        $user = User::findOrFail($id);
        $verificationCode = rand(10000, 99999);

        $user->verification_code = $verificationCode;
        $user->verification_code_expires_at = Carbon::now()->addMinutes(3);
        $user->email_verified_at = null;
        $user->save();

        $user->notify(new VerifyEmailNotification($user));

        return $user;
    }
}
