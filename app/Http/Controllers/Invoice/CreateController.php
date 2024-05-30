<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SoapClient;

class CreateController extends Controller
{
    private function invoicingInformationExist(): bool
    {
        $user = Auth::user();
        return 
            !is_null($user->identification)
            && !is_null($user->commercial_name)
            && !is_null($user->address)
            && !is_null($user->certificate)
            && !is_null($user->certificate_password);
    }

    public function __invoke()
    {
        if(!$this->invoicingInformationExist()){
            return redirect(route('profile') . '#update-invoicing-information');
        }
        return view('entities.invoices.create', [
            'clients' => Client::all()
        ]);
    }

    public function store(Request $request, Signer $signer)
    {
        if(!$this->invoicingInformationExist()){
            return redirect(route('profile') . '#update-invoicing-information');
        }

        $invoice = $this->buildInvoice([
            'client' => Client::find($request->get('client')),
            'selected_products' => $request->get('selected_products'),
            'amounts' => $request->get('amounts')
        ]);

        Storage::disk('local')->put('invoice.xml', $invoice['content']);

        $signed_invoice = $signer->sign();

        try{
            $response = $this->sendInvoice($signed_invoice);
        }catch(Exception $e){
            $response = null;
        }

        $status =
            $response?->RespuestaRecepcionComprobante?->estado
            == 'RECIBIDA'
            ? 'Enviada'
            : 'Envio Fallido';

        Invoice::create([
            'authorized' => false,
            'status_details' => $status,
            'access_key' => $invoice['access_key'],
            'content' => $signed_invoice,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('invoices.create');
    }

    private function sendInvoice(string $invoice)
    {
        $client = new SoapClient('https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl');
        $response = $client->validarComprobante(['xml' => $invoice]);
        return $response;
    }

    private function buildInvoice(array $data): array
    {
        $invoice = Storage::get('invoice_template.xml');
        $user = Auth::user();
        $sequential = $this->getSequential();
        $invoice = str_replace('{{user_name}}', $user->name, $invoice);
        $invoice = str_replace('{{user_commercial_name}}', $user->commercial_name, $invoice);
        $invoice = str_replace('{{user_identification}}', $user->identification, $invoice);
        $invoice = str_replace('{{sequential}}', $sequential, $invoice);
        $invoice = str_replace('{{user_address}}', $user->address, $invoice);
        $invoice = str_replace('{{date}}', date('d/m/Y'), $invoice);
        $invoice = str_replace('{{client_name}}', $data['client']?->name ?? 'Consumidor Final', $invoice);
        $invoice = str_replace('{{client_identification}}', $data['client']?->identification ?? '0000000000001', $invoice);

        $access_key = $this->getAccessKey([
            'sequential' => $sequential,
            'user_identification' => $user->identification
        ]);

        $details = $this->buildDetails([
            'selected_products' => $data['selected_products'],
            'amounts' => $data['amounts']
        ]);

        $invoice = str_replace('{{access_key}}', $access_key, $invoice);
        $invoice = str_replace('{{details}}', $details['xml'], $invoice);
        $invoice = str_replace('{{total_without_taxation}}', $details['total_without_taxation'], $invoice);
        $invoice = str_replace('{{tax_value}}', $details['tax_value'], $invoice);
        $invoice = str_replace('{{total}}', $details['total'], $invoice);

        return [
            'content' => $invoice,
            'access_key' => $access_key
        ];
    }

    private function getSequential(): string
    {
        $sequential = Invoice::orderBy('id', 'desc')->first()?->id ?? 1;

        $sequential = ($sequential == 1) ? 1 : ($sequential + 1);

        // Add left zeros
        for($i = 0; $i < 8; $i++){
            if($sequential < (10 ** ($i + 1))){
                $sequential = str_repeat('0', 8 - $i) . $sequential;
                break;
            }
        }
        return $sequential;
    }

    private function getAccessKey(array $data): string
    {
        $access_key = 
            date('dmY')
            . '01' // document type: 01 => invoice
            . $data['user_identification']
            . '1' // enviroment type: 1 => test
            . '001001' // series
            . $data['sequential']
            . '12345678' // random number code (8 length)
            . '1' // issuance type: 1 => normal
            ;
        $access_key .= $this->calcVerifierDigit($access_key);
        return $access_key;
    }

    private function calcVerifierDigit(string $access_key): string
    {
        $digits = str_split($access_key);
        $factors = [7, 6, 5, 4, 3, 2];
        $factors_pointer = 0;

        $summation = 0;

        for($i = 0; $i < count($digits); $i++){
            $summation += $digits[$i] * $factors[$factors_pointer];
            $factors_pointer = ($factors_pointer == 5) ? 0 : $factors_pointer + 1;
        }

        $module =  $summation % 11;
        $subtract = 11 - $module;
        if($subtract == 11){
            $verifierDigit = 0;
        } else if($subtract == 10){
            $verifierDigit = 1;
        } else {
            $verifierDigit = $subtract;
        }
        return $verifierDigit;
    }

    private function buildDetails(array $data): array
    {
        $data_count = count($data['selected_products']);
        $last_iteration = $data_count - 1;
        $details = '';
        $total_without_taxation = '0.00';
        $tax_value = '0.00';
        $total = '0.00';
        for($i = 0; $i < $data_count; $i++){
            $detail = $this->buildDetail(
                $data['selected_products'][$i],
                $data['amounts'][$i],
                $i == $last_iteration,
                $i == 0
            );
            $details .= $detail['xml'];
            $total_without_taxation = bcadd($total_without_taxation, $detail['total_without_taxation'], 2);
            $tax_value = bcadd($tax_value, $detail['tax_value'], 2);
            $total = bcadd($total, $detail['total'], 2);
        }
        return [
            'xml' => $details,
            'total_without_taxation' => $total_without_taxation,
            'tax_value' => $tax_value,
            'total' => $total
        ];
    }

    private function buildDetail(
        int $productId,
        int $amount,
        bool $lastDetail,
        bool $firstDetail
    ): array
    {
        $product = Product::find($productId);
        $detail = 
         ($firstDetail
                 ? "<detalle>\n"
         : "        <detalle>\n")
         . "            <codigoPrincipal>{{id}}</codigoPrincipal>\n"
         . "            <descripcion>{{name}}</descripcion>\n"
         . "            <cantidad>{{amount}}</cantidad>\n"
         . "            <precioUnitario>{{price}}</precioUnitario>\n"
         . "            <descuento>0</descuento>\n"
         . "            <precioTotalSinImpuesto>{{total_without_taxation}}</precioTotalSinImpuesto>\n"
         . "            <impuestos>\n"
         . "                <impuesto>\n"
         . "                    <codigo>2</codigo>\n"
         . "                    <codigoPorcentaje>4</codigoPorcentaje>\n"
         . "                    <tarifa>15.00</tarifa>\n"
         . "                    <baseImponible>{{total_without_taxation}}</baseImponible>\n"
         . "                    <valor>{{tax_value}}</valor>\n"
         . "                </impuesto>\n"
         . "            </impuestos>\n"
         . "        </detalle>"
         . ($lastDetail ? '' : "\n");

        $detail = str_replace('{{id}}', $product->id, $detail);
        $detail = str_replace('{{name}}', $product->name, $detail);
        $detail = str_replace('{{amount}}', $amount, $detail);
        $detail = str_replace('{{price}}', $product->price, $detail);

        $total_without_taxation = bcmul("$product->price", "$amount", 2);
        $tax_value = bcmul($total_without_taxation, "0.15", 2);

        $detail = str_replace('{{total_without_taxation}}', $total_without_taxation, $detail);
        $detail = str_replace('{{tax_value}}', $tax_value, $detail);

        return [
            'xml' => $detail,
            'tax_value' => $tax_value,
            'total_without_taxation' => $total_without_taxation,
            'total' => bcadd($total_without_taxation, $tax_value, 2)
        ];
    }
}
