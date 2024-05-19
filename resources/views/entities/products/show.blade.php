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
                    
                    <a
                        href="{{route('products.index')}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Volver
                    </a>

                    <ul class="list-disk ml-6 mb-6">
                        <li>
                            <strong>Nombre:</strong> <br>
                            {{$product->name}}
                        </li>
                        <li>
                            <strong>Precio:</strong> <br>
                            ${{$product->price}}
                        </li>
                        <li>
                            <strong>Usuario:</strong> <br>
                            {{$product->user->name}}
                        </li>
                    </ul>

                    <a
                        href="{{route('products.edit', $product->id)}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Editar Producto
                    </a>

                    <form action="{{route('products.destroy', $product->id)}}" method="post">
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