<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\OTP;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $otp = 121212;//rand(100000, 999999);
        $email = $request->email;

        OTP::create([
            'email' => $email,
            'otp' => $otp,
            'created_at' => now(),
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        try {
            Mail::to($email)->send(new OTPMail($otp));
            return response()->json(['message' => 'OTP sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send OTP'], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $otpRecord = OTP::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if ($otpRecord) {
            // Check if the user already exists
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Register the user

                if (!$user) {
                    // Register the user
                    $user = User::create([
                        'email' => $request->email,
                        'name' => 'Default Name', // Replace with actual name if available
                        'password' => bcrypt('defaultpassword'), // Replace with actual password if available
                        // Add other necessary fields here
                    ]);
                }

            }

            // Log the user in
            Auth::login($user);

            return response()->json(['message' => 'OTP verified successfully, user logged in']);
        }

        return response()->json(['message' => 'Invalid or expired OTP'], 400);
    }
}