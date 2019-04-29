@extends('layout')
@section('content')
<div class="col-xs-12 col-md-6" id="panelDatosUsuario"> 
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Datos Sorteo</div>           
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <input type="email" class="form-control" id="txtNombreSorteo" placeholder="Ingrese Nombre">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Descripcion</label>
                    <textarea  rows="6" type="password" class="form-control" id="txtDescripcionSorteo" placeholder="Ingrese Descripcion"></textarea>
                </div>   
                <div class="form-group">
                    <label for="exampleInputPassword1">RD</label>
                    <input type="email" class="form-control" id="txtRdSorteo" placeholder="Ingrese RD">
                </div>  
                <div class="form-group">
                    <label for="exampleInputPassword1">Fecha Inicio</label>
                    <div class='input-group date fechaSorteo' id=''>
                        <input type='text' class="form-control" id="txtFechaInicio" readonly/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="exampleInputPassword1">Fecha Fin</label>
                    <div class='input-group date fechaSorteo' id=''>
                        <input type='text' class="form-control" id="txtFechaFin" readonly/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>                           
            </form>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-6" id="panelDatosUsuario"> 
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Restricciones</div>           
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Descripcion</label>
                    <input type="text" class="form-control" id="txtDescripcionRestriccion" placeholder="Ingrese Descripción">
                </div>                 
                <div class="form-group">
                    <label for="exampleInputPassword1">Valor Apuesta</label>
                    <input type="text" class="form-control" id="txtValorApuesta" placeholder="Ingrese Valor Apuesta">
                </div> 
                <div class="form-group">
                    <label for="txtTiempoCaducidadTicket">Tiempo Caducidad Ticktet</label>
                    <input type="text" class="form-control" id="txtTiempoCaducidadTicket" placeholder="Ingrese Tiempo de Caducidad de Ticket">
                </div>  
                <div class="custom-checkbox custom-checkbox-info">
                    <input type="checkbox" id="chkRegiones">
                    <label for="chkRegiones">Por Regiones</label>
                </div>                                         
            </form>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-6" id="panelDatosUsuario"> 
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Beneficios</div>
            <a href="#" id="btnAgregarBeneficio">
                <i class="icon-theme icon-circle fa fa-plus icon-primary icon-theme-lg agregarBeneficio" style="position:absolute;right: 12px;top: 3px; width: 30px !important;height:30px !important;line-height:30px !important;top: 10px;"></i>        
            </a>   
        </div>
        <div class="panel-body">
            <form>
                <div id="contenedorBeneficios">
                    <div class="beneficio">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Descripcion</label>
                            <input type="email" class="form-control" id="txtDescripcionBeneficio" placeholder="Ingrese Descripción">                        
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tipo Beneficio</label>
                            <select class="form-control" id="cboBeneficios">                            
                            </select>
                        </div>     
                    </div> 
                    <div class="beneficio XRegion" style="display:none">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Descripcion</label>
                            <input type="email" class="form-control" id="txtDescripcionBeneficio1" placeholder="Ingrese Descripción">                        
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tipo Beneficio</label>
                            <select class="form-control" id="cboBeneficios1">                            
                            </select>
                        </div>     
                    </div>
                    <div class="beneficio XRegion" style="display:none">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Descripcion</label>
                            <input type="email" class="form-control" id="txtDescripcionBeneficio2" placeholder="Ingrese Descripción">                        
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tipo Beneficio</label>
                            <select class="form-control" id="cboBeneficios2">                            
                            </select>
                        </div>     
                    </div>
                    <div class="beneficio XRegion" style="display:none">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Descripcion</label>
                            <input type="email" class="form-control" id="txtDescripcionBeneficio3" placeholder="Ingrese Descripción">                        
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tipo Beneficio</label>
                            <select class="form-control" id="cboBeneficios3">                            
                            </select>
                        </div>     
                    </div>                                   
                </div>                                                                                                        
                <button id="btnGuardarSorteo" class="btn btn-success pull-right">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <!-- <script src="{{url('../resources/js/vistas/sorteo/nuevoSorteo.js')}}" ></script> -->
    <script src="{{asset('../js/vistas/sorteo/nuevoSorteo.js')}}"></script>
@endsection

