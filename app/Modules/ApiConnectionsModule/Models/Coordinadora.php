<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SoapClient;

class Coordinadora
{
    protected $urlGuides;
    protected $urlPickups;
    protected $client;

    public function __construct()
    {
        $this->urlGuides = 'https://sandbox.coordinadora.com/agw/ws/guias/1.6/server.php?wsdl';
        $this->urlPickups = 'https://sandbox.coordinadora.com/agw/ws/guias/1.6/server.php?wsdl';
        $this->clientGuides = new SoapClient($this->urlGuides, array("trace" => 1,"exceptions" => true));
        $this->clientPickups = new SoapClient($this->urlPickups, ["trace" => 1,"exceptions" => true]);
    }
    

    public function testConnection(){
        try {
            //$r = print_r(json_encode((array)$this->client->__getFunctions()));
            /* $result = $this->client->Cotizador_ciudades([
                "p" => null,
                
            ]); */

            $result = $this->clientGuides->Guias_detalleDespacho([
                "ubl" => 12345,
                "alto" => 5.0, //cm
                "ancho" => 5.0, //cm
                "largo" => 5.0, //cm
                "peso" => 25.0, //kg
                "unidades" => 2,
                "referencia" => "reference",
                "nombre_empaque" => "name",
            ]);

            
            $json_data = json_encode((array) $result);
            return $json_data;
        //var_dump($result);
        } catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
        
    }

    public function generateGuide()
    {   
        //Detalle de la guía
        $Agw_typeGuiaDetalle = array(
            "ubl" => 12345,
            "alto" => 5.0, //cm
            "ancho" => 5.0, //cm
            "largo" => 5.0, //cm
            "peso" => 25.0, //kg
            "unidades" => 2,
            "referencia" => "reference",
            "nombre_empaque" => "name",
        );
        
        //Detalle del recaudo
        $Agw_typeGuiaDetalleRecaudo = array(
            "referencia" => "reference",
            "valor" => 10.0,
            "valor_base_iva" => 10.0,
            "valor_iva" => 10.0,
            "forma_pago" => 1, //1. Efectivo, 5. Tarjeta
        );

        //Notificaciones
        $Agw_typeNotificaciones = array(
            "tipo_medio" => "1",  /*
                                    Es una combinación del tipo notificación (estandar - codigo_seguridad),
                                    con el medio de envio (correo - sms - wsdl - facebook)
                                    1 correo estandar
                                    2 SMS estandar
                                    3 correo código seguridad
                                    4 SMS código seguridad
                                    @var string
                                  */
            "destino_notificacion" => "12345" //correo o numero celular destino de la notif.
        );

        //Información de la guía de reversa
        $Agw_typeAtributosRetorno = array(
            "nit" => "12345",
            "div" => "div",
            "nombre" => "name",
            "direccion" => "adress",
            "codigo_seguridad" => "secCode",
            "telefono" => "phone"
        );

        try {
            $result = $this->clientGuides->Guias_generarGuia([
                "codigo_remision" => "12345",
                "fecha" => "2022-01-01", //yyyy-mm-dd
                "id_cliente" => 1,
                "id_remitente" => 1,  //para un remitente sin registrar utilice el valor 0
                "nit_remitente" => "12345", //nullable
                "nombre_remitente" => "userName", //vacio si se envia id_remitente diferente de 0
                "direccion_remitente" => "userAdress", //vacio si se envia id_remitente diferente de 0
                "telefono_remitente" => "userPhone", //vacio si se envia id_remitente diferente de 0
                "ciudad_remitente" => "userCity", //Ciudad del remitente en código dane de 8 digitos ej: Medellín -> 05001000 vacio si se envia id_remitente diferente de 0
                "nit_destinatario" => "recipientNit",
                "div_destinatario" => "recipientDiv",
                "nombre_destinatario" => "recipientName",
                "direccion_destinatario" => "recipientAdress",
                "ciudad_destinatario" => "recipientCity", //Ciudad del destinatario en código dane de 8 digitos ej: Medellín -> 05001000
                "telefono_destinatario" => "recipientPhone",
                "valor_declarado" => 10.0,
                "codigo_cuenta" => 10, //1. Cuenta Corriente, 2. Acuerdo Semanal, 3. Flete Pago
                "codigo_producto" => 1, //0. Auto, se determina automaticamente a partir del detalle de la guia, 1. Mercancia, 2. Paquetes de 1-2 Kg, 3. Documentos, 6. Paquetes de 3-5 Kg
                "nivel_servicio" => 1, // 1. Estandar, 2. Express, 3. Programado
                "linea" => "12345", //nullable
                "contenido" => "content",
                "referencia" => "reference",
                "observaciones" => "observ",
                "estado" => "status", //puede ser PENDIENTE o IMPRESO.
                "detalle" => $Agw_typeGuiaDetalle, //Agw_typeGuiaDetalle[], se debe enviar al menos uno
                "cuenta_contable" => "account", //nullable
                "centro_costos" => "12345", //nullable
                "recaudos" => null, //Agw_typeGuiaDetalleRecaudo[], nullable
                "margen_izquierdo" => 5.0,
                "margen_superior" => 5.0,
                "usuario_vmi" => "userVMI",
                "formato_impresion" => "format",
                "atributo1_nombre" => "nameOneAtt",
                "atributo1_valor" => "valueOneAtt",
                "notificaciones" => null, //Agw_typeNotificaciones[]
                "atributos_retorno" => null, //Agw_typeAtributosRetorno
                "nro_doc_radicados" => "nitValue",
                "nro_sobre" => "number",
                "codigo_vendedor" => 1, //nullable
                "usuario" => "user",
                "clave" => "password123"
            ]);

            
            $json_data = json_encode((array) $result);
            return $json_data;
        } catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

}
/* metodos api cotizador y reocgidas
(Cotizador_departamentos $parameters)",
(Cotizador_ciudades $parameters)",
(Cotizador_cotizar $parameters)",
(Cotizador_cotizarInter $parameters)",
(Cotizador_cotizarPruebas $parameters)",
(Recaudos_consultar $parameters)",
(Recogidas_programar $parameters)",
(Recogidas_seguimiento $parameters)",
(Recogidas_seguimientoExt $parameters)",
(Recogidas_seguimientoPorFecha $parameters)",
(Recogidas_seguimientoFCDetalladoPorReferencia $parameters)",
(Recogidas_programarFC $parameters)",
(Seguimiento_simple $parameters)",
(Seguimiento_detallado $parameters)" 

metodos guías
- Guias_generarGuia(Agw_typeGenerarGuiaIn $p)
- Guias_anularGuia(Agw_typeAnularGuiaIn $p)
- Guias_liquidacionGuia(Agw_liquidacionGuiaIn $p)
- Guias_generarDespacho(Agw_typeGenerarDespachoIn $p)
- Guias_generarDespacharLevantePrevio(Agw_typeGenerarDespachoLevantePrevioIn $p)
- Guias_reimprimirGuia(Agw_typeReimprimirGuiaIn $p)
- Guias_reimprimirDespacho(Agw_typeReimprimirDespachoIn $p)
- Guias_reimprimirDespachoPlano(Agw_typeReimprimirDespachoPlanoIn $p)
- Guias_consultarDespachos(Agw_typeconsultarDespachosIn $p)
- Guias_consultarRetornoRDFD(Agw_typeConsultarRetornoRDFDIn $p)
- Guias_actualizarPesoVolumenRetornoRDFD(Agw_typeActualizarPesoVolumenRetornoRDFDIn $p)
- Guias_generarDespachoRDFD(Agw_typeGenerarDespachoRDFDIn $p)
- Guias_rastreoSimple(Agw_typeRastreoSimpleIn $p)
- Guias_rastreoExtendido(Agw_typeRastreoExtendidoIn $p)
- Guias_detalleDespacho(Agw_detalleDespachoIn $p)
- Guias_estadoRecaudo(Agw_estadoRecaudoIn $p)
- Guias_ciudades(Agw_ciudadesIn $p)
- Guias_generarDespachoMovil(Agw_generarDespachoMovilIn $p)
- Guias_imprimirRotulos(Agw_imprimirRotulosIn $p)
- Guias_reimprimirGuias(Agw_typeReimprimirGuiasIn $p)
- Guias_generarGuiaInter(Agw_typeGenerarGuiaInterIn $p)
- Guias_editarGuia(Agw_typeEditarGuiaIn $p)
- Guias_rotuloPrevio(Agw_rotuloPrevioIn $p)
- Guias_rotuloPrevioRD(Agw_rotuloPrevio_RDIn $p)
- Guias_novedadReetiquetado(Agw_typeNovedadReetiquetadoIn $p)
- Sifa_sugerirSifa(Agw_typeSugerirSifaIn $p)
- Sifa_liquidarSifa(Agw_typeliquidarSifaIn $p)
- Sifa_liquidarFullTarifaSifa(Agw_typeliquidarFullTarifaSifaIn $p)

generar guia, cotizarla y hacerle seguimiento
*/