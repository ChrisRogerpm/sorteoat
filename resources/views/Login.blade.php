<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from vtdes.ru/demo/caspero/xp-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Jan 2019 14:02:27 GMT -->
<head>

    <!-- Page title -->
    <title>Apuesta Total</title>
    <!-- /Page title -->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- /Meta -->

    <!-- SEO Meta -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- /SEO Meta -->

    <!-- OpenGraph meta -->
    <meta property="og:image" content="">
    <meta property="og:title" content="og title">
    <meta property="og:description" content="og description">    
    <!-- /OpenGraph meta -->

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/logoat.jpg">
    <!-- /Favicon -->

    <!-- AppleTouch Icons -->
    <link rel="apple-touch-icon" href="#">
    <link rel="apple-touch-icon" href="#" sizes="57x57">
    <link rel="apple-touch-icon" href="#" sizes="72x72">
    <link rel="apple-touch-icon" href="#" sizes="76x76">
    <link rel="apple-touch-icon" href="#" sizes="114x114">
    <link rel="apple-touch-icon" href="#" sizes="120x120">
    <link rel="apple-touch-icon" href="#" sizes="144x144">
    <link rel="apple-touch-icon" href="#" sizes="152x152">
    <link rel="apple-touch-icon" href="#" sizes="180x180">
    <!-- /AppleTouch Icons -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('../css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('../css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('../css/login.css')}}">
    <link rel="stylesheet" href="{{asset('../components/toastr/toastr.min.css')}}">
    <!-- /Styles -->

</head>
<body class="">
<div id="contenedorBoton" style="position:fixed;left:50%; z-index: 10000; display:none;">
    <button id="btncloseModal" type="button" class="close" data-dismiss="modal" aria-label="Close" style="height: 50px;font-size: 40px;top: 32px;width: 50px;border-radius: 50%;border: solid;position:relative;left:-50%;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!-- MAIN CONTAINER -->
<main class="main-container no-margin no-padding">

    <!-- FULLSCREEN -->
    <div class="fullscreen">

        <!-- VERTICAL MIDDLE -->
        <div class="">

            <!-- CONTENT AREA -->
            <div class="content container">

                <div class="row">
                    <div class="col-xs-12 imgHeaderWeb" style="text-align:center;">
                        <img id="imgTeLlevamosWeb" src="images/TE-LLEVAMOS-A-LA-COPA-AMERICA.png" alt="hincha">                           
                    </div>
                    <div class="col-xs-12 imgHeaderMobile" style="text-align:center;display:none;">
                        <img id="imgTeLlevamosMobile" src="images/TE-LLEVAMOS-A-LA-COPA-AMERICA.png" alt="hincha">                           
                        <img id="headerLogo" src="images/hincha.png" alt="hincha"  >                                                  
                    </div>
                    <div class="col-md-3 lateral">
						<img id="imgLateralIzquierdo" src="../images/LATERAL-WEB.png" alt="hincha"  />						
                    </div>
                    <div class="col-xs-12 col-md-6" style="font-size: 17px !important;z-index:1">

                        <!-- PANEL: Authorization -->
                        <div class="panel">

                            <!-- Panel Body -->
                            <div class="panel-body">

                                <div class="image mb text-center">
                                    <div style="width:80%;margin: 0 auto;">
                                        <img src="images/Logotipo-Horizontal-2258x662.png" alt="CasperoBoard" id="logoApuestaTotal" style="padding-top: 20px;padding-bottom: 20px;">         
                                        @if(session()->has('revisarCorreo'))
                                            <p style="font-family: Helvetica, Arial, sans-serif;">{{ \Session::get('revisarCorreo') }}</p>  
                                        @endif
                                    </div>
                                </div>        

                                @if(session()->has('revisarCorreo'))
                                    <!-- <p style="font-family: Helvetica, Arial, sans-serif;">{{ \Session::get('revisarCorreo') }}</p>                                                                                                           -->
                                @else
                                    @if(session()->has('form'))
                                        <form id="formClienteDatos" method="POST" action="{{ route(\Session::get('form')) }}">                                                                                                          
                                    @else
                                        <form id="formDni" method="POST" action="{{ route('ValidarClienteJson') }}">                                
                                    @endif 
                                                                                                                                        
                                        {{ csrf_field() }}
                                        @if(session()->has('verificacion'))
                                            <div class="form-group">
                                                <label for="login" style="display: block;">DNI - Carácter De Verificación</label>
                                                <input type="text" value="{{ old('dni')}}" style="width:78%;display: inline;" id="TxtDni" class="form-control input-sm" placeholder="Ingrese DNI" name="dni" required="required" readonly>
                                                <input type="text" value="{{ old('verificacion')}}" style="width:20%;display: inline;" id="TxtVerific" class="form-control input-sm" placeholder="" name="verificacion" required="required" readonly>
                                            </div>    
                                        @else
                                            <div class="form-group">
                                                <label for="login" style="display: block;font-size: 20px;">DNI - Carácter De Verificación</label>
                                                <input type="text" value="{{ old('dni')}}" style="width:78%;display: inline;" id="TxtDni" class="form-control input-lg" placeholder="Ingrese DNI" name="dni" required="required" autocomplete="off" autofocus >
                                                <input type="text" value="{{ old('verificacion')}}" style="width:20%;display: inline;" id="TxtVerific" class="form-control input-lg" placeholder="" name="verificacion" required="required" data-toggle="tooltip" data-placement="top" data-html="true" title="<img id='imgdni' class='veri' src=&quot;images/cverificador1.png&quot;>" autocomplete="off">
                                            </div>                                          
                                        @endif                                                                                                                                                                                     
                                        @if(session()->has('nombres'))
                                            <div class="form-group">
                                                <label for="password">Nombres</label>
                                                <input value="{{ session('nombres') }}" type="text" id="TxtNombres" class="form-control input-sm" placeholder="Ingrese Numero de Celular" name="nombres" required="required" readonly>
                                            </div>                                       
                                        @endif
                                        @if(session()->has('apPaterno'))
                                            <div class="form-group">
                                                <label for="password">Apellido Paterno</label>
                                                <input value="{{ session('apPaterno') }}" type="text" id="TxtApPaterno" class="form-control input-sm" placeholder="Ingrese Numero de Celular" name="apPaterno" required="required" readonly>
                                            </div>                                       
                                        @endif
                                        @if(session()->has('apMaterno'))
                                            <div class="form-group">
                                                <label for="password">Apellido Materno</label>
                                                <input value="{{ session('apMaterno') }}" type="text" id="TxtApMaterno" class="form-control input-sm" placeholder="Ingrese Numero de Celular" name="apMaterno" required="required" readonly>
                                            </div>                                       
                                        @endif                                        
                                        @if(session()->has('email'))
                                            <div class="form-group">
                                                <label for="password">Correo Electronico</label>
                                                <input type="text" id="TxtEmail" class="form-control input-sm" placeholder="Ingrese Correo Electronico" name="correo" required="required">
                                                <span id="txtErrorEmail" class="help-block" style="color:#ED1C24;display:none;width: 100%;font-family: Helvetica, Arial, sans-serif;text-transform: uppercase;font-size: 10px;margin-bottom: 0px!important;">Ingrese un Correo Valido.</span>
                                            </div>                                        
                                        @endif   
                                        @if(session()->has('celular'))
                                            <div class="form-group">
                                                <label for="password">Numero Celular</label>
                                                <input type="text" id="TxtCelular" class="form-control input-sm" placeholder="Ingrese Numero de Celular" name="celular" required="required">
                                                <span id="txtErrorCelular" class="help-block" style="color:#ED1C24;display:none;width: 100%;font-family: Helvetica, Arial, sans-serif;text-transform: uppercase;font-size: 10px;margin-bottom: 0px!important;">Ingrese un Celular Valido.</span>
                                            </div>                                       
                                        @endif   
                                        <!-- <div class="form-group">
                                            <img src="images/cverificador1.png" alt="CasperoBoard" style="" />
                                        </div>                                                                   -->
                                        @if(session()->has('terminos'))
                                        <div class="custom-checkbox custom-checkbox-default">
                                            <input type="checkbox" id="chkTerminosyCondiciones">
                                            <label for="chkTerminosyCondiciones" style="font-size: 15px !important;top:3px !important;"></label>
                                            <label for="" style="font-size: 15px !important;cursor:pointer" data-toggle="modal" data-target="#exampleModal">Acepto Terminos y Condiciones (ver)</label>
                                        </div>  
                                        @endif  
                                        {!! $errors->first('error','<span class="help-block" style="color:#ED1C24;width: 100%;font-family: Helvetica, Arial, sans-serif;text-transform: uppercase;font-size: 10px;">:message</span>') !!}                                        
                                        @if(session()->has('guardar'))
                                            <button type="submit" id="btnGuardarFormulario1" class="btn btn-primary btn-block btnIngreso" style="background: #00000F;border-color: #00000F;">Registrar</button>                                                                       
                                        @else
                                            <button type="submit" id="btnEnviarFormulario" class="btn btn-primary btn-block btn-lg btnIngreso" style="background: #00000F;border-color: #00000F;font-size: 25px !important;">INGRESAR</button>                              
                                        @endif  
                                    </form>                              
                                @endif                                     

                            </div>
                            <!-- /Panel Body -->

                        </div>
                        <!-- /PANEL: Authorization -->

                        <!-- Copyright -->
                        <!-- <p class="text-muted text-center">
                            &copy; Copyright 2017 <strong>Valery Timofeev</strong> | All Rights Reserved
                        </p> -->
                        <!-- /Copyright -->

                    </div>
                    <div class="col-md-3 lateral">
						<img id="imgLateralDerecho" src="../images/LATERAL-WEB.png" alt="hincha"  />						
                    </div>                    
                </div>

            </div>
            <!-- /CONTENT AREA -->

        </div>
        <!-- /VERTICAL MIDDLE -->

    </div>
    <!-- /FULLSCREEN -->

</main>
<!-- /MAIN CONTAINER -->
<!-- MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <h5 class="modal-title" id="exampleModalLabel">Terminos y Condiciones</h5>
      </div>
      <div class="modal-body" id="cuerpoModal">       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /MODAL -->

<!-- SCRIPTS -->
<script src="{{asset('../js/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('../components/jquery-ui/jquery-ui.min.js')}} "></script>
<script src="{{asset('../js/bootstrap.min.js')}}"></script>
<script src="{{asset('../js/moment-with-locales.js')}}"></script>
<script src="{{asset('../js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('../js/jquery.stellar.min.js')}} "></script>
<script src="{{asset('../js/jquery.magnific-popup.min.js')}} "></script>
<script src="{{asset('../js/pnotify.custom.min.js')}} "></script>
<script src="{{asset('../js/owl.carousel.min.js')}} "></script>
<script src="{{asset('../js/jquery.validate.min.js')}} "></script>
<script src="{{asset('../js/jquery.animateNumber.min.js')}} "></script>
<script src="{{asset('../js/Chart.min.js')}} "></script>
<script src="{{asset('../js/sweetalert.min.js')}} "></script>
<script src="{{asset('../js/circle-progress.min.js')}} "></script>
<script src="{{asset('../components/jstree/jstree.min.js')}} "></script>
<script src="{{asset('../js/fullcalendar.min.js')}} "></script>
<script src="{{asset('../components/toastr/toastr.min.js')}}"></script>
<script src="{{asset('../components/loadingoverlay/loadingoverlay.min.js')}}"></script>
<script src="{{asset('../js/Login.js')}} "></script>
<!-- /SCRIPTS -->


</body>

<!-- Mirrored from vtdes.ru/demo/caspero/xp-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Jan 2019 14:02:28 GMT -->
</html>