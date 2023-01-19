<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SoapClient;


class Coordinadora
{   
    use RestActions;

    protected $urlGuides;
    protected $urlPickups;
    protected $client;
    protected $urlCreateOrder;
    //protected $clientDev;
    protected $urlLogin;
    //protected $clientLogin;
    protected $token;

    public function __construct()
    {
        $this->urlGuides = 'https://sandbox.coordinadora.com/agw/ws/guias/1.6/server.php?wsdl';
        $this->urlPickups = 'https://sandbox.coordinadora.com/agw/ws/guias/1.6/server.php?wsdl';
        $this->urlCreateOrder = 'https://apis-dev.coordiutil.com/fullfilment/pedidos/guardar';
        //$this->clientDev = new SoapClient($this->urlDev, array("trace" => 1,"exceptions" => true));
        $this->clientGuides = new SoapClient($this->urlGuides, array("trace" => 1,"exceptions" => true));
        $this->clientPickups = new SoapClient($this->urlPickups, ["trace" => 1,"exceptions" => true]);

        $this->urlLogin = 'https://apis-dev.coordiutil.com/fullfilment/clientes/autenticar';
        //$this->clientLogin = new SoapClient($this->urlLogin, array("trace" => 1,"exceptions" => true));
    }
    

    public function testConnection(){
        try {
            $r = print_r(json_encode((array)$this->clientDev->__getFunctions()));
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

            
            //$json_data = json_encode((array) $result);
            //return $json_data;
        //var_dump($result);
        } catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
        
    }

    public function login()
    {
        $loginResponse = Http::post(
            $this->urlLogin,
            [
                "usuario"  => "user",
                "clave" =>  "password"
            ]
        );
        if ($loginResponse->json()['isError'] == 1) {
            return $this->respond(500, null, null, 'Fallo en el servicio: '.$loginResponse->json()['message'].'.');
        }

        return $this->respond(200, $loginResponse->json(), null, 'Autenticación realizada correctamente');
    }

    public function createOrder()
    {

    }

    public function createOrderRequest()
    //Items/productos del pedido
    {   $details = [
            "referencia" => "83550", //Codigo del producto
            "unidades" => "1", //cantidad
            "peso" => "0.41", //peso en KG
            "alto" => "21.80", //alto en CM
            "ancho" => "12.20", //ancho en CM
            "largo" => "12.20", //largo en CM
            "nombre_empaque" => "Nombre de prueba" //nombre del producto
        ];

        $body = [
            "identificacion_cliente" => "123456789", //Obligatorio, máx: 15 caracteres
            "nombres_cliente" => "usuario prueba", 
            "apellidos cliente" => "prueba usuario", 
            "direccion_cliente" => "calle 1 #3b-24",  //Obligatorio, mínimo 10 caracteres
            "telefono_fijo_cliente" => "123456789", //Obligatorio, null en caso de no tenerlo
            "codigo_ciudad_cliente" => "05001000", //Código DANE formateado a 8 digitos
            
            "identificacion_destinatario" => "22123455678", //Obligatorio, máx 15 caracteres
            "nombres_destinatario" => "nombre destino", 
            "apellidos_destinatario" => "apellido destino",
            "direccion_destinatario" => "calle 2 #4c-56", //Obligatorio, minimo 10 caracteres
            "telefono_fijo_destinatario" => "1234567", //Obligatorio
            "telefono_celular_destinatario" => "12345567",
            "codigo_ciudad_destinatario" => "0500100", //Código DANE formateado a 8 digitos
            "nombre_ciudad_destinatario" => "MEDELLIN (ANT)", //Nombre textual de ciudad donde se va a entregar

            "codigo_pedido" => "3345677", //Número único interno dentro del sistema que identifica el pedido
            "numero_pedido" => "38273452", //Número externo para el cliente, puede ser igual al codigo y no lleva "-"
            "fechahora_pedido" => "2020-01-01 09:47:19", //formato "yyyy-mm-dd hh:mm:ss"
            "codigo_tienda" => "1", //Código númerico para diferenciar la tienda que envia el pedido. 1) pruebas, 2) tienda normal
            "codigo_vendedor" => "0", //Se envia siempre 0
            "es_pago_contra_entrega" => "N", // S) pago contra entrega, N) no es pago contra entrega. Validar que tenga este servicio activo
            "es_entrega_mismo_dia" => "N", // S) aplica para entrega el mismo dia, N) servicio estándar. Debe ser contratado, y tiene restricciones
            "total_coniva" => "57350.00", //Valor total incluyendo el iva
            "valor_declarado" => "57350.00", //Valor total del pedido
            "total_iva" => "8494.12", //Valor del iva

            "nit_remitente" => "900800700", //Nit de la tienda
            "nombre_remitente"=> "Mi tienda S.A", //Nombre de la tienda
            "telefono_remitente" => "3605000", //Numero de telefono de la tienda
            "detalle" => $details,

        ];
        //$url = 'https://apis-dev.coordiutil.com/fullfilment/pedidos/guardar';

        try {
            $createOrderResponse = Http::withHeaders([
                'Authorization' =>  $this->token,
                ])->post(
                    $this->urlCreateOrder,
                    $body
            );

            /* if ('guia no se crea') {
                return $this->respond(500, null, null, 'Ocurrió un fallo en el servicio');
            } */
            return $this->respond(200, $createOrderResponse->json(), null, 'Guía creada correctamente');
        } catch (Exception $e) {
            return $e->getMessage();
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