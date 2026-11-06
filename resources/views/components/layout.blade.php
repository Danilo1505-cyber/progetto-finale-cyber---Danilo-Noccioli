<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <title>The Aulab Post</title>
</head>
<body>
    <x-navbar />
    @if (session('message'))
        <div class="alert alert-success my-2">
            {{ session('message') }}
        </div>
    @endif
    @if (session('alert'))
        <div class="alert alert-danger my-2">
            {{ session('alert') }}
        </div>
    @endif
    <div class="min-vh-100">
        {{ $slot }}
    </div>
    
        </body>
        </html>