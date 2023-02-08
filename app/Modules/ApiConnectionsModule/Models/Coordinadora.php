<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;
use Soapclient;


class Coordinadora
{   
    use RestActions;
    
    protected $client_16;
    protected $url_16;
    protected $url_15;
    protected $client_15;
    protected $user;
    protected $password;
    protected $id_client;
    protected $apiKey;
    protected $apiPassword;
    protected $nit;

    public function __construct()
    {   
        $this->url_16 = "https://sandbox.coordinadora.com/agw/ws/guias/1.6/server.php?wsdl";
        $this->client_16 = new Soapclient($this->url_16, ["trace" => 1,"exceptions" => true]);

        $this->url_15 = "https://sandbox.coordinadora.com/ags/1.5/server.php?wsdl";
        $this->client_15 = new Soapclient($this->url_15, ["trace" => 1,"exceptions" => true]);

        $this->user = "investcapital.ws";
        $this->id_client = 39327;
        $this->password = "9b9be4aca68315b70bc9d7ac6e2bbe013e406a891b311dd50f6770ab73d153d9";

        $this->apiKey = "f923a1b2-03b0-11ed-b939-0242ac120002";
        $this->apiPassword = "lY1kT6rE3kJ8hU9i";
        $this->nit = "901090679";
        
    }

    public function getMethods()
    {
        $getMethods_15 = var_dump($this->client_15->__getTypes()); //Obtener métodos de la api junto con sus atributos    
        $getMethods_16 = var_dump($this->client_16->__getTypes());
        return compact('getMethods_15', 'getMethods_16');
    }

    public function generateGuide(Request $request)
    {   
        
        //Detalle de la guía
        $Agw_typeGuiaDetalle = array(
            [
            "ubl" => 0,
            "alto" => 1, //cm
            "ancho" => 50, //cm
            "largo" => 50, //cm
            "peso" => 1, //kg
            "unidades" => 1,
            "referencia" => "referencia del paquete",
            "nombre_empaque" => "nombre del paquete",
            ],
            
        );
        
        //Detalle del recaudo
        $Agw_typeGuiaDetalleRecaudo = array(
            "referencia" => "",
            "valor" => null,
            "valor_base_iva" => null,
            "valor_iva" => null,
            "forma_pago" => null, //1. Efectivo, 5. Tarjeta
        );

        
        //Notificaciones
        $Agw_typeNotificaciones = array(
            "tipo_medio" => "",  /*
                                    Es una combinación del tipo notificación (estandar - codigo_seguridad),
                                    con el medio de envio (correo - sms - wsdl - facebook)
                                    1 correo estandar
                                    2 SMS estandar
                                    3 correo código seguridad
                                    4 SMS código seguridad
                                    @var string
                                  */
            "destino_notificacion" => "" //correo o numero celular destino de la notif.
        );

        //Información de la guía de reversa
        $Agw_typeAtributosRetorno = array(
            "nit" => "",
            "div" => "",
            "nombre" => "",
            "direccion" => "",
            "codigo_ciudad" => "",
            "codigo_seguridad" => "",
            "telefono" => ""
        );
        try {
            $result = $this->client_16->Guias_generarGuia([
                "codigo_remision" => $request->codigo_remision ?? null,
                "fecha" => $request->fecha ?? null, //yyyy-mm-dd
                "id_cliente" => $this->id_client,
                "id_remitente" => $request->id_remitente ?? null,  //para un remitente sin registrar utilice el valor 0
                "nit_remitente" => $request->nit_remitente ?? null, //nullable
                "nombre_remitente" => $request->nombre_remitente ?? null, //vacio si se envia id_remitente diferente de 0
                "direccion_remitente" => $request->direccion_remitente ?? null, //vacio si se envia id_remitente diferente de 0
                "telefono_remitente" => $request->telefono_remitente ?? null, //vacio si se envia id_remitente diferente de 0
                "ciudad_remitente" => $request->ciudad_remitente ?? null, //Ciudad del remitente en código dane de 8 digitos ej: Medellín -> 05001000 vacio si se envia id_remitente diferente de 0
                "nit_destinatario" => $request->nit_destinatario ?? null,
                "div_destinatario" => $request->div_destinatario ?? null,
                "nombre_destinatario" => $request->nombre_destinatario,
                "direccion_destinatario" => $request->direccion_destinatario,
                "ciudad_destinatario" => $request->ciudad_destinatario, //Ciudad del destinatario en código dane de 8 digitos ej: Medellín -> 05001000
                "telefono_destinatario" => $request->telefono_destinatario,
                "valor_declarado" => $request->valor_declarado,
                "codigo_cuenta" => $request->codigo_cuenta, //1. Cuenta Corriente, 2. Acuerdo Semanal, 3. Flete Pago
                "codigo_producto" => $request->codigo_producto, //0. Auto, se determina automaticamente a partir del detalle de la guia, 1. Mercancia, 2. Paquetes de 1-2 Kg, 3. Documentos, 6. Paquetes de 3-5 Kg
                "nivel_servicio" => $request->nivel_servicio, // 1. Estandar, 2. Express, 3. Programado
                "linea" => $request->linea ?? null, //nullable
                "contenido" => $request->contenido,
                "referencia" => $request->referencia,
                "observaciones" => $request->observaciones,
                "estado" => $request->estado, //puede ser PENDIENTE o IMPRESO.
                "detalle" => $request->detalle, //Agw_typeGuiaDetalle[], se debe enviar al menos uno
                "cuenta_contable" => $request->cuenta_contable ?? null, //nullable
                "centro_costos" => $request->centro_costos ?? null, //nullable
                "recaudos" => $request->recaudos, //Agw_typeGuiaDetalleRecaudo[], nullable
                "margen_izquierdo" => $request->margen_izquierdo,
                "margen_superior" => $request->margen_derecho,
                "usuario_vmi" => "",
                "formato_impresion" => $request->formato_impresion ?? null,
                "atributo1_nombre" => $request->atributo1_nombre ?? null,
                "atributo1_valor" => $request->atributo1_valor ?? null,
                "notificaciones" => $request->notificaciones, //Agw_typeNotificaciones[]
                "atributos_retorno" => $request->atributos_retorno, //Agw_typeAtributosRetorno
                "nro_doc_radicados" => $request->nro_doc_radicados ?? null,
                "nro_sobre" => $request->nro_sobre ?? null,
                "codigo_vendedor" => $request->codigo_vendedor ?? null, //nullable
                "usuario" => $this->user,
                "clave" => $this->password
            ]);

            return $this->respond(200, $result, null, "Petición procesada correctamente");
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), "Hubo un fallo en el servicio");
        }
            
    }

    public function printLabels(Request $request)
    { 
        try
        {   //id_remision 6828594
            $referalCodes = array(
                95352500003
            );

            $result = $this->client_16->Guias_imprimirRotulos([
                        "id_rotulo" => $request->id_rotulo,
                        "codigos_remisiones" => $request->codigos_remisiones,
                        "usuario" => $this->user,
                        "clave" => $this->password
                    ]);
            
            return $this->respond(200, $result, null, "Petición procesada correctamente");

        } catch(Exception $e) {
            return $this->respond(500, null, $e->getMessage(), "Hubo un fallo en el servicio");
        }
    }

    public function schedulePickup(Request $request)
    {   
        $p = "p";
        $body = array(
            "modalidad" => $request->modalidad, //1 = Cuenta Corriente, 2 = Flete Pago, 3 = Flete Contra Entrega, 4 = Flete al Cobro, 5 = Acuerdo Semanal, 6 = CC Int., 7 = FPI, 8 = CC/INT
            "fecha_recogida" => $request->date, //YYYY-MM-DD
            "ciudad_origen" => $request->ciudad_origen,    //codigo de la ciudad de 8 digitos
            "ciudad_destino" => $request->ciudad_destino,   //codigo de la ciudad de 8 digitos
            "nombre_destinatario" => $request->nombre_destinatario ?? null,
            "nit_destinatario" => $request->nit_destinatario ?? null,
            "direccion_destinatario" => $request->direccion_destinatario ?? null,
            "telefono_destinatario" => $request->telefono_destinatario ?? null,
            "nombre_empresa" => $request->nombre_empresa,
            "nombre_contacto" => $request->nombre_contacto,
            "direccion" => $request->direccion,
            "telefono" => $request->telefono, //Longitud 7
            "producto" => $request->producto, // 2 para mensajeria, 4 para mercancia
            "referencia" => $request->referencia,
            "nivel_servicio" => $request->nivel_servicio ?? null,
            "guia_inicial" => $request->guia_inicial ?? null,
            "nit_cliente" => $this->nit, //Longitud 20
            "div_cliente" => $request->div_cliente, //Longitud 2
            "persona_autoriza" => $request->persona_autoriza,
            "telefono_autoriza" => $request->telefono_autoriza,
            "tipo_notificacion" => $request->tipo_notificacion ?? null, // 0 si no se desea notificar, 1 notificar por correo
            "destino_notificacion" => $request->destino_notificacion,
            "valor_declarado" => $request->valor_declarado, //Formato 11.11
            "unidades" => $request->unidades,
            "observaciones" => $request->observaciones,
            "estado" => $request->estado,
            "centro_costos" => $request->centro_costos ?? null,
            "cuenta_contable" => $request->cuenta_contable ?? null,
            "datafono" => $request->datafono ?? null,
            "agente" => $request->agente ?? null,
            "contenido" => $request->contenido ?? null,
            "equipo" => $request->equipo ?? null,
            "sub_equipo" => $request->sub_equipo ?? null,
            "nit_remite" => $request->nit_remitente ?? null,
            "apikey" => $this->apiKey,
            "clave" => $this->apiPassword
        );

        try
        {
            $result = $this->client_15->Recogidas_programar([
                $p => $body
            ]);

            return $this->respond(200, $result, null, "Petición procesada correctamente");
        } catch(Exception $e){
            return $this->respond(500, null, $e->getMessage(), "Hubo un fallo en el servicio");
        }
    }

    public function pickupTracking(Request $request){
        $p = "p";
        $body = array(
            "id_recogida" => $request->id_recogida,
            "nit_cliente" => $this->nit,
            "div_cliente" => $request->div_cliente,
            "referencia" => $request->referencia,
            "apikey" => $this->apiKey,
            "clave" => $this->apiPassword
        );

        try {
            $result = $this->client_15->Recogidas_seguimiento([
                $p => $body
            ]);

            return $this->respond(200, $result, null, "Petición procesada correctamente");
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), "Hubo un fallo en el servicio");
        }
    }
}