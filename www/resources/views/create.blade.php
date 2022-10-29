<x-app-layout>
    <x-slot name="title">
        {{ __('New Survey') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Survey') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Request::get('draft_id'))
                <livewire:builder/>
            @else
                <livewire:create/>
            @endif
        </div>
    </div>
</x-app-layout>
