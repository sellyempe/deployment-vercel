<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ get_setting('site_name', 'Pink Tour and Travel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white overflow-hidden">

    <div class="min-h-screen flex w-full">

        <!-- LEFT SIDE IMAGE -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-950">

            <img src="/images/banda-neira.jpeg" alt="Banda Neira"
                class="absolute inset-0 w-full h-full object-cover opacity-90" style="object-position: 75% center;">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-slate-950/20 backdrop-blur-[0.5px]"></div>

            <!-- Left Content -->
            <div class="absolute z-10 flex flex-col text-white text-left w-full max-w-2xl px-8" style="bottom: 7%; left: 3%;">

                <h1 class="text-5xl font-bold leading-tight mb-4 uppercase">
                    Start Your Journey With Us
                </h1>

                <p class="text-lg text-white/90 leading-relaxed">
                    Create your account and discover unforgettable travel
                    experiences in Banda Neira with {{ get_setting('site_name', 'Pink Tour and Travel') }}.
                </p>
            </div>
        </div>

        <!-- RIGHT SIDE FORM -->
        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8">

            <div class="w-full max-w-md -mt-12">

                <!-- Heading -->
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-[#020617] mb-2">
                        Create Account
                    </h2>

                    <p class="text-slate-500">
                        Join us and begin your travel adventure
                    </p>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6">
                    <p class="font-semibold mb-2">
                        Please review the following:
                    </p>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Register Form -->
                <form action="{{ route('register') }}" method="POST" class="space-y-5">

                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-800 mb-2">
                            Full Name
                        </label>

                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Enter your full name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-800 mb-2">
                            Email Address
                        </label>

                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-800 mb-2">
                            Password
                        </label>

                        <input type="password" id="password" name="password" placeholder="••••••••" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">

                        <p class="text-xs text-gray-500 mt-1">
                            Minimum 6 characters
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-800 mb-2">
                            Confirm Password
                        </label>

                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="••••••••" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="terms" name="terms" required
                            class="mt-1 w-4 h-4 text-pink-600 rounded border-gray-300 focus:ring-pink-500">

                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the
                            <a href="#" class="text-pink-600 font-medium hover:text-pink-700">
                                Terms & Conditions
                            </a>
                            and
                            <a href="#" class="text-pink-600 font-medium hover:text-pink-700">
                                Privacy Policy
                            </a>
                        </label>
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 rounded-xl transition duration-200 hover:scale-[1.02]">
                        Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <p class="text-center mt-6 text-gray-600">
                    Already have an account?

                    <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:text-pink-700">
                        Sign In
                    </a>
                </p>

            </div>
        </div>
    </div>

</body>

</html>