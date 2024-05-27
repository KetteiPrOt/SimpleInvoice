<?php

namespace App\View\Components\Entities\Invoice\Show;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Document extends Component
{
    private string $documentContent;

    public array $detailTranslator = [
        'id' => 'Codigo Principal',
        'name' => 'Descripcion',
        'amount' => 'Cantidad',
        'price' => 'Precio Unitario',
        'totalWithoutTaxation' => 'Total sin Impuestos',
        'totalTax' => 'Total IVA 15%'
    ];

    public array $translator = [
        'socialReason' => 'Razon Social',
        'commercialName' => 'Nombre Comercial',
        'enviroment' => 'Ambiente', // ambiente
        'issuanceType' => 'Tipo de Emision', // tipo de emision
        'ruc' => 'RUC',
        'accessKey' => 'Clave de Acceso',
        'sequential' => 'Secuencial',
        'address' => 'Direccion Matriz',
        'date' => 'Fecha de Emision',
        'establishmentAddress' => 'Dirreccion del Establecimiento',
        'requiredKeepAccounting' => 'Obligado a llevar Contabilidad',
        'clientIdentificationType' => 'Tipo de identificacion del cliente',
        'clientName' => 'Razon social cliente',
        'clientIdentification' => 'Identificacion del cliente',
        'totalWithoutTaxation' => 'Total sin Impuestos',
        'taxBase' => 'Base Imponible',
        'taxPercentaje' => 'Porcentaje de impuesto',
        'totalTax' => 'Total de impuestos',
        'total' => 'Importe total',
        'tip' => 'Propina',
        'pay' => 'Pagado'
    ];

    public array $documentTags = [
        'socialReason' => 'razonSocial',
        'commercialName' => 'nombreComercial',
        'ruc' => 'ruc',
        'accessKey' => 'claveAcceso',
        'address' => 'dirMatriz',
        'date' => 'fechaEmision',
        'establishmentAddress' => 'dirEstablecimiento',
        'requiredKeepAccounting' => 'obligadoContabilidad',
        'clientName' => 'razonSocialComprador',
        'clientIdentification' => 'identificacionComprador',
        'totalWithoutTaxation' => 'totalSinImpuestos',
        'total' => 'importeTotal',
        'tip' => 'propina',
        'pay' => 'total'
    ];

    public array $documentData = [
        'enviroment' => 'Pruebas',
        'issuanceType' => 'Normal',
        'clientIdentificationType' => 'Cedula'
    ];

    public array $documentDetails;

    /**
     * Create a new component instance.
     */
    public function __construct(string $content)
    {
        $this->documentContent = $content;
        $this->addSequential();
        foreach($this->documentTags as $name => $tag){
            $this->documentData[$name] = $this->getTagContent($tag);
        }
        $this->addTaxes();
        $this->addDetails();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entities.invoice.show.document');
    }

    private function getTagContent(string $name, $xml = false): string
    {
        if(!$xml){
            $xml = $this->documentContent;
        }
        $start = mb_strpos($xml, "<$name>") + mb_strlen("<$name>");
        $end = mb_strpos($xml, "</$name>");
        return substr($xml, $start, $end - $start);
    }

    private function addSequential(): void
    {
        $this->documentData['sequential'] = 
            $this->getTagContent('estab')
            . '-' . $this->getTagContent('ptoEmi')
            . '-' . $this->getTagContent('secuencial');
    }

    private function addTaxes(): void
    {
        $taxes = $this->getTagContent('totalImpuesto');
        $this->documentData['taxBase'] = $this->getTagContent('baseImponible', $taxes);
        $this->documentData['taxPercentaje'] = $this->getTagContent('tarifa', $taxes);
        $this->documentData['totalTax'] = $this->getTagContent('valor', $taxes);
    }

    private function addDetails(): void
    {
        $details = explode("</detalle>\n", $this->getTagContent('detalles'));
        array_pop($details);
        foreach($details as $detail){
            $this->documentDetails[] = [
                'id' => $this->getTagContent('codigoPrincipal', $detail),
                'name' => $this->getTagContent('descripcion', $detail),
                'amount' => $this->getTagContent('cantidad', $detail),
                'price' => $this->getTagContent('precioUnitario', $detail),
                'totalWithoutTaxation' => $this->getTagContent('precioTotalSinImpuesto', $detail),
                'totalTax' => $this->getTagContent('valor', $detail),
            ];
        }
    }
}
