<div>
    <style>
        table {
            border-collapse: collapse;
        }

        th {
            border: 1px solid black;
            padding: 5px;
        }

        td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($selectedProducts as $selectedProduct)
                <tr>
                    <td>
                        <input hidden name="selected_products[]" value="{{$selectedProduct->id}}">
                        {{$selectedProduct->id}}
                    </td>
                    <td>
                        {{$selectedProduct->name}}
                    </td>
                    <td>
                        <input
                            name="amounts[]"
                            type="number"
                            min="1" max="99" step="1" required
                        >
                    </td>
                    <td>
                        ${{$selectedProduct->price}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td>...</td><td>...</td><td>...</td><td>...</td>
                </tr>
            @endforelse
            <tr>
                <td></td><td></td><td>Total sin impuestos:</td><td>...</td>
            </tr>
            <tr>
                <td></td><td></td><td>Tarifa:</td><td>15%</td>
            </tr>
            <tr>
                <td></td><td></td><td>Base imponible:</td><td>...</td>
            </tr>
            <tr>
                <td></td><td></td><td>Valor:</td><td>...</td>
            </tr>
            <tr>
                <td></td><td></td><td>Importe total:</td><td>...</td>
            </tr>
        </tbody>
    </table>

    <h3
        class="font-bold"
    >Seleccionar productos</h3>

    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aviableProducts as $aviableProduct)
                <tr>
                    <td>{{$aviableProduct->id}}</td>
                    <td>
                        {{$aviableProduct->name}}
                    </td>
                    <td>
                        <div class="flex justify">
                            <button
                                class="border rounded py-1 px-3"
                                wire:click.prevent="pushProduct({{$aviableProduct->id}})"
                            >Agregar</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="max-w-sm">
        {{$aviableProducts->links(data: ['scrollTo' => false])}}
    </div>
</div>
