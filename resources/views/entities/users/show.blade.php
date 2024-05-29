<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="font-bold text-lg">
                        Nombre
                    </h3>
                    <p class="mb-4">
                        {{$user->name}}
                    </p>

                    <h3 class="font-bold text-lg">
                        Email
                    </h3>
                    <p class="mb-4">
                        {{$user->email}}
                    </p>

                    @if(!$user->hasRole('Administrador'))
                        <x-secondary-link-button
                            href="{{route('users.edit', $user->id)}}"
                            class="mr-1"
                        >
                            Editar Usuario
                        </x-secondary-link-button>

                        <form action="{{route('users.destroy', $user->id)}}" method="post" class="inline">
                            @method('delete')
                            @csrf
                            <x-danger-button type="submit" class="ml-1">
                                Eliminar Usuario
                            </x-danger-button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>