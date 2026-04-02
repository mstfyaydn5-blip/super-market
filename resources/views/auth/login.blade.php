<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول - ماركت</title>

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
            font-family: "Tahoma", "Segoe UI", sans-serif;
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
            max-width:1100px;
            display:grid;
            grid-template-columns: 1.05fr .95fr;
            background:var(--card);
            border-radius:28px;
            overflow:hidden;
            box-shadow:var(--shadow);
        }

        .auth-side{
            position:relative;
            padding:48px;
            background:linear-gradient(135deg, #2563eb 0%, #1d4ed8 45%, #22c55e 100%);
            color:#fff;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
        }

        .auth-side::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,.20), transparent 20%),
                radial-gradient(circle at 80% 30%, rgba(255,255,255,.14), transparent 18%),
                radial-gradient(circle at 60% 80%, rgba(255,255,255,.12), transparent 22%);
            pointer-events:none;
        }

        .brand,
        .side-content,
        .side-footer{
            position:relative;
            z-index:1;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            font-size:20px;
            font-weight:700;
        }

        .brand-icon{
            width:48px;
            height:48px;
            border-radius:14px;
            display:grid;
            place-items:center;
            background:rgba(255,255,255,.18);
            backdrop-filter: blur(6px);
            font-size:22px;
        }

        .side-content h1{
            font-size:34px;
            font-weight:800;
            line-height:1.4;
            margin-bottom:14px;
        }

        .side-content p{
            font-size:15px;
            line-height:1.9;
            color:rgba(255,255,255,.92);
            margin-bottom:28px;
        }

        .feature-list{
            display:grid;
            gap:14px;
        }

        .feature-item{
            display:flex;
            align-items:center;
            gap:12px;
            padding:14px 16px;
            border-radius:16px;
            background:rgba(255,255,255,.12);
            backdrop-filter: blur(8px);
        }

        .feature-item i{
            font-size:18px;
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
            max-width:420px;
        }

        .form-box .title{
            font-size:30px;
            font-weight:800;
            margin-bottom:8px;
            color:var(--text);
        }

        .form-box .subtitle{
            color:var(--muted);
            margin-bottom:28px;
            font-size:14px;
        }

        .alert{
            border-radius:14px;
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
            transition:.2s ease;
        }

        .input-group .form-control{
            border-radius:0 14px 14px 0;
        }

        .form-control:focus{
            border-color:rgba(37,99,235,.45);
            box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
        }

        .form-check-label{
            color:var(--muted);
            font-size:14px;
        }

        .btn-auth{
            height:54px;
            border:none;
            border-radius:16px;
            background:linear-gradient(135deg, var(--primary), var(--success));
            color:#fff;
            font-weight:800;
            font-size:15px;
            transition:.2s ease;
            box-shadow:0 14px 28px rgba(37,99,235,.18);
        }

        .btn-auth:hover{
            transform:translateY(-1px);
            opacity:.96;
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

        .auth-switch a:hover{
            text-decoration:underline;
        }

        .mini-note{
            text-align:center;
            margin-top:12px;
            color:var(--muted);
            font-size:13px;
        }

        @media (max-width: 991px){
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

        @media (max-width: 576px){
            body{
                padding:14px;
            }

            .auth-form{
                padding:22px 18px;
            }

            .form-box .title{
                font-size:25px;
            }
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
            <h1>مرحباً بعودتك<br>إلى لوحة التحكم</h1>
            <p>
                ادخل إلى نظام إدارة السوبر ماركت بشكل آمن وسريع، وتابع المنتجات،
                المبيعات، العملاء، الموردين، والصندوق من مكان واحد.
            </p>

            <div class="feature-list">
                <div class="feature-item">
                    <i class="bi bi-shield-check"></i>
                    <span>دخول آمن ومنظم للحساب</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>متابعة النشاط والمبيعات بسهولة</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-people"></i>
                    <span>إدارة العملاء والموردين باحترافية</span>
                </div>
            </div>
        </div>

        <div class="side-footer">
            سوبر ماركت - نظام إدارة احترافي
        </div>
    </div>

    <div class="auth-form">
        <div class="form-box">
            <div class="title">تسجيل الدخول</div>
            <div class="subtitle">أدخل بيانات حسابك للوصول إلى لوحة التحكم</div>

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

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="ادخل البريد الإلكتروني" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="ادخل كلمة المرور" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">تذكرني</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-auth w-100">
                    <i class="bi bi-box-arrow-in-left ms-1"></i>
                    تسجيل الدخول
                </button>

                <div class="auth-switch">
                    ما عندك حساب؟
                    <a href="{{ route('register') }}">إنشاء حساب جديد</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
