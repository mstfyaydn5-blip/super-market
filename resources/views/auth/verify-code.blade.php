<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>التحقق من البريد - ماركت</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --primary:#2563eb;
            --success:#22c55e;
            --bg:#f3f6fb;
            --card:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:#e5e7eb;
            --shadow:0 20px 45px rgba(15, 23, 42, .10);
        }

        body{
            margin:0;
            min-height:100vh;
            font-family:"Tahoma","Segoe UI",sans-serif;
            background:
                radial-gradient(circle at top right, rgba(37,99,235,.10), transparent 25%),
                radial-gradient(circle at bottom left, rgba(34,197,94,.10), transparent 25%),
                var(--bg);
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
        }

        .verify-card{
            width:100%;
            max-width:520px;
            background:#fff;
            border-radius:28px;
            box-shadow:var(--shadow);
            overflow:hidden;
        }

        .verify-header{
            padding:28px 30px;
            background:linear-gradient(135deg,#2563eb,#22c55e);
            color:#fff;
            text-align:center;
        }

        .verify-icon{
            width:74px;
            height:74px;
            border-radius:22px;
            display:grid;
            place-items:center;
            margin:0 auto 14px;
            background:rgba(255,255,255,.16);
            font-size:30px;
        }

        .verify-header h3{
            margin:0 0 8px;
            font-weight:800;
        }

        .verify-header p{
            margin:0;
            color:rgba(255,255,255,.92);
            font-size:14px;
            line-height:1.8;
        }

        .verify-body{
            padding:30px;
        }

        .alert{
            border-radius:14px;
        }

        .email-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 14px;
            border-radius:14px;
            background:#eff6ff;
            color:#1d4ed8;
            font-size:14px;
            font-weight:700;
            margin-bottom:18px;
            word-break:break-all;
        }

        .form-label{
            font-weight:700;
            color:#334155;
            margin-bottom:8px;
            font-size:14px;
        }

        .form-control{
            height:58px;
            border-radius:16px;
            border:1px solid var(--border);
            text-align:center;
            font-size:24px;
            letter-spacing:10px;
            box-shadow:none !important;
        }

        .form-control:focus{
            border-color:rgba(37,99,235,.45);
            box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
        }

        .help-text{
            color:var(--muted);
            font-size:13px;
            margin-top:8px;
        }

        .btn-main{
            height:54px;
            border:none;
            border-radius:16px;
            background:linear-gradient(135deg,#2563eb,#22c55e);
            color:#fff;
            font-weight:800;
            box-shadow:0 14px 28px rgba(37,99,235,.18);
        }

        .btn-light-custom{
            height:52px;
            border:none;
            border-radius:16px;
            background:#eef2f7;
            color:#0f172a;
            font-weight:700;
        }

        .bottom-link{
            text-align:center;
            margin-top:18px;
            font-size:14px;
            color:#64748b;
        }

        .bottom-link a{
            text-decoration:none;
            font-weight:700;
            color:#2563eb;
        }
    </style>
</head>
<body>

<div class="verify-card">
    <div class="verify-header">
        <div class="verify-icon">
            <i class="bi bi-patch-check"></i>
        </div>
        <h3>تأكيد البريد الإلكتروني</h3>
        <p>أدخل كود التحقق المكوّن من 6 أرقام لتفعيل حسابك ومتابعة تسجيل الدخول</p>
    </div>

    <div class="verify-body">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="email-badge">
            <i class="bi bi-envelope-check"></i>
            <span>{{ $email ?? old('email') }}</span>
        </div>

        <form method="POST" action="{{ route('verify.code.submit') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

            <div class="mb-3">
                <label class="form-label">كود التحقق</label>
                <input type="text" name="code" class="form-control" maxlength="6" inputmode="numeric" placeholder="000000" required>
                <div class="help-text">تحقق من بريدك الإلكتروني وأدخل الكود كما وصلك تماماً.</div>
            </div>

            <button type="submit" class="btn btn-main w-100 mb-3">
                <i class="bi bi-check-circle ms-1"></i>
                تأكيد الكود
            </button>
        </form>

        <form method="POST" action="{{ route('verify.code.resend') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
            <button type="submit" class="btn btn-light-custom w-100">
                <i class="bi bi-arrow-repeat ms-1"></i>
                إعادة إرسال الكود
            </button>
        </form>

        <div class="bottom-link">
            رجوع إلى
            <a href="{{ route('login') }}">تسجيل الدخول</a>
        </div>
    </div>
</div>

<script>
    const codeInput = document.querySelector('input[name="code"]');

    if (codeInput) {
        codeInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
        });
    }
</script>

</body>
</html>
