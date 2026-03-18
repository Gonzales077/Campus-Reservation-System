<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\GmailService;

class LoginController extends Controller
{
    protected $gmailService;

    public function __construct(GmailService $gmailService)
    {
        $this->gmailService = $gmailService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $otp = rand(100000, 999999);

            session([
                '2fa_user_id' => $user->id,
                '2fa_otp' => $otp,
                '2fa_expires_at' => now()->addMinute(),
            ]);

            $recipientEmail = $user->gmail_address ?? $user->email;
            $user->email = $recipientEmail;
            $this->gmailService->sendOtpEmail($user, $otp);

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('login.otp.view');
        }

        return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric|digits:6']);

        if (now()->gt(session('2fa_expires_at'))) {
            return response()->json(['success' => false, 'message' => 'OTP expired. Please login again.'], 422);
        }

        if ($request->otp == session('2fa_otp')) {
            $user = User::find(session('2fa_user_id'));
            Auth::login($user);
            $request->session()->regenerate();
            session()->forget(['2fa_user_id', '2fa_otp', '2fa_expires_at']);

            $url = $user->isAdmin() ? route('admin.dashboard') : route('user.dashboard');
            return response()->json(['success' => true, 'redirect' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid verification code.'], 422);
    }

    public function resendOtp()
    {
        if (!session()->has('2fa_user_id')) return redirect()->route('login');

        $user = User::find(session('2fa_user_id'));
        $otp = rand(100000, 999999);

        session([
            '2fa_user_id' => $user->id,
            '2fa_otp' => $otp,
            '2fa_expires_at' => now()->addMinute(),
        ]);

        $user->email = $user->gmail_address ?? $user->email;
        $this->gmailService->sendOtpEmail($user, $otp);

        return back()->with('toast_success', 'A new verification code has been sent.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}