<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Throwable;

class RoleController extends Controller
{
  // use AuthorizesRequests;
  /**
   * Display a listing of roles
   */
  public function index(Request $request)
  {

    try {
      $query = Role::query()->with(['permissions', 'users']);

      if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
      }

      $roles = $query->paginate($request->get('per_page', 15));

      return view('admin.roles.index', compact('roles'));
    } catch (Throwable $e) {
      Log::error('error in Admin/RoleController@index', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()->with('error', 'Failed to load roles list');
    }
  }

  /**
   * Show the form for creating a new role
   */
  public function create()
  {

    $permissions = Permission::all()->groupBy(function ($permission) {
      return explode('.', $permission->name)[1] ?? 'general';
    });

    return view('admin.roles.create', compact('permissions'));
  }

  /**
   * Store a newly created role
   */
  public function store(Request $request)
  {

    $request->validate([
      'name' => 'required|string|unique:roles,name|max:255',
      'permissions' => 'array',
      'permissions.*' => 'string|exists:permissions,name',
    ]);

    DB::beginTransaction();

    try {
      $role = Role::create([
        'name' => $request->name,
        'guard_name' => 'web',
      ]);

      if ($request->filled('permissions')) {
        $role->syncPermissions($request->permissions);
      }

      DB::commit();

      Log::info('Admin created role via web interface', [
        'role_id' => $role->id,
      ]);

      return redirect()->route('admin.roles.index')
        ->with('success', 'Role created successfully');
    } catch (Throwable $e) {
      DB::rollBack();

      Log::error('error in Admin/RoleController@store', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()
        ->withInput()
        ->with('error', 'Failed to create role');
    }
  }

  /**
   * Display the specified role
   */
  public function show(Role $role)
  {

    try {
      $role->load(['permissions', 'users']);

      return view('admin.roles.show', compact('role'));
    } catch (Throwable $e) {
      Log::error('error in Admin/RoleController@show', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()->with('error', 'Failed to load role details');
    }
  }

  /**
   * Show the form for editing the specified role
   */
  public function edit(Role $role)
  {
    $permissions = Permission::all()->groupBy(function ($permission) {
      return explode('.', $permission->name)[1] ?? 'general';
    });

    return view('admin.roles.edit', compact('role', 'permissions'));
  }

  /**
   * Update the specified role
   */
  public function update(Request $request, Role $role)
  {

    if (!auth()->user()->hasRole('admin')) {
      return back()->with('error', 'You are not authorized to update roles');
    }

    $request->validate([
      'name' => 'sometimes|string|unique:roles,name,' . $role->id . '|max:255',
      'permissions' => 'array',
      'permissions.*' => 'string|exists:permissions,name',
    ]);

    DB::beginTransaction();

    try {
      if ($request->filled('name')) {
        $role->update(['name' => $request->name]);
      }

      if ($request->has('permissions')) {
        $role->syncPermissions($request->permissions);
      }

      DB::commit();



      return redirect()->route('admin.roles.show', $role)
        ->with('success', 'Role updated successfully');
    } catch (Throwable $e) {
      DB::rollBack();

      Log::error('error in Admin/RoleController@update', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()
        ->withInput()
        ->with('error', 'Failed to update role');
    }
  }

  /**
   * Remove the specified role
   */
  public function destroy(Role $role)
  {

    // Prevent deletion of system roles
    if (in_array($role->name, ['admin', 'user'])) {
      return back()->with('error', 'Cannot delete system roles');
    }

    DB::beginTransaction();

    try {
      $roleData = $role->toArray();
      $role->delete();

      DB::commit();


      return redirect()->route('admin.roles.index')
        ->with('success', 'Role deleted successfully');
    } catch (Throwable $e) {
      DB::rollBack();


      Log::error('error in Admin/RoleController@destroy', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()->with('error', 'Failed to delete role');
    }
  }

  /**
   * Assign role to user
   */
  public function assignUser(Request $request)
  {
    $request->validate([
      'user_id' => 'required|integer|exists:users,id',
      'role_name' => 'required|string|exists:roles,name',
    ]);

    $user = \App\Models\User::find($request->user_id);

    if (!auth()->user()->hasRole('admin')) {
      return back()->with('error', 'You are not authorized to assign roles');
    }

    try {
      $user->assignRole($request->role_name);



      return back()->with('success', 'Role assigned successfully');
    } catch (Throwable $e) {
      Log::error('error in Admin/RoleController@assignUser', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()->with('error', 'Failed to assign role');
    }
  }

  /**
   * Remove role from user
   */
  public function removeUser(Request $request, Role $role, \App\Models\User $user)
  {
    if (!auth()->user()->hasRole('admin')) {
      return back()->with('error', 'You are not authorized to remove roles');
    }

    try {
      $user->removeRole($role->name);

      return back()->with('success', 'Role removed successfully');
    } catch (Throwable $e) {
      Log::error('error in Admin/RoleController@removeUser', [
        'error' => $e->getMessage(),
        'line'  => $e->getLine(),
        'file'  => $e->getFile(),
      ]);

      return back()->with('error', 'Failed to remove role');
    }
  }
}
