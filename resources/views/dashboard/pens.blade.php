@extends('layouts.app')

@section('title', 'Monitor Kandang')

@section('content')
  <div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-4">
      <a href="{{ route('dashboard') }}"
        class="inline-flex items-center text-sm text-gray-600 hover:text-green-600 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Dashboard
      </a>
    </div>

    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
      <h1 class="text-2xl font-bold text-gray-800 mb-2">Monitor Kandang</h1>
      <p class="text-gray-600">Pantau aktivitas kandang secara real-time melalui kamera yang terpasang.</p>
    </div>

    <!-- Video Feed Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Live Feed</h2>
        <div class="flex items-center space-x-2">
          <span id="connection-status"
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
            <span class="h-2 w-2 mr-1 bg-green-400 rounded-full animate-pulse"></span>
            Live
          </span>
          <button id="fullscreen-btn" class="p-1 rounded-md hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 0h-4m4 0l-5-5" />
            </svg>
          </button>
        </div>
      </div>

      <!-- 16:9 Video Container -->
      <div class="relative bg-black rounded-lg overflow-hidden" style="padding-top: 56.25%;">
        <!-- Video placeholder with message that will be replaced by actual video stream -->
        <div id="video-placeholder" class="absolute inset-0 flex items-center justify-center flex-col">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
          </svg>
          <p class="text-gray-300 text-center px-4">Menghubungkan ke kamera... <br>Video stream akan muncul di sini.</p>
        </div>

        <!-- This will be the actual video element, initially hidden -->
        <img id="video-stream" class="absolute inset-0 w-full h-full object-cover hidden" src="http://10.10.1.99:5000/video_feed"></img>
      </div>

      <!-- Video Controls -->
      <div class="mt-4 flex flex-wrap items-center justify-between">
        <div class="flex items-center space-x-3 mt-2 sm:mt-0">
          <button id="play-pause-btn"
            class="p-2 bg-green-600 rounded-full text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </button>
          <button id="mute-btn"
            class="p-2 bg-gray-200 rounded-full text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"
                clip-rule="evenodd" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
            </svg>
          </button>
          <span id="time-display" class="text-sm text-gray-600">00:00:00</span>
        </div>

        <div class="flex space-x-3 mt-2 sm:mt-0">
          <select id="camera-select"
            class="text-sm rounded-lg border-gray-300 bg-gray-50 focus:border-green-500 focus:ring-green-200">
            <option value="camera1">Kamera 1</option>
            <option value="camera2">Kamera 2</option>
            <option value="camera3">Kamera 3</option>
          </select>
          <select id="quality-select"
            class="text-sm rounded-lg border-gray-300 bg-gray-50 focus:border-green-500 focus:ring-green-200">
            <option value="high">Kualitas Tinggi</option>
            <option value="medium" selected>Kualitas Sedang</option>
            <option value="low">Kualitas Rendah</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Camera Information -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <!-- Camera Status Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-4">
          <div class="p-2 bg-blue-100 rounded-lg mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Status Kamera</h3>
        </div>
        <ul class="space-y-2">
          <li class="flex justify-between">
            <span class="text-gray-600">Status Koneksi:</span>
            <span class="font-medium text-green-600">Terhubung</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Resolusi:</span>
            <span class="font-medium">1280x720</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Frame Rate:</span>
            <span class="font-medium">24 fps</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Terakhir Diperiksa:</span>
            <span class="font-medium">{{ date('d M Y, H:i') }}</span>
          </li>
        </ul>
      </div>

      <!-- Kandang Info -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-4">
          <div class="p-2 bg-green-100 rounded-lg mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Info Kandang</h3>
        </div>
        <ul class="space-y-2">
          <li class="flex justify-between">
            <span class="text-gray-600">Nama Kandang:</span>
            <span class="font-medium">Kandang Utama</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Jumlah Domba:</span>
            <span class="font-medium">24 ekor</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Luas Area:</span>
            <span class="font-medium">120 m²</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Lokasi:</span>
            <span class="font-medium">Blok A</span>
          </li>
        </ul>
      </div>

      <!-- Environmental Data -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-4">
          <div class="p-2 bg-yellow-100 rounded-lg mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Kondisi Lingkungan</h3>
        </div>
        <ul class="space-y-2">
          <li class="flex justify-between">
            <span class="text-gray-600">Suhu:</span>
            <span class="font-medium">26°C</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Kelembapan:</span>
            <span class="font-medium">65%</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Kualitas Udara:</span>
            <span class="font-medium text-green-600">Baik</span>
          </li>
          <li class="flex justify-between">
            <span class="text-gray-600">Pencahayaan:</span>
            <span class="font-medium">Sedang</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-4 mb-6">
      <button
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Kamera
      </button>
      <button
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        Pantau Semua Kamera
      </button>
      <button
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        Rekaman Tersimpan
      </button>
    </div>
  </div>

  <!-- JavaScript for video controls (placeholder) -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Simulating connection after 2 seconds
      setTimeout(() => {
        document.getElementById('video-placeholder').classList.add('hidden');
        document.getElementById('video-stream').classList.remove('hidden');

        // Since we don't have an actual stream, we're displaying a message
        const videoEl = document.getElementById('video-stream');
        const canvas = document.createElement('canvas');
        canvas.width = 1280;
        canvas.height = 720;
        const ctx = canvas.getContext('2d');

        // Create a placeholder with text
        ctx.fillStyle = '#1f2937';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.font = '24px sans-serif';
        ctx.fillStyle = '#ffffff';
        ctx.textAlign = 'center';
        ctx.fillText('IoT Video Stream akan muncul di sini', canvas.width / 2, canvas.height / 2 - 15);
        ctx.font = '18px sans-serif';
        ctx.fillText('Silakan hubungkan ke perangkat IoT Anda', canvas.width / 2, canvas.height / 2 + 20);

        // Set as video background
        videoEl.poster = canvas.toDataURL();
      }, 2000);

      // Fullscreen handler
      document.getElementById('fullscreen-btn').addEventListener('click', function() {
        const videoContainer = document.querySelector('.relative.bg-black');
        if (videoContainer.requestFullscreen) {
          videoContainer.requestFullscreen();
        } else if (videoContainer.webkitRequestFullscreen) {
          videoContainer.webkitRequestFullscreen();
        } else if (videoContainer.msRequestFullscreen) {
          videoContainer.msRequestFullscreen();
        }
      });

      // Update time display
      setInterval(() => {
        const now = new Date();
        const timeString = now.toTimeString().split(' ')[0];
        document.getElementById('time-display').textContent = timeString;
      }, 1000);
    });
  </script>
@endsection
