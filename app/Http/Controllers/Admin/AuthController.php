<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System\User;
use App\Utils\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        // If already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {


        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try {

            if (Auth::attempt($credentials)) {

                /** @var User $user */
                $user = Auth::user();

                if (!$user->hasRole('admin')) {
                    Auth::logout();
                    return back()->withErrors(['email' => 'ليس لديك صلاحية للوصول إلى لوحة التحكم']);
                }

                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
            Log::warning('Admin login failed - invalid credentials', [
                'email_attempted' => $request->email,
                'reason' => 'invalid_credentials'
            ]);

            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('error', 'بيانات الدخول غير صحيحة');
        } catch (Throwable $e) {
            Log::error('Error during admin login', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('error', 'حدث خطأ أثناء تسجيل الدخول، يرجى المحاولة مرة أخرى');
        }
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();


            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('success', 'تم تسجيل الخروج بنجاح');
        } catch (Throwable $e) {
            Log::error('Error during admin logout', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            // Even if there's an error, still logout the user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('error', 'تم تسجيل الخروج مع وجود خطأ');
        }
    }

    /**
     * Check if user is authenticated (for AJAX requests)
     */
    public function checkAuth()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? Auth::user()->only(['id', 'name', 'email']) : null
        ]);
    }
}
