<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Facturas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a
                        href="{{route('invoices.create')}}"
                        class="inline-block text-blue-400 underline mb-6"
                    >
                        Crear nueva Factura
                    </a>

                    <ul class="ml-6">
                        @foreach($invoices as $invoice)
                            <li>
                                {{date('d/m/Y H:i:s', strtotime($invoice->created_at))}}
                                ==>
                                <a href="{{route('invoices.show', $invoice->id)}}" class="text-blue-400 underline">
                                    {{$invoice->sequential}}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
