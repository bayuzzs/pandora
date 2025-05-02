@extends('layouts.app')

@section('title', 'Dasbor Pandora')

@section('content')
  <!-- Hero Section -->
  <div class="bg-gradient-to-r from-[#008a3e] to-[#006a2e] rounded-xl shadow-sm p-8 mb-8">
    <div class="max-w-3xl">
      <h1 class="text-3xl font-bold text-white mb-4">Selamat Datang!</h1>
      {{-- <h1 class="text-3xl font-bold text-white mb-4">Selamat Datang, {{ Auth::user()->name }}!</h1> --}}
      <p class="text-white/90 text-lg">Selamat Datang di Pandora - Pendataan Domba Rahayu</p>
      <p class="text-white/90 text-lg mt-2">Sistem pengelolaan data domba yang membantu Anda mengawasi dan mengelola ternak
        domba dengan lebih efisien.</p>
      <div class="mt-6">
        <a href="{{ route('dashboard.sheep.create') }}"
          class="inline-flex items-center px-4 py-2 bg-white text-green-700 border border-transparent rounded-md font-semibold text-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-700 transition-colors duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Tambah Domba Baru
        </a>
      </div>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @php
      $totalSheep = \App\Models\Sheep::count();
      $healthySheep = \App\Models\Sheep::where('health_status', 'healthy')->count();
      $totalPens = \App\Models\Pen::count();
      $sickSheep =
          \App\Models\Sheep::where('health_status', 'sick')->count() +
          \App\Models\Sheep::where('health_status', 'recovering')->count();
    @endphp

    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-gray-500 text-sm font-medium">Total Domba</h3>
      <p class="text-2xl font-bold text-green-600 mt-2">{{ $totalSheep }}</p>
      <p class="text-green-500 text-sm mt-2">Domba terdaftar dalam sistem</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-gray-500 text-sm font-medium">Domba Sehat</h3>
      <p class="text-2xl font-bold text-green-600 mt-2">{{ $healthySheep }}</p>
      <p class="text-green-500 text-sm mt-2">{{ $totalSheep > 0 ? round(($healthySheep / $totalSheep) * 100) : 0 }}% dari
        total domba</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-gray-500 text-sm font-medium">Kandang</h3>
      <p class="text-2xl font-bold text-green-600 mt-2">{{ $totalPens }}</p>
      <p class="text-green-500 text-sm mt-2">Kandang tersedia</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-gray-500 text-sm font-medium">Perlu Perhatian</h3>
      <p class="text-2xl font-bold text-{{ $sickSheep > 0 ? 'red' : 'green' }}-600 mt-2">{{ $sickSheep }}</p>
      <p class="text-{{ $sickSheep > 0 ? 'red' : 'green' }}-500 text-sm mt-2">Domba sakit/pemulihan</p>
    </div>
  </div>

  <!-- Quick Access & Recent Data -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Quick Access -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Menu Cepat</h2>
      <div class="space-y-3">
        <a href="{{ route('dashboard.sheep.search') }}"
          class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-colors duration-200">
          <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <h3 class="text-md font-medium text-gray-900">Cari Domba</h3>
            <p class="text-sm text-gray-500">Cari dengan tag RFID</p>
          </div>
        </a>

        <a href="{{ route('dashboard.sheep.create') }}"
          class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-colors duration-200">
          <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
          </div>
          <div class="ml-4">
            <h3 class="text-md font-medium text-gray-900">Tambah Domba</h3>
            <p class="text-sm text-gray-500">Daftarkan domba baru</p>
          </div>
        </a>

        <a href="{{ route('dashboard.pens.index') }}"
          class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-colors duration-200">
          <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
          </div>
          <div class="ml-4">
            <h3 class="text-md font-medium text-gray-900">Lihat Kandang</h3>
            <p class="text-sm text-gray-500">Monitoring kandang</p>
          </div>
        </a>

        <a href="{{ route('dashboard.sheep.index') }}"
          class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-colors duration-200">
          <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <div class="ml-4">
            <h3 class="text-md font-medium text-gray-900">Manajemen Data</h3>
            <p class="text-sm text-gray-500">Kelola data domba</p>
          </div>
        </a>
      </div>
    </div>

    <!-- Recent Sheep -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:col-span-2">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Domba Terbaru</h2>
        <a href="{{ route('dashboard.sheep.index') }}" class="text-sm text-green-600 hover:text-green-700">Lihat
          Semua</a>
      </div>

      @php
        $recentSheep = \App\Models\Sheep::latest()->take(5)->get();
      @endphp

      @if ($recentSheep->count() > 0)
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  ID
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nama
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Breed
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($recentSheep as $sheep)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $sheep->rfid }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="ml-0">
                        <div class="text-sm font-medium text-gray-900">{{ $sheep->name }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ ucfirst($sheep->breed) }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                      {{ $sheep->health_status == 'healthy'
                          ? 'bg-green-100 text-green-800'
                          : ($sheep->health_status == 'sick'
                              ? 'bg-red-100 text-red-800'
                              : 'bg-yellow-100 text-yellow-800') }}">
                      {{ ucfirst($sheep->health_status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('dashboard.sheep.show', $sheep) }}"
                      class="text-green-600 hover:text-green-900 mr-3">Detail</a>
                    <a href="{{ route('dashboard.sheep.edit', $sheep) }}"
                      class="text-indigo-600 hover:text-indigo-900">Edit</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-center py-8">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <p class="mt-2 text-sm text-gray-500">Belum ada data domba</p>
          <div class="mt-4">
            <a href="{{ route('dashboard.sheep.create') }}"
              class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
              Tambah Domba Baru
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>

  <!-- Breed Distribution & Health Status -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Breed Distribution -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Breed Domba</h2>

      @php
        $breeds = \App\Models\Sheep::select('breed')
            ->selectRaw('count(*) as count')
            ->groupBy('breed')
            ->get()
            ->map(function ($item) use ($totalSheep) {
                $item->percentage = $totalSheep > 0 ? round(($item->count / $totalSheep) * 100) : 0;
                return $item;
            });
      @endphp

      @if ($breeds->count() > 0)
        <div class="space-y-4">
          @foreach ($breeds as $breed)
            <div>
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-900">{{ ucfirst($breed->breed) }}</span>
                <span class="text-sm text-gray-500">{{ $breed->percentage }}%</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $breed->percentage }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-8">
          <p class="text-sm text-gray-500">Belum ada data breed</p>
        </div>
      @endif
    </div>

    <!-- Health Status -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Kesehatan</h2>

      @php
        $healthStatuses = \App\Models\Sheep::select('health_status')
            ->selectRaw('count(*) as count')
            ->groupBy('health_status')
            ->get()
            ->map(function ($item) use ($totalSheep) {
                $item->percentage = $totalSheep > 0 ? round(($item->count / $totalSheep) * 100) : 0;
                return $item;
            });

        $statusColors = [
            'healthy' => 'green',
            'sick' => 'red',
            'recovering' => 'yellow',
            'quarantined' => 'purple',
        ];
      @endphp

      @if ($healthStatuses->count() > 0)
        <div class="space-y-4">
          @foreach ($healthStatuses as $status)
            @php
              $color = $statusColors[$status->health_status] ?? 'gray';
            @endphp
            <div>
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-900">{{ ucfirst($status->health_status) }}</span>
                <span class="text-sm text-gray-500">{{ $status->percentage }}%</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-{{ $color }}-600 h-2 rounded-full" style="width: {{ $status->percentage }}%">
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-8">
          <p class="text-sm text-gray-500">Belum ada data status kesehatan</p>
        </div>
      @endif
    </div>
  </div>
@endsection
