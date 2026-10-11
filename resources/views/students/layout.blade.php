<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Students') | Student Directory</title>
    <style>
        body { margin: 0; background: #f4f6f8; color: #1f2937; font: 16px/1.5 system-ui, sans-serif; }
        main { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        h1 { margin: 0 0 20px; }
        a { color: #2563eb; }
        .button, button { display: inline-block; border: 0; border-radius: 6px; padding: 9px 14px; background: #2563eb; color: white; font: inherit; text-decoration: none; cursor: pointer; }
        .button.secondary { background: #4b5563; }
        .button.danger, button.danger { background: #dc2626; }
        .actions { display: flex; gap: 8px; align-items: center; }
        .card, table { width: 100%; background: white; border-collapse: collapse; border-radius: 8px; box-shadow: 0 1px 4px #00000012; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f9fafb; }
        tr:last-child td { border-bottom: 0; }
        label { display: block; margin: 14px 0 5px; font-weight: 600; }
        input { box-sizing: border-box; width: 100%; max-width: 500px; padding: 9px; border: 1px solid #9ca3af; border-radius: 5px; font: inherit; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
        .status { margin: 0 0 18px; padding: 10px 14px; background: #dcfce7; border-radius: 6px; }
        .error { color: #b91c1c; margin: 4px 0 0; }
        .empty { padding: 22px; text-align: center; color: #6b7280; }
    </style>
</head>
<body>
<main>
    @if (session('status'))
        <p class="status">{{ session('status') }}</p>
    @endif
    @yield('content')
</main>
</body>
</html>
