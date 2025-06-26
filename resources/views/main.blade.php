<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydroponic Grow</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon dan Icons -->
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
    
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
</head>
<body>
    <div class="container">
    <section class="page-section">
            @include('navbar') <!-- Bagian pertama -->
        </section>
        <section class="page-section">
            @include('homepage') <!-- Bagian pertama -->
        </section>

        <section class="page-section">
            @include('article') <!-- Bagian kedua -->
        </section>

        <section class="page-section">
            @include('video') <!-- Bagian ketiga -->
        </section>

        
    </div>
</body>
</html>
