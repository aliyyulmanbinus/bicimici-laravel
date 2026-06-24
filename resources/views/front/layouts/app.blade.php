<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('output.css') }}" rel="stylesheet">
        @stack('after-styles')
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <title>@yield('title')</title>
        <meta name="description" content="Bicimici is an innovative online learning platform that empowers students and professionals with high-quality, accessible courses.">

        <!-- Favicon -->
        <link rel="icon" type="image/svg" sizes="32x32" href="assets/images/logos/') }}">
        <link rel="apple-touch-icon" href="assets/images/logos/') }}">

        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="Bicimici Online Learning Platform - Learn Anytime, Anywhere">
        <meta property="og:description" content="Bicimici is an innovative online learning platform that empowers students and professionals with high-quality, accessible courses.">
        <meta property="og:image" content="assets/images/logos/') }}">
        <meta property="og:url" content="https://bicimici.netlify.app">
        <meta property="og:type" content="website">
    </head>
    <body>
        @yield('content')

        @stack('after-scripts')
    </body>
</html>