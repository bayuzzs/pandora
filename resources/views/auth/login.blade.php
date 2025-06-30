<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 transform transition-all duration-300">
            <!-- Logo Section -->
            <div class="text-center">
                <div class="flex justify-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}"
                        class="h-22 w-auto">
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    Selamat Datang
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Silahkan Login untuk melanjutkan
                </p>
            </div>

            <!-- Login Form -->
            <div class="bg-white py-8 px-4 shadow-lg rounded-lg">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                address</label>
                            <input id="email" name="email" type="email" required
                                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-[#008a3e] focus:border-[#008a3e] transition duration-150 ease-in-out sm:text-sm"
                                placeholder="Enter your email">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input id="password" name="password" type="password" required
                                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-[#008a3e] focus:border-[#008a3e] transition duration-150 ease-in-out sm:text-sm"
                                placeholder="Enter your password">       
                        </div>
                    </div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#008a3e] hover:bg-[#006a2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#008a3e] transition duration-150 ease-in-out transform hover:scale-[1.02]">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-[#006a2e] group-hover:text-white transition duration-150 ease-in-out"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Registration Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="font-medium text-[#008a3e] hover:text-[#006a2e] transition duration-150 ease-in-out">
                        Daftar Akun
                    </a>
                </p>
            </div>
        </div>
    </div>

    @if (session('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'bottom-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
</script>
@endif

@stack('scripts')
</body>

</html>