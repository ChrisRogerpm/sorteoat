@extends('layout')
@section('content')
    <div class="col-xs-12 col-md-12">

        <!-- PANEL: Basic Example -->
        <div class="panel">

            <!-- Panel Heading -->
            <div class="panel-heading">

                <!-- Panel Title -->
                <div class="panel-title">Listado Sorteos</div>
                <!-- /Panel Title -->
                <!-- <div class="panel-controls">
                    <ul class="panel-buttons">
                        <li>
                            <a href="" class="btn btn-primary btn-sm"
                               style="margin-top: 10px;"><i class="fa fa-file pr-2"></i> NUEVO</a>
                        </li>
                    </ul>
                </div> -->

            </div>

            <div class="panel-body" style="overflow: scroll;">

                <table id="table" class="table table-bordered table-striped" style="width:100%"></table>

            </div>

        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{asset('../js/vistas/sorteo/ListadoSorteo.js')}}" ></script>
@endsection

