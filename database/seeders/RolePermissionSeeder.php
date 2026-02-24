<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
  /**
   * List of all models that need permissions
   */
  protected array $models = [
    'email',
    'proxy',
    'user',
    'setting',
    'account',
  ];

  /**
   * Standard actions for each model
   */
  protected array $actions = [
    'read',
    'store',
    'update',
    'delete',
  ];

  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Create permissions for each model
    $this->createPermissions();

    // Create roles and assign permissions
    $this->createRoles();

    // Assign specific permissions based on role hierarchy
    $this->assignPermissionsToRoles();

    // create users for admin and user roles:
    //1- admin:
    $admin = User::create([
      'name' => 'admin',
      'email' => 'admin@example.com',
      'password' => Hash::make('password'),
    ]);
    $admin->assignRole('admin');

    //2- user:
    $user = User::create([
      'name' => 'user',
      'email' => 'user@example.com',
      'password' => Hash::make('password'),
    ]);
    $user->assignRole('user');
  }

  /**
   * Create permissions for all models
   */
  protected function createPermissions(): void
  {
    foreach ($this->models as $model) {
      foreach ($this->actions as $action) {
        $permissionName = "{$action}.{$model}";

        Permission::firstOrCreate([
          'name' => $permissionName,
          'guard_name' => 'web',
        ], [
          'name' => $permissionName,
          'guard_name' => 'web',
        ]);
      }
    }

    // Additional permissions
    $additionalPermissions = [
      'manage.roles',
      'manage.permissions',
      'view.admin.dashboard',
      'view.analytics',
      'export.data',
      'import.data',
    ];

    foreach ($additionalPermissions as $permission) {
      Permission::firstOrCreate([
        'name' => $permission,
        'guard_name' => 'web',
      ], [
        'name' => $permission,
        'guard_name' => 'web',
      ]);
    }
  }

  /**
   * Create system roles
   */
  protected function createRoles(): void
  {
    $roles = [
      [
        'name' => 'admin',
        'guard_name' => 'web',
      ],
      [
        'name' => 'user',
        'guard_name' => 'web',
      ],
    ];

    foreach ($roles as $roleData) {
      Role::firstOrCreate([
        'name' => $roleData['name'],
        'guard_name' => $roleData['guard_name'],
      ], $roleData);
    }
  }

  /**
   * Assign permissions to roles based on hierarchy
   */
  protected function assignPermissionsToRoles(): void
  {
    // CEO - Has all permissions
    $ceo = Role::where('name', 'CEO')->first();
    if ($ceo) {
      $ceo->syncPermissions(Permission::all());
    }

    // Super Admin - Almost all permissions except managing CEO role
    $superAdmin = Role::where('name', 'super-admin')->first();
    if ($superAdmin) {
      $allPermissions = Permission::whereNotIn('name', [
        'manage.roles', // CEO only can manage roles
      ])->get();
      $superAdmin->syncPermissions($allPermissions);
    }

    // Admin - Can manage specific models and view analytics
    $admin = Role::where('name', 'admin')->first();
    if ($admin) {
      $adminPermissions = [];

      // Admin can manage emails, proxies, users, settings, accounts
      foreach (['email', 'proxy', 'user', 'setting', 'account'] as $model) {
        foreach ($this->actions as $action) {
          $adminPermissions[] = "{$action}.{$model}";
        }
      }

      // Additional permissions
      $adminPermissions = array_merge($adminPermissions, [
        'view.admin.dashboard',
        'view.analytics',
        'export.data',
      ]);

      $admin->syncPermissions($adminPermissions);
    }

    // Support - Read-only access plus some update permissions
    $support = Role::where('name', 'support')->first();
    if ($support) {
      $supportPermissions = [];

      // Support can read most models
      foreach (['email', 'proxy', 'user', 'setting', 'account'] as $model) {
        $supportPermissions[] = "read.{$model}";
      }

      // Support can update some models
      $supportPermissions = array_merge($supportPermissions, [
        'update.email', // for status updates
        'update.user',  // for basic user info
        'view.admin.dashboard',
      ]);

      $support->syncPermissions($supportPermissions);
    }

    // User - Basic customer permissions
    $user = Role::where('name', 'user')->first();
    if ($user) {
      $userPermissions = [
        'read.user', // can read own profile
        'update.user', // can update own profile
      ];

      $user->syncPermissions($userPermissions);
    }
  }

  /**
   * Get all permissions for a specific model
   */
  public static function getModelPermissions(string $model): array
  {
    return array_map(function ($action) use ($model) {
      return "{$action}.{$model}";
    }, ['read', 'store', 'update', 'delete']);
  }

  /**
   * Add permissions for a new model
   * This method can be called when adding new models
   */
  public static function addModelPermissions(string $model): void
  {
    $actions = ['read', 'store', 'update', 'delete'];

    foreach ($actions as $action) {
      $permissionName = "{$action}.{$model}";

      Permission::firstOrCreate([
        'name' => $permissionName,
        'guard_name' => 'web',
      ], [
        'name' => $permissionName,
        'guard_name' => 'web',
      ]);
    }
  }

  /**
   * Assign model permissions to a role
   */
  public static function assignModelPermissionsToRole(string $roleName, string $model, array $actions = null): void
  {
    $role = Role::where('name', $roleName)->first();
    if (!$role) {
      return;
    }

    $actions = $actions ?? ['read', 'store', 'update', 'delete'];
    $permissions = array_map(function ($action) use ($model) {
      return "{$action}.{$model}";
    }, $actions);

    $role->givePermissionTo($permissions);
  }
}
