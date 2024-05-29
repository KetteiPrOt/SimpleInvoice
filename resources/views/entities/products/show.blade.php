<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver Producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="font-bold text-lg">
                        Descripción
                    </h3>
                    <p class="mb-4">
                        {{$product->name}}
                    </p>

                    <h3 class="font-bold text-lg">
                        Precio
                    </h3>
                    <p class="mb-4">
                        ${{$product->price}}
                    </p>

                    <h3 class="font-bold text-lg">
                        Usuario
                    </h3>
                    <p class="mb-4">
                        {{$product->user->name}}
                    </p>

                    <x-secondary-link-button
                        class="mr-4"
                        href="{{route('products.edit', $product->id)}}"
                    >
                        Editar Producto
                    </x-secondary-link-button>

                    <form action="{{route('products.destroy', $product->id)}}" method="post" class="inline">
                        @method('delete')
                        @csrf
                        <x-danger-button type="submit">
                            Eliminar Producto
                        </x-danger-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>