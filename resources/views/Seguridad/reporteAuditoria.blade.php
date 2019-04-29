@extends('layout')
@section('content')    
    <link rel="stylesheet" href="{{asset('../css/Multiselect.css')}}">    
    <div class="col-xs-12 col-md-12">

        <!-- PANEL: Basic Example -->
        <div class="panel">

            <!-- Panel Heading -->
            <div class="panel-heading">

                <!-- Panel Title -->
                <div class="panel-title">Reporte Auditoria</div>
                <!-- /Panel Title -->
                <div class="panel-controls">
                    <ul class="panel-buttons">
                        <li>
                            <a href="#" class="btn btn-primary btn-sm" id="btnBuscar"
                               style="margin-top: 10px;"><i class="fa fa-search pr-2"></i> Buscar</a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label>Usuarios</label>
                            <select class="form-control" name="txtUsuario" id="txtUsuario"><option>--Seleccione--</option></select>

                        </div>              
                    </div>
                    
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fecha Inicio</label>
                            <div class='input-group date' id=''>
                                <input type='text' class="form-control fechaSorteo" name="txtFechaInicio" id="txtFechaInicio" readonly/>
                                <span for="txtFechaInicio" class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>                
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fecha Fin</label>
                            <div class='input-group date' id=''>
                                <input type='text' class="form-control fechaSorteo" name="txtFechaFin" id="txtFechaFin" readonly/>
                                <span for="txtFechaFin" class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>               
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <table id="table" class="table table-bordered table-striped" style="width:100%"></table>              
                    </div>                    
                </div>                

            </div>          
        </div>
    </div>

<div class="modal medium-modal  fade" id="modalAuditoria" tabindex="-1" role="dialog" aria-labelledby="default-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <input type="hidden" name="hddModal" id="hddmodal" />
        <div class="modal-content" data-border-top="multi">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="default-modal-label">Data</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="bodyModalAuditoria">
                    
                </div>
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
    <script src="{{asset('../js/vistas/Seguridad/ReporteAuditoria.js')}}" ></script>
@endsection

