<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\SupportRequestController as AdminSupportRequestController;
use App\Http\Controllers\Admin\TopItemsController;
use App\Http\Controllers\Admin\UpcomingReleaseController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursePurchaseController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportRequestController;
use App\Http\Controllers\User\MyCoursesController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Support\Facades\Route;

// P?BLICO
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact'); // aseg?rate de tener resources/views/contact.blade.php

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

// CARRITO (sesi?n)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{itemKey}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{itemKey}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart-clear', [CartController::class, 'clear'])->name('cart.clear');
});

// AUTENTICACI?N (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::view('/chat', 'chat')->name('chat');
Route::post('/chatbot', [ChatbotController::class, 'chat']);

// RUTAS PARA USUARIOS AUTENTICADOS
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Inscripci?n a cursos (cliente)
    Route::post('/courses/{course}/enroll', [CourseEnrollmentController::class, 'store'])->name('courses.enroll');
    Route::post('/courses/{course}/purchase', [CoursePurchaseController::class, 'store'])->name('courses.purchase');

    // Reseñas de productos
    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('products.reviews.store');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Solicitudes de asesor?a
    Route::post('/support-requests', [SupportRequestController::class, 'store'])->name('support-requests.store');

    // Perfil de usuario
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Mis pedidos (usuario)
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [UserOrderController::class, 'show'])->name('orders.show');

    // Mis cursos (usuario)
    Route::get('/my-courses', [MyCoursesController::class, 'index'])->name('courses.my');
});

// PANEL ADMIN (solo admin)
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Productos
        Route::resource('/products', AdminProductController::class);

        // CRUD Cursos
        Route::resource('/courses', AdminCourseController::class);

        // CRUD Proveedores
        Route::resource('/suppliers', AdminSupplierController::class);

        // Pedidos
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Solicitudes de asesor?a
        Route::get('/support-requests', [AdminSupportRequestController::class, 'index'])->name('support-requests.index');
        Route::get('/support-requests/{id}', [AdminSupportRequestController::class, 'show'])->name('support-requests.show');
        Route::put('/support-requests/{id}', [AdminSupportRequestController::class, 'update'])->name('support-requests.update');

        // Inscripciones a cursos
        Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/enrollments/{id}', [AdminEnrollmentController::class, 'show'])->name('enrollments.show');
        Route::put('/enrollments/{id}/status', [AdminEnrollmentController::class, 'updateStatus'])->name('enrollments.updateStatus');

        // Pr?ximos lanzamientos
        Route::resource('/upcoming-releases', UpcomingReleaseController::class)->except(['show']);

        // Tops de productos/cursos
        Route::get('/top-items', [TopItemsController::class, 'index'])->name('top-items.index');

        // Auditor?a
        Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
    });
