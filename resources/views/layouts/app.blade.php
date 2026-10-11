<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Workshop Directory') | Workshop Directory</title>
    <style>
        body { margin: 0; background: #f4f6f8; color: #1f2937; font: 16px/1.5 system-ui, sans-serif; }
        main { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        h1 { margin: 0 0 20px; }
        a { color: #2563eb; }
        .site-nav { display: flex; gap: 16px; margin-bottom: 24px; }
        .site-nav a { font-weight: 600; }
        .button, button { display: inline-block; border: 0; border-radius: 6px; padding: 9px 14px; background: #2563eb; color: white; font: inherit; text-decoration: none; cursor: pointer; }
        .button.secondary { background: #4b5563; }
        .button.danger, button.danger { background: #dc2626; }
        .actions { display: flex; gap: 8px; align-items: center; }
        .card, table { width: 100%; background: white; border-collapse: collapse; border-radius: 8px; box-shadow: 0 1px 4px #00000012; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f9fafb; }
        tr:last-child td { border-bottom: 0; }
        label { display: block; margin: 14px 0 5px; font-weight: 600; }
        input, textarea, select { box-sizing: border-box; width: 100%; max-width: 500px; padding: 9px; border: 1px solid #9ca3af; border-radius: 5px; font: inherit; }
        input[type="checkbox"] { width: auto; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
        .status { margin: 0 0 18px; padding: 10px 14px; background: #dcfce7; border-radius: 6px; }
        .error { color: #b91c1c; margin: 4px 0 0; }
        .empty { padding: 22px; text-align: center; color: #6b7280; }
        .badge { display: inline-block; padding: 3px 9px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; }
        .badge-easy { background: #dcfce7; color: #166534; }
        .badge-medium { background: #fef3c7; color: #92400e; }
        .badge-hard { background: #fee2e2; color: #991b1b; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #e5e7eb; color: #374151; }
        .checkbox-label { display: flex; align-items: center; gap: 8px; margin-top: 18px; }
    </style>
</head>
<body>
<main>
    <nav class="site-nav" aria-label="Main navigation">
        <a href="{{ route('students.index') }}">Students</a>
        <a href="{{ route('courses.index') }}">Courses</a>
    </nav>
    @if (session('status'))
        <p class="status">{{ session('status') }}</p>
    @endif
    @yield('content')
</main>
</body>
</html>
