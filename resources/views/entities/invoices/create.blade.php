<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Factura
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{route('invoices.store')}}" method="post" class="space-y-4">
                        @csrf

                        <p>
                            <strong>Fecha de emision</strong> <br>
                            {{date('d/m/Y')}}
                        </p>

                        <div>
                            <x-input-label for="clientInput">
                                Cliente
                            </x-input-label>
                            <select name="client" id="clientInput" class="rounded">
                                <option value="">
                                    Consumidor Final
                                </option>
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">
                                        {{$client->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="productInput">
                                Productos
                            </x-input-label>
                            <livewire:entities.invoices.create.products-input
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