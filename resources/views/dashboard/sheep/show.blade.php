@extends('layouts.app')

@section('title', $sheep->name . ' - Detail Domba')

@section('content')
  <div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-4">
      <a href="{{ route('dashboard.sheep.index') }}"
        class="inline-flex items-center text-sm text-gray-600 hover:text-green-600 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar Domba
      </a>
    </div>

    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $sheep->name }}</h1>
          <p class="text-gray-600">Detail informasi lengkap tentang domba.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
          <a href="{{ route('dashboard.sheep.edit', $sheep) }}"
            class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit
          </a>
          <form action="{{ route('dashboard.sheep.destroy', $sheep) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus domba ini?')"
              class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Hapus
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left Column - Basic Info -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dasar</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- RFID -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Tag RFID</p>
              <p class="font-medium text-gray-800">{{ $sheep->uid }}</p>
            </div>

            <!-- Name -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Nama</p>
              <p class="font-medium text-gray-800">{{ $sheep->name }}</p>
            </div>

            <!-- Gender -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Jenis Kelamin</p>
              <p class="font-medium text-gray-800">
                @if ($sheep->gender == 'male')
                  <span class="inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Jantan
                  </span>
                @else
                  <span class="inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500 mr-1" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Betina
                  </span>
                @endif
              </p>
            </div>

            <!-- Breed -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Jenis/Ras</p>
              <p class="font-medium text-gray-800">{{ ucfirst($sheep->breed) }}</p>
            </div>

            <!-- Birth Date -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Tanggal Lahir</p>
              <p class="font-medium text-gray-800">{{ $sheep->birth_date->format('d M Y') }}</p>
            </div>

            <!-- Age -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Umur</p>
              <p class="font-medium text-gray-800">{{ $sheep->birth_date->diffForHumans(null, true) }}</p>
            </div>

            <!-- Weight -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Berat</p>
              <p class="font-medium text-gray-800">{{ $sheep->weight }} kg</p>
            </div>

            <!-- Health Status -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Status Kesehatan</p>
              <p class="font-medium">
                @if ($sheep->health_status == 'Sehat')
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Sehat
                  </span>
                @elseif($sheep->health_status == 'Sakit')
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Sakit
                  </span>
                @elseif($sheep->health_status == 'Karantina')
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Pemulihan
                  </span>
                @else
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    Karantina
                  </span>
                @endif
              </p>
            </div>

            <!-- Pen -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Kandang</p>
              <p class="font-medium text-gray-800">
                @if ($sheep->pen)
                  {{ $sheep->pen->name }} ({{ $sheep->pen->location }})
                @else
                  <span class="text-gray-500">Tidak ada kandang</span>
                @endif
              </p>
            </div>
          </div>
        </div>

        <!-- Parentage Information -->
        {{-- <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Genetik</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Parent Sire -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">ID Pejantan (Ayah)</p>
              <p class="font-medium text-gray-800">
                @if ($sheep->parent_sire)
                  {{ $sheep->parent_sire }}
                @else
                  <span class="text-gray-500">Tidak tercatat</span>
                @endif
              </p>
            </div>

            <!-- Parent Dam -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">ID Induk (Ibu)</p>
              <p class="font-medium text-gray-800">
                @if ($sheep->parent_dam)
                  {{ $sheep->parent_dam }}
                @else
                  <span class="text-gray-500">Tidak tercatat</span>
                @endif
              </p>
            </div>
          </div>
        </div> --}}

        <!-- Health Records -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan Kesehatan</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Last Check Date -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Pemeriksaan Terakhir</p>
              <p class="font-medium text-gray-800">
                @if ($sheep->last_check_date)
                  {{ $sheep->last_check_date->format('d M Y') }}
                @else
                  <span class="text-gray-500">Belum pernah diperiksa</span>
                @endif
              </p>
            </div>

            <!-- Last Vaccination Date -->
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
              <p class="text-sm text-gray-500 mb-1">Vaksinasi Terakhir</p>
              <p class="font-medium text-gray-800">
                @if ($sheep->last_vaccination_date)
                  {{ $sheep->last_vaccination_date->format('d M Y') }}
                @else
                  <span class="text-gray-500">Belum pernah divaksin</span>
                @endif
              </p>
            </div>
          </div>
        </div>

        <!-- Notes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan</h2>

          <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
            @if ($sheep->notes)
              <p class="text-gray-800">{{ $sheep->notes }}</p>
            @else
              <p class="text-gray-500">Tidak ada catatan</p>
            @endif
          </div>
        </div>
      </div>

      <!-- Right Column - Photo and Timestamps -->
      <div class="space-y-6">
        <!-- Photo Card -->
        {{-- <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Foto</h2>

          <div class="w-64 h-64 mx-auto bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
            @if ($sheep->photo_path)
              <img src="{{ asset('storage/' . $sheep->photo_path) }}" alt="{{ $sheep->name }}"
                class="object-cover w-full h-full">
            @else
              @if ($sheep->gender == 'male')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-1/3 h-1/3 text-blue-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-1/3 h-1/3 text-pink-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              @endif
            @endif
          </div>
        </div> --}}

        <!-- System Information Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Sistem</h2>

          <div class="space-y-3">
           
            <div>
              <p class="text-sm text-gray-500 mb-1">Terdaftar Pada</p>
              <p class="font-medium text-gray-800">{{ $sheep->created_at->format('d M Y H:i') }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Terakhir Diupdate</p>
              <p class="font-medium text-gray-800">{{ $sheep->updated_at->format('d M Y H:i') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
