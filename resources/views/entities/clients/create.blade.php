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
                                minlength="2" maxlength="255"
                                name="name" id="nameInput" required
                                value="{{old('name')}}"
                            />
                            <x-input-error
                                :messages="$errors->get('name')"
                            />
                        </div>
                        <div>
                            <x-input-label for="identificationInput">
                                RUC
                            </x-input-label>
                            <x-text-input
                                minlength="13" maxlength="13"
                                name="identification" id="identificationInput" required
                                value="{{old('identification')}}"
                            />
                            <x-input-error
                                :messages="$errors->get('identification')"
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
