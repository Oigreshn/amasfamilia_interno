<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestor de Eventos/Reuniones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:calendario/>
                </div>
            </div>
        
    </div>
</x-app-layout>