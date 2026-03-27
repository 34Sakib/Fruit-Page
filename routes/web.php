<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\SpecialOrderController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\Admin\CourierServiceController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\TermsConditionsController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ShippingPolicyController;
use App\Http\Controllers\Admin\ReturnPolicyController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/product/{slug}', [FrontendController::class, 'productDetails'])->name('product.details');
Route::get('/category/{category:slug}', [FrontendController::class, 'category'])->name('category');

// Live Search Route
Route::get('/live-search', [FrontendController::class, 'liveSearch'])->name('live.search');

// About Us Route
Route::get('/about', [FrontendController::class, 'about'])->name('about');

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
});

// Contact Routes
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// Privacy Policy Route
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy.policy');

// Terms & Conditions Route
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions'])->name('terms.conditions');

// Shipping Policy Route
Route::get('/shipping-policy', [FrontendController::class, 'shippingPolicy'])->name('shipping.policy');

// Return Policy Route
Route::get('/return-policy', [FrontendController::class, 'returnPolicy'])->name('return.policy');

// Wishlist Routes
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
    Route::delete('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
    Route::delete('/clear', [WishlistController::class, 'clear'])->name('clear');
});

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'store'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'destroy'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success', [CheckoutController::class, 'success'])->name('success');
});

// Special Order Routes
Route::prefix('special-order')->name('special-order.')->group(function () {
    Route::get('/', [SpecialOrderController::class, 'create'])->name('create');
    Route::post('/', [SpecialOrderController::class, 'store'])->name('store');
    Route::get('/products/{categoryId}', [SpecialOrderController::class, 'getProductsByCategory'])->name('products.by-category');
    Route::get('/details/{id}', [SpecialOrderController::class, 'getOrderDetails'])->name('details');
    Route::get('/track/{id}', [SpecialOrderController::class, 'trackOrder'])->name('track.ajax');
});

// Review Routes
Route::middleware('auth')->group(function () {
    Route::post('/product/{product}/review', [FrontendController::class, 'storeReview'])->name('review.store');
    Route::delete('/reviews/{review}', [FrontendController::class, 'deleteReview'])->name('review.destroy');
});

// Category Routes
Route::get('/category/{slug}', [FrontendController::class, 'category'])->name('category.show');

// Special Pages
Route::get('/{type}', [FrontendController::class, 'specialPage'])
    ->where('type', 'organic|seasonal|deals|fruits|vegetables')
    ->name('special.page');

// Authentication Routes
require __DIR__.'/auth.php';

// Profile and Order Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/show', [ProfileController::class, 'show'])->name('show');
    });
    
    // Order Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Frontend\OrderController::class, 'index'])->name('index');
        Route::get('/support', [\App\Http\Controllers\Frontend\OrderController::class, 'support'])->name('support');
        Route::get('/track/{order}', [\App\Http\Controllers\Frontend\OrderController::class, 'track'])->name('track');
        Route::get('/invoice/{order}', [\App\Http\Controllers\Frontend\OrderController::class, 'invoice'])->name('invoice');
        Route::post('/{order}/cancel', [\App\Http\Controllers\Frontend\OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order}/return', [\App\Http\Controllers\Frontend\OrderController::class, 'returnOrder'])->name('return');
        Route::get('/{order}', [\App\Http\Controllers\Frontend\OrderController::class, 'show'])->name('show');
    });

    // Address Routes
    Route::prefix('addresses')->name('addresses.')->group(function () {
        Route::post('/', [\App\Http\Controllers\AddressController::class, 'store'])->name('store');
        Route::put('/{address}', [\App\Http\Controllers\AddressController::class, 'update'])->name('update');
        Route::delete('/{address}', [\App\Http\Controllers\AddressController::class, 'destroy'])->name('destroy');
        Route::post('/{address}/set-default', [\App\Http\Controllers\AddressController::class, 'setDefault'])->name('set-default');
    });
});

// Test Email Route
Route::get('/test-email', function() {
    try {
        Mail::raw('This is a test email from FruitMart', function($message) {
            $message->to(env('MAIL_FROM_ADDRESS'))
                    ->subject('Test Email from FruitMart');
        });
        return 'Test email sent successfully to ' . env('MAIL_FROM_ADDRESS');
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard data route
    Route::get('/dashboard/data', [AdminController::class, 'getDashboardData'])->name('dashboard.data');
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories Resource
    Route::resource('categories', CategoryController::class);
    
    // Products Resource
    Route::resource('products', ProductController::class);
    
    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        // Admin Users List
        Route::get('/admins', [UserController::class, 'admins'])->name('admins');
        
        // Regular Users Routes
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    }); // End of users prefix group

    // Slider Management
    Route::resource('sliders', SliderController::class)->except(['show']);
    Route::post('sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.update-order');
    
    // Reviews Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/pending', [ReviewController::class, 'pending'])->name('pending');
        Route::get('/{review}/edit', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
        Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
    });
    
    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/pending', [OrderController::class, 'pending'])->name('pending');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('status.update');
    });

    // Admin Special Orders Management
    Route::prefix('special-orders')->name('special-orders.')->group(function () {
        Route::get('/', [SpecialOrderController::class, 'index'])->name('index');
        Route::get('/{specialOrder}', [SpecialOrderController::class, 'show'])->name('show');
        Route::put('/{specialOrder}/status', [SpecialOrderController::class, 'updateStatus'])->name('status.update');
        Route::put('/{specialOrder}/notes', [SpecialOrderController::class, 'updateNotes'])->name('notes.update');
        Route::put('/{specialOrder}/final-price', [SpecialOrderController::class, 'updateFinalPrice'])->name('final-price.update');
        Route::post('/{specialOrder}/send-invoice', [SpecialOrderController::class, 'sendInvoice'])->name('send-invoice');
        Route::put('/{specialOrder}/courier', [SpecialOrderController::class, 'updateCourierService'])->name('courier.update');
        Route::post('/{specialOrder}/ship', [SpecialOrderController::class, 'markAsShipped'])->name('ship');
    });

    // Footer Management
    Route::resource('footers', FooterController::class);

    // Courier Services Management
    Route::resource('courier-services', CourierServiceController::class);
    Route::put('courier-services/{courierService}/toggle', [CourierServiceController::class, 'toggleStatus'])->name('courier-services.toggle');

    // About Us Management
    Route::prefix('about-us')->name('about-us.')->group(function () {
        Route::get('/', [AboutUsController::class, 'index'])->name('index');
        Route::get('/edit', [AboutUsController::class, 'edit'])->name('edit');
        Route::put('/', [AboutUsController::class, 'update'])->name('update');
        
        // Team Members
        Route::prefix('team')->name('team.')->group(function () {
            Route::get('/', [AboutUsController::class, 'teamIndex'])->name('index');
            Route::get('/create', [AboutUsController::class, 'teamCreate'])->name('create');
            Route::post('/', [AboutUsController::class, 'teamStore'])->name('store');
            Route::get('/{teamMember}', [AboutUsController::class, 'teamShow'])->name('show');
            Route::get('/{teamMember}/edit', [AboutUsController::class, 'teamEdit'])->name('edit');
            Route::put('/{teamMember}', [AboutUsController::class, 'teamUpdate'])->name('update');
            Route::delete('/{teamMember}', [AboutUsController::class, 'teamDestroy'])->name('destroy');
            Route::post('/{teamMember}/toggle-status', [AboutUsController::class, 'teamToggleStatus'])->name('toggle-status');
        });
    });

    // Contact Management
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
        Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit');
        Route::put('/{contact}', [ContactController::class, 'update'])->name('update');
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [ContactController::class, 'bulkAction'])->name('bulk-action');
    });

    // Contact Info Management
    Route::prefix('contact-info')->name('contact-info.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ContactInfoController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\ContactInfoController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\ContactInfoController::class, 'store'])->name('store');
        Route::get('/{contactInfo}', [App\Http\Controllers\Admin\ContactInfoController::class, 'show'])->name('show');
        Route::get('/{contactInfo}/edit', [App\Http\Controllers\Admin\ContactInfoController::class, 'edit'])->name('edit');
        Route::put('/{contactInfo}', [App\Http\Controllers\Admin\ContactInfoController::class, 'update'])->name('update');
        Route::delete('/{contactInfo}', [App\Http\Controllers\Admin\ContactInfoController::class, 'destroy'])->name('destroy');
    });

    // FAQ Management
    Route::prefix('faqs')->name('faqs.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FaqController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\FaqController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\FaqController::class, 'store'])->name('store');
        Route::get('/{faq}', [App\Http\Controllers\Admin\FaqController::class, 'show'])->name('show');
        Route::get('/{faq}/edit', [App\Http\Controllers\Admin\FaqController::class, 'edit'])->name('edit');
        Route::put('/{faq}', [App\Http\Controllers\Admin\FaqController::class, 'update'])->name('update');
        Route::delete('/{faq}', [App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('destroy');
    });

    // Blog Management
    Route::prefix('blog')->name('blog.')->group(function () {
        // Blog Posts
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', [BlogPostController::class, 'index'])->name('index');
            Route::get('/create', [BlogPostController::class, 'create'])->name('create');
            Route::post('/', [BlogPostController::class, 'store'])->name('store');
            Route::get('/{post}', [BlogPostController::class, 'show'])->name('show');
            Route::get('/{post}/edit', [BlogPostController::class, 'edit'])->name('edit');
            Route::put('/{post}', [BlogPostController::class, 'update'])->name('update');
            Route::delete('/{post}', [BlogPostController::class, 'destroy'])->name('destroy');
            Route::post('/{post}/toggle-status', [BlogPostController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Blog Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
            Route::get('/create', [BlogCategoryController::class, 'create'])->name('create');
            Route::post('/', [BlogCategoryController::class, 'store'])->name('store');
            Route::get('/{category}', [BlogCategoryController::class, 'show'])->name('show');
            Route::get('/{category}/edit', [BlogCategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [BlogCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [BlogCategoryController::class, 'destroy'])->name('destroy');
        });

        // Blog Tags
        Route::prefix('tags')->name('tags.')->group(function () {
            Route::get('/', [BlogTagController::class, 'index'])->name('index');
            Route::get('/create', [BlogTagController::class, 'create'])->name('create');
            Route::post('/', [BlogTagController::class, 'store'])->name('store');
            Route::get('/{tag}', [BlogTagController::class, 'show'])->name('show');
            Route::get('/{tag}/edit', [BlogTagController::class, 'edit'])->name('edit');
            Route::put('/{tag}', [BlogTagController::class, 'update'])->name('update');
            Route::delete('/{tag}', [BlogTagController::class, 'destroy'])->name('destroy');
        });
    });

    // Privacy Policy Management
    Route::prefix('privacy-policy')->name('privacy-policy.')->group(function () {
        Route::get('/', [PrivacyPolicyController::class, 'index'])->name('index');
        Route::get('/create', [PrivacyPolicyController::class, 'create'])->name('create');
        Route::post('/', [PrivacyPolicyController::class, 'store'])->name('store');
        Route::get('/{privacyPolicy}/edit', [PrivacyPolicyController::class, 'edit'])->name('edit');
        Route::put('/{privacyPolicy}', [PrivacyPolicyController::class, 'update'])->name('update');
        Route::delete('/{privacyPolicy}', [PrivacyPolicyController::class, 'destroy'])->name('destroy');
        Route::put('/{privacyPolicy}/toggle-status', [PrivacyPolicyController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Shipping Policy Route
    Route::get('/shipping-policy', [FrontendController::class, 'shippingPolicy'])->name('shipping.policy');

    // Terms & Conditions Management
    Route::prefix('terms-conditions')->name('terms-conditions.')->group(function () {
        Route::get('/', [TermsConditionsController::class, 'index'])->name('index');
        Route::get('/create', [TermsConditionsController::class, 'create'])->name('create');
        Route::post('/', [TermsConditionsController::class, 'store'])->name('store');
        Route::get('/{termsConditions}/edit', [TermsConditionsController::class, 'edit'])->name('edit');
        Route::put('/{termsConditions}', [TermsConditionsController::class, 'update'])->name('update');
        Route::delete('/{termsConditions}', [TermsConditionsController::class, 'destroy'])->name('destroy');
        Route::put('/{termsConditions}/toggle-status', [TermsConditionsController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Shipping Policy Management
    Route::prefix('shipping-policy')->name('shipping-policy.')->group(function () {
        Route::get('/', [ShippingPolicyController::class, 'index'])->name('index');
        Route::get('/create', [ShippingPolicyController::class, 'create'])->name('create');
        Route::post('/', [ShippingPolicyController::class, 'store'])->name('store');
        Route::get('/{shippingPolicy}/edit', [ShippingPolicyController::class, 'edit'])->name('edit');
        Route::put('/{shippingPolicy}', [ShippingPolicyController::class, 'update'])->name('update');
        Route::delete('/{shippingPolicy}', [ShippingPolicyController::class, 'destroy'])->name('destroy');
        Route::post('/{shippingPolicy}/toggle-status', [ShippingPolicyController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Return Policy Management
    Route::prefix('return-policy')->name('return-policy.')->group(function () {
        Route::get('/', [ReturnPolicyController::class, 'index'])->name('index');
        Route::get('/create', [ReturnPolicyController::class, 'create'])->name('create');
        Route::post('/', [ReturnPolicyController::class, 'store'])->name('store');
        Route::get('/{returnPolicy}/edit', [ReturnPolicyController::class, 'edit'])->name('edit');
        Route::put('/{returnPolicy}', [ReturnPolicyController::class, 'update'])->name('update');
        Route::delete('/{returnPolicy}', [ReturnPolicyController::class, 'destroy'])->name('destroy');
        Route::put('/{returnPolicy}/toggle-status', [ReturnPolicyController::class, 'toggleStatus'])->name('toggle-status');
    });
}); // End of admin prefix group

// Special Orders User Routes (Protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::prefix('special-orders')->name('special-orders.')->group(function () {
        Route::get('/{specialOrder}', [SpecialOrderController::class, 'showDetails'])->name('details');
        Route::get('/{specialOrder}/track', [SpecialOrderController::class, 'trackOrderView'])->name('track');
    });
});

// Dashboard Route (Protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return redirect()->route('home');
    })->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Debug route (temporary)
Route::get('/debug/users', function() {
    try {
        $users = User::all();
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
        $admin = User::where('email', 'admin@fruitmart.com')->first();
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


