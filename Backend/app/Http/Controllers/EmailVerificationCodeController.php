<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class VerificationCodeController extends Controller
{

    public function verify(Request $request)
    {

        $validated = $request->validate([
            'verification_code' => 'required|numeric|digits:5',
        ]);

        $user = User::findOrFail($request->user_id);


        if ($user->verification_code != $request->verification_code) {
            return redirect()->back()->withErrors(['verification_code' => 'Invalid verification code.']);
        }


        if (Carbon::now()->gt($user->verification_code_expires_at)) {
            return redirect()->back()->withErrors(['verification_code' => 'Verification code has expired.']);
        }


        $user->email_verified_at = Carbon::now();
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();

        return redirect()->route('home')->with('success', 'Your email has been successfully verified!');
    }
}
