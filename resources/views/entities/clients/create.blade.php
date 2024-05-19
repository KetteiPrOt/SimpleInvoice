<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{route('clients.store')}}" method="post" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="nameInput">
                                Nombre
                            </x-input-label>
                            <x-text-input
                                name="name" id="nameInput" required
                            />
                        </div>
                        <div>
                            <x-input-label for="identificationInput">
                                Cedula
                            </x-input-label>
                            <x-text-input
                                minlength="13" maxlength="13"
                                name="identification" id="identificationInput" required
                            />
                        </div>
                        <div>
                            <x-primary-button>
                                Guardar
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
