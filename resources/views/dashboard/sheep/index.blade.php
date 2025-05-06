@extends('layouts.app')

@section('title', 'Semua Domba')

@section('content')
  <div class="max-w-7xl mx-auto">
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
      <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-800 mb-2">Daftar Semua Domba</h1>
          <p class="text-gray-600">Kelola dan lihat informasi semua domba yang terdaftar dalam sistem.</p>
        </div>
        <div class="mt-4 md:mt-0">
          <a href="{{ route('dashboard.sheep.create') }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Domba Baru
          </a>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter & Pencarian</h2>

      <form action="{{ route('dashboard.sheep.index') }}" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Search Input -->
          <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <input type="text" id="search" name="search" value="{{ request('search') }}"
                class="pl-10 w-full h-10 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200"
                placeholder="Nama atau RFID">
            </div>
          </div>

          <!-- Gender Filter -->
          <div>
            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
            <select id="gender" name="gender"
              class="w-full h-10 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200">
              <option value="">Semua</option>
              <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Jantan</option>
              <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Betina</option>
            </select>
          </div>

          <!-- Breed Filter -->
          <div>
            <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Jenis/Ras</label>
            <select id="breed" name="breed"
              class="w-full h-10 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200">
              <option value="">Semua Jenis</option>
              @foreach ($breeds as $breed)
                <option value="{{ $breed }}" {{ request('breed') == $breed ? 'selected' : '' }}>
                  {{ ucfirst($breed) }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Health Status Filter -->
          <div>
            <label for="health_status" class="block text-sm font-medium text-gray-700 mb-1">Status Kesehatan</label>
            <select id="health_status" name="health_status"
              class="w-full h-10 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200">
              <option value="">Semua Status</option>
              <option value="healthy" {{ request('health_status') == 'healthy' ? 'selected' : '' }}>Sehat</option>
              <option value="sick" {{ request('health_status') == 'sick' ? 'selected' : '' }}>Sakit</option>
              <option value="recovering" {{ request('health_status') == 'recovering' ? 'selected' : '' }}>Dalam Pemulihan
              </option>
              <option value="quarantined" {{ request('health_status') == 'quarantined' ? 'selected' : '' }}>Karantina
              </option>
            </select>
          </div>

          <!-- Pen Filter -->
          <div>
            <label for="pen_id" class="block text-sm font-medium text-gray-700 mb-1">Kandang</label>
            <select id="pen_id" name="pen_id"
              class="w-full h-10 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200">
              <option value="">Semua Kandang</option>
              @foreach ($pens as $pen)
                <option value="{{ $pen->id }}" {{ request('pen_id') == $pen->id ? 'selected' : '' }}>
                  {{ $pen->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Sort By -->
          <div>
            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan Berdasarkan</label>
            <select id="sort" name="sort"
              class="w-full h-10 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200">
              <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal Ditambahkan
              </option>
              <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
              <option value="weight" {{ request('sort') == 'weight' ? 'selected' : '' }}>Berat</option>
              <option value="birth_date" {{ request('sort') == 'birth_date' ? 'selected' : '' }}>Umur</option>
            </select>
          </div>

          <!-- Sort Direction -->
          <div>
            <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
            <select id="direction" name="direction"
              class="w-full h-10 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200">
              <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Menurun (Z-A, terbaru)
              </option>
              <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Menaik (A-Z, terlama)</option>
            </select>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-end space-x-2">
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
              </svg>
              Filter
            </button>
            <a href="{{ route('dashboard.sheep.index') }}"
              class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Reset
            </a>
          </div>
        </div>
      </form>
    </div>

    <!-- Main Content / Sheep List -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Domba</h2>
        <p class="text-sm text-gray-500">Total: <span class="font-semibold">{{ $sheep->total() }}</span> domba</p>
      </div>

      @if ($sheep->count() > 0)
        <!-- Sheep Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach ($sheep as $animal)
            <div
              class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
              <div class="flex items-center p-4 border-b border-gray-100">
                <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden flex-shrink-0">
                  @if ($animal->gender == 'male')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full p-2 text-blue-500" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full p-2 text-pink-500" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  @endif
                </div>
                <div class="ml-4">
                  <h3 class="font-bold text-gray-800">{{ $animal->name }}</h3>
                  <p class="text-sm text-gray-600">{{ ucfirst($animal->breed) }}</p>
                </div>
                <div class="ml-auto">
                  @if ($animal->health_status == 'Sehat')
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      Sehat
                    </span>
                  @elseif($animal->health_status == 'Sakit')
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                      Sakit
                    </span>
                  @elseif($animal->health_status == 'Pemulihan')
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
                </div>
              </div>
              <div class="p-4">
                <div class="grid grid-cols-2 gap-4 mb-4">
                  <div>
                    <p class="text-xs text-gray-500 mb-1">RFID</p>
                    <p class="text-sm font-medium">{{ $animal->uid }}</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500 mb-1">Berat</p>
                    <p class="text-sm font-medium">{{ $animal->weight }} kg</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500 mb-1">Umur</p>
                    <p class="text-sm font-medium">{{ $animal->birth_date->diffForHumans(null, true) }}</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500 mb-1">Kandang</p>
                    <p class="text-sm font-medium">{{ $animal->pen ? $animal->pen->name : 'Tidak ada' }}</p>
                  </div>
                </div>
                <div class="flex justify-between">
                  <a href="{{ route('dashboard.sheep.show', $animal) }}"
                    class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors duration-200">
                    Lihat Detail
                  </a>
                  <div class="flex space-x-2">
                    <a href="{{ route('dashboard.sheep.edit', ['uid' => $animal->uid]) }}"
                      class="text-sm text-gray-500 hover:text-gray-700">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                      </svg>
                    </a>
                    <button type="button" class="text-sm text-red-500 hover:text-red-700"
                      onclick="if(confirm('Apakah Anda yakin ingin menghapus domba ini?')){document.getElementById('delete-form-{{ $animal->id }}').submit();}">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                    <form id="delete-form-{{ $animal->id }}"
                      action="{{ route('dashboard.sheep.destroy', $animal) }}" method="POST" style="display: none;">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
          {{ $sheep->links() }}
        </div>
      @else
        <!-- Empty State -->
        <div class="text-center py-12">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada data domba</h3>
          <p class="mt-2 text-gray-500">Tidak ada data domba yang sesuai dengan filter yang dipilih.</p>
          <div class="mt-6">
            <a href="{{ route('dashboard.sheep.create') }}"
              class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Tambah Domba Baru
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
