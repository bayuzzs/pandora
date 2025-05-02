@extends('layouts.app')

@section('title', 'Cari Domba dengan RFID')

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
      <h1 class="text-2xl font-bold text-gray-800 mb-2">Pencarian RFID Domba</h1>
      <p class="text-gray-600">Sistem ini menampilkan informasi domba berdasarkan tag RFID yang terbaca oleh perangkat
        IoT.</p>
    </div>

    <!-- IoT Device Status -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Status Perangkat IoT</h2>
        <div class="flex gap-4">
          <span id="connection-status"
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
            <span class="h-2 w-2 mr-1 bg-green-400 rounded-full animate-pulse"></span>
            Terhubung
          </span>
          <span id="device-status"
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
            <span class="h-2 w-2 mr-1 bg-yellow-400 rounded-full"></span>
            Menunggu Pemindaian
          </span>
        </div>
      </div>

      <!-- RFID Scanner Interface -->
      <div
        class="flex flex-col items-center justify-center py-10 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mb-6">
        <div id="scanner-animation" class="relative mb-4">
          <div class="absolute -inset-2 bg-green-500 opacity-20 rounded-full blur animate-pulse"></div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-green-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
          </svg>
        </div>
        <h3 id="scanner-status-text" class="text-lg font-medium text-gray-700 mb-2">Menunggu Pemindaian RFID</h3>
        <p class="text-gray-500 text-center max-w-md mb-6">
          Sistem sedang mendengarkan pemindaian RFID dari perangkat IoT. Dekatkan tag RFID domba ke perangkat untuk
          memindai dan menampilkan informasi.
        </p>

        <!-- Manual Input Option -->
        <div class="w-full max-w-md">
          <div class="flex items-center">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="flex-shrink px-3 text-sm text-gray-500">atau masukkan RFID manual</span>
            <div class="flex-grow border-t border-gray-300"></div>
          </div>

          <form action="{{ route('dashboard.sheep.search') }}" method="GET" class="mt-4 flex">
            <input type="text" id="manual-rfid" name="rfid" placeholder="Masukkan ID RFID"
              class="flex-grow h-11 rounded-l-lg border-gray-300 bg-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 transition-colors duration-200">
            <button id="search-btn" type="submit"
              class="px-6 h-11 bg-green-600 text-white font-medium rounded-r-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
              Cari
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Recently Scanned Sheep -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Pemindaian Terbaru</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Waktu</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                RFID</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nama Domba</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Kandang</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Aksi</th>
            </tr>
          </thead>
          <tbody id="recent-scans" class="bg-white divide-y divide-gray-200">
            <!-- This will be populated by JavaScript -->
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ date('H:i:s') }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">RF-2023-0089</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Domba Garut A12</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Kandang Utama</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Sehat
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <a href="#" class="text-green-600 hover:text-green-900">Lihat Detail</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Sheep Details Card (Initially Hidden unless found) -->
    <div id="sheep-details"
      class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6 {{ (!isset($sheep) || $sheep === null) && !isset($searchPerformed) ? 'hidden' : '' }}">
      @if (isset($sheep) && $sheep !== null)
        <!-- Sheep found -->
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold text-gray-800">Detail Domba Ditemukan</h2>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            ID: {{ $sheep->rfid }}
          </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Sheep Image -->
          <div class="flex flex-col items-center">
            <div class="w-full h-60 bg-gray-200 rounded-lg overflow-hidden mb-4">
              @if ($sheep->photo_path)
                <img src="{{ asset('storage/' . $sheep->photo_path) }}" alt="Foto {{ $sheep->name }}"
                  class="w-full h-full object-cover">
              @else
                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                  @if ($sheep->gender == 'male')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-blue-500" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-pink-500" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  @endif
                </div>
              @endif
            </div>
            <div class="text-center">
              <h3 class="text-xl font-bold text-gray-800">{{ $sheep->name }}</h3>
              <p class="text-gray-600">{{ ucfirst($sheep->breed) }}</p>
            </div>
          </div>

          <!-- Sheep Information -->
          <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Dasar</h4>
                <ul class="space-y-2">
                  <li class="flex justify-between">
                    <span class="text-gray-600">Jenis Kelamin:</span>
                    <span class="font-medium">{{ $sheep->gender == 'male' ? 'Jantan' : 'Betina' }}</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">Tanggal Lahir:</span>
                    <span class="font-medium">{{ $sheep->birth_date->format('d F Y') }}</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">Usia:</span>
                    <span class="font-medium">{{ $sheep->birth_date->diffForHumans(null, true) }}</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">Berat:</span>
                    <span class="font-medium">{{ $sheep->weight }} kg</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">Status Kesehatan:</span>
                    <span
                      class="font-medium 
                      {{ $sheep->health_status == 'healthy'
                          ? 'text-green-600'
                          : ($sheep->health_status == 'sick'
                              ? 'text-red-600'
                              : ($sheep->health_status == 'recovering'
                                  ? 'text-yellow-600'
                                  : 'text-gray-600')) }}">
                      {{ $sheep->health_status == 'healthy'
                          ? 'Sehat'
                          : ($sheep->health_status == 'sick'
                              ? 'Sakit'
                              : ($sheep->health_status == 'recovering'
                                  ? 'Pemulihan'
                                  : 'Karantina')) }}
                    </span>
                  </li>
                </ul>
              </div>

              <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Kandang</h4>
                <ul class="space-y-2">
                  <li class="flex justify-between">
                    <span class="text-gray-600">Kandang:</span>
                    <span class="font-medium">{{ $sheep->pen ? $sheep->pen->name : 'Tidak Terdaftar' }}</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">Lokasi:</span>
                    <span class="font-medium">{{ $sheep->pen ? $sheep->pen->location : 'Tidak Terdaftar' }}</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">Bergabung Sejak:</span>
                    <span class="font-medium">{{ $sheep->created_at->format('d F Y') }}</span>
                  </li>
                </ul>
              </div>

              <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Kesehatan</h4>
                <ul class="space-y-2">
                  <li class="flex justify-between">
                    <span class="text-gray-600">Vaksinasi Terakhir:</span>
                    <span
                      class="font-medium">{{ $sheep->last_vaccination_date ? $sheep->last_vaccination_date->format('d F Y') : 'Belum Ada' }}</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">Pemeriksaan Terakhir:</span>
                    <span
                      class="font-medium">{{ $sheep->last_check_date ? $sheep->last_check_date->format('d F Y') : 'Belum Ada' }}</span>
                  </li>
                </ul>
              </div>

              <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Silsilah</h4>
                <ul class="space-y-2">
                  <li class="flex justify-between">
                    <span class="text-gray-600">ID Pejantan:</span>
                    <span class="font-medium">{{ $sheep->parent_sire ?: 'Tidak Diketahui' }}</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-gray-600">ID Induk:</span>
                    <span class="font-medium">{{ $sheep->parent_dam ?: 'Tidak Diketahui' }}</span>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-wrap gap-4">
              <a href="{{ route('dashboard.sheep.edit', $sheep) }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Data
              </a>
              <a href="{{ route('dashboard.sheep.show', $sheep) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Lihat Detail Lengkap
              </a>
              <button onclick="window.print()"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Info
              </button>
            </div>
          </div>
        </div>
      @elseif(isset($searchPerformed) && $searchPerformed)
        <!-- Search performed but no sheep found -->
        <div class="flex flex-col items-center py-10">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mb-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Domba Tidak Ditemukan</h3>
          <p class="text-gray-600 text-center max-w-md mb-6">
            Tidak ada domba dengan RFID yang dimasukkan. Periksa kembali ID RFID atau hubungi administrator sistem.
          </p>
          <a href="{{ route('dashboard.sheep.create') }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Domba Baru
          </a>
        </div>
      @else
        <!-- Initial state, no search yet -->
        <div class="flex flex-col items-center py-10">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-500 mb-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Siap Mencari Domba</h3>
          <p class="text-gray-600 text-center max-w-md">
            Pemindai RFID siap digunakan. Dekatkan tag RFID domba ke perangkat pemindai, atau gunakan formulir di atas
            untuk mencari secara manual.
          </p>
        </div>
      @endif
    </div>
  </div>

  <!-- JavaScript for IoT device integration -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sheepDetails = document.getElementById('sheep-details');
      const searchBtn = document.getElementById('search-btn');
      const manualRfidInput = document.getElementById('manual-rfid');
      const connectionStatus = document.getElementById('connection-status');
      const deviceStatus = document.getElementById('device-status');
      const scannerStatusText = document.getElementById('scanner-status-text');
      const scannerAnimation = document.getElementById('scanner-animation');
      const recentScans = document.getElementById('recent-scans');

      // Allow pressing Enter to search in manual input
      manualRfidInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
          searchBtn.click();
        }
      });

      // IoT device simulation vars
      let socket = null;
      let isConnected = false;
      let reconnectAttempts = 0;
      const MAX_RECONNECT_ATTEMPTS = 5;

      // Connect to WebSocket server
      function connectToIoTDevice() {
        try {
          updateConnectionStatus('connecting');

          // In a real implementation, replace with actual WebSocket endpoint
          // socket = new WebSocket('wss://your-iot-device-websocket-endpoint');

          // For demo purposes, we'll simulate a connection
          setTimeout(() => {
            isConnected = true;
            updateConnectionStatus('connected');
            listenForRFIDScans();
          }, 1500);

          // In a real implementation, you'd handle WebSocket events like this:
          /*
          socket.onopen = function() {
            isConnected = true;
            reconnectAttempts = 0;
            updateConnectionStatus('connected');
          };
          
          socket.onclose = function() {
            isConnected = false;
            updateConnectionStatus('disconnected');
            attemptReconnect();
          };
          
          socket.onerror = function(error) {
            console.error('WebSocket error:', error);
            updateConnectionStatus('error');
          };
          
          socket.onmessage = function(event) {
            const data = JSON.parse(event.data);
            if (data.type === 'rfid_scan') {
              handleRFIDScan(data.rfid);
            }
          };
          */
        } catch (error) {
          console.error('Failed to connect to IoT device:', error);
          updateConnectionStatus('error');
        }
      }

      // Update UI based on connection status
      function updateConnectionStatus(status) {
        switch (status) {
          case 'connecting':
            connectionStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
            connectionStatus.innerHTML =
              '<span class="h-2 w-2 mr-1 bg-yellow-400 rounded-full animate-pulse"></span> Menghubungkan...';
            break;
          case 'connected':
            connectionStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
            connectionStatus.innerHTML =
              '<span class="h-2 w-2 mr-1 bg-green-400 rounded-full animate-pulse"></span> Terhubung';
            deviceStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
            deviceStatus.innerHTML =
              '<span class="h-2 w-2 mr-1 bg-blue-400 rounded-full animate-pulse"></span> Mendengarkan';
            break;
          case 'disconnected':
            connectionStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            connectionStatus.innerHTML = '<span class="h-2 w-2 mr-1 bg-gray-400 rounded-full"></span> Terputus';
            deviceStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            deviceStatus.innerHTML = '<span class="h-2 w-2 mr-1 bg-gray-400 rounded-full"></span> Tidak Aktif';
            break;
          case 'error':
            connectionStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
            connectionStatus.innerHTML =
              '<span class="h-2 w-2 mr-1 bg-red-400 rounded-full"></span> Kesalahan Koneksi';
            break;
          case 'scanning':
            deviceStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
            deviceStatus.innerHTML =
              '<span class="h-2 w-2 mr-1 bg-green-400 rounded-full animate-ping"></span> Memindai';
            scannerStatusText.textContent = 'Pemindaian RFID Terdeteksi';
            scannerAnimation.classList.add('scale-110');
            break;
          case 'idle':
            deviceStatus.className =
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
            deviceStatus.innerHTML =
              '<span class="h-2 w-2 mr-1 bg-blue-400 rounded-full animate-pulse"></span> Mendengarkan';
            scannerStatusText.textContent = 'Menunggu Pemindaian RFID';
            scannerAnimation.classList.remove('scale-110');
            break;
        }
      }

      // Attempt to reconnect to WebSocket
      function attemptReconnect() {
        if (reconnectAttempts < MAX_RECONNECT_ATTEMPTS) {
          reconnectAttempts++;
          setTimeout(() => {
            console.log(`Attempting to reconnect (${reconnectAttempts}/${MAX_RECONNECT_ATTEMPTS})...`);
            connectToIoTDevice();
          }, 2000 * reconnectAttempts); // Exponential backoff
        } else {
          console.error('Maximum reconnect attempts reached');
        }
      }

      // Process RFID scan data
      function handleRFIDScan(rfid) {
        // Update UI to show scanning state
        updateConnectionStatus('scanning');

        // Simulate API request to fetch sheep data
        fetchSheepData(rfid);

        // Add to recent scans list
        addToRecentScans(rfid);

        // Reset scanner state after a delay
        setTimeout(() => {
          updateConnectionStatus('idle');
        }, 3000);
      }

      // Fetch sheep data from the server
      function fetchSheepData(rfid) {
        // In a real implementation, you'd make an AJAX request:
        /*
        fetch(`/api/sheep/search?rfid=${rfid}`)
          .then(response => response.json())
          .then(data => {
            if (data.found) {
              displaySheepDetails(data.sheep);
            } else {
              displayNotFound(rfid);
            }
          })
          .catch(error => {
            console.error('Error fetching sheep data:', error);
          });
        */

        // For demo purposes, redirect to search page with rfid parameter
        window.location.href = `/dashboard/sheep/search?rfid=${rfid}`;
      }

      // Add a new scan to the recent scans table
      function addToRecentScans(rfid, name = 'Loading...', pen = 'Loading...') {
        const now = new Date();
        const timeString = now.toTimeString().split(' ')[0];

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${timeString}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${rfid}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${name}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${pen}</td>
          <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
              Memuat...
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <a href="/dashboard/sheep/search?rfid=${rfid}" class="text-green-600 hover:text-green-900">Lihat Detail</a>
          </td>
        `;

        // Add to the beginning of the table
        const firstRow = recentScans.querySelector('tr');
        if (firstRow) {
          recentScans.insertBefore(newRow, firstRow);
        } else {
          recentScans.appendChild(newRow);
        }

        // Keep only the latest 5 scans
        const rows = recentScans.querySelectorAll('tr');
        if (rows.length > 5) {
          for (let i = 5; i < rows.length; i++) {
            rows[i].remove();
          }
        }
      }

      // Simulate RFID scans (for demo purposes)
      function listenForRFIDScans() {
        // In a real implementation, you'd listen for WebSocket messages
        // Here we'll simulate random scans for demo purposes

        // Example RFID tags
        const exampleRFIDs = [
          'RF-2023-0089',
          'RF-2023-0072',
          'RF-2023-0045',
          'RF-2023-0118',
          'RF-2023-0056'
        ];

        // Schedule a random scan 
        const randomScanTimeout = Math.random() * 20000 + 10000; // Random time between 10-30 seconds
        setTimeout(() => {
          if (isConnected) {
            // Pick a random RFID
            const rfid = exampleRFIDs[Math.floor(Math.random() * exampleRFIDs.length)];
            handleRFIDScan(rfid);

            // Schedule the next scan
            listenForRFIDScans();
          }
        }, randomScanTimeout);
      }

      // Start the connection
      connectToIoTDevice();
    });
  </script>
@endsection
