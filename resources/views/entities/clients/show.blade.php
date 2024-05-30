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

                    <h3 class="font-bold text-lg">
                        Razón Social
                    </h3>
                    <p class="mb-4">
                        {{$client->name}}
                    </p>

                    <h3 class="font-bold text-lg">
                        RUC
                    </h3>
                    <p class="mb-4">
                        {{$client->identification}}
                    </p>

                    <h3 class="font-bold text-lg">
                        Email
                    </h3>
                    <p class="mb-4">
                        {{$client->email}}
                    </p>

                    <h3 class="font-bold text-lg">
                        Usuario
                    </h3>
                    <p class="mb-4">
                        {{$client->user->name}}
                    </p>

                    <x-secondary-link-button
                        href="{{route('clients.edit', $client->id)}}"
                        class="mr-1"
                    >
                        Editar Cliente
                    </x-secondary-link-button>

                    <form action="{{route('clients.destroy', $client->id)}}" method="post" class="inline">
                        @method('delete')
                        @csrf
                        <x-danger-button type="submit" class="ml-1">
                            Eliminar Cliente
                        </x-danger-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>