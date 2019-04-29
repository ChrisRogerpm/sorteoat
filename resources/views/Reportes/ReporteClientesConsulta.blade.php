@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('../css/Multiselect.css')}}">
<div class="col-xs-12 col-md-12">

    <!-- PANEL: Basic Example -->
    <div class="panel">

        <!-- Panel Heading -->
        <div class="panel-heading">

            <!-- Panel Title -->
            <div class="panel-title">Reporte Consulta de Clientes</div>
            <!-- /Panel Title -->
            <div class="panel-controls">
                <ul class="panel-buttons">
                    <li>
                        <a href="#" class="btn btn-primary btn-sm" id="btnConsultarCliente" style="margin-top: 10px;"><i
                                class="fa fa-search pr-2"></i> Buscar</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label for="txtNombre">Nombre</label>
                        <input type="text" class="form-control" id="txtNombre" placeholder="Ingrese Nombre del Cliente">
                    </div>
                </div>



                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label for="txtApellido">Apellido</label>
                        <input type="text" class="form-control" id="txtApellido" placeholder="Ingrese Apellido">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label for="txtDni">DNI</label>
                        <input type="text" class="form-control" id="txtDni" placeholder="Ingrese DNI">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <table id="table" class="table table-bordered table-striped" style="width:100%"></table>
                </div>
            </div>

        </div>


    </div>

</div>
@endsection
@section('scripts')
<script src="{{asset('../js/lodash.min.js')}}"></script>
<script src="{{asset('../js/vistas/Reportes/ReporteClientesConsulta.js')}}"></script>
@endsection