@extends('layout')
@section('content')                
    <div class="col-xs-12 col-md-12">

        <!-- PANEL: Basic Example -->
        <div class="panel">

            <!-- Panel Heading -->
            <div class="panel-heading" style="height: 50px;">

                <!-- Panel Title -->
                <div class="panel-title"></div>
                <!-- /Panel Title -->
                <div class="panel-controls">
                    <ul class="panel-buttons">
                        <li>
                            <a href="#" class="btn btn-primary btn-sm" id="btnBuscar" style="margin-top: 10px;"><i class="fa fa-search pr-2"></i> Buscar</a>
                            <a href="#" class="btn btn-primary btn-sm" id="btnLimpiar" style="margin-top: 10px;"><i class="fa fa-eraser pr-2"></i> Limpiar</a>
                            <a href="#" class="btn btn-success btn-sm" id="btnGuardar" style="margin-top: 10px;"><i class="fa fa-floppy-o pr-2"></i> Guadar</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">       
                    <input type="hidden" id="TxtIdCliente" >
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="txtNombre">DNI</label>
                            <input type="text" class="form-control" id="TxtDni" placeholder="Ingrese DNI del Cliente">
                        </div>
                    </div>   
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="txtCorreo">Correo</label>
                            <input type="text" class="form-control" id="TxtCorreoBusqueda" placeholder="Ingrese Correo del Cliente">                           
                        </div>
                    </div>                    
                </div>
                <hr />   
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="TxtCorreo">Correo</label>
                            <input type="text" class="form-control" id="TxtCorreo" placeholder="Correo Electronico" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="TxtCelular">Celular</label>
                            <input type="text" class="form-control" id="TxtCelular" placeholder="Celular" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="custom-checkbox custom-checkbox-primary" style="margin-top: 30px;">
                            <input type="checkbox" id="chkBloqueado" disabled>
                            <label for="chkBloqueado" style="">Bloqueado</label>
                        </div> 
                    </div> 
                    <div class="col-xs-12 col-sm-3">
                        <div class="custom-checkbox custom-checkbox-primary" style="margin-top: 30px;">
                            <input type="checkbox" id="chkVerificacionCorreo" disabled>
                            <label for="chkVerificacionCorreo" >Verificacion Correo</label>
                        </div> 
                    </div>                   
                </div>                            
            </div>
            
        </div>

    </div>
@endsection
@section('scripts')    
    <script src="{{asset('../js/vistas/Cliente/EditarClienteVista.js')}}" ></script>
@endsection

