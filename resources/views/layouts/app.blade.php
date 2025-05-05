<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', config('app.name'))</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>

<body class="bg-gray-50">
  <div class="min-h-screen">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center space-x-4">
            <a href="/" class="flex items-center">
              <img src="{{ asset('images/logo-caption.png') }}" alt="Logo" class="h-8 w-auto">
            </a>
          </div>
          <div class="flex items-center space-x-4">
            @auth
              <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                  class="flex items-center space-x-2 text-gray-700 hover:text-primary focus:outline-none">
                  <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false"
                  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                  <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profile
                  </a>
                  <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Settings
                  </a>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                      class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      Logout
                    </button>
                  </form>
                </div>
              </div>
            @endauth
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      @yield('content')
    </main>
  </div>
  @stack('scripts')
</body>

</html>
