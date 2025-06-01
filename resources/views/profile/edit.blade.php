@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
  <!-- Hero Section -->
  <div class="bg-gradient-to-r from-[#008a3e] to-[#006a2e] rounded-xl shadow-sm p-8 mb-8">
    <div class="max-w-3xl">
      <h1 class="text-3xl font-bold text-white mb-4">Profil Anda</h1>
      <p class="text-white/90 text-lg">Kelola informasi profil dan pengaturan keamanan akun Anda</p>
    </div>
  </div>

  <!-- Profile Information -->
  <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Informasi Profil</h2>

    @if (session('status') === 'profile-updated')
      <div class="bg-green-50 text-green-800 p-4 mb-6 rounded-lg border border-green-100">
        Profil berhasil diperbarui.
      </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
          required>
        @error('name')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
          required>
        @error('email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <button type="submit"
          class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

  <!-- Change Password -->
  <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Ubah Password</h2>

    @if (session('status') === 'password-updated')
      <div class="bg-green-50 text-green-800 p-4 mb-6 rounded-lg border border-green-100">
        Password berhasil diperbarui.
      </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
        <input type="password" name="current_password" id="current_password"
          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
          required>
        @error('current_password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
        <input type="password" name="password" id="password"
          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
          required>
        @error('password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
          Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
          required>
      </div>

      <div>
        <button type="submit"
          class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
          Perbarui Password
        </button>
      </div>
    </form>
  </div>
@endsection
