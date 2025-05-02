@props(['icon', 'title', 'time'])

<div class="flex items-start">
  <div class="flex-shrink-0">
    <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center">
      {{ $icon }}
    </div>
  </div>
  <div class="ml-3">
    <p class="text-sm font-medium text-gray-900">{{ $title }}</p>
    <p class="text-sm text-gray-500">{{ $time }}</p>
  </div>
</div>