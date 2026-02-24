<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => 'بيانات غير صحيحة',
          'errors' => $validator->errors()
        ], 422);
      }

      $credentials = $request->only('email', 'password');

      if (!Auth::attempt($credentials)) {
        return response()->json([
          'success' => false,
          'message' => 'بيانات الدخول غير صحيحة'
        ], 401);
      }

      $user = Auth::user();
      $token = $user->createToken('API Token')->plainTextToken;

      return response()->json([
        'success' => true,
        'message' => 'تم تسجيل الدخول بنجاح',
        'data' => [
          'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
          ],
          'access_token' => $token,
          'token_type' => 'Bearer'
        ]
      ])->withHeaders([
        'Authorization' => 'Bearer ' . $token,
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/AuthController@login', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'request' => $request->all()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء تسجيل الدخول',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function register(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => 'بيانات غير صحيحة',
          'errors' => $validator->errors()
        ], 422);
      }

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);

      // Assign default role (user)
      $user->assignRole('user');

      $token = $user->createToken('API Token')->plainTextToken;

      return response()->json([
        'success' => true,
        'message' => 'تم إنشاء الحساب بنجاح',
        'data' => [
          'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
          ],
          'access_token' => $token,
          'token_type' => 'Bearer'
        ]
      ], 201)->withHeaders([
        'Authorization' => 'Bearer ' . $token,

      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/AuthController@register', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'request' => $request->all()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء إنشاء الحساب',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function logout(Request $request)
  {
    try {
      $request->user()->currentAccessToken()->delete();

      return response()->json([
        'success' => true,
        'message' => 'تم تسجيل الخروج بنجاح'
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/AuthController@logout', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء تسجيل الخروج',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function user(Request $request)
  {
    try {
      return response()->json([
        'success' => true,
        'data' => [
          'user' => [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'email_verified_at' => $request->user()->email_verified_at,
            'created_at' => $request->user()->created_at,
            'updated_at' => $request->user()->updated_at,
          ]
        ]
      ]);
    } catch (\Exception $e) {
      Log::error('error in Api/AuthController@user', [
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile()
      ]);

      return response()->json([
        'success' => false,
        'message' => 'حدث خطأ أثناء جلب بيانات المستخدم',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
