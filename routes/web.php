<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerPaymentController;



Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'min:6', 'confirmed'], // لازم password_confirmation
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    Auth::login($user);


    return redirect()->route('products.index');
})->middleware('guest')->name('register.store');


Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->route('products.index');
    }

    return back()
        ->withErrors(['email' => 'بيانات الدخول غير صحيحة'])
        ->onlyInput('email');
})->middleware('guest')->name('login.attempt');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');


Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});


Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])
    ->name('products.images.destroy');


Route::put('products/{product}/images/{image}/make-main', [ProductController::class, 'makeMainImage'])
    ->name('products.images.makeMain');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/my-products', [ProductController::class, 'myProducts'])->name('products.mine');
});


Route::get('/activities', [ProductActivityController::class, 'index'])
    ->name('activities.index')
    ->middleware('auth');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::resource('suppliers', SupplierController::class);



Route::get('supplier-payments/create/{supplier}', [SupplierPaymentController::class,'create'])->name('supplier.payments.create');

Route::post('supplier-payments/store', [SupplierPaymentController::class,'store'])->name('supplier.payments.store');



Route::get('cash', [CashController::class,'index'])->name('cash.index');



Route::resource('customers', CustomerController::class);



Route::get('customer-payments/create/{customer}', [CustomerPaymentController::class,'create'])->name('customer.payments.create');

Route::post('customer-payments/store', [CustomerPaymentController::class,'store'])->name('customer.payments.store');
