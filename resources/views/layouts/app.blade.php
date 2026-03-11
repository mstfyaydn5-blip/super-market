<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Market</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root{
            --bg:#f6f7fb;
            --card:#ffffff;
            --border:#e6e8ef;
            --text:#111827;
            --muted:#6b7280;
            --primary:#2563eb;
            --primary-weak:#e8f0ff;
        }

        body{ background:var(--bg); color:var(--text); }

        .app-shell{ min-height:100vh; }

        .sidebar{
            min-height:100vh;
            background:var(--card);
            border-left:1px solid var(--border);
            position:sticky;
            top:0;
        }

        .brand{
            border:1px solid var(--border);
            border-radius:16px;
            background:linear-gradient(135deg,#fff,#f3f6ff);
            padding:14px;
        }

        .menu-section{
            margin-top: 10px;
            margin-bottom: 6px;
            padding: 0 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .2px;
        }

        .nav-itemx{
            display:flex;
            align-items:center;
            gap:10px;
            padding:10px 12px;
            border-radius:12px;
            width:100%;
            text-decoration:none;
            color:var(--text);
            transition:.15s;
            justify-content:flex-start;
        }

        .nav-itemx:hover{
            background:#f3f6ff;
            color:var(--primary);
        }

        .nav-itemx.active{
            background:var(--primary-weak);
            color:var(--primary);
            font-weight:700;
        }

        .nav-icon{
            width:36px;
            height:36px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#f1f3f7;
            flex:0 0 auto;
            font-size:18px;
            color:#374151;
        }

        .nav-itemx.active .nav-icon{
            background:#dbe7ff;
            color:var(--primary);
        }

        .chev{
            margin-right:auto;
            transition:.2s;
            opacity:.7;
            font-size:13px;
        }

        button[aria-expanded="true"] .chev{
            transform:rotate(180deg);
        }

        .submenu{
            border-right:2px solid #edf0f5;
            margin-right:14px;
            padding-right:14px;
            padding-top:6px;
            display:grid;
            gap:6px;
        }

        .submenu .nav-itemx{
            font-size:14px;
            padding:9px 10px;
            border-radius:12px;
            font-weight:600;
        }

        .submenu .nav-itemx.active{
            background:#f1f6ff;
            color:var(--primary);
            font-weight:800;
        }

        .submenu .nav-itemx.active .nav-icon{
            background:#dbe7ff;
            color:var(--primary);
        }

        .submenu .nav-icon{
            width:30px;
            height:30px;
            border-radius:10px;
            font-size:14px;
        }

        .topbar{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:16px;
            box-shadow:0 10px 25px rgba(0,0,0,.04);
        }

        .content-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:16px;
            box-shadow:0 10px 25px rgba(0,0,0,.04);
        }

        .alert{
            border-radius:14px;
            border:1px solid var(--border);
        }

        @media (max-width: 992px){
            .sidebar{ position:relative; min-height:auto; }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="container-fluid app-shell">
    <div class="row">

        {{-- SIDEBAR --}}
        <aside class="col-12 col-lg-2 sidebar p-3 d-flex flex-column">

            <div class="brand mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-bold"><i class="bi bi-cart3"></i> Super Market</div>
                        <div class="text-muted small">لوحة الإدارة</div>
                    </div>
                    <span class="badge text-bg-light border">v1</span>
                </div>
            </div>

            <nav class="d-grid gap-2">

                {{-- الإدارة --}}
                <div class="menu-section">الإدارة</div>

                <a class="nav-itemx {{ request()->is('dashboard') ? 'active' : '' }}"
                   href="{{ url('/dashboard') }}">
                    <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                    لوحة التحكم
                </a>

                {{-- المخزون --}}
                <div class="menu-section">المخزون</div>

                @php $productsOpen = request()->is('products*'); @endphp
                <div>
                    <button class="nav-itemx border-0 bg-transparent {{ $productsOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuProducts"
                            aria-expanded="{{ $productsOpen ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                        المنتجات
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $productsOpen ? 'show' : '' }}" id="menuProducts">
                        <div class="submenu">
                            <a class="nav-itemx {{ request()->is('products') ? 'active' : '' }}"
                               href="{{ route('products.index') }}">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                عرض المنتجات
                            </a>

                            @if(\Illuminate\Support\Facades\Route::has('products.create'))
                                <a class="nav-itemx {{ request()->is('products/create') ? 'active' : '' }}"
                                   href="{{ route('products.create') }}">
                                    <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                    إضافة منتج
                                </a>
                            @endif

                            @if(\Illuminate\Support\Facades\Route::has('products.mine'))
                                <a class="nav-itemx {{ request()->is('products/mine') ? 'active' : '' }}"
                                   href="{{ route('products.mine') }}">
                                    <span class="nav-icon"><i class="bi bi-person"></i></span>
                                    منتجاتي
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @php $categoriesOpen = request()->is('categories*'); @endphp
                <div>
                    <button class="nav-itemx border-0 bg-transparent {{ $categoriesOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuCategories"
                            aria-expanded="{{ $categoriesOpen ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="bi bi-folder2"></i></span>
                        الأصناف
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $categoriesOpen ? 'show' : '' }}" id="menuCategories">
                        <div class="submenu">
                            <a class="nav-itemx {{ request()->is('categories') ? 'active' : '' }}"
                               href="{{ route('categories.index') }}">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                عرض الأصناف
                            </a>

                            @if(\Illuminate\Support\Facades\Route::has('categories.create'))
                                <a class="nav-itemx {{ request()->is('categories/create') ? 'active' : '' }}"
                                   href="{{ route('categories.create') }}">
                                    <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                    إضافة صنف
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- المحاسبة --}}
                <div class="menu-section">المحاسبة</div>

                @php $suppliersOpen = request()->is('suppliers*') || request()->is('supplier-payments*'); @endphp
                <div>
                    <button class="nav-itemx border-0 bg-transparent {{ $suppliersOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuSuppliers"
                            aria-expanded="{{ $suppliersOpen ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="bi bi-truck"></i></span>
                        الموردين
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $suppliersOpen ? 'show' : '' }}" id="menuSuppliers">
                        <div class="submenu">
                            <a class="nav-itemx {{ request()->is('suppliers') ? 'active' : '' }}"
                               href="{{ route('suppliers.index') }}">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                عرض الموردين
                            </a>

                            <a class="nav-itemx {{ request()->is('suppliers/create') ? 'active' : '' }}"
                               href="{{ route('suppliers.create') }}">
                                <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                إضافة مورد
                            </a>
                        </div>
                    </div>
                </div>

                @php $customersOpen = request()->is('customers*') || request()->is('customer-payments*'); @endphp
                <div>
                    <button class="nav-itemx border-0 bg-transparent {{ $customersOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuCustomers"
                            aria-expanded="{{ $customersOpen ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="bi bi-people"></i></span>
                        العملاء
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $customersOpen ? 'show' : '' }}" id="menuCustomers">
                        <div class="submenu">
                            <a class="nav-itemx {{ request()->is('customers') ? 'active' : '' }}"
                               href="{{ route('customers.index') }}">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                عرض العملاء
                            </a>

                            <a class="nav-itemx {{ request()->is('customers/create') ? 'active' : '' }}"
                               href="{{ route('customers.create') }}">
                                <span class="nav-icon"><i class="bi bi-person-plus"></i></span>
                                إضافة عميل
                            </a>
                        </div>
                    </div>
                </div>

                @php $cashOpen = request()->is('cash*'); @endphp
                <div>
                    <button class="nav-itemx border-0 bg-transparent {{ $cashOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuCash"
                            aria-expanded="{{ $cashOpen ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="bi bi-cash-stack"></i></span>
                        الصندوق
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $cashOpen ? 'show' : '' }}" id="menuCash">
                        <div class="submenu">
                            <a class="nav-itemx {{ request()->is('cash') ? 'active' : '' }}"
                               href="{{ route('cash.index') }}">
                                <span class="nav-icon"><i class="bi bi-wallet2"></i></span>
                                حركة الصندوق
                            </a>
                        </div>
                    </div>
                </div>

                {{-- السجلات --}}
                <div class="menu-section">السجلات</div>

                @php $activitiesOpen = request()->is('activities*'); @endphp
                <div>
                    <button class="nav-itemx border-0 bg-transparent {{ $activitiesOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuActivities"
                            aria-expanded="{{ $activitiesOpen ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="bi bi-receipt"></i></span>
                        سجل الموظفين
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $activitiesOpen ? 'show' : '' }}" id="menuActivities">
                        <div class="submenu">
                            <a class="nav-itemx {{ request()->is('activities') ? 'active' : '' }}"
                               href="{{ route('activities.index') }}">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                عرض السجل
                            </a>

                            @if(\Illuminate\Support\Facades\Route::has('activities.create'))
                                <a class="nav-itemx {{ request()->is('activities/create') ? 'active' : '' }}"
                                   href="{{ route('activities.create') }}">
                                    <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                    إضافة سجل
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </nav>

            <div class="mt-auto pt-3">
                <div class="content-card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">المستخدم</small>
                        <small class="fw-semibold">{{ auth()->user()->name ?? '' }}</small>
                    </div>

                    <form method="POST" action="{{ route('logout') }}"
                          onsubmit="return confirm('هل أنت متأكد من تسجيل الخروج؟');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- CONTENT --}}
        <main class="col-12 col-lg-10 p-4">

            <div class="topbar p-3 mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold">مرحباً 👋</div>
                    <div class="text-muted small">{{ now()->format('Y-m-d H:i') }}</div>
                </div>
                <div class="text-muted small">نظام إدارة السوبرماركت</div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <b>أكو أخطاء:</b>
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="content-card p-3">
                @yield('content')
            </div>

        </main>

    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('هل أنت متأكد من الحذف؟');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  tinymce.init({
    selector: '#description',
    directionality: "rtl",
    height: 300,
    menubar: false,
    plugins: 'lists link table',
    toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright'
  });
});
</script>

@stack('scripts')
</body>
</html>
