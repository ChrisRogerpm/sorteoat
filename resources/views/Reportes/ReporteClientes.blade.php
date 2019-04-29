@extends('layout')
@section('content')            
    <link rel="stylesheet" href="{{asset('../css/Multiselect.css')}}">    
    <div class="col-xs-12 col-md-12">

        <!-- PANEL: Basic Example -->
        <div class="panel">

            <!-- Panel Heading -->
            <div class="panel-heading">

                <!-- Panel Title -->
                <div class="panel-title">Reporte Clientes</div>
                <!-- /Panel Title -->
                <div class="panel-controls">
                    <ul class="panel-buttons">
                        <li>
                            <a href="#" class="btn btn-primary btn-sm" id="btnGuardarSorteo"
                               style="margin-top: 10px;"><i class="fa fa-search pr-2"></i> Buscar</a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="dropdown-container1" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                            <div class="dropdown-button1 noselect" style="margin-top: 4px !important;">
                                <div class="dropdown-label1">Locales</div>
                                <div class="dropdown-quantity1">(<span class="quantity">Todos</span>)</div>
                                    <i class="fa fa-filter"></i>
                            </div>
                            <div class="dropdown-list1" style="display: none;">
                                <input id="idLocales"type="search" placeholder="Buscar" class="dropdown-search" style="width: 100%;border-radius: 5px;"/>
                                <ul id="ulLocales"></ul>
                            </div>
                        </div>               
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="dropdown-container2" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                            <div class="dropdown-button2 noselect" style="margin-top: 4px !important;">
                                <div class="dropdown-label2">Juegos</div>
                                <div class="dropdown-quantity2">(<span class="quantity2">Todos</span>)</div>
                                    <i class="fa fa-filter"></i>
                            </div>
                            <div class="dropdown-list2" style="display: none;">
                                <input id="idJuegos"type="search" placeholder="Buscar" class="dropdown-search2" style="width: 100%;border-radius: 5px;"/>
                                <ul id="uljuegos"></ul>
                            </div>
                        </div>                  
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fecha Inicio</label>
                            <div class='input-group date fechaSorteo' id=''>
                                <input type='text' class="form-control" id="txtFechaInicio" readonly/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>                
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fecha Fin</label>
                            <div class='input-group date fechaSorteo' id=''>
                                <input type='text' class="form-control" id="txtFechaFin" readonly/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>               
                    </div>
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
                <hr />
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
    <script src="{{asset('../js/vistas/Reportes/ReporteClientes.js')}}" ></script>
@endsection

