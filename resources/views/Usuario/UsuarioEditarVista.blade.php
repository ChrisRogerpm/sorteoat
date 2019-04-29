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
                                                Editar Usuario
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
                    <input type="hidden" name="id" value="{{$Usuario->id}}">
                    <div class="row">


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtPerfil">Perfil</label>
                                <select class="form-control input-sm" name="cboPerfil" id="cboPerfil"
                                    style="margin-top: 7px;">
                                    <option value="">--Perfil--</option>
                                    <option value="0">Administrador</option>
                                    <option value="1">Cajero</option>
                                </select>
                                <input type="hidden" id="txtPerfil" value="{{$Usuario->perfil_id}}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Usuario</label>
                                <input value="{{$Usuario->nombre}}" type="text" class="form-control input-sm"
                                    name="txtNombre">
                            </div>
                        </div>

                        <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre Tienda</label>
                                    <input value="{{$Usuario->tienda_nombre}}" type="text" class="form-control input-sm" name="tienda">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Id tienda</label>
                                    <input value="{{$Usuario->tienda_id}}" type="text" class="form-control input-sm" name="tiendaId">
                                </div>
                            </div>
                             -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtEstado">Estado</label>
                                <select class="form-control input-sm" name="cboEstado" id="cboEstado"
                                    style="margin-top: 7px;">
                                        <option value="">--Estado--</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                </select>
                                <input type="hidden" id="txtEstado" value="{{$Usuario->estado}}">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('../js/vistas/Usuario/UsuarioEditar.js')}}"></script>
@endsection