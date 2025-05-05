@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
  <!-- Stats Overview -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-dashboard.stats-card title="Total Sessions" value="24,500" trend="+12% from last month" />
    <x-dashboard.stats-card title="Bounce Rate" value="42.3%" trend="-8% from last month" trendColor="red" />
    <x-dashboard.stats-card title="Avg. Session Duration" value="3m 42s" trend="+15% from last month" />
    <x-dashboard.stats-card title="Page Views" value="89,500" trend="+5% from last month" />
  </div>

  <!-- Bento Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Traffic Sources -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300 md:col-span-2">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Traffic Sources</h3>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
              <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
              </svg>
            </div>
            <span class="ml-3 text-sm font-medium text-gray-900">Organic Search</span>
          </div>
          <div class="text-right">
            <p class="text-sm font-medium text-gray-900">12,500</p>
            <p class="text-xs text-gray-500">51% of total</p>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
              <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <span class="ml-3 text-sm font-medium text-gray-900">Social Media</span>
          </div>
          <div class="text-right">
            <p class="text-sm font-medium text-gray-900">6,800</p>
            <p class="text-xs text-gray-500">28% of total</p>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
              <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <span class="ml-3 text-sm font-medium text-gray-900">Email</span>
          </div>
          <div class="text-right">
            <p class="text-sm font-medium text-gray-900">3,200</p>
            <p class="text-xs text-gray-500">13% of total</p>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
              <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </div>
            <span class="ml-3 text-sm font-medium text-gray-900">Direct</span>
          </div>
          <div class="text-right">
            <p class="text-sm font-medium text-gray-900">2,000</p>
            <p class="text-xs text-gray-500">8% of total</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Top Pages -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Pages</h3>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-gray-900">Homepage</span>
          <span class="text-sm text-gray-500">8,500 views</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-gray-900">Products</span>
          <span class="text-sm text-gray-500">6,200 views</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-gray-900">Blog</span>
          <span class="text-sm text-gray-500">4,800 views</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-gray-900">About Us</span>
          <span class="text-sm text-gray-500">3,100 views</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-gray-900">Contact</span>
          <span class="text-sm text-gray-500">1,900 views</span>
        </div>
      </div>
    </div>

    <!-- Device Distribution -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Device Distribution</h3>
      <div class="space-y-4">
        <div>
          <div class="flex justify-between mb-1">
            <span class="text-sm font-medium text-gray-900">Mobile</span>
            <span class="text-sm text-gray-500">65%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-primary h-2 rounded-full" style="width: 65%"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between mb-1">
            <span class="text-sm font-medium text-gray-900">Desktop</span>
            <span class="text-sm text-gray-500">25%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-primary h-2 rounded-full" style="width: 25%"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between mb-1">
            <span class="text-sm font-medium text-gray-900">Tablet</span>
            <span class="text-sm text-gray-500">10%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-primary h-2 rounded-full" style="width: 10%"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300 md:col-span-2">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-dashboard.quick-action>
          <x-slot name="icon">
            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </x-slot>
          <x-slot name="label">Reports</x-slot>
        </x-dashboard.quick-action>
        <x-dashboard.quick-action>
          <x-slot name="icon">
            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
          </x-slot>
          <x-slot name="label">Export</x-slot>
        </x-dashboard.quick-action>
        <x-dashboard.quick-action>
          <x-slot name="icon">
            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
          </x-slot>
          <x-slot name="label">Settings</x-slot>
        </x-dashboard.quick-action>
        <x-dashboard.quick-action>
          <x-slot name="icon">
            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </x-slot>
          <x-slot name="label">Schedule</x-slot>
        </x-dashboard.quick-action>
      </div>
    </div>
  </div>
@endsection
