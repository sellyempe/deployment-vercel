<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-gray-900">
    <x-navbar></x-navbar>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                Selamat Datang di <span class="bg-gradient-to-r from-pink-500 to-blue-500 bg-clip-text text-transparent">Pink
                    Tour and Travel</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                Temukan destinasi menakjubkan dan rencanakan perjalanan impian Anda
            </p>

            <div class="flex gap-4 justify-center">
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-pink-500 to-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition">
                    Jelajahi Sekarang
                </a>
                <a href="{{ route('register') }}" class="border-2 border-gray-300 text-gray-900 dark:text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
</body>

</html>