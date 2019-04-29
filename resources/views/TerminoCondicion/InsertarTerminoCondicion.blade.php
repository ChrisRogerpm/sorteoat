@extends('layout')
@section('content')
<div class="col-xs-12 col-md-12" id="panelDatosUsuario"> 
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Terminos y Condiciones</div>   
            <div class="panel-controls">
                <ul class="panel-buttons">
                    <li>
                        <a href="#" class="btn btn-primary btn-sm" id="btnGuardar"
                           style="margin-top: 10px;"><i class="fa fa-floppy-o pr-2"></i> Guardar</a>
                    </li>
                </ul>
            </div>                   
        </div>
        <div class="panel-body">
            <textarea name="" id="editor" cols="30" rows="30">
            </textarea>
        </div>
    </div>
</div>
@endsection
@section('scripts')    
    <script src="{{asset('../plugins/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('../js/vistas/TerminoCondicion/InsertarTerminoCondicion.js')}}"></script>
@endsection

