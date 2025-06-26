<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Member;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show Sign Up Form
    public function showSignUpForm()
    {
        return view('auth.sign_up');
    }

    // Show Sign In Form  
    public function showSignInForm()
    {
        return view('auth.sign_in');
    }

    // Show Forgot Password Form
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    // Show Token Verification Form
    public function showTokenVerificationForm()
    {
        return view('auth.verify_token');
    }

    // Show Reset Password Form (Only after token verification)
    public function showResetPasswordForm(Request $request)
    {
        // Get token and email from session (after verification)
        $token = session('verified_token');
        $email = session('verified_email');
        
        if (!$token || !$email) {
            return redirect()->route('verify.token.form')
                ->withErrors(['token' => 'Please verify your reset token first.']);
        }

        return view('auth.reset_password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Cek apakah email sudah ada di tabel users atau members
        $emailExistsInUsers = User::where('email', $request->email)->exists();
        $emailExistsInMembers = Member::where('email', $request->email)->exists();
        
        // Check username in both tables
        $usernameExistsInUsers = User::where('username', $request->username)->exists();
        $usernameExistsInMembers = Member::where('username', $request->username)->exists();

        if ($emailExistsInUsers || $emailExistsInMembers) {
            return back()->withErrors(['email' => 'Email sudah terdaftar.']);
        }

        if ($usernameExistsInUsers || $usernameExistsInMembers) {
            return back()->withErrors(['username' => 'Username sudah digunakan.']);
        }

        // Logic pemisahan berdasarkan email
        if (str_starts_with($request->email, 'admin@')) {
            // Registrasi sebagai Admin (ke tabel users)
            User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            // Registrasi sebagai Member (ke tabel members)
            Member::create([
                'email' => $request->email,
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('sign_in')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Handle Login - Check All Databases
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginField = $request->username;
        $password = $request->password;
        $isEmail = filter_var($loginField, FILTER_VALIDATE_EMAIL);

        // Prepare credentials
        $credentials = $isEmail 
            ? ['email' => $loginField, 'password' => $password]
            : ['username' => $loginField, 'password' => $password];

        // Method 1: Try Admin first (users table)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Method 2: Try Member (members table)
        if (Auth::guard('member')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('user.dashboard'));
        }

        // Login failed
        return back()->withErrors([
            'username' => 'Username/Email atau password salah.',
        ])->onlyInput('username');
    }

    // Handle Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->email;
        
        // Cek apakah email ada di tabel users atau members
        $user = User::where('email', $email)->first();
        $member = Member::where('email', $email)->first();
        
        if (!$user && !$member) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate token
        $token = Str::random(6); // 6 digit token for easier input
        
        // Simpan token menggunakan Query Builder
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Bersihkan token yang sudah expired
        DB::table('password_resets')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->delete();

        // Store email in session for verification form
        session(['reset_email' => $email]);

        // KIRIM EMAIL - IMPLEMENTASI EMAIL SENDING
        try {
            // Menggunakan Mail untuk mengirim email
            Mail::send('emails.password_reset', ['token' => $token], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Password Reset Token - HydroponicGrow');
            });
            
            return redirect()->route('verify.token.form')
                ->with('success', 'Reset token telah dikirim ke email Anda. Silakan cek inbox dan spam folder.')
                ->with('email', $email);
        } catch (\Exception $e) {
            // Jika email gagal dikirim, tampilkan token untuk development
            // HANYA UNTUK DEVELOPMENT - HAPUS DI PRODUCTION
            return redirect()->route('verify.token.form')
                ->with('success', 'Token: ' . $token . ' (Email belum dikonfigurasi)')
                ->with('email', $email);
        }
    }

    // Alias method untuk Laravel default password reset
    public function sendResetLinkEmail(Request $request)
    {
        return $this->forgotPassword($request);
    }

    // Handle Token Verification
    public function verifyToken(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string', 'min:6', 'max:64'],
        ]);

        $email = $request->email;
        $inputToken = $request->token;

        // Cari token di database
        $passwordReset = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token reset password tidak ditemukan untuk email ini.'])->withInput();
        }

        // Verifikasi token
        if (!Hash::check($inputToken, $passwordReset->token)) {
            return back()->withErrors(['token' => 'Token tidak valid.'])->withInput();
        }

        // Cek apakah token sudah expired (24 jam)
        $isExpired = Carbon::parse($passwordReset->created_at)->addHours(24)->isPast();
        if ($isExpired) {
            // Hapus token yang expired
            DB::table('password_resets')->where('email', $email)->delete();
            return back()->withErrors(['token' => 'Token sudah kadaluarsa. Silakan request token baru.'])->withInput();
        }

        // Token valid - simpan di session
        session([
            'verified_token' => $inputToken,
            'verified_email' => $email,
            'token_verified_at' => Carbon::now()
        ]);

        return redirect()->route('password.reset.form')
            ->with('success', 'Token berhasil diverifikasi! Silakan masukkan password baru Anda.');
    }

    // Handle Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $token = $request->token;
        $email = $request->email;
        $password = $request->password;

        // Verify session data
        if (session('verified_token') !== $token || session('verified_email') !== $email) {
            return redirect()->route('verify.token.form')
                ->withErrors(['token' => 'Session tidak valid. Silakan verifikasi token lagi.']);
        }

        // Check if token verification is not too old (max 10 minutes)
        $tokenVerifiedAt = session('token_verified_at');
        if (!$tokenVerifiedAt || Carbon::parse($tokenVerifiedAt)->addMinutes(10)->isPast()) {
            session()->forget(['verified_token', 'verified_email', 'token_verified_at']);
            return redirect()->route('verify.token.form')
                ->withErrors(['token' => 'Verifikasi token sudah kadaluarsa. Silakan verifikasi ulang.']);
        }

        // Double check token in database
        $passwordReset = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            return redirect()->route('verify.token.form')
                ->withErrors(['token' => 'Token tidak valid atau sudah tidak berlaku.']);
        }

        // Cari user di tabel users atau members
        $user = User::where('email', $email)->first();
        $member = Member::where('email', $email)->first();

        if ($user) {
            // Update password untuk admin
            $user->update([
                'password' => Hash::make($password)
            ]);
        } elseif ($member) {
            // Update password untuk member
            $member->update([
                'password' => Hash::make($password)
            ]);
        } else {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Hapus token dari database
        DB::table('password_resets')->where('email', $email)->delete();

        // Clear session
        session()->forget(['verified_token', 'verified_email', 'token_verified_at', 'reset_email']);

        return redirect()->route('sign_in')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('member')->check()) {
            Auth::guard('member')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sign_in')->with('success', 'Berhasil logout');
    }

    // Clean expired password reset tokens
    public function cleanExpiredTokens()
    {
        $deleted = DB::table('password_resets')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->delete();

        return response()->json([
            'message' => "Deleted {$deleted} expired tokens"
        ]);
    }
}