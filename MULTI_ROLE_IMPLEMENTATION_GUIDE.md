# Multi-Role User System Implementation Guide

## Overview
Successfully implemented a complete multi-role user system with 3 roles: Pelanggan (Customer), Admin, and Pimpinan (Director/Leadership).

## System Architecture

### Roles
1. **Pelanggan** (ID: 1) - Default role for public registration
2. **Admin** (ID: 2) - System administration access
3. **Pimpinan** (ID: 3) - Highest level management access

## Database Structure

### Roles Table
- `id` (primary key)
- `name` (unique: 'pelanggan', 'admin', 'pimpinan')
- `display_name` ('Pelanggan', 'Admin', 'Pimpinan')
- `description` (nullable text)
- `timestamps`

### Users Table (Updated)
- Added `role_id` (foreign key to roles table, default: 1)
- Foreign key constraint with `onDelete('restrict')`

## Files Created

### Migrations
1. `database/migrations/2024_12_20_100000_create_roles_table.php`
   - Creates roles table with 3 default roles

2. `database/migrations/2024_12_20_100001_add_role_id_to_users_table.php`
   - Adds role_id column to users table
   - Sets default value to 1 (pelanggan)
   - Adds foreign key constraint

### Models
1. `app/Models/Role.php`
   - HasMany relationship with User
   - Helper methods: `isAdmin()`, `isPimpinan()`, `isPelanggan()`

2. `app/Models/User.php` (Updated)
   - Added `role_id` to `$fillable`
   - BelongsTo relationship with Role
   - Helper methods:
     - `hasRole($roleName)` - Check if user has specific role
     - `isAdmin()` - Check if admin
     - `isPimpinan()` - Check if pimpinan
     - `isPelanggan()` - Check if pelanggan
     - `getRoleName()` - Get role name
     - `getRoleDisplayName()` - Get role display name

### Seeders
1. `database/seeders/RoleSeeder.php`
   - Seeds 3 roles: pelanggan, admin, pimpinan

2. `database/seeders/AdminUserSeeder.php`
   - Creates initial admin user: admin@becksapparel.com / password
   - Creates initial pimpinan user: pimpinan@becksapparel.com / password

### Middleware
1. `app/Http/Middleware/CheckRole.php`
   - Checks if authenticated user has required role(s)
   - Usage: `Route::middleware(['auth', 'role:admin,pimpinan'])`
   - Returns 403 if user doesn't have required role

### Controllers
1. `app/Http/Controllers/Admin/AdminUserController.php`
   - `index()` - List all users with pagination
   - `create()` - Show create user form with role selection
   - `store()` - Create user with selected role
   - `edit()` - Show edit user form
   - `update()` - Update user including role change
   - `destroy()` - Delete user (prevents self-deletion)
   - Protected by `role:admin,pimpinan` middleware

2. `app/Http/Controllers/Auth/RegisteredUserController.php` (Updated)
   - Sets `role_id = 1` (pelanggan) for all public registrations

### Views
1. `resources/views/admin/users/index.blade.php`
   - User listing with role badges
   - Color-coded roles (Purple: Pimpinan, Blue: Admin, Green: Pelanggan)
   - Edit and delete actions
   - Pagination support

2. `resources/views/admin/users/create.blade.php`
   - Create user form with role dropdown
   - All fields: name, email, nomor_telepon, role, password

3. `resources/views/admin/users/edit.blade.php`
   - Edit user form
   - Optional password change
   - Role can be changed

### Routes
Updated `routes/web.php`:
```php
Route::middleware(['auth', 'role:admin,pimpinan'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);
});
```

### Navigation
Updated `resources/views/partials/navbar.blade.php`:
- Shows "USER MANAGEMENT" link for Admin and Pimpinan
- Shows "DASHBOARD" link for Pelanggan
- Role-based menu display

## Installation Steps

### 1. Run Migrations
```bash
php artisan migrate
```

This will:
- Create `roles` table
- Add `role_id` column to `users` table

### 2. Run Seeders
```bash
php artisan db:seed
```

Or run individually:
```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=AdminUserSeeder
```

This will:
- Create 3 roles (pelanggan, admin, pimpinan)
- Create initial admin user (admin@becksapparel.com / password)
- Create initial pimpinan user (pimpinan@becksapparel.com / password)

### 3. Update Existing Users (if any)
If you have existing users without role_id, run:
```sql
UPDATE users SET role_id = 1 WHERE role_id IS NULL;
```

## Usage Examples

### Check User Role in Controllers
```php
if (auth()->user()->isAdmin()) {
    // Admin only code
}

if (auth()->user()->isPimpinan()) {
    // Pimpinan only code
}

if (auth()->user()->hasRole('admin')) {
    // Check specific role
}
```

### Check User Role in Views
```blade
@auth
    @if(auth()->user()->isAdmin() || auth()->user()->isPimpinan())
        <!-- Admin/Pimpinan content -->
    @endif
    
    @if(auth()->user()->isPelanggan())
        <!-- Customer content -->
    @endif
@endauth
```

### Protect Routes with Middleware
```php
// Admin and Pimpinan only
Route::middleware(['auth', 'role:admin,pimpinan'])->group(function () {
    // Routes here
});

// Pimpinan only
Route::middleware(['auth', 'role:pimpinan'])->group(function () {
    // Routes here
});

// Multiple roles
Route::middleware(['auth', 'role:admin,pimpinan'])->group(function () {
    // Routes here
});
```

## Access Control

### Public Registration
- Route: `/register`
- Automatically assigns `role_id = 1` (Pelanggan)
- No role selection visible

### Admin User Management
- Routes: `/admin/users/*`
- Access: Admin and Pimpinan only
- Features:
  - List all users
  - Create new users with any role
  - Edit users (including role change)
  - Delete users (cannot delete self)

## Default Credentials

After running seeders:

**Admin:**
- Email: `admin@becksapparel.com`
- Password: `password`

**Pimpinan:**
- Email: `pimpinan@becksapparel.com`
- Password: `password`

⚠️ **IMPORTANT**: Change these passwords immediately after first login!

## Security Features

1. **Role-based Access Control**: Middleware protects routes
2. **Foreign Key Constraints**: Prevents orphaned records
3. **Self-Deletion Prevention**: Users cannot delete themselves
4. **Validation**: Role must exist in database
5. **CSRF Protection**: All forms protected

## Testing Checklist

- [x] Roles table created with 3 roles
- [x] Users table has role_id column
- [x] Public registration assigns pelanggan role
- [x] Admin can create users with any role
- [x] Admin can edit user roles
- [x] Admin can delete users (except self)
- [x] Middleware blocks unauthorized access
- [x] Navigation shows role-based menus
- [x] Role helper methods work correctly
- [x] Seeders create initial admin/pimpinan users

## Next Steps (Optional Enhancements)

1. **Role Permissions**: Add granular permissions system
2. **Audit Log**: Track role changes
3. **Role Assignment Rules**: Add business rules for role assignment
4. **Bulk Operations**: Add bulk user management features
5. **User Profile**: Add profile page with role display
6. **Role-based Dashboard**: Create different dashboards per role

## Troubleshooting

### Issue: Foreign key constraint error
**Solution**: Make sure roles are seeded before creating users

### Issue: Middleware not working
**Solution**: Check that middleware is registered in `bootstrap/app.php`

### Issue: Users without roles
**Solution**: Run `UPDATE users SET role_id = 1 WHERE role_id IS NULL;`

### Issue: Cannot access admin routes
**Solution**: Verify user has correct role_id (2 for admin, 3 for pimpinan)

---

**Implementation Date**: December 2024
**Laravel Version**: 12.42.0
**Status**: ✅ Complete and Ready for Use

