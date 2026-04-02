<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
</head>
<body style="font-family:Arial; background:#f6f7fb; padding:30px;">

<div style="max-width:600px; margin:auto; background:#fff; padding:30px; border-radius:15px;">
    <h2>تأكيد البريد الإلكتروني</h2>

    <p>أهلاً {{ $user->name }}</p>

    <p>هذا كود التحقق الخاص بك:</p>

    <div style="font-size:30px; text-align:center; margin:20px 0; font-weight:bold;">
        {{ $user->verification_code }}
    </div>

    <p>الكود صالح لمدة 10 دقائق فقط.</p>
</div>

</body>
</html>
