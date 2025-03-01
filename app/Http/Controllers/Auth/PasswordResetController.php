<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Notifications\OtpNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use DB;

class PasswordResetController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
            }

            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Save OTP and expiry time
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10)
            ]);

            // Send OTP notification
            $user->notify(new OtpNotification($otp));

            Log::info('OTP sent successfully to: ' . $request->email);

            return redirect()->route('password.verify-otp', ['email' => $request->email])
                ->with('status', 'We have sent an OTP to your email address.');

        } catch (\Exception $e) {
            Log::error('Error sending OTP: ' . $e->getMessage());
            return back()->withErrors(['email' => 'There was an error sending the OTP. Please try again.']);
        }
    }

    public function showVerifyOtpForm(Request $request)
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Clear OTP
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        // Generate reset token and store it
        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email])
            ->with('status', 'Please set your new password.');
    }

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            // Find user first
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return back()->withErrors(['email' => 'User not found.']);
            }

            // Verify the reset token
            $tokenData = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (!$tokenData || !Hash::check($request->token, $tokenData->token)) {
                return back()->withErrors(['email' => 'Invalid password reset token.']);
            }

            // Update password directly
            $password = Hash::make($request->password);
            $user->update([
                'password' => $password,
                'remember_token' => Str::random(60),
            ]);

            // Log in the user immediately
            auth()->login($user);

            // Fire the password reset event
            event(new PasswordReset($user));

            // Clear any reset tokens
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->delete();

            if (auth()->check()) {
                return redirect()->route('matches.index')
                    ->with('status', 'Password has been reset successfully.');
            }

            return back()->withErrors(['email' => 'Could not log in after password reset.']);
        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'An error occurred while resetting your password.']);
        }
    }
}
