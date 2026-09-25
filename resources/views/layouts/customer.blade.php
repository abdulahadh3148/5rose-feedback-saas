<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '5Rose Cool Bar')</title>
    @vite([
        'resources/css/app.css',
        'resources/css/customer.css',
        'resources/js/app.js',
    ])
</head>
<body class="customer-app">
    @hasSection('hideCustomerChrome')
    @else
        @include('components.customer.header')
    @endif

    @yield('content')

    @hasSection('hideCustomerChrome')
    @else
        @include('components.customer.footer')
    @endif
</body>
</html>
