<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>التسجيل - ماركت</title>
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
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .valid-password {
            border-color: #198754 !important;
        }
    </style>
</head>
<body>

<div class="card auth-card">
    <div class="card-header text-center py-3">
        <h4 class="mb-0">إنشاء حساب جديد</h4>
        <small>سوبر ماركت - لوحة التحكم</small>
    </div>
    <div class="card-body p-4">
        <form method="POST" action="{{route('register.store')}}">
            @csrf

            <div class="mb-3">
                <label class="form-label">الاسم الكامل</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" id="password" name="password" class="form-control" minlength="6" required>
                <div class="form-text">يُفضّل ألا تقل عن 6 أحرف/أرقام.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" minlength="6" required>
                <div id="password-error" class="invalid-feedback d-block" style="display:none;">

                </div>
                <div id="password-ok" class="valid-feedback d-block" style="display:none;">
                 
                </div>
            </div>

            <button id="register-btn" type="submit" class="btn btn-primary w-100" disabled>
                إنشاء الحساب
            </button>

            <div class="text-center mt-3">
                <small>لديك حساب بالفعل؟ <a href="/login">تسجيل الدخول</a></small>
            </div>
        </form>
    </div>
</div>

<script>
    const passwordInput  = document.getElementById('password');
    const confirmInput   = document.getElementById('password_confirmation');
    const errorDiv       = document.getElementById('password-error');
    const okDiv          = document.getElementById('password-ok');
    const registerButton = document.getElementById('register-btn');

    function validatePasswords() {
        const pass  = passwordInput.value;
        const conf  = confirmInput.value;


        if (!pass || !conf) {
            errorDiv.style.display = 'none';
            okDiv.style.display    = 'none';
            confirmInput.classList.remove('is-invalid','valid-password');
            registerButton.disabled = true;
            return;
        }

        if (pass === conf) {

            errorDiv.style.display = 'none';
            okDiv.style.display    = 'block';
            confirmInput.classList.remove('is-invalid');
            confirmInput.classList.add('valid-password');
            registerButton.disabled = false;
        } else {

            okDiv.style.display    = 'none';
            errorDiv.style.display = 'block';
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
