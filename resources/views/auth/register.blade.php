<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - {{ config('app.name', 'Laravel') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
  <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 transform transition  -all duration-300">
      <!-- Logo Section -->
      <div class="text-center">
        <div class="flex justify-center mb-3">
          <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="h-22 w-auto">
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
          Daftar Akun
        </h2>
        <p class="mt-2 text-sm text-gray-600">
          Buat akun baru untuk melanjutkan
        </p>
      </div>

      <!-- Register Form -->
      <div class="bg-white py-8 px-4 shadow-lg rounded-lg">
        <form class="space-y-6" action="{{ route('register') }}" method="POST">
          @csrf
          <div class="space-y-4">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
              <input id="name" name="name" type="text" required
                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-[#008a3e] focus:border-[#008a3e] transition duration-150 ease-in-out sm:text-sm"
                placeholder="Masukkan nama lengkap">
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
              <input id="email" name="email" type="email" required
                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-[#008a3e] focus:border-[#008a3e] transition duration-150 ease-in-out sm:text-sm"
                placeholder="Masukkan alamat email">
            </div>
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata
                Sandi</label>
              <input id="password" name="password" type="password" required
                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-[#008a3e] focus:border-[#008a3e] transition duration-150 ease-in-out sm:text-sm"
                placeholder="Masukkan kata sandi">
            </div>
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata
                Sandi</label>
              <input id="password_confirmation" name="password_confirmation" type="password" required
                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-[#008a3e] focus:border-[#008a3e] transition duration-150 ease-in-out sm:text-sm"
                placeholder="Masukkan ulang kata sandi">
            </div>
          </div>

          <div>
            <button type="submit"
              class="group relative  w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#008a3e] hover:bg-[#006a2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#008a3e] transition duration-150 ease-in-out transform hover:scale-[1.02]">
              <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-[#006a2e] group-hover:text-white transition duration-150 ease-in-out"
                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </span>
              Daftar
            </button>
          </div>
        </form>
      </div>

      <!-- Login Link -->
      <div class="text-center">
        <p class="text-sm text-gray-600">
          Sudah memiliki akun?
          <a href="{{ route('login') }}"
            class="font-medium text-[#008a3e] hover:text-[#006a2e] transition duration-150 ease-in-out">
            Masuk di sini
          </a>
        </p>
      </div>
    </div>
  </div>
</body>

</html>
