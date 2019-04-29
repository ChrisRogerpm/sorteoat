@extends('layout')
@section('content')
<div class="col-xs-12 col-md-6">
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Consulta Usuario Reniec</div>
        </div>
        <div class="panel-body">
            <form id="formConsultaDni" class="form-inline">                
                <div class="form-group">
                    <label class="sr-only" for="exampleInputPassword3">
                    </label>
                    <input placeholder="ingrese DNI" id="txtDni" name="txtDni" type="text" class="form-control" />
                    <input name="token" value="{{ csrf_token() }}" type="hidden" />
                </div>                
                <button id="btnConsultarDni" class="btn btn-primary">Consultar</button>
            </form>
        </div>
    </div>   
</div>
<div class="col-xs-12 col-md-6" id="panelValidacionTicket">    
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Validación Ticket</div>
        </div>
        <div class="panel-body">
            <form class="form-inline">                
                <div class="form-group">
                    <label class="sr-only" for="exampleInputPassword3">
                    </label>
                    <input placeholder="Nùmero de Ticket" id="txtTicket" name="txtTicket" type="text" class="form-control" />
                    <input name="token" value="{{ csrf_token() }}" type="hidden"/>
                </div>                
                <button id="" class="btn btn-primary">Valdiar</button>
            </form>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-6" id="panelDatosUsuario"> 
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Datos Usuario</div>           
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefono</label>
                    <input type="email" class="form-control" id="txtTelefono" placeholder="Ingrese Telefono">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Correo Electronico</label>
                    <input type="password" class="form-control" id="txtCorreoElectronico" placeholder="Ingrese Correo Electronico" />
                </div>                               
                <button id="btnGuardarDataUsuario" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{url('../resources/js/vistas/sorteos.js')}}" ></script>
@endsection

