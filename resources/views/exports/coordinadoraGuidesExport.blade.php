<table>
    <thead>
        <tr>
            <th colspan="16" style="text-align: center">REPORTE DE GUÍAS (Lote {{ $batch->order_number ?? 'Guias por Rango de Fecha' }})</th>
            <th style="text-align: center">DETALLES DEL PAQUETE</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center">Datos del destinatario</th>
            <th colspan="8" style="text-align: center">Datos de la guía</th>
            <th style="text-align: center" rowspan="2">Referencia del paquete</th>
            <th style="text-align: center" rowspan="2">Unidades</th>
            <th style="text-align: center" rowspan="2">Peso (kg)</th>
            <th style="text-align: center" rowspan="2">Alto (cm)</th>
            <th style="text-align: center" rowspan="2">Ancho (cm)</th>
            <th style="text-align: center" rowspan="2">Largo (cm)</th>
            <th style="text-align: center" rowspan="2">Nombre del paquete</th>
        </tr>
        <tr>
            <th style="text-align: center">Identificación</th>
            <th style="text-align: center">Nombres</th>
            <th style="text-align: center">Apellidos</th>
            <th style="text-align: center">Dirección</th>
            <th style="text-align: center">Teléfono fijo</th>
            <th style="text-align: center">Teléfono celular</th>
            <th style="text-align: center">Código de la ciudad</th>
            <th style="text-align: center">Nombre de la ciudad</th>
            <th style="text-align: center">Código del pedido</th>
            <th style="text-align: center">Número del pedido</th>
            <th style="text-align: center">Entrega mismo día</th>
            <th style="text-align: center">Valor declarado</th>
            <th style="text-align: center">Estado de registro</th>
            <th style="text-align: center">Estado del envío</th>
            <th style="text-align: center">Fecha de creación</th>
            <th style="text-align: center">Fecha y hora de envío</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($guideData as $index => $guide)
            <tr>
                <td style="text-align: center">{{ $guide->identificacion_destinatario }}</td>
                <td style="text-align: center">{{ $guide->nombres_destinatario }}</td>
                <td style="text-align: center">{{ $guide->apellidos_destinatario }}</td>
                <td style="text-align: center">{{ $guide->direccion_destinatario }}</td>
                <td style="text-align: center">{{ $guide->telefono_fijo_destinatario }}</td>
                <td style="text-align: center">{{ $guide->telefono_celular_destinatario }}</td>
                <td style="text-align: center">{{ $guide->codigo_ciudad_destinatario }}</td>
                <td style="text-align: center">{{ $guide->nombre_ciudad_destinatario }}</td>
                <td style="text-align: center">{{ $guide->codigo_pedido }}</td>
                <td style="text-align: center">{{ $guide->numero_pedido }}</td>
                <td style="text-align: center">
                    @if ($guide->es_entrega_mismo_dia == "N")
                    No
                    @else
                    Si
                    @endif
                </td>
                <td style="text-align: center">$ {{ $guide->valor_declarado }}</td>
                <td style="text-align: center">
                    @if ($guide->state == null)
                    Sin registrar
                    @else
                    Registrada
                    @endif
                </td>
                <td style="text-align: center">{{ $guide->status ?? "Sin información registrada" }}</td>
                <td style="text-align: center">{{ $guide->created_at }}</td>
                <td style="text-align: center">{{ $guide->fechahora_pedido ?? "No registra" }}</td>
                <td style="text-align: center">{{ $guide->getGuideDetails[0]->referencia ?? "---" }}</td>
                <td style="text-align: center">{{ $guide->getGuideDetails[0]->unidades ?? "---" }}</td>
                <td style="text-align: center">{{ $guide->getGuideDetails[0]->peso ?? "---" }}</td>
                <td style="text-align: center">{{ $guide->getGuideDetails[0]->alto ?? "---" }}</td>
                <td style="text-align: center">{{ $guide->getGuideDetails[0]->ancho ?? "---" }}</td>
                <td style="text-align: center">{{ $guide->getGuideDetails[0]->largo ?? "---" }}</td>
                <td style="text-align: center">{{ $guide->getGuideDetails[0]->nombre_empaque ?? "---" }}</td>
            </tr>
                @foreach ($guide->getGuideDetails as $key => $product)
                    @if($key!==0)
                        <tr>
                            <td colspan="16"></td>
                            <td style="text-align: center">{{ $product->referencia }}</td>
                            <td style="text-align: center">{{ $product->unidades }}</td>
                            <td style="text-align: center">{{ $product->peso }}</td>
                            <td style="text-align: center">{{ $product->alto }}</td>
                            <td style="text-align: center">{{ $product->ancho }}</td>
                            <td style="text-align: center">{{ $product->largo }}</td>
                            <td style="text-align: center">{{ $product->nombre_empaque }}</td>
                        </tr>
                    @endif
                @endforeach
        @endforeach
    </tbody>
</table>
<style>
    table th {
        text-align: center
    }
</style>