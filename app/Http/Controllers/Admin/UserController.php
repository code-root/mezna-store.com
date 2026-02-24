<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Throwable;


class UserController extends Controller
{
  // use AuthorizesRequests;
  /**
   * Display a listing of users
   */
  public function index(Request $request)
  {

    try {
      $query = User::query()->with(['roles']);

      // Filters
      if ($request->filled('role')) {
        $query->whereHas('roles', function ($q) use ($request) {
          $q->where('name', $request->role);
        });
      }

      if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
          $q->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%');
        });
      }

      $users = $query->paginate($request->get('per_page', 15));

      // Available roles for filter
      $roles = Role::all();

      return view('admin.users.index', compact('users', 'roles'));
    } catch (Throwable $e) {
      Log::error('error in Admin/UserController@index', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);
      return back()->with('error', 'Failed to load users list');
    }
  }

  /**
   * Show the form for creating a new user
   */
  public function create()
  {

    $roles = Role::all();
    return view('admin.users.create', compact('roles'));
  }

  /**
   * Store a newly created user
   */
  public function store(Request $request)
  {

    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:8|confirmed',
      'roles' => 'array',
      'roles.*' => 'string|exists:roles,name',
    ]);

    DB::beginTransaction();

    try {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_verified_at' => now(),
      ]);

      if ($request->filled('roles')) {
        $user->syncRoles($request->roles);
      }

      DB::commit();

      Log::info('Admin created user via web interface', [
        'user_id' => $user->id,
      ]);

      return redirect()->route('admin.users.index')
        ->with('success', 'User created successfully');
    } catch (Throwable $e) {
      DB::rollBack();

      Log::error('error in Admin/UserController@store', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()
        ->withInput()
        ->with('error', 'Failed to create user');
    }
  }

  /**
   * Display the specified user
   */
  public function show(User $user)
  {

    try {
      $user->load(['roles.permissions']);


      return view('admin.users.show', compact('user'));
    } catch (Throwable $e) {
      Log::error('error in Admin/UserController@show', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()->with('error', 'Failed to load user details');
    }
  }

  /**
   * Show the form for editing the specified user
   */
  public function edit(User $user)
  {

    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
  }

  /**
   * Update the specified user
   */
  public function update(Request $request, User $user)
  {

    $request->validate([
      'name' => 'sometimes|string|max:255',
      'email' => 'sometimes|email|unique:users,email,' . $user->id,
      'password' => 'nullable|string|min:8|confirmed',
      'roles' => 'array',
      'roles.*' => 'string|exists:roles,name',
    ]);

    DB::beginTransaction();

    try {
      $updateData = $request->only(['name', 'email']);

      if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
      }

      $user->update($updateData);

      if ($request->has('roles')) {
        $user->syncRoles($request->roles);
      }

      DB::commit();


      return redirect()->route('admin.users.show', $user)
        ->with('success', 'User updated successfully');
    } catch (Throwable $e) {
      DB::rollBack();

      Log::error('error in Admin/UserController@update', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()
        ->withInput()
        ->with('error', 'Failed to update user');
    }
  }

  /**
   * Remove the specified user
   */
  public function destroy(User $user)
  {

    // Prevent deletion of self
    if ($user->id === auth()->id()) {
      return back()->with('error', 'Cannot delete your own account');
    }

    DB::beginTransaction();

    try {
      $userData = $user->toArray();
      $user->delete();

      DB::commit();
      return redirect()->route('admin.users.index')
        ->with('success', 'User deleted successfully');
    } catch (Throwable $e) {
      DB::rollBack();

      Log::error('error in Admin/UserController@destroy', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);
      return back()->with('error', 'Failed to delete user');
    }
  }
}
