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
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('../css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('../css/material-bootstrap-wizard.css')}}">
    <link rel="stylesheet" href="{{asset('../css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('../css/AllinOne.css')}}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
		<link rel="shortcut icon" href="../images/logoat.jpg">
		<style>
				.moving-tab{
					width:102% !important;
				}
		</style>
</head>

<body>
    <div class="image-container set-full-height">


        <div class="container" id="container">
            <div class="row">
                <div class="col-sm-2 lateral" style="height: 100vh;">
                    <img id="imgLateralIzquierdo" src="../images/LATERAL-WEB.png" alt="hincha">
                </div>
                <div class="col-sm-8 mainContainer" style="z-index:1;">

                    <div class="wizard-container" style="padding-top:35px;">
                        <div class="card wizard-card" data-color="red" id="wizard"
                            style="background-color: #0F1B24;position: relative;">
                            <form action="" method="">
                                <div class="wizard-header" style="">
                                    <img id="headerLogoWEB" src="../images/HEAD-WEB.png" alt="hincha" />
                                    <img id="headerLogo" src="../images/HEAD-MOBIL.png" alt="hincha" />
                                </div>
                                <div class="wizard-navigation" id="ul1" style="height: 4vh;">
                                    <ul>
                                        <li><a href="#tickets" data-toggle="tab">Tiquetes</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content" style="background-color: #F3F3F3;height: 60vh;overflow-y: scroll">                                   
                                    <div class="tab-pane" id="tickets">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-offset-3">
                                                <!-- <h4 class="info-text"> Registre sus tickets.</h4> -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">confirmation_number</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">ID Tique</label>
                                                        <input id="txtTicket" name="" type="text" class="form-control"
                                                            autofocus>
                                                        <p style="display:none;color:red;font-size: 9px;border-top: 0;border-bottom: 0;margin-bottom: 0;margin-top: 0;padding-top: 0;padding-bottom: 0;line-height: 100%;"
                                                            id="txtErrorCelular">TICKET NO VALIDO</p>
                                                    </div>
                                                    <span class="input-group-addon" style="padding: 0px;">
                                                        <i id="btnAgregarTicket" class="material-icons"
                                                            style="font-size:30px;color:#ED1C24;cursor:pointer;padding-top: 20px;">add_box</i>
                                                    </span>
                                                </div>
                                            </div>                                                                                        
                                            <div class="col-sm-10 col-sm-offset-1" style="overflow-x: scroll;">
                                                <table id="example" class="table table-striped table-bordered"
                                                    style="width:100%"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-footer" style="height: 9vh;position:relative">
                                    <div class="pull-right">                                        
                                        <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' value='Imprimir' id="btnImprimir" style="position: absolute;bottom: 0;right: 10px;background-color: #0F1B24 !important;" />
                                    </div>                                    
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 lateral" style="height: 100vh;">
                    <img id="imgLateralDerecho" src="../images/LATERAL-WEB.png" alt="hincha">
                </div>
            </div>
        </div>

    </div>


<div class="modal" id="modal_imprimir" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Impresión</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="overflow:auto">
             <div style="text-align:center">
                <div id="divimpresion" style="box-shadow:0 0 10px black;width:80mm;margin:auto">
                    <div class="ticket" style="display:inline-block;font-size:10pt;width:80mm;padding:8mm">
                        <div class="titulo" style="width: 100%; text-align: center; display: flex; align-items: center;border-bottom:1px solid;padding-bottom:5px"><div style="width:100%">
                            <img id="imagen_apuestatotal" width="210" height="120" src="../images/logo.png">
                        </div></div>
                        <div class="datos" style="width:100%;display:table;padding-top:8pt;">
                            <div style="width:100%;border-top:2px dotted;display:table;font-size:14pt;padding-top:4pt">
                                        <div style="width:50%;float:LEFT;text-align:left">Ingrese ID Tique</div>
                                        <div style="width:50%;float:LEFT;text-align:right" id="IDTique"></div>
                            </div>
                            <div style="width:100%;display:table;border-top:2px dotted;padding-bottom:4px;padding-top:4px;font-size:14pt" id="datos_filas">
                            </div>
                        
                            <div style="width:100%;display:table;border-top:2px dotted;padding-top:4px" id="">
                                <div style="width:50%;float:LEFT;text-align:left;">Impreso En</div>
                                <div style="width:50%;float:LEFT;text-align:right" id="impreso_en"></div>
                            </div>
                        </div>
                        <div class="footer" style="width:100%;text-align:center"></div>
                       <!--  <div class="codigoqr_barra" style="width:100%;margin-bottom:8mm;display:table">
                            <div id="codigo_barra" style="float: LEFT; width:100%;padding-top:20px;text-align:center">
                                    <img id="imagen_codigobarra" >
                            </div>

                            
                        </div> -->

                    </div>
                </div>
            </div><!--FIN DIV WRAPPER-->
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnimprimir">Imprimir</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin:10px 1px">Cerrar</button>
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


<script src="{{asset('../js/vistas/Caja/Caja.js')}}"></script>


</html>