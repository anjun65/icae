<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <main class="flex-1 relative z-0 overflow-y-auto pt-2 pb-6 focus:outline-none md:py-6" tabindex="0" x-data="" x-init="$el.focus()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            @livewire('admin.users')
        </div>
    </main>

</x-app-layout>
