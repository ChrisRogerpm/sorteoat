<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:37 -0500.
 */

namespace App\Models;
use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

/**
 * Class TblCliente
 * 
 * @property int $ID
 * @property int $tipo_cliente_id
 * @property string $ruc
 * @property string $dni
 * @property string $razon_social
 * @property string $nombre
 * @property string $email
 * @property string $telefono
 * @property string $celular
 * @property string $direccion
 * @property string $ubigeo_id
 * @property int $banco_id
 * @property int $moneda_id
 * @property string $numero_cuenta
 * @property int $representante_id
 * @property int $infocorp
 * @property string $como_se_entero
 * @property string $como_se_entero_des
 * @property int $estado
 *
 * @package App\Models
 */
class TblCliente extends Eloquent
{
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'tipo_cliente_id' => 'int',
		'banco_id' => 'int',
		'moneda_id' => 'int',
		'representante_id' => 'int',
		'infocorp' => 'int',
		'estado' => 'int',
		'verificacion'=>'int',
		'verificacionCorreo'=>'int',
		'editado'=>'int',
		'bloqueado'=>'int'		
	];

	protected $fillable = [
		'tipo_cliente_id',
		'ruc',
		'dni',
		'razon_social',
		'nombre',
		'email',
		'telefono',
		'celular',
		'direccion',
		'ubigeo_id',
		'banco_id',
		'moneda_id',
		'numero_cuenta',
		'representante_id',
		'infocorp',
		'como_se_entero',
		'como_se_entero_des',
		'estado',
		'verificacion',
		'verificacionCorreo',
		'editado',		
		'bloqueado',		
	];
	public static function ActualizarTicketClienteJson($idCliente,$intentos)
	{
		tblCliente::where('id', $idCliente)
		->update(['ticketsInvalidos'=>$intentos]); 
		return true;
	}
	public static function ActualizarAgrupadosTicketClienteJson($idCliente,$intentosAgrupados)
	{
		tblCliente::where('id', $idCliente)
		->update(['observacion_ticket_agrupado'=>$intentosAgrupados]); 
		return true;
	}
	public static function ActualizarClienteJson(Request $request)
	{
		tblCliente::where('id', $request->txtidCliente)
		->update(['celular' => $request->txtTelefono,'email' =>$request->txtCorreoElectronico,'editado'=>1]); 
		return true;
	}
	public static function ActualizarDNIClienteJson(Request $request)
	{
		tblCliente::where('id', $request->TxtIdCliente)
		->update(['celular' => $request->TxtCelular,'email' =>$request->TxtCorreo,'bloqueado' =>$request->chkBloqueado,'verificacionCorreo' =>$request->chkVerificacionCorreo]); 
		return true;
	}		
	public static function ObtenerClienteJson($id)
	{
		$cliente=DB::table('tbl_clientes')->where('id','=',$id)->first();	
        return $cliente;  
	}
	public static function ObtenerDniClienteJson($dni)
	{
		$cliente=DB::table('tbl_clientes')->where('dni','=',$dni)->first();	
        return $cliente;  
	}
	public static function ObtenerDniCorreoClienteJson(Request $request)
	{
		if($request->TxtDni != "" && $request->TxtCorreoBusqueda != ""){
			$cliente=DB::table('tbl_clientes')->where([['dni','=',$request->TxtDni],['email','=',$request->TxtCorreoBusqueda]])->first();	
		}
		else{
			if($request->TxtDni != ""){
				$cliente=DB::table('tbl_clientes')->where('dni','=',$request->TxtDni)->first();	
			}
			else{
				$cliente=DB::table('tbl_clientes')->where('email','=',$request->TxtCorreoBusqueda)->first();	
			}
		}
		//$cliente=DB::table('tbl_clientes')->where('dni','=',$dni)->first();	
        return $cliente;  
	}
	public static function ListarClienteJson()
	{		
		$clientes=DB::table('tbl_clientes')->inRandomOrder()->limit(55)->get();	
        return $clientes;  
	}
	public static function ValidarClienteJson(Request $request)
	{
		$cliente=DB::table('tbl_clientes')->where('dni','=',$request->dni)->first();	
        return $cliente;  
	}	
	public static function LoguearClienteJson(Request $request)
	{
		$cliente=DB::table('tbl_clientes')->where([['dni','=',$request->dni],['verificacion','=',$request->verificacion]])->first();	
        return $cliente;  
	}	
	public static function GuardarClienteJson(Request $request)
	{
		// $cliente=DB::table('tbl_clientes')->where('dni','=',$request->dni)->first();	
        // return $cliente;  
	}	
	public static function InsertarClienteJson(Request $request)
	{
		$idCliente=DB::table('tbl_clientes')->insertGetId(
			['nombre' => $request->nombres,'apellidoPaterno' => $request->apPaterno,'apellidoMaterno' => $request->apMaterno,'dni'=>$request->dni,'email'=>$request->correo,'celular'=>$request->celular,'verificacion'=>$request->verificacion,'verificacionCorreo'=>0,'bloqueado'=>0,'ticketsInvalidos'=>0,'observacion_ticket_agrupado'=>0]
		);	
        return $idCliente;  
	}
	public static function VerificarCorreClienteJson($id)
	{		
		$cliente=DB::table('tbl_clientes')->where('id','=',$id)->update(['verificacionCorreo'=>1]);	
        return $cliente;  
	}	
	public static function BloquearClienteJson($idCliente)
	{
		DB::table('tbl_clientes')->where('id','=',$idCliente)->update(['bloqueado'=>1,'fechaBloqueo'=>date('Y-m-d H:i:s')]);	
		return true;
	}	
	public static function DesbloquearClienteJson($idCliente)
	{
		DB::table('tbl_clientes')->where('id','=',$idCliente)->update(['bloqueado'=>0,'ticketsInvalidos'=>0]);	
		return true;
	}	
	public static function LimpiarTicketsInvalidosClienteJson($idCliente)
	{
		DB::table('tbl_clientes')->where('id','=',$idCliente)->update(['ticketsInvalidos'=>0]);	
		return true;
	}	
	public static function LimpiarObservacionesAgrupadasClienteJson($idCliente)
	{
		DB::table('tbl_clientes')->where('id','=',$idCliente)->update(['observacion_ticket_agrupado'=>0]);	
		return true;
	}			
	public static function ListadoClientesJson(Request $request)
	{
		
		$listar =DB::table('tbl_clientes')
			->get();
		return $listar;  
	}

	public static function ListadoClientesConsultaJson(Request $request)
	{
		$txtNombre= $request->txtNombre;
		$txtApellido= $request->txtApellido;
		$txtDni= $request->txtDni;

		$whereNombre = ($txtNombre=="") ? "" : "where c.nombre='".$txtNombre."'";

		$whereApellido =($txtNombre=="")?"where ":"or ";
		$whereApellido = ($txtApellido=="") ? "" : $whereApellido."c.apellidoPaterno='".$txtApellido."'";
		
		$whereDni =($whereApellido=="")?"where ":"or ";
		$whereDni = ($txtDni=="") ? "" : $whereDni."c.dni='".$txtDni."'";

		
		$listar = DB::select(DB::raw("SELECT *
        FROM tbl_clientes c
        $whereNombre
		$whereApellido
		$whereDni
		"));
		 return $listar;
	}
	public static function ObtenerTerminoCondicionClienteJson()
	{		
		$lista=DB::table('tbl_terminos_condiciones')->get()->first();	
		return $lista;
		//
	} 
}
