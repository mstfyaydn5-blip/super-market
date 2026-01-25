<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>تسجيل الدخول - ماركت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f3f4f6;
        }
        .auth-card {
            max-width: 420px;
            margin: 40px auto;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,.08);
        }
        .auth-card .card-header {
            background: linear-gradient(135deg,#2563eb,#22c55e);
            color:#fff;
            border-radius: 20px 20px 0 0 !important;
        }
    </style>
</head>
<body>

<div class="card auth-card">
    <div class="card-header text-center py-3">
        <h4 class="mb-0">تسجيل الدخول</h4>
        <small>سوبر ماركت - لوحة التحكم</small>
    </div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required autocomplete="current-password">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        تذكرني
                    </label>
                </div>
                <a href="#" class="small">نسيت كلمة المرور؟</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                دخول
            </button>

            <div class="text-center mt-3">
                <small>ما عندك حساب؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a></small>
            </div>
        </form>
    </div>
</div>

</body>
</html>
