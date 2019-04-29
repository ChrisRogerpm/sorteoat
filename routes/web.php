<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(array(), function()
{	                                   
	Route::get('/LoginCC', 'UsuarioController@LoginCCVista')->name('LoginCC');	
	Route::get('/EnvioCorreo', 'UsuarioController@EnvioCorreo');	
	Route::post('/ConsultarCliente', 'UsuarioController@UsuarioController');	
	Route::post('/ValidarLoginJsonFk','UsuarioController@ValidarLoginJson')->name('ValidarLoginJson');
	Route::post('/ValidarLoginCCJson','UsuarioController@ValidarLoginCCJson')->name('ValidarLoginCCJson');
	Route::get('/LogOutCC', 'UsuarioController@LogOutCCJson')->name('LogOutCC');	
	Route::get('/DatosUsuarioActivo', 'UsuarioController@ObtenerActivoUsuarioJson')->name('DatosUsuarioActivo');		

	Route::get('/AllinOne', 'SorteoController@SorteoActivoValidarJson');
	Route::get('/ListadoSorteo', 'SorteoController@SorteoListarVista');
	Route::get('/ConsultarIniciadoSorteoJson', 'SorteoController@ConsultarIniciadoSorteoJson');	
	Route::get('/NuevoSorteo', 'SorteoController@InsertarSorteoVista');
	Route::get('/AnimacionSorteo', 'SorteoController@AnimacionSorteo');	
	Route::post('/GuardarSorteo', 'SorteoController@SorteoInsertarJson');
	Route::post('/SorteoListarJson', 'SorteoController@SorteoListarJson');
	Route::post('/IniciarSorteoJson', 'SorteoController@IniciarSorteoJson');
		
	Route::post('/ConsultarTicket', 'TicketController@ConsultarTicketJson');
	Route::post('/ConsultarTickets', 'TicketController@ConsultarTicketsJson');
	Route::get('/RegistroT/{id}', 'TicketController@SorteoActivoValidarJson')->name('RegistroT');

	Route::get('/', 'ClienteController@LoginVista')->name('Login');
	Route::get('/LogOut', 'ClienteController@LogOutJson')->name('LogOut');
	Route::get('/ObtenerTerminoCondicionClienteJson','ClienteController@ObtenerTerminoCondicionClienteJson');	
	Route::post('/ValidarClienteJson','ClienteController@ValidarClienteJson')->name('ValidarClienteJson');
	Route::post('/GuardarClienteJson','ClienteController@GuardarClienteJson')->name('GuardarClienteJson');	
	Route::post('/GuardarDatosUsuario', 'ClienteController@ActualizarClienteJson');
	//Route::get('/ObtenerDatosReniec/{txtDni}', 'ClienteController@ObtenerDatosReniec');

	Route::get('/cajeros', 'CajaController@RegistroTicketsVista');
	Route::post('/GenerarTicketAgrupadoJson', 'CajaController@GenerarTicketAgrupadoJson');	
	
	Route::get('/ReporteClientes', 'ReporteController@ReporteClientes');	
	Route::get('/ReporteGanadores', 'ReporteController@ReporteGanadores');	
	Route::get('/ReporteOpcionesSorteos', 'ReporteController@ReporteOpcionesSorteos');
	Route::post('/ListadoClientesJson','ReporteController@ListadoClientesJson');	
	Route::get('/ReporteLocales','ReporteController@ReporteLocales');
	Route::get('/ListadoAuditoria', 'ReporteController@ReporteAuditoriaVista');
	Route::get('/ListadoLocalesJson','ReporteController@ListadoLocalesJson');
	Route::post('/ReporteClientesJson', 'ReporteController@ReporteClientesJson');
	Route::post('/ReporteGanadoresJson', 'ReporteController@ReporteGanadoresJson');	
	Route::post('/ReporteOpcionesSorteosJson', 'ReporteController@ReporteOpcionesSorteosJson');
	Route::post('/ReporteLocalesJson', 'ReporteController@ReporteLocalesJson');    	
	Route::post('/ListdoAuditoriaJson', 'ReporteController@ReporteAuditoriaJson');

	//Route::get('/datos', 'GeneradorController@ObtenerAleatorio');

	Route::post('/ListadoTipoBeneficio', 'TipoBeneficioController@Listado');

	Route::post('/ListadoBeneficioJson','BeneficioController@ListadoBeneficioJson');

	Route::get('/Dashboard', 'HomeController@Home')->name('Dashboard');

	Route::get('/EditarClienteVista', 'SoporteController@EditarClienteVista')->name('EditarClienteVista');	
	Route::post('/BuscarClientesJson', 'SoporteController@BuscarClientesJson')->name('BuscarClientesJson');	
	Route::post('/ActualizarDNIClienteJson', 'SoporteController@ActualizarDNIClienteJson')->name('ActualizarDNIClienteJson');			
	
	Route::get('/EditarTerminosCondiciones', 'TerminoCondicionController@EditarTerminosCondicionesVista');
	Route::post('/InsertarTerminoCondicionJson', 'TerminoCondicionController@InsertarTerminoCondicionJson');	
	Route::get('/ObtenerTerminoCondicionJson', 'TerminoCondicionController@ObtenerTerminoCondicionJson');		

	// REPORTE CONSULTA CLIENTES
	
	Route::get('/ReporteClientesConsulta', 'ReporteController@ReporteClientesConsulta');
	Route::post('/ListadoClientesConsultaJson','ReporteController@ListadoClientesConsultaJson');
	// FIN REPORTE CONSULTA CLIENTES
});

//seguridad
Route::get('/ListdoPermisos', 'SeguridadController@PermisosUsuarioVista');
Route::post('/ListdoPermisosPerfil', 'SeguridadController@PermisoPerfilListarJson');
Route::post('/PermisoPerfilCheck', 'SeguridadController@PermisoPerfilJson');
///inicio sin seguridad
Route::post('/ListdoUsuariosSelectFk', 'SeguridadController@UsuarioListarJson');
Route::get('/BarridoPermisosFk', 'SeguridadController@BarridoPermisos');
Route::post('/DataAuditoriaRegistroFk', 'SeguridadController@DataAuditoriaJson');

#region [Usuario]
Route::get('/UsuarioListar', 'SeguridadController@UsuarioListarVista')->name('Usuario.Listar');
Route::get('/UsuarioInsertar', 'SeguridadController@UsuarioInsertarVista')->name('Usuario.Insertar');
Route::get('/UsuarioEditar/{idUsuario}', 'SeguridadController@UsuarioEditarVista')->name('Usuario.Editar');

Route::post('UsuarioListarJson', 'SeguridadController@UsuarioListarJson');
Route::post('UsuarioInsertarJson', 'SeguridadController@UsuarioInsertarJson');
Route::post('UsuarioEditarJson', 'SeguridadController@UsuarioEditarJson');
#endregion

//fin sin seguridad
Route::post('/CambiarPerfilUsuario', 'SeguridadController@ActualizarPerfilUsuario');

