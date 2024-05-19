<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a
                        href="{{route('clients.index')}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Volver
                    </a>

                    <ul class="list-disk ml-6 mb-6">
                        <li>
                            <strong>Nombre:</strong> <br>
                            {{$client->name}}
                        </li>
                        <li>
                            <strong>Cedula:</strong> <br>
                            {{$client->identification}}
                        </li>
                        <li>
                            <strong>Usuario:</strong> <br>
                            {{$client->user->name}}
                        </li>
                    </ul>

                    <a
                        href="{{route('clients.edit', $client->id)}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Editar Cliente
                    </a>

                    <form action="{{route('clients.destroy', $client->id)}}" method="post">
                        @method('delete')
                        @csrf
                        <x-danger-button type="submit">
                            Eliminar Cliente
                        </x-danger-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>