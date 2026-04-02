<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trim($__env->yieldContent('page_title', 'لوحة الإدارة')) }} - Super Market</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root{
            --bg:#f5f7fb;
            --card:#ffffff;
            --card-2:#f8faff;
            --border:#e7ebf3;
            --text:#0f172a;
            --muted:#6b7280;
            --primary:#2563eb;
            --primary-2:#1d4ed8;
            --primary-soft:#eef4ff;
            --danger:#dc2626;
            --success:#16a34a;
            --warning:#f59e0b;
            --shadow:0 10px 30px rgba(15, 23, 42, .06);
            --shadow-soft:0 6px 18px rgba(15, 23, 42, .04);
            --sidebar-width:280px;
            --sidebar-mini-width:92px;
            --topbar-height:92px;
            --settings-width:320px;
        }

        *{ box-sizing:border-box; }
        html,body{ height:100%; }

        body{
            margin:0;
            background:
                radial-gradient(circle at top right, rgba(37,99,235,.05), transparent 22%),
                linear-gradient(180deg, #f8faff 0%, #f4f7fb 100%);
            color:var(--text);
            font-family:"Segoe UI", Tahoma, Arial, sans-serif;
            overflow:hidden;
        }

        body.theme-green{
            --primary:#16a34a;
            --primary-2:#15803d;
            --primary-soft:#ecfdf3;
        }

        body.theme-purple{
            --primary:#7c3aed;
            --primary-2:#6d28d9;
            --primary-soft:#f3e8ff;
        }

        body.theme-orange{
            --primary:#ea580c;
            --primary-2:#c2410c;
            --primary-soft:#fff7ed;
        }

        body.theme-dark{
            --bg:#0f172a;
            --card:#111827;
            --card-2:#172033;
            --border:#253047;
            --text:#e5eefc;
            --muted:#94a3b8;
            --primary-soft:rgba(37,99,235,.15);
            --shadow:0 10px 30px rgba(0, 0, 0, .22);
            --shadow-soft:0 6px 18px rgba(0, 0, 0, .18);
            background:
                radial-gradient(circle at top right, rgba(37,99,235,.12), transparent 22%),
                linear-gradient(180deg, #0b1220 0%, #0f172a 100%);
        }

        body.theme-dark .sidebar,
        body.theme-dark .top-header,
        body.theme-dark .content-card,
        body.theme-dark .profile-card,
        body.theme-dark .brand,
        body.theme-dark .sidebar-search-wrap,
        body.theme-dark .header-chip,
        body.theme-dark .settings-panel,
        body.theme-dark .search-empty,
        body.theme-dark .quick-search-dropdown,
        body.theme-dark .topbar-user-menu{
            background:#111827 !important;
            color:var(--text);
            border-color:var(--border) !important;
        }

        body.theme-dark .sidebar-top{
            background:linear-gradient(180deg, rgba(17,24,39,.96), rgba(17,24,39,.88));
        }

        body.theme-dark .sidebar-search .form-control,
        body.theme-dark .quick-search-input{
            background:#0f172a;
            color:var(--text);
            border-color:var(--border);
        }

        body.theme-dark .sidebar-search .form-control::placeholder,
        body.theme-dark .quick-search-input::placeholder{
            color:#7b8aa1;
        }

        body.theme-dark .nav-itemx,
        body.theme-dark .brand-title,
        body.theme-dark .header-title,
        body.theme-dark .profile-name,
        body.theme-dark .pinned-item,
        body.theme-dark .crumb-link,
        body.theme-dark .topbar-user-name,
        body.theme-dark .dropdown-link{
            color:var(--text);
        }

        body.theme-dark .nav-itemx:hover,
        body.theme-dark .pinned-item:hover,
        body.theme-dark .dropdown-link:hover{
            background:#182235;
        }

        body.theme-dark .nav-icon{
            background:#1a2437;
            color:#cbd5e1;
        }

        body.theme-dark .submenu{
            border-right-color:#334155;
        }

        body.theme-dark .brand-version{
            background:#172033;
            color:#dbe6f7;
            border-color:#334155;
        }

        body.theme-dark .pin-btn:hover{
            background:#182235;
        }

        body.theme-dark .remove-pin:hover{
            background:#3a1f24;
            color:#ff8a8a;
        }

        body.theme-dark .topbar-user-btn,
        body.theme-dark .header-btn{
            background:#111827;
            color:var(--text);
            border-color:var(--border);
        }

        a{ text-decoration:none; }

        .app-layout{
            height:100vh;
            display:flex;
            overflow:hidden;
            position:relative;
        }

        .app-layout.sidebar-collapsed .sidebar{
            width:var(--sidebar-mini-width);
            min-width:var(--sidebar-mini-width);
            max-width:var(--sidebar-mini-width);
        }

        .app-layout.sidebar-collapsed .brand-subtitle,
        .app-layout.sidebar-collapsed .brand-title,
        .app-layout.sidebar-collapsed .brand-version,
        .app-layout.sidebar-collapsed .sidebar-search-wrap,
        .app-layout.sidebar-collapsed .menu-section,
        .app-layout.sidebar-collapsed .nav-label,
        .app-layout.sidebar-collapsed .chev,
        .app-layout.sidebar-collapsed .submenu-wrap,
        .app-layout.sidebar-collapsed .profile-card > *:not(.profile-mini),
        .app-layout.sidebar-collapsed .profile-mini > div:last-child{
            display:none !important;
        }

        .app-layout.sidebar-collapsed .brand{
            padding:12px;
            display:flex;
            justify-content:center;
        }

        .app-layout.sidebar-collapsed .brand .d-flex{
            justify-content:center !important;
        }

        .app-layout.sidebar-collapsed .sidebar-top{
            padding:16px 10px 12px;
        }

        .app-layout.sidebar-collapsed .nav-itemx,
        .app-layout.sidebar-collapsed .pinned-item{
            justify-content:center;
            padding:10px;
        }

        .app-layout.sidebar-collapsed .nav-icon{
            margin:0;
        }

        .app-layout.sidebar-collapsed .pin-btn,
        .app-layout.sidebar-collapsed .remove-pin{
            display:none !important;
        }

        .app-layout.sidebar-collapsed .sidebar-footer{
            padding:10px;
        }

        .app-layout.sidebar-collapsed .profile-mini{
            justify-content:center;
            margin-bottom:0;
        }

        .sidebar{
            width:var(--sidebar-width);
            min-width:var(--sidebar-width);
            max-width:var(--sidebar-width);
            background:rgba(255,255,255,.88);
            backdrop-filter:blur(14px);
            border-left:1px solid rgba(231,235,243,.9);
            box-shadow:var(--shadow-soft);
            display:flex;
            flex-direction:column;
            position:relative;
            z-index:20;
            transition:.25s ease;
        }

        .sidebar-top{
            padding:18px 16px 14px;
            border-bottom:1px solid var(--border);
            background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,.82));
        }

        .brand{
            padding:14px;
            border:1px solid var(--border);
            border-radius:20px;
            background:linear-gradient(135deg,#ffffff 0%, #f3f7ff 100%);
            box-shadow:0 8px 20px rgba(37,99,235,.06);
            transition:.2s ease;
        }

        .brand .brand-icon{
            width:46px;
            height:46px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg, var(--primary), var(--primary-2));
            color:#fff;
            font-size:20px;
            box-shadow:0 10px 20px rgba(37,99,235,.22);
        }

        .brand-title{
            font-size:20px;
            font-weight:800;
            line-height:1.2;
        }

        .brand-subtitle{
            color:var(--muted);
            font-size:13px;
            margin-top:2px;
        }

        .brand-version{
            border:1px solid #dbe4f3;
            background:#fff;
            color:#334155;
            border-radius:10px;
            padding:5px 10px;
            font-size:12px;
            font-weight:700;
        }

        .sidebar-search-wrap{
            padding:14px 12px 8px;
            background:rgba(255,255,255,.92);
            border-bottom:1px solid rgba(231,235,243,.7);
        }

        .sidebar-search{
            position:relative;
        }

        .sidebar-search .form-control{
            height:46px;
            border-radius:14px;
            border:1px solid var(--border);
            background:#f8fbff;
            box-shadow:none;
            padding-right:42px;
            padding-left:14px;
            font-size:14px;
            font-weight:700;
            color:var(--text);
        }

        .sidebar-search .form-control:focus{
            border-color:#cfe0ff;
            background:#fff;
            box-shadow:0 0 0 4px rgba(37,99,235,.08);
        }

        .sidebar-search .form-control::placeholder{
            color:#94a3b8;
            font-weight:600;
        }

        .sidebar-search .search-icon{
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
            font-size:15px;
            pointer-events:none;
        }

        .search-empty{
            display:none;
            margin:10px 10px 4px;
            padding:12px;
            border:1px dashed #d7e2f2;
            border-radius:14px;
            background:#f8fbff;
            color:#64748b;
            text-align:center;
            font-size:13px;
            font-weight:700;
        }

        .sidebar-scroll{
            flex:1;
            overflow-y:auto;
            overflow-x:hidden;
            padding:14px 10px 20px;
            scrollbar-width:thin;
            scrollbar-color:#cfd8ea transparent;
        }

        .sidebar-scroll::-webkit-scrollbar{ width:8px; }
        .sidebar-scroll::-webkit-scrollbar-thumb{
            background:#d7deea;
            border-radius:20px;
        }

        .menu-section{
            margin:18px 10px 10px;
            color:#94a3b8;
            font-size:11px;
            font-weight:900;
            letter-spacing:.8px;
        }

        .nav-group{
            display:grid;
            gap:6px;
        }

        .nav-itemx{
            width:100%;
            border:none;
            display:flex;
            align-items:center;
            gap:12px;
            padding:10px 12px;
            min-height:50px;
            border-radius:16px;
            color:#1e293b;
            background:transparent;
            transition:.18s ease;
            position:relative;
            font-size:15px;
            font-weight:700;
            text-align:right;
        }

        .nav-itemx:hover{
            background:#f6f9ff;
            color:var(--primary);
            transform:translateX(-2px);
        }

        .nav-itemx.active{
            background:linear-gradient(90deg, rgba(37,99,235,.12), rgba(37,99,235,.04));
            color:var(--primary);
            box-shadow:inset 0 0 0 1px rgba(37,99,235,.09);
        }

        .nav-itemx.active::before{
            content:"";
            position:absolute;
            right:0;
            top:10px;
            bottom:10px;
            width:4px;
            border-radius:10px;
            background:linear-gradient(180deg, var(--primary), var(--primary-2));
        }

        .nav-icon{
            width:38px;
            height:38px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#f1f5f9;
            color:#475569;
            flex:0 0 auto;
            font-size:17px;
            transition:.18s ease;
        }

        .nav-itemx:hover .nav-icon{
            background:#e8f0ff;
            color:var(--primary);
        }

        .nav-itemx.active .nav-icon{
            background:#dfeaff;
            color:var(--primary);
        }

        .nav-label{
            flex:1;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .chev{
            font-size:12px;
            color:#94a3b8;
            transition:.2s ease;
            margin-right:auto;
        }

        button[aria-expanded="true"] .chev{
            transform:rotate(180deg);
            color:var(--primary);
        }

        .submenu-wrap{
            padding:2px 6px 8px 6px;
        }

        .submenu{
            margin-right:18px;
            padding-right:12px;
            border-right:2px dashed #e4ebf7;
            display:grid;
            gap:6px;
        }

        .submenu .nav-itemx{
            min-height:44px;
            padding:8px 10px;
            font-size:14px;
            font-weight:700;
            border-radius:14px;
        }

        .submenu .nav-icon{
            width:32px;
            height:32px;
            font-size:14px;
            border-radius:10px;
        }

        .sidebar-footer{
            position:sticky;
            bottom:0;
            padding:14px;
            background:linear-gradient(180deg, rgba(255,255,255,0), rgba(255,255,255,.96) 20%, rgba(255,255,255,1) 100%);
            border-top:1px solid var(--border);
        }

        .profile-card{
            border:1px solid var(--border);
            border-radius:18px;
            background:linear-gradient(180deg,#ffffff,#f8fbff);
            box-shadow:var(--shadow-soft);
            padding:14px;
        }

        .profile-mini{
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:12px;
        }

        .profile-avatar{
            width:42px;
            height:42px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#eaf1ff,#dbeafe);
            color:var(--primary);
            font-size:18px;
            font-weight:800;
        }

        .profile-name{
            font-size:14px;
            font-weight:800;
            color:#0f172a;
        }

        .profile-role{
            font-size:12px;
            color:var(--muted);
        }

        .logout-btn{
            border-radius:14px;
            font-weight:800;
            min-height:46px;
        }

        .main-wrap{
            flex:1;
            min-width:0;
            height:100vh;
            overflow-y:auto;
            overflow-x:hidden;
            padding:18px;
        }

        .main-wrap::-webkit-scrollbar{ width:10px; }
        .main-wrap::-webkit-scrollbar-thumb{
            background:#d9e1ee;
            border-radius:20px;
        }

        .top-header{
            min-height:var(--topbar-height);
            background:rgba(255,255,255,.88);
            backdrop-filter:blur(12px);
            border:1px solid rgba(231,235,243,.95);
            border-radius:24px;
            box-shadow:var(--shadow);
            padding:16px 20px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:16px;
            margin-bottom:18px;
        }

        .topbar-left{
            min-width:0;
            display:flex;
            flex-direction:column;
            gap:8px;
        }

        .header-title{
            font-size:26px;
            font-weight:900;
            margin:0;
            line-height:1.1;
            color:#0f172a;
        }

        .header-subtitle{
            margin:0;
            color:var(--muted);
            font-size:14px;
            font-weight:500;
        }

        .breadcrumb-mini{
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
            font-size:13px;
            font-weight:700;
        }

        .crumb-link{
            color:#64748b;
        }

        .crumb-link.active{
            color:var(--primary);
        }

        .crumb-sep{
            color:#94a3b8;
            font-size:11px;
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }

        .quick-search{
            position:relative;
            width:280px;
            max-width:100%;
        }

        .quick-search-input{
            width:100%;
            height:46px;
            border-radius:14px;
            border:1px solid var(--border);
            background:#fff;
            box-shadow:none;
            padding-right:42px;
            padding-left:14px;
            font-size:14px;
            font-weight:700;
            color:var(--text);
        }

        .quick-search-input:focus{
            outline:none;
            border-color:#cfe0ff;
            box-shadow:0 0 0 4px rgba(37,99,235,.08);
        }

        .quick-search-icon{
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
            font-size:15px;
            pointer-events:none;
        }

        .quick-search-dropdown{
            position:absolute;
            top:54px;
            right:0;
            left:0;
            background:#fff;
            border:1px solid var(--border);
            border-radius:18px;
            box-shadow:0 18px 40px rgba(15,23,42,.10);
            padding:8px;
            display:none;
            z-index:50;
        }

        .quick-search-dropdown.show{
            display:block;
        }

        .quick-search-item{
            display:flex;
            align-items:center;
            gap:10px;
            padding:10px 12px;
            border-radius:12px;
            color:#334155;
            font-weight:700;
        }

        .quick-search-item:hover{
            background:#f6f9ff;
            color:var(--primary);
        }

        .header-chip{
            min-height:44px;
            padding:0 16px;
            border-radius:14px;
            border:1px solid #dbe5f3;
            background:#fff;
            display:flex;
            align-items:center;
            gap:10px;
            font-weight:800;
            color:#334155;
            box-shadow:0 4px 12px rgba(15,23,42,.03);
        }

        .header-chip.primary{
            background:linear-gradient(135deg, #eef4ff, #f8fbff);
            color:var(--primary);
            border-color:#d9e7ff;
        }

        .header-btn{
            min-width:44px;
            height:44px;
            border:none;
            border-radius:14px;
            background:#fff;
            border:1px solid var(--border);
            color:#334155;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
            box-shadow:0 4px 12px rgba(15,23,42,.03);
            transition:.18s ease;
        }

        .header-btn:hover{
            transform:translateY(-1px);
            color:var(--primary);
            border-color:#d9e7ff;
            background:#f7fbff;
        }

        .topbar-user{
            position:relative;
        }

        .topbar-user-btn{
            min-height:46px;
            border:none;
            border-radius:16px;
            background:#fff;
            border:1px solid var(--border);
            padding:6px 10px 6px 12px;
            display:flex;
            align-items:center;
            gap:10px;
            box-shadow:0 4px 12px rgba(15,23,42,.03);
            transition:.18s ease;
        }

        .topbar-user-btn:hover{
            transform:translateY(-1px);
            border-color:#d9e7ff;
        }

        .topbar-user-avatar{
            width:34px;
            height:34px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,var(--primary),var(--primary-2));
            color:#fff;
            font-size:15px;
            font-weight:900;
        }

        .topbar-user-text{
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            line-height:1.2;
        }

        .topbar-user-name{
            font-size:13px;
            font-weight:900;
            color:#0f172a;
        }

        .topbar-user-role{
            font-size:11px;
            color:var(--muted);
            font-weight:700;
        }

        .topbar-user-menu{
            position:absolute;
            top:56px;
            left:0;
            min-width:220px;
            background:#fff;
            border:1px solid var(--border);
            border-radius:18px;
            box-shadow:0 18px 40px rgba(15,23,42,.10);
            padding:8px;
            display:none;
            z-index:60;
        }

        .topbar-user-menu.show{
            display:block;
        }

        .dropdown-link{
            width:100%;
            border:none;
            background:transparent;
            display:flex;
            align-items:center;
            gap:10px;
            padding:11px 12px;
            border-radius:12px;
            color:#334155;
            font-weight:700;
            text-align:right;
        }

        .dropdown-link:hover{
            background:#f6f9ff;
            color:var(--primary);
        }

        .dropdown-divider{
            margin:6px 0;
            border-top:1px solid var(--border);
        }

        .content-area{
            display:grid;
            gap:16px;
        }

        .content-card{
            background:rgba(255,255,255,.92);
            border:1px solid rgba(231,235,243,.95);
            border-radius:24px;
            box-shadow:var(--shadow);
            padding:20px;
        }

        .alert{
            border-radius:18px;
            border:1px solid var(--border);
            box-shadow:var(--shadow-soft);
            margin-bottom:0;
        }

        .alerts-stack{
            display:grid;
            gap:12px;
        }

        .search-hidden{
            display:none !important;
        }

        .settings-panel{
            position:fixed;
            top:20px;
            left:20px;
            width:var(--settings-width);
            max-width:calc(100vw - 40px);
            background:rgba(255,255,255,.96);
            backdrop-filter:blur(14px);
            border:1px solid var(--border);
            border-radius:24px;
            box-shadow:0 20px 50px rgba(15,23,42,.14);
            z-index:1050;
            transform:translateX(calc(-100% - 30px));
            opacity:0;
            pointer-events:none;
            transition:.25s ease;
            overflow:hidden;
        }

        .settings-panel.open{
            transform:translateX(0);
            opacity:1;
            pointer-events:auto;
        }

        .settings-header{
            padding:18px 18px 14px;
            border-bottom:1px solid var(--border);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
        }

        .settings-title{
            font-size:18px;
            font-weight:900;
            color:var(--text);
        }

        .settings-subtitle{
            color:var(--muted);
            font-size:12px;
            margin-top:4px;
        }

        .settings-body{
            padding:16px;
            display:grid;
            gap:16px;
        }

        .setting-group{
            display:grid;
            gap:10px;
        }

        .setting-label{
            font-size:13px;
            font-weight:900;
            color:var(--muted);
        }

        .setting-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:12px 14px;
            background:var(--card);
            border:1px solid var(--border);
            border-radius:16px;
        }

        .setting-row .text small{
            display:block;
            color:var(--muted);
            margin-top:2px;
        }

        .theme-grid{
            display:grid;
            grid-template-columns:repeat(5, 1fr);
            gap:10px;
        }

        .theme-btn{
            border:none;
            height:52px;
            border-radius:16px;
            position:relative;
            cursor:pointer;
            border:2px solid transparent;
            transition:.18s ease;
            background:transparent;
        }

        .theme-btn.active{
            transform:translateY(-1px);
            border-color:#0f172a;
        }

        body.theme-dark .theme-btn.active{
            border-color:#fff;
        }

        .theme-btn::after{
            content:"";
            position:absolute;
            inset:8px;
            border-radius:12px;
        }

        .theme-blue::after{ background:linear-gradient(135deg,#2563eb,#1d4ed8); }
        .theme-green-btn::after{ background:linear-gradient(135deg,#16a34a,#15803d); }
        .theme-purple-btn::after{ background:linear-gradient(135deg,#7c3aed,#6d28d9); }
        .theme-orange-btn::after{ background:linear-gradient(135deg,#ea580c,#c2410c); }
        .theme-dark-btn::after{ background:linear-gradient(135deg,#0f172a,#1e293b); }

        .settings-close{
            min-width:40px;
            height:40px;
            border:none;
            border-radius:12px;
            background:#f8fafc;
            border:1px solid var(--border);
            color:#475569;
        }

        .switch{
            position:relative;
            width:54px;
            height:30px;
            flex:0 0 auto;
        }

        .switch input{ display:none; }

        .switch span{
            position:absolute;
            inset:0;
            border-radius:999px;
            background:#dbe4f0;
            transition:.2s ease;
            cursor:pointer;
        }

        .switch span::after{
            content:"";
            position:absolute;
            width:22px;
            height:22px;
            border-radius:50%;
            background:#fff;
            top:4px;
            right:4px;
            transition:.2s ease;
            box-shadow:0 2px 8px rgba(0,0,0,.12);
        }

        .switch input:checked + span{
            background:linear-gradient(135deg,var(--primary),var(--primary-2));
        }

        .switch input:checked + span::after{
            transform:translateX(-24px);
        }

        .settings-backdrop{
            position:fixed;
            inset:0;
            background:rgba(15,23,42,.22);
            z-index:1040;
            opacity:0;
            pointer-events:none;
            transition:.25s ease;
        }

        .settings-backdrop.show{
            opacity:1;
            pointer-events:auto;
        }

        .pin-btn{
            width:30px;
            height:30px;
            border:none;
            background:transparent;
            border-radius:10px;
            color:#94a3b8;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 auto;
            transition:.18s ease;
            margin-right:auto;
        }

        .pin-btn:hover{
            background:#eef4ff;
            color:var(--primary);
        }

        .pin-btn.pinned{
            color:var(--primary);
            background:rgba(37,99,235,.08);
        }

        .pinned-item{
            width:100%;
            display:flex;
            align-items:center;
            gap:12px;
            padding:10px 12px;
            min-height:50px;
            border-radius:16px;
            color:#1e293b;
            background:transparent;
            transition:.18s ease;
            position:relative;
            font-size:15px;
            font-weight:700;
            text-align:right;
        }

        .pinned-item:hover{
            background:#f6f9ff;
            color:var(--primary);
        }

        .pinned-item.active{
            background:linear-gradient(90deg, rgba(37,99,235,.12), rgba(37,99,235,.04));
            color:var(--primary);
            box-shadow:inset 0 0 0 1px rgba(37,99,235,.09);
        }

        .pinned-item .nav-label{
            flex:1;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .remove-pin{
            width:28px;
            height:28px;
            border:none;
            border-radius:10px;
            background:transparent;
            color:#94a3b8;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 auto;
        }

        .remove-pin:hover{
            background:#fee2e2;
            color:#dc2626;
        }

        @media (max-width: 1200px){
            .quick-search{ width:220px; }
        }

        @media (max-width: 991.98px){
            body{ overflow:auto; }

            .app-layout{
                height:auto;
                display:block;
                overflow:visible;
            }

            .sidebar{
                width:100%;
                min-width:100%;
                max-width:100%;
                height:auto;
                border-left:none;
                border-bottom:1px solid var(--border);
            }

            .app-layout.sidebar-collapsed .sidebar{
                width:100%;
                min-width:100%;
                max-width:100%;
            }

            .app-layout.sidebar-collapsed .brand-subtitle,
            .app-layout.sidebar-collapsed .brand-title,
            .app-layout.sidebar-collapsed .brand-version,
            .app-layout.sidebar-collapsed .sidebar-search-wrap,
            .app-layout.sidebar-collapsed .menu-section,
            .app-layout.sidebar-collapsed .nav-label,
            .app-layout.sidebar-collapsed .chev,
            .app-layout.sidebar-collapsed .submenu-wrap,
            .app-layout.sidebar-collapsed .profile-card > *:not(.profile-mini),
            .app-layout.sidebar-collapsed .profile-mini > div:last-child{
                display:initial !important;
            }

            .app-layout.sidebar-collapsed .nav-itemx,
            .app-layout.sidebar-collapsed .pinned-item{
                justify-content:flex-start;
                padding:10px 12px;
            }

            .app-layout.sidebar-collapsed .pin-btn,
            .app-layout.sidebar-collapsed .remove-pin{
                display:flex !important;
            }

            .sidebar-scroll{
                max-height:none;
                overflow:visible;
            }

            .sidebar-footer{
                position:relative;
                bottom:auto;
            }

            .main-wrap{
                height:auto;
                overflow:visible;
                padding:14px;
            }

            .top-header{
                padding:16px;
                border-radius:20px;
                flex-direction:column;
                align-items:stretch;
            }

            .header-title{ font-size:22px; }

            .topbar-right{
                justify-content:flex-start;
            }

            .quick-search{
                width:100%;
            }

            .settings-panel{
                top:auto;
                bottom:16px;
                left:16px;
                right:16px;
                width:auto;
                max-width:none;
                transform:translateY(120%);
            }

            .settings-panel.open{
                transform:translateY(0);
            }

            .topbar-user-menu{
                left:auto;
                right:0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="settings-backdrop" id="settingsBackdrop"></div>

<div class="settings-panel" id="settingsPanel">
    <div class="settings-header">
        <div>
            <div class="settings-title">إعدادات الواجهة</div>
            <div class="settings-subtitle">خصص اللون وشكل القائمة بالطريقة اللي تعجبك</div>
        </div>
        <button type="button" class="settings-close" id="closeSettingsBtn">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="settings-body">
        <div class="setting-group">
            <div class="setting-label">ألوان الواجهة</div>
            <div class="theme-grid">
                <button type="button" class="theme-btn theme-blue active" data-theme="blue" title="أزرق"></button>
                <button type="button" class="theme-btn theme-green-btn" data-theme="green" title="أخضر"></button>
                <button type="button" class="theme-btn theme-purple-btn" data-theme="purple" title="بنفسجي"></button>
                <button type="button" class="theme-btn theme-orange-btn" data-theme="orange" title="برتقالي"></button>
                <button type="button" class="theme-btn theme-dark-btn" data-theme="dark" title="داكن"></button>
            </div>
        </div>

        <div class="setting-group">
            <div class="setting-row">
                <div class="text">
                    <div class="fw-bold">تصغير السايدبار</div>
                    <small>إظهار الأيقونات فقط</small>
                </div>
                <label class="switch">
                    <input type="checkbox" id="collapseSidebarToggle">
                    <span></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="app-layout" id="appLayout">

    <aside class="sidebar" id="sidebar">

        <div class="sidebar-top">
            <div class="brand">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="brand-icon">
                            <i class="bi bi-cart3"></i>
                        </div>
                        <div>
                            <div class="brand-title">Super Market</div>
                            <div class="brand-subtitle">نظام إدارة السوبرماركت</div>
                        </div>
                    </div>
                    <span class="brand-version">v1</span>
                </div>
            </div>
        </div>

        <div class="sidebar-search-wrap">
            <div class="sidebar-search">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="sidebarSearch" class="form-control" placeholder="بحث بالقائمة...">
            </div>
        </div>

        <div class="search-empty" id="searchEmpty">
            لا توجد نتائج مطابقة
        </div>

        <div class="sidebar-scroll" id="sidebarScroll">
            <nav class="nav-group" id="sidebarMenu">

                <div id="pinnedSection" class="search-hidden">
                    <div class="menu-section">المثبتة</div>
                    <div class="nav-group" id="pinnedMenuList"></div>
                </div>

                <div class="menu-section sidebar-searchable-section">الإدارة</div>

                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('dashboard') ? 'active' : '' }}"
                   href="{{ url('/dashboard') }}"
                   data-key="dashboard"
                   data-label="لوحة التحكم"
                   data-icon="bi-speedometer2"
                   data-href="{{ url('/dashboard') }}"
                   data-search="لوحة التحكم dashboard الرئيسية home">
                    <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                    <span class="nav-label">لوحة التحكم</span>
                    <button type="button" class="pin-btn" title="تثبيت">
                        <i class="bi bi-pin-angle"></i>
                    </button>
                </a>

                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('pos*') ? 'active' : '' }}"
                   href="{{ route('pos.index') }}"
                   data-key="pos"
                   data-label="الكاشير"
                   data-icon="bi-cart"
                   data-href="{{ route('pos.index') }}"
                   data-search="الكاشير نقاط البيع pos بيع">
                    <span class="nav-icon"><i class="bi bi-cart"></i></span>
                    <span class="nav-label">الكاشير</span>
                    <button type="button" class="pin-btn" title="تثبيت">
                        <i class="bi bi-pin-angle"></i>
                    </button>
                </a>

                <div class="menu-section sidebar-searchable-section">المخزون</div>

                @php $productsOpen = request()->is('products*'); @endphp
                <div class="sidebar-searchable-block" data-search-block="المنتجات product products عرض المنتجات اضافة منتج منتجاتي مخزون">
                    <button class="nav-itemx sidebar-searchable {{ $productsOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuProducts"
                            aria-expanded="{{ $productsOpen ? 'true' : 'false' }}"
                            data-search="المنتجات product products عرض المنتجات اضافة منتج منتجاتي مخزون">
                        <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                        <span class="nav-label">المنتجات</span>
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $productsOpen ? 'show' : '' }} submenu-wrap" id="menuProducts">
                        <div class="submenu">
                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('products') ? 'active' : '' }}"
                               href="{{ route('products.index') }}"
                               data-key="products.index"
                               data-label="عرض المنتجات"
                               data-icon="bi-card-list"
                               data-href="{{ route('products.index') }}"
                               data-search="عرض المنتجات products list">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                <span class="nav-label">عرض المنتجات</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>

                            @if(\Illuminate\Support\Facades\Route::has('products.create'))
                                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('products/create') ? 'active' : '' }}"
                                   href="{{ route('products.create') }}"
                                   data-key="products.create"
                                   data-label="إضافة منتج"
                                   data-icon="bi-plus-lg"
                                   data-href="{{ route('products.create') }}"
                                   data-search="إضافة منتج create product add product">
                                    <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                    <span class="nav-label">إضافة منتج</span>
                                    <button type="button" class="pin-btn" title="تثبيت">
                                        <i class="bi bi-pin-angle"></i>
                                    </button>
                                </a>
                            @endif

                            @if(\Illuminate\Support\Facades\Route::has('products.mine'))
                                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('products/mine') ? 'active' : '' }}"
                                   href="{{ route('products.mine') }}"
                                   data-key="products.mine"
                                   data-label="منتجاتي"
                                   data-icon="bi-person"
                                   data-href="{{ route('products.mine') }}"
                                   data-search="منتجاتي my products">
                                    <span class="nav-icon"><i class="bi bi-person"></i></span>
                                    <span class="nav-label">منتجاتي</span>
                                    <button type="button" class="pin-btn" title="تثبيت">
                                        <i class="bi bi-pin-angle"></i>
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @php $categoriesOpen = request()->is('categories*'); @endphp
                <div class="sidebar-searchable-block" data-search-block="الأصناف تصنيفات categories category عرض الأصناف اضافة صنف">
                    <button class="nav-itemx sidebar-searchable {{ $categoriesOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuCategories"
                            aria-expanded="{{ $categoriesOpen ? 'true' : 'false' }}"
                            data-search="الأصناف تصنيفات categories category عرض الأصناف اضافة صنف">
                        <span class="nav-icon"><i class="bi bi-folder2"></i></span>
                        <span class="nav-label">الأصناف</span>
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $categoriesOpen ? 'show' : '' }} submenu-wrap" id="menuCategories">
                        <div class="submenu">
                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('categories') ? 'active' : '' }}"
                               href="{{ route('categories.index') }}"
                               data-key="categories.index"
                               data-label="عرض الأصناف"
                               data-icon="bi-card-list"
                               data-href="{{ route('categories.index') }}"
                               data-search="عرض الأصناف categories list">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                <span class="nav-label">عرض الأصناف</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>

                            @if(\Illuminate\Support\Facades\Route::has('categories.create'))
                                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('categories/create') ? 'active' : '' }}"
                                   href="{{ route('categories.create') }}"
                                   data-key="categories.create"
                                   data-label="إضافة صنف"
                                   data-icon="bi-plus-lg"
                                   data-href="{{ route('categories.create') }}"
                                   data-search="إضافة صنف add category create category">
                                    <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                    <span class="nav-label">إضافة صنف</span>
                                    <button type="button" class="pin-btn" title="تثبيت">
                                        <i class="bi bi-pin-angle"></i>
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="menu-section sidebar-searchable-section">المحاسبة</div>

                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('sales*') ? 'active' : '' }}"
                   href="{{ route('sales.index') }}"
                   data-key="sales.index"
                   data-label="الفواتير"
                   data-icon="bi-receipt-cutoff"
                   data-href="{{ route('sales.index') }}"
                   data-search="الفواتير مبيعات sales invoices receipt">
                    <span class="nav-icon"><i class="bi bi-receipt-cutoff"></i></span>
                    <span class="nav-label">الفواتير</span>
                    <button type="button" class="pin-btn" title="تثبيت">
                        <i class="bi bi-pin-angle"></i>
                    </button>
                </a>

                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('profits*') ? 'active' : '' }}"
                   href="{{ route('profits.index') }}"
                   data-key="profits.index"
                   data-label="الأرباح"
                   data-icon="bi-graph-up-arrow"
                   data-href="{{ route('profits.index') }}"
                   data-search="الأرباح profit profits تقارير الأرباح ربح">
                    <span class="nav-icon"><i class="bi bi-graph-up-arrow"></i></span>
                    <span class="nav-label">الأرباح</span>
                    <button type="button" class="pin-btn" title="تثبيت">
                        <i class="bi bi-pin-angle"></i>
                    </button>
                </a>

                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('receipts*') ? 'active' : '' }}"
                   href="{{ route('receipts.index') }}"
                   data-key="receipts.index"
                   data-label="الوصولات"
                   data-icon="bi-receipt"
                   data-href="{{ route('receipts.index') }}"
                   data-search="الوصولات receipts دفعات المورد دفعات العميل">
                    <span class="nav-icon"><i class="bi bi-receipt"></i></span>
                    <span class="nav-label">الوصولات</span>
                    <button type="button" class="pin-btn" title="تثبيت">
                        <i class="bi bi-pin-angle"></i>
                    </button>
                </a>

                @php $suppliersOpen = request()->is('suppliers*') || request()->is('supplier-payments*'); @endphp
                <div class="sidebar-searchable-block" data-search-block="الموردين suppliers supplier عرض الموردين اضافة مورد كشف المورد دفعات المورد">
                    <button class="nav-itemx sidebar-searchable {{ $suppliersOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuSuppliers"
                            aria-expanded="{{ $suppliersOpen ? 'true' : 'false' }}"
                            data-search="الموردين suppliers supplier عرض الموردين اضافة مورد كشف المورد دفعات المورد">
                        <span class="nav-icon"><i class="bi bi-truck"></i></span>
                        <span class="nav-label">الموردين</span>
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $suppliersOpen ? 'show' : '' }} submenu-wrap" id="menuSuppliers">
                        <div class="submenu">
                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('suppliers') ? 'active' : '' }}"
                               href="{{ route('suppliers.index') }}"
                               data-key="suppliers.index"
                               data-label="عرض الموردين"
                               data-icon="bi-card-list"
                               data-href="{{ route('suppliers.index') }}"
                               data-search="عرض الموردين suppliers list">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                <span class="nav-label">عرض الموردين</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>

                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('suppliers/create') ? 'active' : '' }}"
                               href="{{ route('suppliers.create') }}"
                               data-key="suppliers.create"
                               data-label="إضافة مورد"
                               data-icon="bi-plus-lg"
                               data-href="{{ route('suppliers.create') }}"
                               data-search="إضافة مورد add supplier create supplier">
                                <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                <span class="nav-label">إضافة مورد</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                @php $customersOpen = request()->is('customers*') || request()->is('customer-payments*'); @endphp
                <div class="sidebar-searchable-block" data-search-block="العملاء customers customer عرض العملاء اضافة عميل كشف العميل دفعات العميل">
                    <button class="nav-itemx sidebar-searchable {{ $customersOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuCustomers"
                            aria-expanded="{{ $customersOpen ? 'true' : 'false' }}"
                            data-search="العملاء customers customer عرض العملاء اضافة عميل كشف العميل دفعات العميل">
                        <span class="nav-icon"><i class="bi bi-people"></i></span>
                        <span class="nav-label">العملاء</span>
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $customersOpen ? 'show' : '' }} submenu-wrap" id="menuCustomers">
                        <div class="submenu">
                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('customers') ? 'active' : '' }}"
                               href="{{ route('customers.index') }}"
                               data-key="customers.index"
                               data-label="عرض العملاء"
                               data-icon="bi-card-list"
                               data-href="{{ route('customers.index') }}"
                               data-search="عرض العملاء customers list">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                <span class="nav-label">عرض العملاء</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>

                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('customers/create') ? 'active' : '' }}"
                               href="{{ route('customers.create') }}"
                               data-key="customers.create"
                               data-label="إضافة عميل"
                               data-icon="bi-person-plus"
                               data-href="{{ route('customers.create') }}"
                               data-search="إضافة عميل add customer create customer">
                                <span class="nav-icon"><i class="bi bi-person-plus"></i></span>
                                <span class="nav-label">إضافة عميل</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('purchases*') ? 'active' : '' }}"
                   href="{{ route('purchases.index') }}"
                   data-key="purchases.index"
                   data-label="المشتريات"
                   data-icon="bi-bag-check"
                   data-href="{{ route('purchases.index') }}"
                   data-search="المشتريات purchases شراء فواتير شراء">
                    <span class="nav-icon"><i class="bi bi-bag-check"></i></span>
                    <span class="nav-label">المشتريات</span>
                    <button type="button" class="pin-btn" title="تثبيت">
                        <i class="bi bi-pin-angle"></i>
                    </button>
                </a>

                @php $cashOpen = request()->is('cash*'); @endphp
                <div class="sidebar-searchable-block" data-search-block="الصندوق cash حركة الصندوق الخزنة">
                    <button class="nav-itemx sidebar-searchable {{ $cashOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuCash"
                            aria-expanded="{{ $cashOpen ? 'true' : 'false' }}"
                            data-search="الصندوق cash حركة الصندوق الخزنة">
                        <span class="nav-icon"><i class="bi bi-cash-stack"></i></span>
                        <span class="nav-label">الصندوق</span>
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $cashOpen ? 'show' : '' }} submenu-wrap" id="menuCash">
                        <div class="submenu">
                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('cash') ? 'active' : '' }}"
                               href="{{ route('cash.index') }}"
                               data-key="cash.index"
                               data-label="حركة الصندوق"
                               data-icon="bi-wallet2"
                               data-href="{{ route('cash.index') }}"
                               data-search="حركة الصندوق cash movement">
                                <span class="nav-icon"><i class="bi bi-wallet2"></i></span>
                                <span class="nav-label">حركة الصندوق</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-section sidebar-searchable-section">السجلات</div>

                @php $activitiesOpen = request()->is('activities*'); @endphp
                <div class="sidebar-searchable-block" data-search-block="سجل الموظفين activities activity عرض السجل اضافة سجل">
                    <button class="nav-itemx sidebar-searchable {{ $activitiesOpen ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuActivities"
                            aria-expanded="{{ $activitiesOpen ? 'true' : 'false' }}"
                            data-search="سجل الموظفين activities activity عرض السجل اضافة سجل">
                        <span class="nav-icon"><i class="bi bi-receipt"></i></span>
                        <span class="nav-label">سجل الموظفين</span>
                        <i class="bi bi-chevron-down chev"></i>
                    </button>

                    <div class="collapse {{ $activitiesOpen ? 'show' : '' }} submenu-wrap" id="menuActivities">
                        <div class="submenu">
                            <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('activities') ? 'active' : '' }}"
                               href="{{ route('activities.index') }}"
                               data-key="activities.index"
                               data-label="عرض السجل"
                               data-icon="bi-card-list"
                               data-href="{{ route('activities.index') }}"
                               data-search="عرض السجل activities list">
                                <span class="nav-icon"><i class="bi bi-card-list"></i></span>
                                <span class="nav-label">عرض السجل</span>
                                <button type="button" class="pin-btn" title="تثبيت">
                                    <i class="bi bi-pin-angle"></i>
                                </button>
                            </a>

                            @if(\Illuminate\Support\Facades\Route::has('activities.create'))
                                <a class="nav-itemx sidebar-searchable pinnable-item {{ request()->is('activities/create') ? 'active' : '' }}"
                                   href="{{ route('activities.create') }}"
                                   data-key="activities.create"
                                   data-label="إضافة سجل"
                                   data-icon="bi-plus-lg"
                                   data-href="{{ route('activities.create') }}"
                                   data-search="إضافة سجل add activity create activity">
                                    <span class="nav-icon"><i class="bi bi-plus-lg"></i></span>
                                    <span class="nav-label">إضافة سجل</span>
                                    <button type="button" class="pin-btn" title="تثبيت">
                                        <i class="bi bi-pin-angle"></i>
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </nav>
        </div>

        <div class="sidebar-footer">
            <div class="profile-card">
                <div class="profile-mini">
                    <div class="profile-avatar">
                        {{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="profile-name">{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="profile-role">مستخدم النظام</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}"
                      onsubmit="return confirm('هل أنت متأكد من تسجيل الخروج؟');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 logout-btn">
                        <i class="bi bi-box-arrow-right ms-1"></i>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <main class="main-wrap">

        <header class="top-header">
            <div class="topbar-left">
                <div class="breadcrumb-mini">
                    <span class="crumb-link">الرئيسية</span>
                    <span class="crumb-sep"><i class="bi bi-chevron-left"></i></span>
                    <span class="crumb-link active">@yield('page_title', 'لوحة الإدارة')</span>
                </div>

                <h1 class="header-title">@yield('page_title', 'لوحة الإدارة')</h1>

                <p class="header-subtitle">
                    @yield('page_subtitle', 'متابعة المخزون، المحاسبة، المبيعات، وحركة النظام بشكل سريع وواضح')
                </p>
            </div>

            <div class="topbar-right">
                <div class="quick-search">
                    <i class="bi bi-search quick-search-icon"></i>
                    <input type="text" class="quick-search-input" id="quickSearchInput" placeholder="بحث سريع بالروابط...">
                    <div class="quick-search-dropdown" id="quickSearchDropdown"></div>
                </div>

                <button type="button" class="header-btn" id="toggleSidebarBtn" title="تصغير أو توسيع السايدبار">
                    <i class="bi bi-layout-sidebar-inset"></i>
                </button>

                <button type="button" class="header-btn" id="openSettingsBtn" title="إعدادات الواجهة">
                    <i class="bi bi-gear"></i>
                </button>

                <div class="header-chip primary">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ now()->format('Y-m-d') }}</span>
                </div>

                <div class="header-chip">
                    <i class="bi bi-clock-history"></i>
                    <span id="liveTime">{{ now()->format('H:i') }}</span>
                </div>

                <div class="topbar-user">
                    <button type="button" class="topbar-user-btn" id="topbarUserBtn">
                        <div class="topbar-user-avatar">
                            {{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="topbar-user-text">
                            <span class="topbar-user-name">{{ auth()->user()->name ?? 'User' }}</span>
                            <span class="topbar-user-role">مستخدم النظام</span>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="topbar-user-menu" id="topbarUserMenu">
                        <div class="dropdown-link">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ auth()->user()->name ?? 'User' }}</span>
                        </div>
                        <div class="dropdown-link">
                            <i class="bi bi-envelope"></i>
                            <span>{{ auth()->user()->email ?? 'no-email@example.com' }}</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button type="button" class="dropdown-link" id="openSettingsBtn2">
                            <i class="bi bi-sliders"></i>
                            <span>إعدادات الواجهة</span>
                        </button>
                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('هل أنت متأكد من تسجيل الخروج؟');">
                            @csrf
                            <button type="submit" class="dropdown-link">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>تسجيل الخروج</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-area">

            @if(session('success') || session('error') || $errors->any())
                <div class="alerts-stack">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill ms-1"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill ms-1"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <div class="fw-bold mb-2">أكو أخطاء:</div>
                            <ul class="mb-0">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <div class="content-card">
                @yield('content')
            </div>

        </div>

    </main>

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
    const desc = document.querySelector('#description');
    if (desc) {
        tinymce.init({
            selector: '#description',
            directionality: "rtl",
            height: 300,
            menubar: false,
            plugins: 'lists link table',
            toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright'
        });
    }

    const sidebarScroll = document.getElementById('sidebarScroll');
    const SIDEBAR_SCROLL_KEY = 'sidebar-scroll-position';

    if (sidebarScroll) {
        const savedScroll = sessionStorage.getItem(SIDEBAR_SCROLL_KEY);
        if (savedScroll !== null) {
            setTimeout(() => {
                sidebarScroll.scrollTop = parseInt(savedScroll, 10);
            }, 50);
        }

        sidebarScroll.addEventListener('scroll', function () {
            sessionStorage.setItem(SIDEBAR_SCROLL_KEY, sidebarScroll.scrollTop);
        });

        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', function () {
                sessionStorage.setItem(SIDEBAR_SCROLL_KEY, sidebarScroll.scrollTop);
            });
        });
    }

    const searchInput = document.getElementById('sidebarSearch');
    const searchableItems = document.querySelectorAll('.sidebar-searchable');
    const searchableBlocks = document.querySelectorAll('.sidebar-searchable-block');
    const sectionTitles = document.querySelectorAll('.sidebar-searchable-section');
    const emptyBox = document.getElementById('searchEmpty');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            let visibleCount = 0;

            searchableItems.forEach(item => {
                const text = (item.dataset.search || item.textContent || '').toLowerCase();
                const matched = q === '' || text.includes(q);
                item.classList.toggle('search-hidden', !matched);
                if (matched) visibleCount++;
            });

            searchableBlocks.forEach(block => {
                const innerVisible = block.querySelectorAll('.sidebar-searchable:not(.search-hidden)');
                const hasVisible = innerVisible.length > 0;
                block.classList.toggle('search-hidden', !hasVisible);

                const collapseEl = block.querySelector('.collapse');
                if (collapseEl && q !== '' && hasVisible) {
                    collapseEl.classList.add('show');
                }
            });

            sectionTitles.forEach(section => {
                let next = section.nextElementSibling;
                let hasVisibleUnderSection = false;

                while (next && !next.classList.contains('sidebar-searchable-section')) {
                    if (!next.classList.contains('search-hidden')) {
                        hasVisibleUnderSection = true;
                        break;
                    }
                    next = next.nextElementSibling;
                }

                section.classList.toggle('search-hidden', !hasVisibleUnderSection && q !== '');
            });

            const pinnedSection = document.getElementById('pinnedSection');
            const pinnedHasItems = document.querySelectorAll('#pinnedMenuList .pinned-item').length > 0;
            if (q === '' && pinnedSection && pinnedHasItems) {
                pinnedSection.classList.remove('search-hidden');
            }

            if (emptyBox) {
                emptyBox.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
    }

    const body = document.body;
    const appLayout = document.getElementById('appLayout');
    const openSettingsBtn = document.getElementById('openSettingsBtn');
    const openSettingsBtn2 = document.getElementById('openSettingsBtn2');
    const closeSettingsBtn = document.getElementById('closeSettingsBtn');
    const settingsPanel = document.getElementById('settingsPanel');
    const settingsBackdrop = document.getElementById('settingsBackdrop');
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const collapseSidebarToggle = document.getElementById('collapseSidebarToggle');
    const themeButtons = document.querySelectorAll('.theme-btn');
    const topbarUserBtn = document.getElementById('topbarUserBtn');
    const topbarUserMenu = document.getElementById('topbarUserMenu');

    const STORAGE_KEYS = {
        theme: 'sm_theme',
        collapsed: 'sm_sidebar_collapsed',
        pinnedMenu: 'sm_pinned_menu_items'
    };

    function openSettings() {
        settingsPanel.classList.add('open');
        settingsBackdrop.classList.add('show');
    }

    function closeSettings() {
        settingsPanel.classList.remove('open');
        settingsBackdrop.classList.remove('show');
    }

    if (openSettingsBtn) openSettingsBtn.addEventListener('click', openSettings);
    if (openSettingsBtn2) openSettingsBtn2.addEventListener('click', function () {
        openSettings();
        if (topbarUserMenu) topbarUserMenu.classList.remove('show');
    });
    if (closeSettingsBtn) closeSettingsBtn.addEventListener('click', closeSettings);
    if (settingsBackdrop) settingsBackdrop.addEventListener('click', closeSettings);

    function applyTheme(theme) {
        body.classList.remove('theme-green', 'theme-purple', 'theme-orange', 'theme-dark');

        if (theme === 'green') body.classList.add('theme-green');
        if (theme === 'purple') body.classList.add('theme-purple');
        if (theme === 'orange') body.classList.add('theme-orange');
        if (theme === 'dark') body.classList.add('theme-dark');

        themeButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.theme === theme);
        });

        localStorage.setItem(STORAGE_KEYS.theme, theme);
    }

    function applySidebarCollapsed(collapsed) {
        appLayout.classList.toggle('sidebar-collapsed', collapsed);
        if (collapseSidebarToggle) collapseSidebarToggle.checked = collapsed;
        localStorage.setItem(STORAGE_KEYS.collapsed, collapsed ? '1' : '0');
    }

    const savedTheme = localStorage.getItem(STORAGE_KEYS.theme) || 'blue';
    const savedCollapsed = localStorage.getItem(STORAGE_KEYS.collapsed) === '1';

    applyTheme(savedTheme);
    applySidebarCollapsed(savedCollapsed);

    themeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            applyTheme(this.dataset.theme);
        });
    });

    if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', function () {
            const isCollapsed = appLayout.classList.contains('sidebar-collapsed');
            applySidebarCollapsed(!isCollapsed);
        });
    }

    if (collapseSidebarToggle) {
        collapseSidebarToggle.addEventListener('change', function () {
            applySidebarCollapsed(this.checked);
        });
    }

    const PIN_STORAGE_KEY = STORAGE_KEYS.pinnedMenu;
    const pinnedSection = document.getElementById('pinnedSection');
    const pinnedMenuList = document.getElementById('pinnedMenuList');
    const pinnableItems = document.querySelectorAll('.pinnable-item');

    function getPinnedItems() {
        try {
            return JSON.parse(localStorage.getItem(PIN_STORAGE_KEY)) || [];
        } catch (e) {
            return [];
        }
    }

    function savePinnedItems(items) {
        localStorage.setItem(PIN_STORAGE_KEY, JSON.stringify(items));
    }

    function isPinned(key) {
        return getPinnedItems().some(item => item.key === key);
    }

    function updatePinButtons() {
        pinnableItems.forEach(item => {
            const key = item.dataset.key;
            const btn = item.querySelector('.pin-btn');
            if (!btn) return;

            const pinned = isPinned(key);
            btn.classList.toggle('pinned', pinned);
            btn.innerHTML = pinned
                ? '<i class="bi bi-pin-angle-fill"></i>'
                : '<i class="bi bi-pin-angle"></i>';
        });
    }

    function renderPinnedSection() {
        const items = getPinnedItems();
        if (!pinnedMenuList || !pinnedSection) return;

        pinnedMenuList.innerHTML = '';

        if (!items.length) {
            pinnedSection.classList.add('search-hidden');
            return;
        }

        pinnedSection.classList.remove('search-hidden');

        items.forEach(item => {
            const a = document.createElement('a');
            a.href = item.href;
            a.className = 'pinned-item';

            const currentPath = window.location.pathname.replace(/\/+$/, '');
            const itemPath = new URL(item.href, window.location.origin).pathname.replace(/\/+$/, '');
            if (currentPath === itemPath) {
                a.classList.add('active');
            }

            a.innerHTML = `
                <span class="nav-icon"><i class="bi ${item.icon}"></i></span>
                <span class="nav-label">${item.label}</span>
                <button type="button" class="remove-pin" data-key="${item.key}" title="إزالة التثبيت">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;

            pinnedMenuList.appendChild(a);
        });

        pinnedMenuList.querySelectorAll('.remove-pin').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const key = this.dataset.key;
                const items = getPinnedItems().filter(item => item.key !== key);
                savePinnedItems(items);
                renderPinnedSection();
                updatePinButtons();
            });
        });
    }

    pinnableItems.forEach(item => {
        const btn = item.querySelector('.pin-btn');
        if (!btn) return;

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const key = item.dataset.key;
            const label = item.dataset.label;
            const icon = item.dataset.icon;
            const href = item.dataset.href;

            let items = getPinnedItems();

            if (items.some(i => i.key === key)) {
                items = items.filter(i => i.key !== key);
            } else {
                items.push({ key, label, icon, href });
            }

            savePinnedItems(items);
            renderPinnedSection();
            updatePinButtons();
        });
    });

    renderPinnedSection();
    updatePinButtons();

    const quickSearchInput = document.getElementById('quickSearchInput');
    const quickSearchDropdown = document.getElementById('quickSearchDropdown');

    if (quickSearchInput && quickSearchDropdown) {
        quickSearchInput.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            quickSearchDropdown.innerHTML = '';

            if (!q) {
                quickSearchDropdown.classList.remove('show');
                return;
            }

            let results = [];
            document.querySelectorAll('.pinnable-item').forEach(item => {
                const label = item.dataset.label || '';
                const href = item.dataset.href || '#';
                const icon = item.dataset.icon || 'bi-link';
                const search = (item.dataset.search || label).toLowerCase();

                if (search.includes(q)) {
                    results.push({ label, href, icon });
                }
            });

            results = results.slice(0, 6);

            if (!results.length) {
                quickSearchDropdown.innerHTML = `<div class="quick-search-item">لا توجد نتائج</div>`;
                quickSearchDropdown.classList.add('show');
                return;
            }

            results.forEach(result => {
                const a = document.createElement('a');
                a.href = result.href;
                a.className = 'quick-search-item';
                a.innerHTML = `<i class="bi ${result.icon}"></i><span>${result.label}</span>`;
                quickSearchDropdown.appendChild(a);
            });

            quickSearchDropdown.classList.add('show');
        });

        document.addEventListener('click', function (e) {
            if (!quickSearchInput.parentElement.contains(e.target)) {
                quickSearchDropdown.classList.remove('show');
            }
        });
    }

    if (topbarUserBtn && topbarUserMenu) {
        topbarUserBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            topbarUserMenu.classList.toggle('show');
        });

        document.addEventListener('click', function (e) {
            if (!topbarUserMenu.contains(e.target) && !topbarUserBtn.contains(e.target)) {
                topbarUserMenu.classList.remove('show');
            }
        });
    }

    const liveTime = document.getElementById('liveTime');
    if (liveTime) {
        setInterval(() => {
            const now = new Date();
            const hh = String(now.getHours()).padStart(2, '0');
            const mm = String(now.getMinutes()).padStart(2, '0');
            liveTime.textContent = `${hh}:${mm}`;
        }, 1000);
    }
});
</script>

@stack('scripts')
</body>
</html>
