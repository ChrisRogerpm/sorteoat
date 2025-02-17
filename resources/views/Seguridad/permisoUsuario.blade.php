@extends('layout')
@section('content')    
    <link rel="stylesheet" href="{{asset('../css/Multiselect.css')}}">    
    <div class="col-xs-12 col-md-12">

        <!-- PANEL: Basic Example -->
        <div class="panel">

            <!-- Panel Heading -->
            <div class="panel-heading">

                <!-- Panel Title -->
                <div class="panel-title">Permisos</div>
                <!-- /Panel Title -->
                <div class="panel-controls">
                    <ul class="panel-buttons">
                        <li>
                            <select class="form-control" name="txtPerfil" id="txtPerfil" style="margin-top: 7px;">
                                <option value="">--Perfil--</option>
                                <option value="0">Administrador</option>
                                <option value="1">Cajero</option>
                            </select>
                        </li>
                        <li>
                            <a href="#" class="btn btn-primary btn-md" id="btnBuscar"
                               style="margin-top: 0px;"><i class="fa fa-search pr-2"></i> Permisos</a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-warning btn-md" id="btnBarrido"
                               style="margin-top: 0px;"><i class="fa fa-cog pr-2"></i> Recorrer</a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <table id="table" class="table table-bordered table-striped table-condensed" style="width:100%"></table>              
                    </div>                    
                </div>                

            </div>          
        </div>
    </div>

<div class="modal fade" id="modalAuditoria" tabindex="-1" role="dialog" aria-labelledby="default-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" data-border-top="multi">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="default-modal-label">Permisos</h4>
            </div>
            <div class="modal-body" id="bodyModal">
                <table class="table table-condensed table-striped table-bordered" style="display: none;">
                    <thead><tr><th colspan="3">Menu</th></tr></thead>
                    <tbody ><tr><td style="width: 80%">Nombre Menu</td><td style="width: 20%"><input type="checkbox" name="chkmenu_1"></td></tr></tbody>
                </table>
                <table class="table table-condensed table-striped table-bordered">
                    <thead><tr><th colspan="3">Permisos</th></tr><tr><th>Nombre</th><th>Metodo</th><th></th></tr></thead>
                    <tbody id="tbodyPermisos"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('scripts')
    <script src="{{asset('../js/lodash.min.js')}}"></script>
    <script src="{{asset('../js/vistas/Seguridad/PermisosUsuario.js')}}" ></script>
@endsection

