<a href="{{ $href }}"
   class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ $active ? 'bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 border-r-4 border-indigo-600' : '' }}">
    {{ $slot }}
</a>