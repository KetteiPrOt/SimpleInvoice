<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Informacion de facturacion
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{route('users.update-invoicing-data')}}" method="post" enctype="multipart/form-data" class="space-y-4">
                        @method('put')
                        @csrf

                        <div>
                            <x-input-label for="identificationInput">
                                Cedula
                            </x-input-label>
                            <x-text-input
                                minlength="13" maxlength="13"
                                name="identification" id="identificationInput" required
                                value="{{old('identification', $user->identification)}}"
                            />
                        </div>
                        <div>
                            <x-input-label for="commercialNameInput">
                                Nombre Comercial
                            </x-input-label>
                            <x-text-input
                                maxlength="255"
                                name="commercial_name" id="commercialNameInput" required
                                value="{{old('commercial_name', $user->commercial_name)}}"
                            />
                        </div>
                        <div>
                            <x-input-label for="addressInput">
                                Direccion
                            </x-input-label>
                            <x-text-input
                                maxlength="255"
                                name="address" id="addressInput" required
                                value="{{old('address', $user->address)}}"
                            />
                        </div>
                        <div>
                            <x-input-label for="certificateInput">
                                Certificado de firma digital
                            </x-input-label>
                            <input
                                type="file"
                                name="certificate" id="certificateInput"
                                @required(is_null($user->certificate))
                            >
                            @if(is_null($user->certificate))
                                <span class="block text-red-400">
                                    Requerido (ningun certificado guardado)
                                </span>
                            @else
                                <span class="block text-green-400">
                                    No requerido (certificado guardado)
                                </span>
                            @endif
                        </div>
                        <div>
                            <x-input-label for="certificatePasswordInput">
                                Contraseña del certificado
                            </x-input-label>
                            <x-text-input
                                type="password"
                                maxlength="255"
                                name="certificate_password" id="certificatePasswordInput" required
                                value="{{old('certificate_password', $user->certificate_password)}}"
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