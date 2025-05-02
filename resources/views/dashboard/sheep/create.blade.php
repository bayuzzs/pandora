@extends('layouts.app')

@section('title', 'Tambah Domba Baru')

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
      <h1 class="text-2xl font-bold text-gray-800 mb-2">Tambah Domba Baru</h1>
      <p class="text-gray-600">Isi formulir berikut untuk mendaftarkan domba baru ke dalam sistem.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
      <form action="{{ route('dashboard.sheep.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- RFID Input -->
          <div>
            <label for="rfid" class="block text-sm font-medium text-gray-700 mb-1">Tag RFID <span
                class="text-red-500">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
              </div>
              <input type="text" id="rfid" name="rfid"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('rfid') border-red-500 @enderror"
                placeholder="Masukkan nomor tag RFID" value="{{ old('rfid') }}" required>
              <button type="button" id="scan-rfid-btn"
                class="absolute inset-y-0 right-0 flex items-center cursor-pointer px-4 text-green-600 hover:text-green-800 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span class="ml-1">Scan</span>
              </button>
            </div>
            <p class="mt-1 text-xs text-gray-500">Nomor unik dari tag RFID yang terpasang pada domba.</p>
            @error('rfid')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- RFID Scanner Modal -->
          <div id="rfid-scanner-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
              <!-- Background overlay -->
              <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

              <!-- Modal panel -->
              <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                  <div class="sm:flex sm:items-start">
                    <div
                      class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                      </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                      <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Memindai Tag RFID
                      </h3>
                      <div class="mt-2">
                        <p class="text-sm text-gray-500">
                          Menunggu pembacaan tag RFID dari perangkat IoT...
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="mt-5 flex justify-center">
                    <div class="rounded-md bg-gray-100 p-6 w-full">
                      <div class="flex flex-col items-center">
                        <!-- Animated scanning circle -->
                        <div
                          class="w-32 h-32 rounded-full bg-green-50 border-4 border-green-200 flex items-center justify-center relative mb-4">
                          <!-- Pulsing animation -->
                          <div class="absolute w-full h-full rounded-full bg-green-400 opacity-30 animate-ping"></div>
                          <!-- RFID icon -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600 z-10" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                          </svg>
                        </div>

                        <div id="rfid-status" class="text-lg font-semibold text-center">
                          Siap memindai...
                        </div>

                        <!-- Simulate scan button -->
                        <button type="button" id="simulate-scan-btn"
                          class="mt-5 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                          Simulasi Pemindaian
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button type="button" id="close-scanner-btn"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Name Input -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Domba <span
                class="text-red-500">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <input type="text" id="name" name="name"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('name') border-red-500 @enderror"
                placeholder="Masukkan nama domba" value="{{ old('name') }}" required>
            </div>
            @error('name')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Gender Selection -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span
                class="text-red-500">*</span></label>
            <div class="flex space-x-4">
              <label for="gender_male"
                class="relative flex items-center p-3 rounded-lg border border-gray-300 bg-gray-50 cursor-pointer hover:bg-gray-100 transition-colors duration-200 @error('gender') border-red-500 @enderror">
                <input type="radio" id="gender_male" name="gender" value="male"
                  class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300"
                  {{ old('gender') == 'male' ? 'checked' : '' }} required>
                <span class="ml-2 text-gray-700">Jantan</span>
              </label>
              <label for="gender_female"
                class="relative flex items-center p-3 rounded-lg border border-gray-300 bg-gray-50 cursor-pointer hover:bg-gray-100 transition-colors duration-200 @error('gender') border-red-500 @enderror">
                <input type="radio" id="gender_female" name="gender" value="female"
                  class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300"
                  {{ old('gender') == 'female' ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Betina</span>
              </label>
            </div>
            @error('gender')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Birth Date -->
          <div>
            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span
                class="text-red-500">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <input type="date" id="birth_date" name="birth_date"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('birth_date') border-red-500 @enderror"
                value="{{ old('birth_date') }}" required>
            </div>
            @error('birth_date')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Breed (Jenis/Ras) -->
          <div>
            <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Jenis/Ras <span
                class="text-red-500">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
              <select id="breed" name="breed"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('breed') border-red-500 @enderror"
                required>
                <option value="" disabled {{ old('breed') ? '' : 'selected' }}>Pilih jenis domba</option>
                <option value="merino" {{ old('breed') == 'merino' ? 'selected' : '' }}>Merino</option>
                <option value="suffolk" {{ old('breed') == 'suffolk' ? 'selected' : '' }}>Suffolk</option>
                <option value="dorper" {{ old('breed') == 'dorper' ? 'selected' : '' }}>Dorper</option>
                <option value="texel" {{ old('breed') == 'texel' ? 'selected' : '' }}>Texel</option>
                <option value="garut" {{ old('breed') == 'garut' ? 'selected' : '' }}>Domba Garut</option>
                <option value="ekor_gemuk" {{ old('breed') == 'ekor_gemuk' ? 'selected' : '' }}>Domba Ekor Gemuk
                </option>
                <option value="batur" {{ old('breed') == 'batur' ? 'selected' : '' }}>Domba Batur</option>
                <option value="lainnya" {{ old('breed') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
              </select>
            </div>
            @error('breed')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Weight -->
          <div>
            <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Berat (kg) <span
                class="text-red-500">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
              </div>
              <input type="number" id="weight" name="weight" step="0.1" min="0"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('weight') border-red-500 @enderror"
                placeholder="Masukkan berat domba" value="{{ old('weight') }}" required>
            </div>
            @error('weight')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Health Status -->
          <div>
            <label for="health_status" class="block text-sm font-medium text-gray-700 mb-1">Status Kesehatan <span
                class="text-red-500">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </div>
              <select id="health_status" name="health_status"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('health_status') border-red-500 @enderror"
                required>
                <option value="" disabled {{ old('health_status') ? '' : 'selected' }}>Pilih status kesehatan
                </option>
                <option value="healthy" {{ old('health_status') == 'healthy' ? 'selected' : '' }}>Sehat</option>
                <option value="sick" {{ old('health_status') == 'sick' ? 'selected' : '' }}>Sakit</option>
                <option value="recovering" {{ old('health_status') == 'recovering' ? 'selected' : '' }}>Dalam Pemulihan
                </option>
                <option value="quarantined" {{ old('health_status') == 'quarantined' ? 'selected' : '' }}>Karantina
                </option>
              </select>
            </div>
            @error('health_status')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Pen Selection -->
          <div>
            <label for="pen_id" class="block text-sm font-medium text-gray-700 mb-1">Kandang</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
              <select id="pen_id" name="pen_id"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('pen_id') border-red-500 @enderror">
                <option value="">Pilih kandang (opsional)</option>
                @foreach (\App\Models\Pen::all() as $pen)
                  <option value="{{ $pen->id }}" {{ old('pen_id') == $pen->id ? 'selected' : '' }}>
                    {{ $pen->name }} - {{ $pen->location }}
                  </option>
                @endforeach
              </select>
            </div>
            @error('pen_id')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Parent Information - sire (father) -->
          <div>
            <label for="parent_sire" class="block text-sm font-medium text-gray-700 mb-1">ID Pejantan (Ayah)</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <input type="text" id="parent_sire" name="parent_sire"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('parent_sire') border-red-500 @enderror"
                placeholder="ID RFID pejantan (opsional)" value="{{ old('parent_sire') }}">
            </div>
            @error('parent_sire')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Parent Information - dam (mother) -->
          <div>
            <label for="parent_dam" class="block text-sm font-medium text-gray-700 mb-1">ID Induk (Ibu)</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <input type="text" id="parent_dam" name="parent_dam"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('parent_dam') border-red-500 @enderror"
                placeholder="ID RFID induk (opsional)" value="{{ old('parent_dam') }}">
            </div>
            @error('parent_dam')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Last Check Date -->
          <div>
            <label for="last_check_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pemeriksaan
              Terakhir</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <input type="date" id="last_check_date" name="last_check_date"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('last_check_date') border-red-500 @enderror"
                value="{{ old('last_check_date') }}">
            </div>
            @error('last_check_date')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Last Vaccination Date -->
          <div>
            <label for="last_vaccination_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Vaksinasi
              Terakhir</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <input type="date" id="last_vaccination_date" name="last_vaccination_date"
                class="pl-10 w-full h-11 rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('last_vaccination_date') border-red-500 @enderror"
                value="{{ old('last_vaccination_date') }}">
            </div>
            @error('last_vaccination_date')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Notes -->
        <div class="mt-6">
          <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
          <div class="relative">
            <textarea id="notes" name="notes" rows="3"
              class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 focus:bg-white transition-colors duration-200 @error('notes') border-red-500 @enderror"
              placeholder="Tambahkan catatan tambahan tentang domba ini (opsional)">{{ old('notes') }}</textarea>
          </div>
          @error('notes')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <!-- Photo Upload -->
        <div class="mt-6">
          <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Domba</label>
          <div class="flex flex-col items-center">
            <div id="image-preview"
              class="hidden mb-4 w-48 h-48 bg-gray-100 rounded-lg border-2 border-gray-300 flex items-center justify-center overflow-hidden">
              <img id="preview-image" class="object-cover w-full h-full" src="#" alt="Preview">
            </div>
            <label
              class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200 cursor-pointer group">
              <div class="space-y-2 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-gray-500 transition-colors duration-200"
                  stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                  <path
                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex flex-col items-center text-sm text-gray-600">
                  <span class="font-medium text-green-600 group-hover:text-green-500 transition-colors duration-200">Klik
                    untuk unggah foto</span>
                  <span class="text-gray-500">atau seret dan lepas</span>
                </div>
                <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                <p class="text-xs text-gray-500">Format yang diterima: JPG, PNG, GIF. Ukuran maksimum: 2MB.</p>
              </div>
            </label>
            <button type="button" id="remove-image" class="mt-2 text-sm text-red-500 hidden hover:text-red-700">
              Hapus Gambar
            </button>
          </div>
          @error('photo')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end space-x-3">
          <a href="{{ route('dashboard.sheep.index') }}"
            class="px-5 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
            Batal
          </a>
          <button type="submit"
            class="px-5 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
            Simpan Data Domba
          </button>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const photoInput = document.getElementById('photo');
        const imagePreview = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');
        const removeButton = document.getElementById('remove-image');

        photoInput.addEventListener('change', function(e) {
          if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
              previewImage.src = e.target.result;
              imagePreview.classList.remove('hidden');
              removeButton.classList.remove('hidden');
            }

            reader.readAsDataURL(this.files[0]);
          }
        });

        removeButton.addEventListener('click', function() {
          photoInput.value = '';
          imagePreview.classList.add('hidden');
          removeButton.classList.add('hidden');
          previewImage.src = '#';
        });

        // RFID Scanner Modal functionality
        const scanRfidBtn = document.getElementById('scan-rfid-btn');
        const rfidModal = document.getElementById('rfid-scanner-modal');
        const closeModalBtn = document.getElementById('close-scanner-btn');
        const simulateScanBtn = document.getElementById('simulate-scan-btn');
        const rfidStatus = document.getElementById('rfid-status');
        const rfidInput = document.getElementById('rfid');

        // Open modal
        scanRfidBtn.addEventListener('click', function() {
          rfidModal.classList.remove('hidden');
          rfidStatus.textContent = 'Siap memindai...';
        });

        // Close modal
        closeModalBtn.addEventListener('click', function() {
          rfidModal.classList.add('hidden');
        });

        // Simulate RFID scan
        simulateScanBtn.addEventListener('click', function() {
          // Disable button during "scanning"
          simulateScanBtn.disabled = true;
          simulateScanBtn.classList.add('bg-gray-400');
          simulateScanBtn.classList.remove('bg-green-600', 'hover:bg-green-700');

          // Update status
          rfidStatus.textContent = 'Memindai...';

          // Simulate processing time
          setTimeout(function() {
            // Generate a random RFID number
            const randomRFID = 'RFID' + Math.floor(1000000 + Math.random() * 9000000);

            // Update status with scanned RFID
            rfidStatus.textContent = 'ID Terdeteksi: ' + randomRFID;
            rfidStatus.classList.add('text-green-600');

            // Populate the RFID input field
            rfidInput.value = randomRFID;

            // Close modal after a short delay
            setTimeout(function() {
              rfidModal.classList.add('hidden');

              // Reset button and status for next use
              simulateScanBtn.disabled = false;
              simulateScanBtn.classList.remove('bg-gray-400');
              simulateScanBtn.classList.add('bg-green-600', 'hover:bg-green-700');
              rfidStatus.classList.remove('text-green-600');
            }, 1500);
          }, 2000);
        });

        // Close modal if clicking outside
        window.addEventListener('click', function(event) {
          if (event.target === rfidModal) {
            rfidModal.classList.add('hidden');
          }
        });
      });
    </script>
  @endpush
@endsection
