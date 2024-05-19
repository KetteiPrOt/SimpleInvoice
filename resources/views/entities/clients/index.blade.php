<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a
                        href="{{route('clients.create')}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Crear nuevo cliente
                    </a>

                    <ol class="list-decimal ml-6">
                        @foreach($clients as $client)
                            <li>
                                <a href="{{route('clients.show', $client->id)}}">
                                    {{$client->name}}
                                </a>
                            </li>
                        @endforeach
                    </ol>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>