<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ChatController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// USER COLLECTION (VIEW ONLY)
Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection/{slug}', [CollectionController::class, 'show'])->name('collection.detail');

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.detail');

// Booking (public form)
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');

// Testimonials
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

// Static Pages
Route::get('/about', [\App\Http\Controllers\PageController::class, 'about'])->name('about');
Route::get('/careers', [\App\Http\Controllers\PageController::class, 'careers'])->name('careers');
Route::get('/press', [\App\Http\Controllers\PageController::class, 'press'])->name('press');
Route::get('/contact', [\App\Http\Controllers\PageController::class, 'contact'])->name('contact');
Route::get('/faq', [\App\Http\Controllers\PageController::class, 'faq'])->name('faq');
Route::get('/help', [\App\Http\Controllers\PageController::class, 'help'])->name('help');
Route::get('/terms', [\App\Http\Controllers\PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [\App\Http\Controllers\PageController::class, 'privacy'])->name('privacy');
Route::get('/cookie', [\App\Http\Controllers\PageController::class, 'cookie'])->name('cookie');


/*
|--------------------------------------------------------------------------
| CHAT ROUTES (PUBLIC/GUEST/USER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/start', [ChatController::class, 'startSession'])->name('chat.start');
    Route::get('/chat/messages', [ChatController::class, 'fetchMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return "Halaman untuk mereset kata sandi sedang dalam tahap pembuatan.";
})->name('password.request');


/*
|--------------------------------------------------------------------------
| USER (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');
    Route::post('/booking/cancel/{id}', [BookingController::class, 'cancel'])->name('booking.cancel');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/logout', [ProfileController::class, 'logout'])->name('profile.logout');

    Route::get('/cart', [ShopController::class, 'cart'])->name('cart.index');
    Route::get('/add-to-cart/{id}', [ShopController::class, 'addToCart'])->name('add.to.cart');
    Route::patch('/update-cart', [ShopController::class, 'update'])->name('update.cart');
    Route::delete('/remove-from-cart', [ShopController::class, 'remove'])->name('remove.from.cart');

    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.history');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.detail');
    Route::post('/transactions/{transaction}/upload-receipt', [TransactionController::class, 'uploadReceipt'])->name('transactions.uploadReceipt');
    
    Route::get('/dashboard', function () {
        if (in_array(auth()->user()->role, ['admin', 'manager'])) {
            return redirect()->route('admin.dashboard.index');
        }
        return redirect()->route('home');
    })->name('dashboard');

    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin']) // Assuming 'admin' middleware checks role
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');

        // Collections (CRUD)
        Route::resource('collections', AdminCollectionController::class);
        Route::post('collections/{collection}/toggle-publish', [AdminCollectionController::class, 'togglePublish'])
             ->name('collections.toggle-publish');

        // Products (CRUD)
        Route::resource('products', AdminProductController::class);

        // Users Management
        Route::resource('users', AdminUserController::class);
        Route::post('users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('users.bulk-action');
        Route::get('users/export/csv', [AdminUserController::class, 'export'])->name('users.export');

        // Bookings Management
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::post('bookings/{id}/reschedule', [BookingController::class, 'reschedule'])->name('bookings.reschedule');
        Route::delete('bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

        // Shop Orders Management
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Reports
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

        // Testimonial Management
        Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
        Route::post('/testimonials/{testimonial}/toggle', [AdminTestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle');
        Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');
        Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
        
        // Chat Management
        Route::get('/chats', [AdminChatController::class, 'index'])->name('chats.index');
        Route::get('/chats/{id}', [AdminChatController::class, 'show'])->name('chats.show');
        Route::get('/chats/{id}/messages', [AdminChatController::class, 'fetchMessages'])->name('chats.messages');
        Route::post('/chats/{id}/reply', [AdminChatController::class, 'reply'])->name('chats.reply');
        Route::post('/chats/{id}/close', [AdminChatController::class, 'close'])->name('chats.close');
        Route::delete('/chats/{id}', [AdminChatController::class, 'destroy'])->name('chats.destroy');

    });
