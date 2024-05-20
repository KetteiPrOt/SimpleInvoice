
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver Informacion de facturacion
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <ul class="list-disk ml-6 mb-6">
                        <li>
                            <strong>Cedula:</strong> <br>
                            {{$user->identification ?? 'No registrada.'}}
                        </li>
                        <li>
                            <strong>Nombre comercial:</strong> <br>
                            {{$user->commercial_name ?? 'No registrado.'}}
                        </li>
                        <li>
                            <strong>Direccion:</strong> <br>
                            {{$user->address ?? 'No registrada.'}}
                        </li>
                        <li>
                            <strong>Certificado de firma digital:</strong> <br>
                            @if(is_null($user->certificate))
                                <span class="text-red-400">
                                    No guardado.
                                </span>
                            @else
                                <span class="text-green-400">
                                    Guardado.
                                </span>
                            @endif
                        </li>
                        <li>
                            <strong>Contraseña del certificado:</strong> <br>
                            {{$user->certificate_password ?? 'No guardada.'}}
                        </li>
                    </ul>

                    <a
                        href="{{route('users.edit-invoicing-data')}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Editar Datos
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>