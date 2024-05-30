<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads;

    public string $identification = '';
    public string $commercial_name = '';
    public string $address = '';
    public $certificate = '';
    public string $certificate_password = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->identification = $user->identification ?? '';
        $this->commercial_name = $user->commercial_name ?? '';
        $this->address = $user->address ?? '';
        $this->certificate = '';
        $this->certificate_password = $user->certificate_password ?? '';
    }

    /**
     * Update the invoicing information for the currently authenticated user.
     */
    public function updateInvoicingInformation(): void
    {
        $user = Auth::user();
        $certificateRequeriment = is_null($user->certificate) ? 'required|' : '';

        $validated = $this->validate([
            'identification' => ['required', 'string', 'size:13', 'regex:/^[0987654321]{13}$/'],
            'commercial_name' => 'required|string|min:2|max:255',
            'address' => 'required|string|min:2|max:255',
            'certificate' => $certificateRequeriment . 'file|max:12288',
            'certificate_password' => ['required', 'string', 'max:255', Rules\Password::defaults()]
        ]);

        if(array_key_exists('certificate', $validated)){
            $this->certificate->storeAs('/', "uploaded-certificate-$user->id.p12");
            $certificate = Storage::get("uploaded-certificate-$user->id.p12");
            $user->update([
                'certificate' => $certificate
            ]);
            Storage::delete("uploaded-certificate-$user->id.p12");
        }

        if(array_key_exists('certificate_password', $validated)){
            $user->update([
                'certificate_password' => $validated['certificate_password']
            ]);
        }

        $user->update([
            'identification' => $validated['identification'],
            'commercial_name' => $validated['commercial_name'],
            'address' => $validated['address'],
        ]);

        $this->dispatch('invoicing-information-updated');
    }
}; ?>

<section>
    <header>
        <a name="update-invoicing-information">
            <h2 class="text-lg font-medium text-gray-900">
                Informacion Tributaria
            </h2>
        </a>

        <p class="mt-1 text-sm text-gray-600">
            Actualize su información de facturación.
        </p>
    </header>

    <form wire:submit="updateInvoicingInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="identificationInput" :value="'RUC'" />
            <x-text-input
                wire:model="identification"
                minlength="13" maxlength="13" required
                id="identificationInput" name="identification" type="text"
                class="mt-1 block w-full"
            />
            <x-input-error class="mt-2" :messages="$errors->get('identification')" />
        </div>

        <div>
            <x-input-label for="commercialNameInput" :value="'Nombre Comercial'" />
            <x-text-input
                wire:model="commercial_name"
                minlength="2" maxlength="255" required
                id="commercialNameInput" name="commercial_name" type="text"
                class="mt-1 block w-full"
            />
            <x-input-error class="mt-2" :messages="$errors->get('commercial_name')" />
        </div>

        <div>
            <x-input-label for="addressInput" :value="'Dirección'" />
            <x-text-input
                wire:model="address"
                minlength="2" maxlength="255" required
                id="addressInput" name="address" type="text"
                class="mt-1 block w-full"
            />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="certificateInput" :value="'Certificado de firma digital'" />
            <x-text-input
                :required="is_null(auth()->user()->certificate)"
                wire:model="certificate"
                id="certificateInput" name="certificate" type="file"
                class="mt-1 block w-full"
            />
            <x-input-error class="mt-2" :messages="$errors->get('certificate')" />
            @if(is_null(auth()->user()->certificate))
                <p class="text-red-500">
                    Sin certificado guardado.
                </p>
            @else
                <p class="text-green-500">
                    Certificado guardado
                </p>
            @endif
        </div>

        <div>
            <x-input-label for="certificatePasswordInput" :value="'Contraseña del certificado'" />
            <x-text-input
                wire:model="certificate_password"
                id="certificatePasswordInput" name="certificate_password" type="password"
                minlength="8" maxlength="255" required
                class="mt-1 block w-full"
            />
            <x-input-error class="mt-2" :messages="$errors->get('certificate_password')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="invoicing-information-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
