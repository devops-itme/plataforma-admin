<?php

namespace App\Modules\UserModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RoleModule\Role;
use App\Modules\UserModule\Controllers\UserTrait;
use App\Modules\UserModule\User;
use App\Modules\OrderModule\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    use UserTrait;

    protected $path = 'UserModule.views.html.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::name(request()->name)
            ->document(request()->document)
            ->email(request()->email)
            ->phone(request()->phone)
            ->role(request()->role_id)
            ->state(request()->state)
            ->whereHas('getRole', function ($q) {
                $q->whereNotIn('name', ['Cliente', 'Mensajero']);
            })
            ->paginate(10);

        $roles = Role::where('state', 1)->whereNotIn('name', ['Cliente', 'Mensajero'])->get();

        return view($this->path . 'index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $document_types = ParameterValue::whereHas('getParameter', function ($q) {
            $q->where('name', 'document_type');
        })->get();
        $roles = Role::where('state', 1)->whereNotIn('name', ['Cliente', 'Mensajero'])->get();
        return view($this->path .  'create', compact('document_types', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->saveUser($request);

        if ($response['state'] == 200) {
            return redirect()->route('users.index')->with('success', 'Usuario registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->showUser($id);
        $user = $user['data'];
        $roles = Role::where('state', 1)->whereIn('id', [1, 2])->get();
        $document_types = ParameterValue::where('parameter_id', 1)->get();
        return view($this->path .  'detail', compact('user', 'roles', 'document_types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->showUser($id);
        $user = $user['data'];
        $roles = Role::where('state', 1)->whereIn('id', [1, 2])->get();
        $document_types = ParameterValue::where('parameter_id', 1)->get();
        return view($this->path .  'edit', compact('user', 'roles', 'document_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->merge([
            'user_id' => $id
        ]);
        $response = $this->updateUser($request, $id);
        if ($response['state'] == 200) {
            return redirect()->route('users.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->deleteUser($id);
        if ($request->response_format == 'json') {
            return $response;
        }
        if ($response['state'] == 200) {
            return redirect()->route('users.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }

    public function importWebUsers()
    {   
        set_time_limit(3600);
        $users = [
/*             [
        "name" => "Mensajeria Panama",
        "email" => "mensajeria.panama@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Monitoreo",
        "email" => "camaras1.monitoreopty@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Pricing",
        "email" => "pricing.panama@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Reclutamiento",
        "email" => "Reclutamiento.Pty@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Auxiliar Finanzas",
        "email" => "auxiliar.finanzaspty2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Verificadores",
        "email" => "VERIFICADORES.SECPTY@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Operaciones IRF",
        "email" => "operaciones.irf.pty@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Monitoreo PS",
        "email" => "DGFPTY.MonitoreoPS@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Asistencia Quality",
        "email" => "Asistencia.quality@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Recepcion PS",
        "email" => "recepcion.parquesur@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Coordinadores Seguridad",
        "email" => "coordinadores.seguridadpty@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Centro Monitoreo",
        "email" => "centro.monitoreopty@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Mensajeria ONX",
        "email" => "mensajeria.onx@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Warehouse Toca",
        "email" => "dgfpty.warehousetoca@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Seguridad Toca",
        "email" => "SeguridadDGF.PTYTUM@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Juan Castillo",
        "email" => "Juan.Castillo@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "John Acosta",
        "email" => "john.acosta@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Gustavo Rivera",
        "email" => "Gustavo.Rivera@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jorge Ortiz",
        "email" => "jorge.ortiz4@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Vielka Camargo",
        "email" => "vielka.camargo@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Francisco Cervantes",
        "email" => "francisco.cervantes2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Efrain Ortega",
        "email" => "Efrain.Ortega@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Christian Schwarz",
        "email" => "C.Schwarz@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Emelda Castillo",
        "email" => "Emelda.Castillo@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Flor Rivera",
        "email" => "Flor.Rivera@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Anthony Ramirez",
        "email" => "anthony.ramirez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Keysha Nieto",
        "email" => "keysha.nieto2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jorge Richard",
        "email" => "jorge.richard@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Richard Bradshaw",
        "email" => "richard.bradshaw@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yara Rojas",
        "email" => "yara.rojas@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Javier Sarmiento",
        "email" => "Javier.Sarmiento@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yineyka Ortega",
        "email" => "Yineyka.Ortega@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Fernando Castillo",
        "email" => "fernando.castillo2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Franchesca Vega",
        "email" => "franchesca.vega@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Walterio Valencia",
        "email" => "walterio.valencia@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yeorleny Saavedra",
        "email" => "Yeorleny.Saavedra@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Felix Villarreal",
        "email" => "felix.villarreal@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alvaro Guerrero",
        "email" => "Alvaro.Guerrero2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Itzel Aguilar",
        "email" => "ITZEL.AGUILAR@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Leydel Quijano",
        "email" => "leydel.quijano@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Rocio Izos",
        "email" => "rocio.izos@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jonathan Wong",
        "email" => "jonathan.wong3@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Karla Montes",
        "email" => "karla.montes@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Glendys Diaz",
        "email" => "glendys.diaz@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Soporte OFRI",
        "email" => "soporte.ofri@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Abdiel Martinez",
        "email" => "abdiel.martinez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Ricardo De Leon",
        "email" => "ricardo.de.leon@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "DGFPTY Inplant3",
        "email" => "Dgfpty.Inplant3@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Verificacion IWS",
        "email" => "verificacion.iwspa2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "DGFPTY Inplant2",
        "email" => "Dgfpty.Inplant2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Johanna Escobar",
        "email" => "johanna.escobar2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Radameth Delgado",
        "email" => "RADAMETH.DELGADO@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Stephany McQueen",
        "email" => "STEPHANY.MCQUEEN@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Ines Rentería",
        "email" => "Ines.Renteria@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Monica De Leon",
        "email" => "monica.de_leon@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "DGFPTY Inplant 11",
        "email" => "dgf.pty.inplant11@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Rigoberto Morales",
        "email" => "rigoberto.morales@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Mailyn Batista",
        "email" => "Mailyn.Batista@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Marzysma Miranda",
        "email" => "marzysma.mirandago@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Monica Vergara",
        "email" => "monica.vergara@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Amadis Escalante",
        "email" => "Amadis.Escalante@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ], */
    /* [
        "name" => "Amilcar Chan",
        "email" => "Amilcar.Chan@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Johodis Rivera ",
        "email" => "Johodis.Rivera@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Dgfpa Capacitaciones",
        "email" => "dgfpa.capacitaciones@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Mirtha Gonzalez",
        "email" => "mirtha.gonzalez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yahmal Rojas",
        "email" => "yahmal.rojas@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Ileana Bonilla",
        "email" => "ILEANA.BONILLA@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Signiean Gonzalezli",
        "email" => "signiean.gonzalezli@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Anthony Montenegro",
        "email" => "anthony.montenegro@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jose Chavez",
        "email" => "jose.chavez6@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Claudia Ballesteros",
        "email" => "claudia.ballesteros@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Ricardo Felipe",
        "email" => "ricardo.felipe@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Rosa Marciaga",
        "email" => "rosa.marciaga@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Paola Rivera",
        "email" => "paola.rivera@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Feliciano Quiros",
        "email" => "feliciano.quiros@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Laisy Urrutia",
        "email" => "Laisy.Urrutia@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Asistente CXP",
        "email" => "asistente.cxp@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Liliana Perez",
        "email" => "liliana.perez2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Oscar Gonzalez",
        "email" => "oscar.gonzalez4@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Josue Concepcion",
        "email" => "josue.concepcion@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Luisa Buenaventura",
        "email" => "Luisa.Buenaventura@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Katherine Carretero",
        "email" => "katherine.carretero@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Marjulys Iglesias",
        "email" => "m.iglesiasc@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Genesis De Gracia",
        "email" => "genesis.de_gracia@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Operaciones AFR",
        "email" => "opercionesafr@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Paul Hull",
        "email" => "paul.hull@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Valeria Chan",
        "email" => "valeria.chan@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Lauritza Palma",
        "email" => "lauritza.palma@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Carolina Aguilera",
        "email" => "CarolinaAndrea.Aguilera@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Edgar Rodriguez",
        "email" => "edgar.rodriguez3@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Miguel Avila",
        "email" => "miguel.avila@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Rosalba Saavedra",
        "email" => "Rosalba.Saavedra@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Asistencia AFRE ONX",
        "email" => "asistencia.afreonx@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yazmin Hernandez",
        "email" => "yazmin.hernandez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Dgfpty Inplant6",
        "email" => "Dgfpty.Inplant6@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alex Avila",
        "email" => "a.avila_sandoval@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jonathan Lopez",
        "email" => "jonathan.lopez_v@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jorge Salazar",
        "email" => "jorge.salazar2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Amarilys Shirley",
        "email" => "amarilys.shirley@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Lizmarie Vasquez",
        "email" => "lizmarie.vasquez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Operaciones1",
        "email" => "operaciones1@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Juan Poveda",
        "email" => "juan.poveda@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Luiyi Sanchez",
        "email" => "luiyi.sanchez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Natzury Tunon",
        "email" => "natzury.tunon@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Adbeel Ortega",
        "email" => "adbeel.ortega@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Angelica Hernandez",
        "email" => "Angelica.Hernandez2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Karen Ulloa",
        "email" => "karen.ulloa@dpdhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Armando Garza",
        "email" => "armando.garza3@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Facturas CXP",
        "email" => "facturas.cxp@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Edgar Villarreal",
        "email" => "edgar.villarreal@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Inelka Blandon",
        "email" => "inelka.blandon@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Benjamin Gutierrez",
        "email" => "benjamin.gutierrez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Adriana Vega",
        "email" => "adriana.vega@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Kristel Chang",
        "email" => "Kristel.Chang@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Marlena Jimenez",
        "email" => "Marlena.Jimenez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Nathalie Gonzalez",
        "email" => "nathalie.gonzalez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Elvia Davis",
        "email" => "Elvia.Davis@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Roger Calles",
        "email" => "roger.calles@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Elvis Falcon",
        "email" => "elvis.falcon@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Paola Yiu",
        "email" => "paola.yiu@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jeremy Bouche",
        "email" => "jeremy.bouche@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Isabella Bethancourth",
        "email" => "isabella.bethancourth@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ], */
    /* [
        "name" => "Yves Torres",
        "email" => "yves.torres@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jonathan Wong",
        "email" => "jonathan_ameth.wong_morales@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Josue Marquez",
        "email" => "j.marquez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Francisco Acuna",
        "email" => "Francisco.Acuna@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Melibeth Torres",
        "email" => "m.torres_vasquez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Mario Vasquez",
        "email" => "Mario.Vasquez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Carolina Gonzalez",
        "email" => "carolina.c.gonzalez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Hector Bernal",
        "email" => "HECTOR.BERNAL@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Genesis de Aguilar",
        "email" => "genesis_d.aguilar_m@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Monitoreo DGFPA",
        "email" => "monitoreo.dgfpa@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Maickol Perea",
        "email" => "maickol.perea@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Juan Gutierrez",
        "email" => "juan.gutierrez4@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Edwin Vega",
        "email" => "e.vegav@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Anel Garibaldi",
        "email" => "anel.garibaldi2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Facturas CXP2",
        "email" => "facturas.cxp2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yanelys Vitola",
        "email" => "Yanelys.Vitola@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yadira Chaparro",
        "email" => "Yadira.Chaparro@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Ocaryna Sanchez",
        "email" => "Ocaryna.Sanchez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Dayrubis de la Espada",
        "email" => "d.de_la_espada@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Dgfpty Inplant5",
        "email" => "Dgfpty.Inplant5@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jose Luis Navarro",
        "email" => "J.Navarro@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alexis Vasquez",
        "email" => "alexis.vasquez2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alberto Campbell",
        "email" => "alberto.campbell@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jonathan Quintero",
        "email" => "jonathan.quintero@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jared Altamirano",
        "email" => "Jared.Altamirano@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Angela Vasquez",
        "email" => "Angela.Vasquez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Monica Melendez",
        "email" => "monica.melendez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Lourdes Reyes",
        "email" => "Lourdes.Reyes@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Luis Sanders",
        "email" => "luis.sanders@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Tania Ruiz",
        "email" => "tania.ruiz2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Norberto Aguirre",
        "email" => "Norberto.Aguirre@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Dgfpty Inplant16",
        "email" => "Dgfpty.Inplant16@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Raul Rios",
        "email" => "raul.rios@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Oriel Cedeno",
        "email" => "oriel.cedeno@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Chabeli Alvarado",
        "email" => "Chabeli.Alvarado@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Lisseth Maldonad",
        "email" => "Lisseth.Maldonado@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Aracelys Combe",
        "email" => "Aracelys.Combe@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Allison Martin",
        "email" => "Allison.Martin@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Roman Zaobornyj",
        "email" => "roman.zaobornyj@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Eyleen Sanchez",
        "email" => "Eyleen.Sanchez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Edgar Jauregui",
        "email" => "edgar.jauregui@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Luis Rojas",
        "email" => "Luis.R.Rojas@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Arnoldo Mendez",
        "email" => "arnoldo.mendez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alexis Samaniego",
        "email" => "alexis.samaniego@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Enrique Navarro",
        "email" => "enrique.navarro2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Juan Diego Perez",
        "email" => "Juandiego.perez1@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Kaadirale Pinillava",
        "email" => "kaadirale.pinillava@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Emanuel Del",
        "email" => "emanuel.del_cid@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Dgfpty Inplant15",
        "email" => "Dgfpty.inplant15@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alex Bedoya",
        "email" => "alex.bedoya2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Practicante Finanzas",
        "email" => "practicante.finanzas@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Maryorie Sanchez",
        "email" => "maryorie.sanchez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Paulo Benyi",
        "email" => "paulo.benyi@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jose Beitia",
        "email" => "jose.beitia2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Orlando Melendez",
        "email" => "orlando.melendez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yahaira Laurie",
        "email" => "yahaira.laurie@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Maria Crespo",
        "email" => "maria.crespo@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alexis Samaniego",
        "email" => "alexis.samaniegovillarreal@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Marisol Bermudez",
        "email" => "marisol.bermudez2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Michael Gomez",
        "email" => "michael.gomez3@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Karen Avila",
        "email" => "karen.avila@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ], */
    /* [
        "name" => "Jorge Perez",
        "email" => "j.perez5@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Astrid Cedeno",
        "email" => "astrid.cedeno@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Raul Lozano",
        "email" => "raul.lozano@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "PTY Facturas OFR",
        "email" => "pty.facturasOFR@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Adriano Bonilla",
        "email" => "adriano.bonilla@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Davidga Mancilla",
        "email" => "davidga.mancillaal@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Arnulfo Castillo",
        "email" => "arnulfo.castillo2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Asistencia AFRI ONX",
        "email" => "Asistencia.afrionx@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jeniffer Betegon",
        "email" => "jeniffer.betegon@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Robert Baker",
        "email" => "robert.baker4@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Ariagna Peralta",
        "email" => "ariagna.peralta@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Migdalia Moreno",
        "email" => "Migdalia.Moreno@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jose Best",
        "email" => "jose.best@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Mitzuyany Martin",
        "email" => "mitzuyany.martin@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Carlos Diaznunez",
        "email" => "carlos.diaznunez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Marianela Pazmino",
        "email" => "marianela.pazmino@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yezkhel Romero",
        "email" => "yezkhel.romero@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Lenin Santamaria",
        "email" => "lenin.santamaria@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Lorian Romero",
        "email" => "Lorian.Romero2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alejandro Gonzalez",
        "email" => "alejandro.gonzalez5@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Thayra Paredes",
        "email" => "thayra.paredes@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Stephanie Crastz",
        "email" => "stephanie.crastz@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Felix Calderon",
        "email" => "felix.calderon@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Eliana Osorio",
        "email" => "eliana.osorio@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Jeffry Gonzalez",
        "email" => "jeffry.gonzalez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Elias Benitez",
        "email" => "elias.benitez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Eydilin Morelos",
        "email" => "eydilin.morelos@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yuliska Baker",
        "email" => "yuliska.baker@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Juan Diaz",
        "email" => "Juan.Diaz2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Iris Aparicio",
        "email" => "iris.aparicio@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Maritza Quiroz",
        "email" => "maritza.quiroz@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Rafael Caro",
        "email" => "Rafael.Caro@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alejandra Giron",
        "email" => "Alejandra.Giron@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ], */
    /* [
        "name" => "Lyriethe Macrine",
        "email" => "Lyriethe.Macrine@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Ricardo Trujillo",
        "email" => "ricardo.trujillo2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Edeishka Perinan",
        "email" => "edeishka.perinan@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Alexis Medina",
        "email" => "Alexis.Medina2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Madyulee Gonzalez",
        "email" => "madyulee.gonzalez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Milibet Quezada",
        "email" => "MilibetYaneli.QuezadaAtencio@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Orlando Oliveros",
        "email" => "Orlando.Oliveros@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Emily Escartin",
        "email" => "emily.escartin@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Leisha Laurie",
        "email" => "Leisha.Laurie@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Amelia Simmons",
        "email" => "Amelia.Simmons@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yeimi Rodriguez",
        "email" => "Yeimi.Rodriguez@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Astrid Aguilar",
        "email" => "astrid.aguilar@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yamilethsy Johnson",
        "email" => "y.johnson@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Delia Vargas",
        "email" => "delia.vargas@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Rosa Gonzalez",
        "email" => "r.gonzalez2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Horacio Guerrero",
        "email" => "horacio.guerrero@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Manuel De Gracia",
        "email" => "manuel.de.gracia@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Anette Salinas",
        "email" => "anette.salinas@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Cecibeth Somarriba",
        "email" => "cecibeth.somarriba@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Oriel Pilisi",
        "email" => "oriel.pilisi@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Rosa Saavedra",
        "email" => "rosa.saavedra@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Akira Ceballos",
        "email" => "akira.ceballos@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yatirca Cumberbatch",
        "email" => "Yatirca.CumberbatchPedroza@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Carlos Gonzalez",
        "email" => "carlos.gonzalez12@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Belkis Barria",
        "email" => "Belkis.Barria@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Melibeth Santamaria",
        "email" => "melibeth.santamaria@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Franklin Saldana",
        "email" => "franklin.saldana@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Edwin Gomez",
        "email" => "edwin.gomez3@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Daniel Rivera",
        "email" => "Daniel.Rivera2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Fernanda Beltran",
        "email" => "fernanda.beltran@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Roberto Castaneda",
        "email" => "roberto.castaneda2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Elvia Warden",
        "email" => "elvia.warden@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Vanessa Qiu",
        "email" => "vanessa.qiu2@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Yanaris Baules",
        "email" => "yanaris.baules@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Carlos Herrera",
        "email" => "carlos.herrera4@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Luis Flores",
        "email" => "luis.flores4@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Fernando Sevillano",
        "email" => "fernando.sevillano@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Mariel Meneses",
        "email" => "Mariel.Meneses@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
    [
        "name" => "Leyra Gallardo",
        "email" => "Leyra.Gallardo@dhl.com",
        "password" => "Admin1234",
        "grl_persona_id" => "2713495",
    ],
 */
        ];
        
        try {
            DB::beginTransaction();
            foreach ($users as $user) {
                $request = $this->requestCreateUser($user);
                if($request != 200)
                {
                    DB::rollBack();
                    return redirect()->back()->with('danger', 'Ocurrió un error con el usuario: '.$user['email'].'');
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Usuarios cargados correctamente');
        } catch (Exception $e) {
            DB::rollback();
            
            return redirect()->back()->with('danger', $e->getMessage());
        } 
    }

    public function requestCreateUser($user)
    {
        $body = [
            "name" => $user['name'],
            "email" => $user['email'],
            "password" => $user['password'],
            "grl_persona_id" => $user['grl_persona_id']
        ];

        $createUserResponse = Http::post(
            'https://api.multientregapanama.com/api/register',
            $body
        );

        $response = $createUserResponse->status();
        return $response;
    }
}  
