@props(['icon', 'label'])

<button
  class="flex flex-col items-center justify-center p-4 rounded-lg bg-primary/5 hover:bg-primary/10 transition-colors duration-300">
  {{ $icon }}
  <span class="mt-2 text-sm font-medium text-gray-700">{{ $label }}</span>
</button>