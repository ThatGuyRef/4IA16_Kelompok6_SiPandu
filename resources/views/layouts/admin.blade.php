<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} — Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&amp;display=swap" rel="stylesheet" />

        <!-- Font Awesome (Admin only) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-S2Zt9lS9+g0aJf6Heky3rj6/3Jb6sD5K+0qjZt2l3wM8CwqN7iFfQ9FvCjF2qk8y5xP2t1zWv5n4a4KQmJ7p2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Material Symbols (Admin only) -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
        <!-- Public Sans for Admin -->
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

        <!-- Vite (Load base app.css for shared nav styles, then admin.css to override/admin-specific) -->
        @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
    </head>
    <body class="font-display antialiased bg-background-light dark:bg-background-dark">
        <div class="min-h-screen bg-background-light dark:bg-background-dark">


            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Render view-pushed scripts --}}
        @stack('scripts')
    </body>
</html>
