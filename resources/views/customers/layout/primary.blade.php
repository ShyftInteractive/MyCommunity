<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Rebase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="{{ mix('/assets/css/customer.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <nav></nav>
    </header>
    <main>
        @yield('page')
    </main>
    <footer>

    </footer>
</body>
</html>
