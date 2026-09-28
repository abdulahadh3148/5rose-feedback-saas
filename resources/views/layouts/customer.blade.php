<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="theme-color"
        content="#071d16"
    >

    <link rel="icon" type="image/png" href="{{ asset('images/5rose/logo.png') }}">

    <title>
        @yield('title', '5Rose Coolspot')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/css/customer.css',
        'resources/js/app.js',
    ])

    @stack('styles')
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


    @stack('scripts')

</body>
</html>
