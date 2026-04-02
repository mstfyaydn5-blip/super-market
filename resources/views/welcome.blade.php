<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ماركت - الصفحة الرئيسية</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f3f6fb;
            --card:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:#e5e7eb;
            --primary:#2563eb;
            --primary-2:#1d4ed8;
            --success:#22c55e;
            --soft:#f8fafc;
            --soft-2:#eef2f7;
            --shadow:0 20px 45px rgba(15, 23, 42, .10);
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            min-height:100vh;
            font-family:"Tahoma","Segoe UI",sans-serif;
            color:var(--text);
            background:
                radial-gradient(circle at top right, rgba(37,99,235,.10), transparent 25%),
                radial-gradient(circle at bottom left, rgba(34,197,94,.10), transparent 25%),
                var(--bg);
            overflow-x:hidden;
            position:relative;
        }

        .page-wrap{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:32px 18px;
        }

        .hero-card{
            width:100%;
            max-width:1080px;
            min-height:620px;
            border-radius:30px;
            overflow:hidden;
            background:#fff;
            border:1px solid var(--border);
            box-shadow:var(--shadow);
            display:grid;
            grid-template-columns: 1.1fr .9fr;
            animation:fadeUp .7s ease;
        }

        .hero-side{
            position:relative;
            padding:48px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            background:
                radial-gradient(circle at 20% 20%, rgba(37,99,235,.06), transparent 24%),
                linear-gradient(180deg, #ffffff, #f8fbff);
        }

        .hero-side::after{
            content:"";
            position:absolute;
            left:0;
            top:0;
            bottom:0;
            width:1px;
            background:var(--border);
        }

        .brand{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .brand-badge{
            width:56px;
            height:56px;
            border-radius:18px;
            display:grid;
            place-items:center;
            background:linear-gradient(135deg, rgba(37,99,235,.12), rgba(34,197,94,.10));
            border:1px solid var(--border);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.8);
            font-size:22px;
            font-weight:800;
            color:var(--primary);
        }

        .brand-text h1{
            margin:0;
            font-size:31px;
            font-weight:800;
            color:var(--text);
        }

        .brand-text p{
            margin:6px 0 0;
            color:var(--muted);
            font-size:14px;
        }

        .hero-content{
            margin-top:36px;
        }

        .hero-content .welcome{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 14px;
            border-radius:999px;
            background:#eff6ff;
            border:1px solid #dbeafe;
            color:#1d4ed8;
            font-size:13px;
            margin-bottom:18px;
            font-weight:700;
        }

        .hero-content h2{
            margin:0 0 14px;
            font-size:42px;
            line-height:1.45;
            font-weight:800;
            color:var(--text);
        }

        .hero-content p{
            margin:0;
            font-size:16px;
            line-height:2;
            color:var(--muted);
            max-width:540px;
        }

        .mini-stats{
            margin-top:28px;
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap:14px;
            max-width:620px;
        }

        .mini-stat{
            background:#fff;
            border:1px solid var(--border);
            border-radius:20px;
            padding:18px;
            box-shadow:0 8px 20px rgba(15, 23, 42, .04);
        }

        .mini-stat .num{
            display:block;
            font-size:22px;
            font-weight:800;
            color:var(--text);
            margin-bottom:6px;
        }

        .mini-stat .label{
            font-size:13px;
            color:var(--muted);
        }

        .hero-footer{
            display:flex;
            flex-wrap:wrap;
            gap:12px;
            margin-top:24px;
        }

        .hero-chip{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:11px 14px;
            border-radius:14px;
            background:#fff;
            border:1px solid var(--border);
            color:#334155;
            font-size:13px;
            box-shadow:0 8px 18px rgba(15, 23, 42, .04);
        }

        .action-side{
            padding:40px;
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
            background:linear-gradient(180deg, #fcfdff, #f8fafc);
        }

        .action-panel{
            width:100%;
            max-width:390px;
            background:#fff;
            border:1px solid var(--border);
            border-radius:28px;
            padding:30px;
            box-shadow:0 20px 45px rgba(15, 23, 42, .08);
        }

        .panel-top{
            text-align:center;
            margin-bottom:26px;
        }

        .panel-logo{
            width:74px;
            height:74px;
            margin:0 auto 16px;
            border-radius:22px;
            display:grid;
            place-items:center;
            font-size:28px;
            color:#fff;
            background:linear-gradient(135deg, var(--primary), var(--success));
            box-shadow:0 18px 35px rgba(37,99,235,.20);
        }

        .panel-top h3{
            margin:0;
            font-size:28px;
            font-weight:800;
            color:var(--text);
        }

        .panel-top p{
            margin:10px 0 0;
            color:var(--muted);
            line-height:1.9;
            font-size:14px;
        }

        .action-buttons{
            display:grid;
            gap:14px;
        }

        .action-btn{
            height:58px;
            border-radius:18px;
            border:none;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            text-decoration:none;
            font-size:15px;
            font-weight:800;
            transition:.2s ease;
        }

        .action-btn:hover{
            transform:translateY(-2px);
        }

        .action-btn.primary{
            color:#fff;
            background:linear-gradient(135deg, var(--primary), var(--success));
            box-shadow:0 16px 30px rgba(37,99,235,.18);
        }

        .action-btn.secondary{
            color:var(--text);
            background:#f3f4f6;
            border:1px solid var(--border);
        }

        .panel-note{
            margin-top:18px;
            text-align:center;
            color:var(--muted);
            font-size:13px;
            line-height:1.9;
        }

        .panel-note strong{
            color:var(--text);
        }

        @keyframes fadeUp{
            from{
                opacity:0;
                transform:translateY(18px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        @media (max-width: 991px){
            .hero-card{
                grid-template-columns:1fr;
            }

            .hero-side{
                padding:30px 24px;
            }

            .hero-side::after{
                display:none;
            }

            .hero-content h2{
                font-size:31px;
            }

            .action-side{
                padding:0 24px 24px;
            }

            .mini-stats{
                grid-template-columns:1fr;
                max-width:none;
            }
        }

        @media (max-width: 576px){
            .page-wrap{
                padding:14px;
            }

            .hero-side,
            .action-side{
                padding:22px;
            }

            .action-side{
                padding-top:0;
            }

            .hero-content h2{
                font-size:26px;
            }

            .panel-top h3{
                font-size:24px;
            }

            .action-panel{
                padding:22px;
                border-radius:22px;
            }
        }
    </style>
</head>
<body>

<div class="page-wrap">
    <div class="hero-card">

        <div class="hero-side">
            <div>
                <div class="brand">
                    <div class="brand-badge">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="brand-text">
                        <h1>Super Market</h1>
                        <p>نظام إدارة ذكي وحديث للسوبر ماركت</p>
                    </div>
                </div>

                <div class="hero-content">
                    <div class="welcome">
                        <i class="bi bi-stars"></i>
                        <span>واجهة دخول حديثة ومريحة</span>
                    </div>

                    <h2>
                        تحكم بالمخزون والمبيعات
                        <br>
                        والعملاء والموردين
                        <br>
                        من مكان واحد
                    </h2>

                    <p>
                        منصة مرتبة وسهلة تساعدك بإدارة مشروع السوبر ماركت باحترافية،
                        من متابعة المنتجات والأصناف إلى الفواتير والصندوق والمبيعات اليومية.
                    </p>

                    <div class="mini-stats">
                        <div class="mini-stat">
                            <span class="num">CRUD</span>
                            <span class="label">إدارة كاملة للمنتجات والأصناف</span>
                        </div>
                        <div class="mini-stat">
                            <span class="num">POS</span>
                            <span class="label">واجهة بيع سريعة ومنظمة</span>
                        </div>
                        <div class="mini-stat">
                            <span class="num">24/7</span>
                            <span class="label">وصول سريع إلى لوحة التحكم</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-footer">
                <div class="hero-chip"><i class="bi bi-box-seam"></i> إدارة المخزون</div>
                <div class="hero-chip"><i class="bi bi-people"></i> العملاء والموردين</div>
                <div class="hero-chip"><i class="bi bi-cash-stack"></i> الصندوق والحسابات</div>
            </div>
        </div>

        <div class="action-side">
            <div class="action-panel">
                <div class="panel-top">
                    <div class="panel-logo">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                    <h3>ابدأ الآن</h3>
                    <p>
                        سجّل الدخول إلى حسابك أو أنشئ حساب جديد
                        للوصول إلى لوحة التحكم الخاصة بالمشروع.
                    </p>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('login') }}" class="action-btn primary">
                        <i class="bi bi-box-arrow-in-left"></i>
                        <span>تسجيل الدخول</span>
                    </a>

                    <a href="{{ route('register') }}" class="action-btn secondary">
                        <i class="bi bi-person-plus"></i>
                        <span>إنشاء حساب جديد</span>
                    </a>
                </div>

                <div class="panel-note">
                    واجهة حديثة ومناسبة لمشروع <strong>السوبر ماركت</strong>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
