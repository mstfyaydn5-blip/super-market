<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name','Super Market') }}</title>

    <style>
        body{
            margin:0;
            font-family: system-ui, -apple-system, "Segoe UI", Tahoma, Arial;
            background: radial-gradient(1200px 600px at 80% 10%, rgba(99,102,241,.25), transparent 60%),
                        radial-gradient(900px 500px at 10% 90%, rgba(16,185,129,.18), transparent 55%),
                        #0b1220;
            color:#e5e7eb;
        }
        .wrap{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
        }
        .cardx{
            width:min(520px, 100%);
            background: rgba(15,23,42,.75);
            border:1px solid rgba(255,255,255,.08);
            border-radius:24px;
            box-shadow: 0 20px 60px rgba(0,0,0,.45);
            overflow:hidden;
        }
        .top{
            padding:26px 26px 14px;
            border-bottom:1px solid rgba(255,255,255,.08);
            background: linear-gradient(135deg, rgba(99,102,241,.15), rgba(16,185,129,.08));
        }
        .logo{
            display:flex;
            align-items:center;
            gap:12px;
        }
        .badge{
            width:48px;height:48px;
            border-radius:16px;
            display:grid;place-items:center;
            background: rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.10);
            font-weight:900;
            letter-spacing:.5px;
        }
        .title{
            font-size:20px;
            font-weight:800;
            margin:0;
        }
        .sub{
            margin:4px 0 0;
            color:rgba(255,255,255,.65);
            font-size:13px;
            line-height:1.7;
        }
        .content{
            padding:22px 26px 26px;
        }
        .btnx{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            width:100%;
            border:0;
            border-radius:16px;
            padding:12px 14px;
            font-weight:800;
            cursor:pointer;
            text-decoration:none;
            transition:.2s;
        }
        .btn-primary{
            background:#6366f1;
            color:white;
        }
        .btn-primary:hover{ filter:brightness(1.06); transform: translateY(-1px); }
        .btn-ghost{
            background: rgba(255,255,255,.06);
            color:white;
            border:1px solid rgba(255,255,255,.10);
            margin-top:10px;
        }
        .btn-ghost:hover{ background: rgba(255,255,255,.10); transform: translateY(-1px); }
        .btn-success{
            background:#10b981;
            color:#06130f;
        }
        .btn-success:hover{ filter:brightness(1.04); transform: translateY(-1px); }
        .btn-danger{
            background: rgba(239,68,68,.16);
            color:#fecaca;
            border:1px solid rgba(239,68,68,.25);
            margin-top:10px;
        }
        .btn-danger:hover{ background: rgba(239,68,68,.22); transform: translateY(-1px); }
        .note{
            margin-top:14px;
            font-size:12px;
            color:rgba(255,255,255,.55);
            text-align:center;
        }
        .pill{
            display:inline-block;
            padding:6px 10px;
            border-radius:999px;
            background: rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.10);
            font-size:12px;
            color:rgba(255,255,255,.75);
            margin-top:14px;
        }
        .hello{
            padding:12px 14px;
            border-radius:16px;
            background: rgba(16,185,129,.12);
            border:1px solid rgba(16,185,129,.22);
            color: rgba(236,253,245,.95);
            font-size:13px;
            margin-bottom:14px;
        }
    </style>
</head>

<body>
<div class="wrap">
    <div class="cardx">
        <div class="top">
            <div class="logo">
                <div class="badge">M</div>
                <div>
                    <p class="title">Super Market</p>
                    <p class="sub">سجّل دخولك أو أنشئ حساب، وبعدها ادخل لوحة السوبر ماركت مباشرة.</p>
                </div>
            </div>
            <div class="pill">CRUD منتجات + أصناف + صور + بحث + فلترة</div>
        </div>

        <div class="content">
            @guest
                <a class="btnx btn-primary" href="{{ route('login') }}" >
                    🔐 تسجيل الدخول
                </a>

                <a class="btnx btn-ghost" href="{{ route('register') }}">
                    📝 إنشاء حساب جديد
                </a>


            @endguest

            @auth
                <div class="hello">
                    أهلاً <b>{{ auth()->user()->name }}</b> 👋 جاهز تدخل لوحة السوبر ماركت؟
                </div>

                <a class="btnx btn-success" href="{{ route('products.index') }}">
                    🏪 الدخول إلى السوبر ماركت
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btnx btn-danger" type="submit">
                        تسجيل خروج
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>
</body>
</html>
