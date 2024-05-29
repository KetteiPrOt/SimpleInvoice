<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{route('products.store')}}" method="post" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="nameInput">
                                Descripción
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
                            <x-input-label for="priceInput">
                                Precio
                            </x-input-label>
                            <x-text-input
                                type="number" min="0.01" max="999999.99" step="0.01"
                                name="price" id="priceInput" required
                                value="{{old('price')}}"
                            />
                            <x-input-error
                                :messages="$errors->get('price')"
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