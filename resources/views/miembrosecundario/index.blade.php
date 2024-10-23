<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestor de Miembros Secundarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto overflow-hidden bg-white shadow-sm p-6 divide-y divide-gray-200">
            <div class="p-6 text-gray-900">
                <livewire:miembro-secundario-datagrid/>
            </div>
        </div>
    </div>
</x-app-layout>

