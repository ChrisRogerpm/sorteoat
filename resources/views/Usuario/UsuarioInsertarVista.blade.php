@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-body" style="padding-bottom: 10px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <div class="block-content-outer">
                                <div class="block-content-inner">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <h6>
                                                <i class="glyphicon glyphicon-th mr-2"></i>
                                                Registro de Usuario
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <button type="button" id="btnGuardar"
                                    class="btn btn-primary btn-sm col-md-12 col-xs-12">
                                    <span class="glyphicon glyphicon-file"></span> GUARDAR
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <a href="{{route('Usuario.Listar')}}"
                                    class="btn btn-success btn-sm col-md-12 col-xs-12"><span
                                        class="fa fa-arrow-circle-left"></span> VOLVER</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="panel panel-primary">
            <div class="panel-body">

                <form id="frmNuevo" autocomplete="off">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtPerfil">Perfil</label>
                                <select class="form-control" name="txtPerfil" id="txtPerfil" style="margin-top: 7px;">
                                    <option value="">--Perfil--</option>
                                    <option value="0">Administrador</option>
                                    <option value="1">Cajero</option>
                                </select>
                                
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNombre">Usuario</label>
                                <input type="text" class="form-control input-sm" id="txtNombre"  name="txtNombre">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtPassword">Contraseña</label>
                                <input type="text" class="form-control input-sm" id="txtPassword"  name="txtPassword">
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre Tienda</label>
                                    <input type="text" class="form-control input-sm" name="tienda">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Id tienda</label>
                                    <input type="text" class="form-control input-sm" name="tiendaId">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    
                                    <select class="form-control" name="cbestado" id="cbestado" >
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div> -->

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('../js/vistas/Usuario/UsuarioInsertar.js')}}"></script>
@endsection