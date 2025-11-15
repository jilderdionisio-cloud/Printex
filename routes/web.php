<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\MyCoursesController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Support\Facades\Route;


// PÚBLICO

Route::get('/', [HomeController::class, 'index'])->name('home');

// Página "Nosotros"
Route::view('/about', 'about')->name('about');

// Página "Contacto" (ASEGÚRATE de tener resources/views/contact.blade.php)
Route::view('/contact', 'contact')->name('contact');


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');


// CARRITO (sesión)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart-clear', [CartController::class, 'clear'])->name('cart.clear');


// AUTENTICACIÓN (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

// RUTAS PARA USUARIOS AUTENTICADOS
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Inscripción a cursos (cliente)
    Route::post('/courses/{course}/enroll', [CourseEnrollmentController::class, 'store'])
        ->name('courses.enroll');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

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

        // Inscripciones a cursos
        Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/enrollments/{id}', [AdminEnrollmentController::class, 'show'])->name('enrollments.show');
        Route::put('/enrollments/{id}/status', [AdminEnrollmentController::class, 'updateStatus'])->name('enrollments.updateStatus');
    });
