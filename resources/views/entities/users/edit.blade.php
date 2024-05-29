<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{route('users.update', $user->id)}}" method="post" class="space-y-4">
                        @method('put')
                        @csrf

                        <div>
                            <x-input-label for="adminPasswordInput">
                                Contraseña (del administrador)
                            </x-input-label>
                            <x-text-input
                                type="password"
                                minlength="8" maxlength="255"
                                name="admin_password" id="adminPasswordInput" required
                                value="{{old('admin_password')}}"
                            />
                            <x-input-error
                                :messages="$errors->get('admin_password')"
                            />
                        </div>
                        <div>
                            <x-input-label for="nameInput">
                                Nombre
                            </x-input-label>
                            <x-text-input
                                minlength="2" maxlength="255"
                                name="name" id="nameInput" required
                                value="{{old('name', $user->name)}}"
                            />
                            <x-input-error
                                :messages="$errors->get('name')"
                            />
                        </div>
                        <div>
                            <x-input-label for="emailInput">
                                Email
                            </x-input-label>
                            <x-text-input
                                type="email"
                                minlength="3" maxlength="255"
                                name="email" id="emailInput" required
                                value="{{old('email', $user->email)}}"
                            />
                            <x-input-error
                                :messages="$errors->get('email')"
                            />
                        </div>
                        <div>
                            <x-input-label for="passwordInput">
                                Contraseña
                            </x-input-label>
                            <x-text-input
                                type="password"
                                minlength="8" maxlength="255"
                                name="password" id="passwordInput" required
                                value="{{old('password')}}"
                            />
                            <x-input-error
                                :messages="$errors->get('password')"
                            />
                        </div>
                        <div>
                            <x-input-label for="passwordConfirmationInput">
                                Confirmar contraseña
                            </x-input-label>
                            <x-text-input
                                type="password"
                                minlength="8" maxlength="255"
                                name="password_confirmation" id="passwordConfirmationInput" required
                                value="{{old('password_confirmation')}}"
                            />
                            <x-input-error
                                :messages="$errors->get('password_confirmation')"
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