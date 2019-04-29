<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Models\Prueba,App\Models\TblUsuarios;
use App\Models\TblCliente;
use App\Models\Curl;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{    
    public function LoginCCVista()
    {
        return view('LoginCC');  
    }        
    public function LogOutCCJson()
    {
        session()->flush();
        return redirect()->route('LoginCC'); 
    }
    public static function ObtenerActivoUsuarioJson(){                 
        $mensaje_error = "";
        try {
            $usuario=TblUsuarios::ObtenerActivoUsuarioJson(session()->get('usuarioID'));    
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }        
        return response()->json(['data'=>$usuario]);  
    }
    public function ValidarLoginCCJson(Request $request)
    {                        
        $usuario= TblUsuarios::ValidarUsuarioJson($request);
        if($usuario){
            session()->put('usuarioID', $usuario->id);
            session()->put('perfilID', $usuario->perfil_id);
            return redirect()->route('Dashboard'); 
        }
        else{
            return back()->withErrors(['mensaje'=>'	Usuario, Contraseña no coinciden.'])->withInput();  
        }                                          
    }       
    public function ConsultarCliente(Request $request)
    {          
        $idCliente=0;
        $esRegistrado=false;
        $cliente = TblCliente::where('dni', $request->txtDni)->first();
        if ($cliente) {
            $esRegistrado=true;
            $object = (object) [
                'esRegistrado' => $esRegistrado,
                'cliente' =>  $cliente,
            ];
        }
        else{
            $respuestaReniec=$this->ObtenerDatosSunat($request->txtDni);            
            if($respuestaReniec->respuesta==true){
                $idCliente = DB::table('tbl_clientes')->insertGetId(
                    ['nombre' => $respuestaReniec->cliente->nombres.' '.$respuestaReniec->cliente->apellido_paterno.' '.$respuestaReniec->cliente->apellido_materno,'dni'=>$request->txtDni]
                );
                $object = (object) [
                    'esRegistrado' => $esRegistrado,
                    'idCliente' =>  $idCliente,
                ];
            }
            else{
                $mensajeError="Ingrese un Dni Valido";
            }
        }                
        return response()->json($object);        
    }
    public function ObtenerDatosSunat($txtDni){
        $respuesta=false;
        $client = new Client([            
            'timeout'  => 2.0,
        ]);    
        $response = $client->post('https://consulta.pe/api/reniec/dni', [
            'headers' => ['Content-Type' => 'application/json','Authorization'=>"Bearer UosGYrbAlY6PZnbOlilWJoSVobKEDJJJDIURVHlN"],
            'body' => json_encode([
                'dni' => $txtDni,
            ])
        ]);       
        $response=$response->getBody()->getContents();
        $arrResponseCli=json_decode($response);  
        if(property_exists($arrResponseCli,'nombres'))
        {
            $respuesta=true;
        }
        else
        {
            $respuesta=false;
        }
        $object = (object) [
            'respuesta' => $respuesta,
            'cliente' =>  $arrResponseCli,
        ];        
        return $object;
    }    
    public function EnvioCorreo()
    {
        $to_name = 'TO_NAME';
        $to_email = 'vh.vega@software3000.net';
        $data = array('name'=>"Sam Jose", "body" => "Test mail");
            
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Artisans Web Testing Mail');
            $message->from('victor.hugo.vega1@gmail.com','Artisans Web');
        });
        return response()->json(true);   
    }        
}
