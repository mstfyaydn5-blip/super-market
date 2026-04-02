<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إنشاء حساب - ماركت</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --primary:#2563eb;
            --primary-2:#1d4ed8;
            --success:#22c55e;
            --bg:#f3f6fb;
            --card:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:#e5e7eb;
            --danger:#dc3545;
            --shadow:0 20px 45px rgba(15, 23, 42, .10);
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            min-height:100vh;
            font-family:"Tahoma","Segoe UI",sans-serif;
            background:
                radial-gradient(circle at top right, rgba(37,99,235,.10), transparent 25%),
                radial-gradient(circle at bottom left, rgba(34,197,94,.10), transparent 25%),
                var(--bg);
            color:var(--text);
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
        }

        .auth-wrapper{
            width:100%;
            max-width:1120px;
            display:grid;
            grid-template-columns: 1fr 1fr;
            background:#fff;
            border-radius:28px;
            overflow:hidden;
            box-shadow:var(--shadow);
        }

        .auth-side{
            padding:48px;
            background:linear-gradient(135deg,#2563eb 0%, #1d4ed8 45%, #22c55e 100%);
            color:#fff;
            position:relative;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
        }

        .auth-side::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                radial-gradient(circle at 18% 22%, rgba(255,255,255,.20), transparent 20%),
                radial-gradient(circle at 82% 28%, rgba(255,255,255,.14), transparent 18%),
                radial-gradient(circle at 60% 78%, rgba(255,255,255,.12), transparent 22%);
            pointer-events:none;
        }

        .brand,.side-content,.side-footer{ position:relative; z-index:1; }

        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            font-size:20px;
            font-weight:800;
        }

        .brand-icon{
            width:48px;
            height:48px;
            border-radius:14px;
            display:grid;
            place-items:center;
            background:rgba(255,255,255,.18);
            font-size:22px;
        }

        .side-content h1{
            font-size:34px;
            font-weight:800;
            line-height:1.4;
            margin-bottom:14px;
        }

        .side-content p{
            line-height:1.9;
            color:rgba(255,255,255,.92);
            margin-bottom:28px;
            font-size:15px;
        }

        .steps{
            display:grid;
            gap:14px;
        }

        .step{
            padding:14px 16px;
            border-radius:16px;
            background:rgba(255,255,255,.12);
            display:flex;
            align-items:center;
            gap:12px;
        }

        .step-number{
            min-width:32px;
            height:32px;
            border-radius:10px;
            display:grid;
            place-items:center;
            background:#fff;
            color:#2563eb;
            font-weight:800;
            font-size:14px;
        }

        .side-footer{
            font-size:13px;
            color:rgba(255,255,255,.88);
        }

        .auth-form{
            padding:48px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .form-box{
            width:100%;
            max-width:430px;
        }

        .title{
            font-size:30px;
            font-weight:800;
            margin-bottom:8px;
        }

        .subtitle{
            color:var(--muted);
            margin-bottom:28px;
            font-size:14px;
        }

        .form-label{
            font-weight:700;
            color:#334155;
            margin-bottom:8px;
            font-size:14px;
        }

        .input-group-text{
            border-radius:14px 0 0 14px;
            background:#f8fafc;
            border-color:var(--border);
        }

        .form-control{
            height:52px;
            border-radius:14px;
            border:1px solid var(--border);
            box-shadow:none !important;
            padding-inline:14px;
        }

        .input-group .form-control{
            border-radius:0 14px 14px 0;
        }

        .form-control:focus{
            border-color:rgba(37,99,235,.45);
            box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
        }

        .is-invalid{
            border-color:#dc3545 !important;
        }

        .valid-password{
            border-color:#198754 !important;
        }

        .btn-auth{
            height:54px;
            border:none;
            border-radius:16px;
            background:linear-gradient(135deg,var(--primary),var(--success));
            color:#fff;
            font-weight:800;
            font-size:15px;
            box-shadow:0 14px 28px rgba(37,99,235,.18);
        }

        .btn-auth:disabled{
            opacity:.65;
            cursor:not-allowed;
        }

        .auth-switch{
            text-align:center;
            margin-top:22px;
            color:var(--muted);
            font-size:14px;
        }

        .auth-switch a{
            color:var(--primary);
            font-weight:700;
            text-decoration:none;
        }

        .alert{
            border-radius:14px;
        }

        @media (max-width:991px){
            .auth-wrapper{
                grid-template-columns:1fr;
            }

            .auth-side{
                display:none;
            }

            .auth-form{
                padding:28px;
            }
        }

        @media (max-width:576px){
            body{ padding:14px; }
            .auth-form{ padding:22px 18px; }
            .title{ font-size:25px; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-side">
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-shop"></i></div>
            <span>ماركت</span>
        </div>

        <div class="side-content">
            <h1>أنشئ حسابك<br>وابدأ الإدارة بسهولة</h1>
            <p>
                أنشئ حساباً جديداً للوصول إلى النظام، ثم أكمل التحقق عبر كود البريد
                الإلكتروني لتفعيل الحساب بشكل آمن.
            </p>

            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div>أدخل الاسم والبريد وكلمة المرور</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div>استلم كود التحقق على البريد الإلكتروني</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div>فعّل الحساب وابدأ استخدام النظام</div>
                </div>
            </div>
        </div>

        <div class="side-footer">
            نظام سوبر ماركت احترافي وآمن
        </div>
    </div>

    <div class="auth-form">
        <div class="form-box">
            <div class="title">إنشاء حساب جديد</div>
            <div class="subtitle">املأ الحقول التالية لإتمام التسجيل</div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">الاسم الكامل</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="ادخل الاسم الكامل" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="ادخل البريد الإلكتروني" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="6" placeholder="ادخل كلمة المرور" required>
                    </div>
                    <div class="form-text">يجب أن تكون 6 أحرف أو أكثر.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">تأكيد كلمة المرور</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" minlength="6" placeholder="أعد إدخال كلمة المرور" required>
                    </div>
                    <div id="password-error" class="invalid-feedback d-none">
                        كلمة المرور غير متطابقة
                    </div>
                    <div id="password-ok" class="valid-feedback d-none">
                        كلمة المرور متطابقة
                    </div>
                </div>

                <button id="register-btn" type="submit" class="btn btn-auth w-100" disabled>
                    <i class="bi bi-person-plus ms-1"></i>
                    إنشاء الحساب
                </button>

                <div class="auth-switch">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}">تسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const errorDiv = document.getElementById('password-error');
    const okDiv = document.getElementById('password-ok');
    const registerButton = document.getElementById('register-btn');

    function validatePasswords() {
        const pass = passwordInput.value.trim();
        const conf = confirmInput.value.trim();

        if (!pass || !conf) {
            errorDiv.classList.add('d-none');
            okDiv.classList.add('d-none');
            confirmInput.classList.remove('is-invalid', 'valid-password');
            registerButton.disabled = true;
            return;
        }

        if (pass === conf) {
            errorDiv.classList.add('d-none');
            okDiv.classList.remove('d-none');
            confirmInput.classList.remove('is-invalid');
            confirmInput.classList.add('valid-password');
            registerButton.disabled = false;
        } else {
            okDiv.classList.add('d-none');
            errorDiv.classList.remove('d-none');
            confirmInput.classList.remove('valid-password');
            confirmInput.classList.add('is-invalid');
            registerButton.disabled = true;
        }
    }

    passwordInput.addEventListener('input', validatePasswords);
    confirmInput.addEventListener('input', validatePasswords);
</script>

</body>
</html>
