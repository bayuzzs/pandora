@props(['title', 'value', 'trend', 'trendColor' => 'green'])

<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
  <h3 class="text-gray-500 text-sm font-medium">{{ $title }}</h3>
  <p class="text-2xl font-bold text-primary mt-2">{{ $value }}</p>
  <p class="text-{{ $trendColor }}-500 text-sm mt-2">{{ $trend }}</p>
</div>