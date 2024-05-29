<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'admin_password' => ['required', 'string', 'current_password'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
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
