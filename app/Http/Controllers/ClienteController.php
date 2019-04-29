<?php

namespace App\Http\Controllers;

//require  __DIR__.'vendor/autoload.php';
use App\Models\TblLogReniec;
use Tecactus\Reniec\DNI;
use Illuminate\Http\Request;
use App\Models\TblCliente, App\Models\TblConsolidadoOpcionesSorteo, App\Models\TblSorteo, App\Models\TblTerminosCondiciones, App\Models\TblUsuarioPj;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('preventBackHistory');
    }

    public function LoginVista()
    {
        session()->forget('cliente');
        return view('Login');
    }

    public function LogOutJson()
    {
        session()->flush();
        return redirect()->route('Login');
    }

    public function ActualizarClienteJson(Request $request)
    {
        $esActualizado = false;
        $mensaje_error = "";
        try {
            $esActualizado = tblCliente::ActualizarClienteJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['esActualizado' => $esActualizado, 'mensaje' => $mensaje_error]);
    }

    public function ValidarClienteJson(Request $request)
    {
        $nombres = "";
        $apPaterno = "";
        $apMaterno = "";
        $caracter_verificacion = -1;
        try {
            if ($this->ConsultarOfisisCliente($request->dni) == false) {
                $cliente = tblCliente::ValidarClienteJson($request);
                if (!$cliente) {

                    $reniecDni = new DNI('UosGYrbAlY6PZnbOlilWJoSVobKEDJJJDIURVHlN');
                    $esCorrecto=$reniecDni->validateDigit($request->dni, $request->verificacion);
                    if($esCorrecto){
                        $respuestaReniec = $this->ObtenerDatosReniec($request->dni);
                        if ($respuestaReniec->respuesta == true) {
                            $nombres = ucwords(strtolower($respuestaReniec->cliente->nombres));
                            $apPaterno = ucwords(strtolower($respuestaReniec->cliente->apellido_paterno));
                            $apMaterno = ucwords(strtolower($respuestaReniec->cliente->apellido_materno));
                            $caracter_verificacion = $respuestaReniec->cliente->caracter_verificacion;
                            if ($caracter_verificacion == $request->verificacion) {
                                if (!$cliente) {
                                    return redirect()->back()->with(
                                        [
                                            'dni' => '',
                                            'nombres' => $nombres,
                                            'apPaterno' => $apPaterno,
                                            'apMaterno' => $apMaterno,
                                            'verificacion' => '',
                                            'celular' => '',
                                            'email' => '',
                                            'terminos' => '',
                                            'guardar' => '',
                                            'form' => 'GuardarClienteJson',
                                        ]
                                    )->withInput();
                                } else {
                                    return $this->LoguearClienteJson($request);
                                }
                            } else {
                                return back()->withErrors(['error' => 'Codigo de Verificacion Incorrecto.'])->withInput();
                            }
                        } else {
                            return back()->withErrors(['error' => 'DNI no valido.'])->withInput();
                        }
                    }else{
                        return back()->withErrors(['error' => 'Codigo de Verificacion Incorrecto'])->withInput();
                    }                                        
                } else {
                    return $this->LoguearClienteJson($request);
                }
            } else {
                return back()->withErrors(['error' => 'usuario no participa.'])->withInput();
            }
        } catch (QueryException $ex) {
            return back()->withErrors(['error' => 'Erro en el Servidor.'])->withInput();
        }
    }

    public function LoguearClienteJson(Request $request)
    {
        $cliente = tblCliente::LoguearClienteJson($request);
        if (!$cliente) {
            return back()
                ->withErrors(['error' => 'Estas credenciales no concuerdan.'])->with(['verificacion' => ''])->withInput();
        } else {
            if ($cliente->verificacionCorreo == 1) {
                if ($cliente->bloqueado == 1) {
                    $fechaBloqueo = Carbon::parse($cliente->fechaBloqueo)->addDays(1)->format('Y-m-d G:i:s');
                    $fechaActual = Carbon::now()->format('Y-m-d G:i:s');
                    $fechaBloqueo = Carbon::parse($fechaBloqueo);
                    $fechaActual = Carbon::parse($fechaActual);
                    if ($fechaActual->greaterThanOrEqualTo($fechaBloqueo)) {
                        tblCliente::DesbloquearClienteJson($cliente->ID);
                        session()->put('cliente', 1);
                        return redirect()->route('RegistroT', ['id' => Crypt::encryptString($cliente->ID)]);
                    } else {
                        return back()
                            ->withErrors(['error' => 'Usuario Bloqueado hasta ' . $fechaBloqueo])->with(['verificacion' => ''])->withInput();
                    }
                } else {
                    session()->put('cliente', 1);
                    return redirect()->route('RegistroT', ['id' => Crypt::encryptString($cliente->ID)]);
                }
            } else {
                return back()
                    ->withErrors(['error' => 'Ingrese al link enviado a su Correo Electronico.'])->with(['verificacion' => ''])->withInput();
            }
        }
    }

    public function GuardarClienteJson(Request $request)
    {
        $idCliente = 0;
        $esRegistrado = false;
        try {
            $cliente = tblCliente::ValidarClienteJson($request);
            if ($cliente) {
                return view('Login');
            } else {
                $nombre = $request->nombres . ' ' . $request->apPaterno . ' ' . $request->apMaterno;
                $idCliente = tblCliente::InsertarClienteJson($request);
                $this->EnvioCorreo($idCliente, $nombre, $request->correo);
                return redirect()->back()->with(['revisarCorreo' => 'Se registró con éxito, revise su correo electrónico para verificar su cuenta.']);
            }
        } catch (QueryException $ex) {
            return view('Login');
        }
    }

    public function ObtenerDatosReniec($txtDni)
    {        
        $reniecDni = new DNI('UosGYrbAlY6PZnbOlilWJoSVobKEDJJJDIURVHlN');
        $arrResponseCli =$reniecDni->get($txtDni);
        print_r($arrResponseCli);
        if (property_exists($arrResponseCli, 'nombres')) {
            $respuesta = true;
            TblLogReniec::RegistrarLogReniec($txtDni, $respuesta);
        } else {
            $respuesta = false;
            TblLogReniec::RegistrarLogReniec($txtDni, $respuesta);
        }
        $object = (object)[
            'respuesta' => $respuesta,
            'cliente' => $arrResponseCli,
        ];        
        return $object;
    }

    public function ObtenerDatosJNE($txtDni)
    {
        $respuesta = false;
        $client = new Client([
            'base_uri' => 'http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI=' . $txtDni,
            'timeout' => 2.0,
        ]);
        $response = $client->request('GET');
        $response = $response->getBody()->getContents();
        $str_arr = explode("|", $response);
        if ($str_arr[0] != '') {
            $respuesta = true;
            //$respuesta=false;
        } else {
            $respuesta = false;
        }
        $object = (object)[
            'respuesta' => $respuesta,
            'cliente' => $str_arr,
        ];
        return $object;
    }

    public function EnvioCorreo($idCliente, $nombre, $correo)
    {
        $to_name = $nombre;
        $to_email = $correo;
        //$data = array('name'=>"Sam Jose", "body" => "Test mail","ruta" => "http://http://localhost:8000/RegistroT/"+Crypt::encryptString($idCliente));
        $data = array('nombre' => $nombre, "ruta" => "https://sorteos.apuestatotal.com/RegistroT/" . Crypt::encryptString($idCliente));

        Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Sorteo Apuesta Total');
            $message->from('victor.hugo.vega1@gmail.com', 'Apuesta Total');
        });
        return response()->json(true);
    }

    public function ObtenerTerminoCondicionClienteJson()
    {
        $lista = "";
        $mensaje = "";
        try {
            $lista = TblTerminosCondiciones::ObtenerTerminoCondicionJson();
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje]);
    }

    public function ConsultarOfisisCliente($dni)
    {
        $respuesta = false;
        $lista = TblUsuarioPj::ListarUsuarioPjJson();
        $esContenido = false;
        foreach ($lista as $usuario) {
            if ($usuario->dni == $dni) {
                $esContenido = true;
            }
        }
        if ($esContenido == true) {
            $respuesta = false;
        } else {
            $client = new Client([
                'base_uri' => 'http://181.65.130.34:5000/api/RRHH/ListEmployeeForDni?Dni=' . $dni,
                'timeout' => 2.0,
            ]);
            $response = $client->request('GET');
            $response = $response->getBody()->getContents();
            $arrResponseCli = json_decode($response);
            if (count($arrResponseCli) > 0) {

                $respuesta = true;
            } else {
                $respuesta = false;
            }
        }
        return $respuesta;
    }
}