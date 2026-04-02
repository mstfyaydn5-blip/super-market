<?php

use App\Mail\EmailVerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\ProductActivityController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\CustomerPaymentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Guest Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!\d+$)[\p{L}\s]+$/u',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
        ], [
            'name.required' => 'الاسم مطلوب.',
            'name.regex' => 'الاسم يجب أن يحتوي على حروف فقط، ولا يمكن أن يكون أرقام فقط.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique' => 'هذا البريد مستخدم مسبقاً.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ]);

        $code = (string) random_int(100000, 999999);

        $user = User::create([
            'name' => trim($data['name']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification_code' => $code,
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new EmailVerificationCodeMail($user));

        return redirect()->route('verify.code.form', ['email' => $user->email])
            ->with('success', 'تم إنشاء الحساب وإرسال كود التحقق إلى بريدك الإلكتروني.');
    })->name('register.store');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();

                return redirect()->route('verify.code.form', ['email' => $request->email])
                    ->withErrors([
                        'email' => 'يجب إدخال كود التحقق أولاً.',
                    ]);
            }

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'بيانات الدخول غير صحيحة.',
            ])
            ->onlyInput('email');
    })->name('login.attempt');
});

/*
|--------------------------------------------------------------------------
| Verify Code Routes
|--------------------------------------------------------------------------
*/

Route::get('/verify-code', function (Request $request) {
    return view('auth.verify-code', [
        'email' => $request->query('email'),
    ]);
})->name('verify.code.form');

Route::post('/verify-code', function (Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email'],
        'code' => ['required', 'digits:6'],
    ], [
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
        'code.required' => 'كود التحقق مطلوب.',
        'code.digits' => 'كود التحقق يجب أن يكون 6 أرقام.',
    ]);

    $user = User::where('email', $data['email'])->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'هذا البريد غير موجود.',
        ])->withInput();
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('success', 'تم التحقق من البريد مسبقاً، يمكنك تسجيل الدخول.');
    }

    if (!$user->verification_code || !$user->verification_code_expires_at) {
        return back()->withErrors([
            'code' => 'لا يوجد كود تحقق صالح. اطلب إعادة الإرسال.',
        ])->withInput();
    }

    if (now()->greaterThan($user->verification_code_expires_at)) {
        return back()->withErrors([
            'code' => 'انتهت صلاحية الكود. اطلب إعادة الإرسال.',
        ])->withInput();
    }

    if ($user->verification_code !== $data['code']) {
        return back()->withErrors([
            'code' => 'كود التحقق غير صحيح.',
        ])->withInput();
    }

    $user->update([
        'email_verified_at' => now(),
        'verification_code' => null,
        'verification_code_expires_at' => null,
    ]);

    return redirect()->route('login')->with('success', 'تم تفعيل الحساب بنجاح، يمكنك الآن تسجيل الدخول.');
})->name('verify.code.submit');

Route::post('/verify-code/resend', function (Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email'],
    ], [
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
    ]);

    $user = User::where('email', $data['email'])->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'هذا البريد غير موجود.',
        ]);
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('success', 'تم التحقق من البريد مسبقاً.');
    }

    $user->update([
        'verification_code' => (string) random_int(100000, 999999),
        'verification_code_expires_at' => now()->addMinutes(10),
    ]);

    Mail::to($user->email)->send(new EmailVerificationCodeMail($user));

    return back()->with('success', 'تم إرسال كود جديد إلى بريدك الإلكتروني.');
})->name('verify.code.resend');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Protected App Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Receipts
    |--------------------------------------------------------------------------
    */
    Route::get('receipts', [ReceiptController::class, 'index'])->name('receipts.index');

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */
    Route::resource('products', ProductController::class);
    Route::get('/my-products', [ProductController::class, 'myProducts'])->name('products.mine');

    Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])
        ->name('products.images.destroy');

    Route::put('products/{product}/images/{image}/make-main', [ProductController::class, 'makeMainImage'])
        ->name('products.images.makeMain');

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | Activities
    |--------------------------------------------------------------------------
    */
    Route::get('/activities', [ProductActivityController::class, 'index'])
        ->name('activities.index');

    /*
    |--------------------------------------------------------------------------
    | Suppliers
    |--------------------------------------------------------------------------
    */
    Route::resource('suppliers', SupplierController::class);
    Route::get('suppliers/{supplier}/statement', [SupplierController::class, 'statement'])
        ->name('suppliers.statement');

    /*
    |--------------------------------------------------------------------------
    | Supplier Payments
    |--------------------------------------------------------------------------
    */
    Route::get('supplier-payments/create/{supplier}', [SupplierPaymentController::class, 'create'])
        ->name('supplier.payments.create');

    Route::post('supplier-payments/store', [SupplierPaymentController::class, 'store'])
        ->name('supplier.payments.store');

    Route::get('supplier-payments/{payment}/receipt', [SupplierPaymentController::class, 'receipt'])
        ->name('supplier.payments.receipt');

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */
    Route::resource('customers', CustomerController::class);
    Route::get('customers/{customer}/statement', [CustomerController::class, 'statement'])
        ->name('customers.statement');

    /*
    |--------------------------------------------------------------------------
    | Customer Payments
    |--------------------------------------------------------------------------
    */
    Route::get('customer-payments/create/{customer}', [CustomerPaymentController::class, 'create'])
        ->name('customer.payments.create');

    Route::post('customer-payments/store', [CustomerPaymentController::class, 'store'])
        ->name('customer.payments.store');

    Route::get('customer-payments/{payment}/receipt', [CustomerPaymentController::class, 'receipt'])
        ->name('customer.payments.receipt');

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */
    Route::get('purchases', [PurchaseInvoiceController::class, 'index'])->name('purchases.index');
    Route::get('purchases/create', [PurchaseInvoiceController::class, 'create'])->name('purchases.create');
    Route::post('purchases', [PurchaseInvoiceController::class, 'store'])->name('purchases.store');
    Route::get('purchases/{purchase}', [PurchaseInvoiceController::class, 'show'])->name('purchases.show');

    /*
    |--------------------------------------------------------------------------
    | Cash
    |--------------------------------------------------------------------------
    */
    Route::get('cash', [CashController::class, 'index'])->name('cash.index');

    /*
    |--------------------------------------------------------------------------
    | POS
    |--------------------------------------------------------------------------
    */
    Route::get('pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('pos/store', [PosController::class, 'store'])->name('pos.store');

    /*
    |--------------------------------------------------------------------------
    | Sales
    |--------------------------------------------------------------------------
    */
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::delete('sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');

    /*
    |--------------------------------------------------------------------------
    | Profits
    |--------------------------------------------------------------------------
    */
    Route::get('profits', [ProfitController::class, 'index'])->name('profits.index');
});
