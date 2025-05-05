@extends('layouts.app')

@section('title', 'Users')

@section('content')
  <!-- Stats Overview -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-dashboard.stats-card title="Total Users" value="1,234" trend="+12% from last month" />
    <x-dashboard.stats-card title="Active Users" value="856" trend="+8% from last month" />
    <x-dashboard.stats-card title="New Users" value="124" trend="+15% from last month" />
    <x-dashboard.stats-card title="Avg. Session" value="4m 32s" trend="+5% from last month" />
  </div>

  <!-- Bento Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300 md:col-span-2">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Recent Users</h3>
        <button class="text-sm text-primary hover:text-primary/80">View All</button>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="text-primary font-medium">JD</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">John Doe</div>
                    <div class="text-sm text-gray-500">john@example.com</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Active
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 days ago</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="text-primary font-medium">AS</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">Alice Smith</div>
                    <div class="text-sm text-gray-500">alice@example.com</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                  Pending
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">User</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 day ago</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="text-primary font-medium">BJ</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">Bob Johnson</div>
                    <div class="text-sm text-gray-500">bob@example.com</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                  Inactive
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">User</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3 days ago</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- User Activity -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">User Activity</h3>
      <div class="space-y-4">
        <x-dashboard.activity-item>
          <x-slot name="icon">
            <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </x-slot>
          <x-slot name="title">New user registration</x-slot>
          <x-slot name="time">2 minutes ago</x-slot>
        </x-dashboard.activity-item>
        <x-dashboard.activity-item>
          <x-slot name="icon">
            <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </x-slot>
          <x-slot name="title">Profile update</x-slot>
          <x-slot name="time">15 minutes ago</x-slot>
        </x-dashboard.activity-item>
        <x-dashboard.activity-item>
          <x-slot name="icon">
            <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </x-slot>
          <x-slot name="title">Password change</x-slot>
          <x-slot name="time">1 hour ago</x-slot>
        </x-dashboard.activity-item>
      </div>
    </div>

    <!-- User Roles -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">User Roles</h3>
      <div class="space-y-4">
        <div>
          <div class="flex justify-between mb-1">
            <span class="text-sm font-medium text-gray-900">Admin</span>
            <span class="text-sm text-gray-500">15%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-primary h-2 rounded-full" style="width: 15%"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between mb-1">
            <span class="text-sm font-medium text-gray-900">Editor</span>
            <span class="text-sm text-gray-500">25%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-primary h-2 rounded-full" style="width: 25%"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between mb-1">
            <span class="text-sm font-medium text-gray-900">User</span>
            <span class="text-sm text-gray-500">60%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-primary h-2 rounded-full" style="width: 60%"></div>
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
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
          </x-slot>
          <x-slot name="label">Add User</x-slot>
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
