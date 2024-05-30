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

                    <x-secondary-link-button
                        class="mb-4"
                        href="{{route('invoices.create')}}"
                    >
                        Emitir una nueva factura
                    </x-secondary-link-button>

                    <x-table>
                        <x-slot:head>
                            <tr>
                                <x-table.th>
                                    Número de factura
                                </x-table.th>
                            </tr>
                        </x-slot:head>
                        <x-slot:body>
                            @forelse($invoices as $invoice)
                                <x-table.tr>
                                    <x-table.td>
                                        <a href="{{route('invoices.show', $invoice->id)}}">
                                            {{$invoice->sequential}}
                                        </a>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.tr>
                                    <x-table.td>
                                        <span class="text-red-500">
                                            No se encontraron facturas...
                                        </span>
                                    </x-table.td>
                                </x-table.tr>
                            @endforelse
                        </x-slot:body>
                    </x-table>
                    {{$invoices->links()}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
