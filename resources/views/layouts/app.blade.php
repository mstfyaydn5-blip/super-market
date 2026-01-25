<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>Super Market</title>

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6f9; }
        .sidebar {
            min-height:100vh;
            background:#212529;
            color:#fff;
        }
        .sidebar a {
            color:#ddd;
            text-decoration:none;
            display:block;
            padding:10px;
            border-radius:6px;
        }
        .sidebar a:hover {
            background:#343a40;
            color:#fff;
        }

  .desc-box p { margin-bottom: .6rem; }
  .desc-box ul, .desc-box ol { padding-right: 1.2rem; margin-bottom: .6rem; }
  .desc-box a { color: #0d6efd; text-decoration: underline; }
  .desc-box h1, .desc-box h2, .desc-box h3 { margin: .8rem 0 .4rem; }

    </style>
    @stack('styles')
</head>

<body>

<div class="container-fluid">
    <div class="row">
      <div class="col-2 sidebar p-3 d-flex flex-column">
    <h5 class="text-center mb-4">🛒 Super Market</h5>

    <a href="{{ route('products.index') }}">📦 المنتجات</a>
    <a href="{{ route('categories.index') }}">🗂 الأصناف</a>
    <a href="{{ route('products.mine') }}">👤 منتجاتي</a>
    <a class="nav-link {{ request()->routeIs('activities.index') ? 'active' : '' }}"
       href="{{ route('activities.index') }}">
        🧾 سجل الموظفين
    </a>



    <div class="mt-auto pt-3 border-top border-light border-opacity-25">
        <form method="POST" action="{{ route('logout') }}"
              onsubmit="return confirm('هل أنت متأكد من تسجيل الخروج؟');">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                🚪 تسجيل الخروج
            </button>
        </form>
    </div>
</div>
        <div class="col-10 p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>

    </div>

</div>

<script>
function confirmDelete() {
    return confirm('هل أنت متأكد من الحذف؟');
}
</script>
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

</body>
</html>
