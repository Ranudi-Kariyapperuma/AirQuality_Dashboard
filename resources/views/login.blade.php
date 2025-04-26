<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - BreatheSafe Colombo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skycustom: '#87CEEB',
                        Deepdark: '#274472'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-skycustom via-white to-sky-200 min-h-screen font-sans">

<nav class="bg-skycustom shadow-md mb-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('dashboard') }}" class="flex items-center text-Deepdark font-bold text-lg">
                <span class="mr-2">*</span> BreatheSafe Colombo
            </a>

            

           
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-[#2c3e50] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        
        <div id="mobile-menu" class="hidden md:hidden flex-col space-y-2 mt-4">
            <a class="block {{ request()->is('/') ? 'text-[#1a2634] font-semibold' : 'text-[#2c3e50]' }} hover:text-[#1a2634]" href="{{ url('/') }}">Home</a>
            <a class="block {{ request()->is('reports') ? 'text-[#1a2634] font-semibold' : 'text-[#2c3e50]' }} hover:text-[#1a2634]" href="{{ url('/reports') }}">Reports</a>
            <a class="block {{ request()->is('about') ? 'text-[#1a2634] font-semibold' : 'text-[#2c3e50]' }} hover:text-[#1a2634]" href="{{ url('/about') }}">About</a>
            <a class="block {{ request()->is('contact') ? 'text-[#1a2634] font-semibold' : 'text-[#2c3e50]' }} hover:text-[#1a2634]" href="{{ url('/contact') }}">Contact</a>
            <a class="block {{ request()->is('login') ? 'text-[#1a2634] font-semibold' : 'text-[#2c3e50]' }} hover:text-[#1a2634]" href="{{ url('/login') }}">Login</a>
        </div>
    </div>
</nav>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>

    
    <div class="w-full max-w-sm p-8 bg-white rounded-2xl shadow-lg mx-auto mt-24">
        <h2 class="text-2xl font-bold text-center text-Deepdark mb-6">Welcome to BreatheSafe Colombo</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 text-sm p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-skycustom focus:outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-skycustom focus:outline-none" required>
            </div>

            <div class="flex items-center justify-between">
                <a href="/forget-password" class="text-sm text-skycustom hover:underline">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full bg-skycustom hover:bg-blue-400 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Login
            </button>
        </form>
    </div>

</body>
</html>
