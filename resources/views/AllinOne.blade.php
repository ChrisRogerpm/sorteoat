<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Apuesta Total</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />	

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
  <link rel="stylesheet" href="{{asset('../css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('../css/material-bootstrap-wizard.css')}}">
  <link rel="stylesheet" href="{{asset('../css/jquery.dataTables.min.css')}}" />
  <link rel="stylesheet" href="{{asset('../css/AllinOne.css')}}" />
  
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="shortcut icon" href="../images/logoat.jpg">
</head>

<body >
	<div class="image-container set-full-height">	   

	    
	    <div class="container" id="container">
	        <div class="row">
						<div class="col-sm-2 lateral" style="height: 100vh;">
							<img id="imgLateralIzquierdo" src="../images/LATERAL-WEB.png" alt="hincha"  >						
						</div>		
		        <div class="col-sm-8 mainContainer" style="z-index:1;">
					
		            <div class="wizard-container" style="padding-top:35px;">
		                <div class="card wizard-card" data-color="red" id="wizard" style="background-color: #0F1B24;position: relative;">						
		                    <form action="" method="" >								
		                    	<div class="wizard-header" style="">		                        	
															<img id="headerLogoWEB" src="../images/HEAD-WEB.png" alt="hincha" />
															<img id="headerLogo" src="../images/HEAD-MOBIL.png" alt="hincha" />
		                    	</div>
													<div class="wizard-navigation" id="ul1" style="height: 4vh;">
														<ul>			                            
																<li id="anchorDatosUsuario"><a href="#captain" data-toggle="tab" data-guardar="0">Datos de Usuario</a></li>
																<li><a href="#tickets" data-toggle="tab">Tiquetes</a></li>
														</ul>
													</div>
		                        <div class="tab-content" style="background-color: #F3F3F3;height: 60vh;overflow-y: scroll">
		                            <div class="tab-pane" id="details">
		                            	<div class="row">
			                            	<div class="col-sm-12">
			                                	<h4 class="info-text"> Ingrese su Dni.</h4>
			                            	</div>
										<div class="col-sm-8 col-sm-offset-2">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">credit_card</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">DNI</label>
														  <input id="txtDni" name="txtDni" type="text" class="form-control">
														  <p style="display:none;color:red;font-size: 9px;border-top: 0;border-bottom: 0;margin-bottom: 0;margin-top: 0;padding-top: 0;padding-bottom: 0;line-height: 100%;" id="txtErrorDni">DNI NO VALIDO</p>
														  <input id="idCliente" type="hidden" value="{{$cliente->ID}}">														  
			                                        </div>
												</div>												

		                                	</div>		                                	
		                            	</div>
		                            </div>
		                            <div class="tab-pane" id="captain">
		                                <h4 class="info-text">Ingrese Sus Datos. </h4>
		                                <div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">email</i>
													</span>
													<div class="form-group label-floating">
														<label class="control-label">Correo Electronico</label>
														<input id="txtCorreoElectronico" name="name" type="text" class="form-control"  value="{{$cliente->email}}">
														<p style="display:none;color:red;font-size: 9px;border-top: 0;border-bottom: 0;margin-bottom: 0;margin-top: 0;padding-top: 0;padding-bottom: 0;line-height: 100%;" id="txtErrorCorreo">CORREO NO VALIDO</p>
			                                        </div>
												</div>

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">settings_cell</i>
													</span>
													<div class="form-group label-floating">
														<label class="control-label">Celular</label>
														<input id="txtCelular" name="name2" type="text" class="form-control"  value="{{$cliente->celular}}">
														<p style="display:none;color:red;font-size: 9px;border-top: 0;border-bottom: 0;margin-bottom: 0;margin-top: 0;padding-top: 0;padding-bottom: 0;line-height: 100%;" id="txtErrorCelular">CELULAR NO VALIDO</p>														  
			                                        </div>
												</div>

		                                	</div>		                                   
		                                </div>
		                            </div>
		                            <div class="tab-pane" id="tickets">
		                                <div class="row">												
											<div class="col-sm-4">
												<!-- <h4 class="info-text"> Registre sus tickets.</h4> -->
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">confirmation_number</i>
													</span>
													<div class="form-group label-floating">
														<label class="control-label">ID Tique</label>
														<input id="txtTicket" name="" type="text" class="form-control" autofocus> 
														<p style="display:none;color:red;font-size: 9px;border-top: 0;border-bottom: 0;margin-bottom: 0;margin-top: 0;padding-top: 0;padding-bottom: 0;line-height: 100%;" id="txtErrorCelular">TICKET NO VALIDO</p>														  
																							</div>
													<span class="input-group-addon" style="padding: 0px;">
														<i id="btnAgregarTicket" class="material-icons" style="font-size:30px;color:#ED1C24;cursor:pointer;padding-top: 20px;">add_box</i>
													</span>
												</div>												
											</div>	
											<div class="col-sm-4">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">account_circle</i>
													</span>
													<div class="form-group label-floating">
														<label class="control-label">Cliente</label>
														<input id="txtNombreCliente" name="" type="text" class="form-control" value="{{$cliente->nombre}}" readonly>
			                                        </div>
												</div>																									
											</div>	
											<div class="col-sm-4">														
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">trending_up</i>
													</span>
													<div class="form-group label-floating">
														<label class="control-label">Total Opciones</label>
														<input id="txtTotalOpciones" name="" type="text" class="form-control" value="{{$opciones->total}}" readonly>
			                                        </div>
												</div>											
		                                    </div>						
		                                    <div class="col-sm-10 col-sm-offset-1" style="overflow-x: scroll;">
												<table id="example" class="table table-striped table-bordered" style="width:100%"></table>
		                                    </div>		                                    
		                                </div>
		                            </div>
		                        </div>
	                        	<div class="wizard-footer" style="height: 9vh;position:relative">
	                            	<div class="pull-right">
	                                    <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Guardar'  id='btnSiguiente'/>
	                                    <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' value='Salir' id="btnTerminar"/>
	                                </div>
	                                <div class="pull-left">
																		<input type='button' id="btnCancelar" class='btn btn-next btn-fill btn-default btn-wd' name='next' value='Cancelar' />	
										@if($cliente->editado==0)
	                                    	<input type='button' id="btnDatosUsuario" class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Datos Usuario' />										
										@endif

										<!-- <div class="footer-checkbox">
											<div class="col-sm-12">
											  <div class="checkbox">
												  <label>
													  <input type="checkbox" name="optionsCheckboxes">
												  </label>
												  Terminos y condiciones.
											  </div>
										  </div>
										</div> -->
	                                </div>
	                                <div class="clearfix"></div>
	                        	</div>
							</form>
							<a href="{{ route('LogOut') }}"><i  id="btnLogOut" class="material-icons" style="position: absolute;top: 10px;right: 10px;color:#0F1B24;cursor:pointer;font-size: 36px;">exit_to_app</i></a>							
		                </div>
		            </div> 
						</div>
						<div class="col-sm-2 lateral" style="height: 100vh;">
							<img id="imgLateralDerecho" src="../images/LATERAL-WEB.png" alt="hincha"  >						
						</div>
	    	</div> 
		</div> 
	   
	</div>

</body>
	<!--   Core JS Files   -->
  <script src="{{asset('../js/jquery-2.2.4.min.js')}}"></script>
  <script src="{{asset('../js/bootstrap.min.js')}}"></script>
  <script src="{{asset('../js/jquery.bootstrap.js')}}"></script>
  <!-- <script src="{{url('../resources/js/jquery-3.3.1.js')}}"></script> -->
  <script src="{{asset('../js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('../js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('../js/sweetalert2.js')}}"></script>
  <script src="{{asset('../components/loadingoverlay/loadingoverlay.min.js')}}"></script>


	<!--  Plugin for the Wizard -->
  <script src="{{asset('../js/material-bootstrap-wizard.js')}}"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
  <script src="{{asset('../js/jquery.validate.min.js')}}"></script>  


  <script src="{{asset('../js/AllinOne.js')}}"></script>


</html>
