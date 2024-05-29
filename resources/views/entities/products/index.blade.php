<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Productos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <x-secondary-link-button
                        class="mb-4"
                        href="{{route('products.create')}}"
                    >
                        Crear nuevo producto
                    </x-secondary-link-button>

                    <form action="{{request()->url()}}">
                        <x-text-input
                            name="search"
                            minlength="2" maxlength="255"
                            value="{{request()->query()['search'] ?? null}}"
                        />
                        <x-primary-button>
                            Buscar
                        </x-primary-button>
                        <x-input-error
                            :messages="$errors->get('search')"
                        />
                    </form>

                    <x-table>
                        <x-slot:head>
                            <tr>
                                <x-table.th>
                                    Descripción
                                </x-table.th>
                            </tr>
                        </x-slot:head>
                        <x-slot:body>
                            @forelse($products as $product)
                                <x-table.tr>
                                    <x-table.td>
                                        <a href="{{route('products.show', $product->id)}}">
                                            {{$product->name}}
                                        </a>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.tr>
                                    <x-table.td>
                                        <span class="text-red-500">
                                            No se encontraron productos...
                                        </span>
                                    </x-table.td>
                                </x-table.tr>
                            @endforelse
                        </x-slot:body>
                    </x-table>
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
