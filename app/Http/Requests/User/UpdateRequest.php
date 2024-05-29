<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! $this->route('user')->hasRole('Administrador');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'admin_password' => ['required', 'string', 'current_password'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['required', 'string', 'confirmed', 'max:255', Rules\Password::defaults()],
        ];
    }

    public function attributes(): array
    {
        return [
            'admin_password' => 'contraseña del administrador',
            'name' => 'nombre',
            'email' => 'email',
            'password' => 'contraseña'
        ];
    }
}
