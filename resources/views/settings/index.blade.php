@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
  <!-- Hero Section -->
  <div class="bg-gradient-to-r from-[#008a3e] to-[#006a2e] rounded-xl shadow-sm p-8 mb-8">
    <div class="max-w-3xl">
      <h1 class="text-3xl font-bold text-white mb-4">Pengaturan Aplikasi</h1>
      <p class="text-white/90 text-lg">Kustomisasi pengalaman Anda dengan mengatur preferensi dan notifikasi</p>
    </div>
  </div>

  <div class="space-y-8">
    <!-- Notification Settings -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <h2 class="text-lg font-semibold text-gray-800 mb-6">Pengaturan Notifikasi</h2>

      @if (session('status') === 'notifications-updated')
        <div class="bg-green-50 text-green-800 p-4 mb-6 rounded-lg border border-green-100">
          Pengaturan notifikasi berhasil diperbarui.
        </div>
      @endif

      <form action="{{ route('settings.notifications') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-4">
          <div class="flex items-center">
            <input type="checkbox" name="email_notifications" id="email_notifications"
              class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
              {{ isset($user->settings['notifications']['email']) && $user->settings['notifications']['email'] ? 'checked' : '' }}>
            <label for="email_notifications" class="ml-2 block text-sm text-gray-700">
              Notifikasi Email
            </label>
          </div>

          <div class="flex items-center">
            <input type="checkbox" name="browser_notifications" id="browser_notifications"
              class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
              {{ isset($user->settings['notifications']['browser']) && $user->settings['notifications']['browser'] ? 'checked' : '' }}>
            <label for="browser_notifications" class="ml-2 block text-sm text-gray-700">
              Notifikasi Browser
            </label>
          </div>
        </div>

        <div class="mt-6">
          <button type="submit"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
            Simpan Pengaturan Notifikasi
          </button>
        </div>
      </form>
    </div>

    <!-- Application Preferences -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <h2 class="text-lg font-semibold text-gray-800 mb-6">Preferensi Aplikasi</h2>

      @if (session('status') === 'preferences-updated')
        <div class="bg-green-50 text-green-800 p-4 mb-6 rounded-lg border border-green-100">
          Preferensi berhasil diperbarui.
        </div>
      @endif

      <form action="{{ route('settings.preferences') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
          <div>
            <label for="theme" class="block text-sm font-medium text-gray-700 mb-1">Tema</label>
            <select name="theme" id="theme"
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
              <option value="light"
                {{ isset($user->settings['preferences']['theme']) && $user->settings['preferences']['theme'] === 'light' ? 'selected' : '' }}>
                Terang</option>
              <option value="dark"
                {{ isset($user->settings['preferences']['theme']) && $user->settings['preferences']['theme'] === 'dark' ? 'selected' : '' }}>
                Gelap</option>
              <option value="system"
                {{ isset($user->settings['preferences']['theme']) && $user->settings['preferences']['theme'] === 'system' ? 'selected' : '' }}>
                Sistem</option>
            </select>
          </div>

          <div>
            <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Bahasa</label>
            <select name="language" id="language"
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
              <option value="en"
                {{ isset($user->settings['preferences']['language']) && $user->settings['preferences']['language'] === 'en' ? 'selected' : '' }}>
                Inggris</option>
              <option value="id"
                {{ isset($user->settings['preferences']['language']) && $user->settings['preferences']['language'] === 'id' ? 'selected' : '' }}>
                Indonesia</option>
            </select>
          </div>
        </div>

        <div class="mt-6">
          <button type="submit"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
            Simpan Preferensi
          </button>
        </div>
      </form>
    </div>

    <!-- Security Settings -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <h2 class="text-lg font-semibold text-gray-800 mb-6">Pengaturan Keamanan</h2>

      <div class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-colors duration-200">
        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
        <div class="ml-4">
          <a href="{{ route('profile.edit') }}">
            <h3 class="text-md font-medium text-gray-900">Ubah Password</h3>
            <p class="text-sm text-gray-500">Atur ulang kata sandi Anda untuk keamanan akun</p>
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
