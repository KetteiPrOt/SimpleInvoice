<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Invoice;
use Exception;
use Illuminate\Http\Request;
use SoapClient;

class Controller extends BaseController
{
    public function index()
    {
        $invoices = Invoice::orderBy('created_at')->paginate(15);
        foreach($invoices as $invoice){
            $invoice->appendSequential();
        }
        return view('entities.invoices.index', [
            'invoices' => $invoices
        ]);
    }

    public function show(Invoice $invoice)
    {
        if(!$invoice->authorized){
            $this->queryAuthorization($invoice);
        }
        $invoice->appendSequential();
        return view('entities.invoices.show', [
            'invoice' => $invoice
        ]);
    }

    private function queryAuthorization(Invoice $invoice): void
    {
        try{
            $client = new SoapClient('https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl');
            $response = $client->autorizacionComprobante([
                'claveAccesoComprobante' => $invoice->access_key
            ]);
            if(
                $response->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado
                === 'AUTORIZADO'
            ){
                $invoice->authorized = true;
                $invoice->status_details = 'Autorizada';
            } else {
                $invoice->status_details = 'No autorizada';
            }
        }catch(Exception $e){}
        $invoice->save();
    }

    public function showDocument(Invoice $invoice)
    {
        return view('entities.invoices.show-document', [
            'content' => $invoice->content
        ]);
    }
}
