<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');

// Category Routes
Route::get('/category/{slug}', [FrontendController::class, 'category'])->name('category.show');

// Special Pages
Route::get('/{type}', [FrontendController::class, 'specialPage'])
    ->where('type', 'organic|seasonal|deals|fruits|vegetables')
    ->name('special.page');

// Authentication Routes
require __DIR__.'/auth.php';

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories Resource
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    
    // Products Resource
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    
    // Users Resource
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

// Dashboard Route (Protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Debug route (temporary)
Route::get('/debug/users', function() {
    try {
        $users = \App\Models\User::all();
        return [
            'users_count' => $users->count(),
            'users' => $users->toArray()
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});

// Fix admin role route (temporary)
Route::get('/fix-admin-role', function() {
    try {
        $admin = \App\Models\User::where('email', 'admin@fruitmart.com')->first();
        if ($admin) {
            $admin->role = 'admin';
            $admin->save();
            
            // Assign admin role using Spatie if needed
            if (class_exists('Spatie\Permission\Models\Role')) {
                $admin->assignRole('admin');
            }
            
            return ['status' => 'success', 'message' => 'Admin role updated successfully'];
        }
        return ['status' => 'error', 'message' => 'Admin user not found'];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});

// Admin Routes (Protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
