<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver Factura
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a
                        href="{{route('invoices.index')}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Volver
                    </a>

                    <ul class="list-disk ml-6 mb-6">
                        <li>
                            <strong>Fecha y hora:</strong> <br>
                            {{date('d/m/Y H:i:s', strtotime($invoice->created_at))}}
                        </li>
                        <li>
                            <strong>Numero de factura:</strong> <br>
                            {{$invoice->sequential}}
                        </li>
                        <li>
                            <strong>Clave de acceso:</strong> <br>
                            {{$invoice->access_key}}
                        </li>
                        <li>
                            <strong>Autorizacion:</strong> <br>
                            <span
                                class="{{$invoice->authorized ? 'text-green-400' : 'text-red-400'}}"
                            >
                                {{$invoice->status_details}}
                            </span>
                        </li>
                    </ul>

                    <a
                        href="{{route('invoices.show-document', $invoice->id)}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Ver documento
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
