$(document).ready(function () {   
    llenarSelect(basePath + "ListadoTipoBeneficio", {}, "cboBeneficios", "id", "descripcion");
    llenarSelect(basePath + "ListadoTipoBeneficio", {}, "cboBeneficios1", "id", "descripcion");
    llenarSelect(basePath + "ListadoTipoBeneficio", {}, "cboBeneficios2", "id", "descripcion");
    llenarSelect(basePath + "ListadoTipoBeneficio", {}, "cboBeneficios3", "id", "descripcion");
    if ($('#chkRegiones').is(':checked')==true) 
    {   
        $(".XRegion").show(); 
        $(".icon-theme-lg").hide('slow');                    
    }
    $('#chkRegiones').click(function(){
        if ($('#chkRegiones').is(':checked')==true) 
        {   
            $(".creado").remove();
            $(".XRegion").show('slow');                    
            $(".icon-theme-lg").hide('slow');                    
        }
        else
        {
            $(".XRegion").hide('slow');                    
            $(".icon-theme-lg").show('slow');                    
        }
    });
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;
    $("#txtFechaInicio").val(output + " 00:01");
    $("#txtFechaFin").val(output + " 00:01");
    
    $('.fechaSorteo').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
    });    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });   
    $("form").submit(function(e){
        return false;
    });     
    $('#btnAgregarBeneficio').on('click', function (e) {             
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));        
        var beneficioHTML="<div id='div"+text+"' style='display:none;' class='beneficio creado'><div id='"+text+"' class='form-group col-md-6'><label>Descripcion</label><input type='email' class='form-control' placeholder='Ingrese Descripción'></div><div class='form-group col-md-6'><label>Tipo Beneficio</label><select class='form-control' id='cbo"+text+"'></select></div></div>";
        $("#contenedorBeneficios").append(beneficioHTML);           
        llenarSelect(basePath + "ListadoTipoBeneficio", {}, "cbo"+text, "id", "descripcion");
        $("#div"+text).show("slow");
    });   
    $('#btnGuardarSorteo').on('click', function (e) {                   
        e.preventDefault();                
        var txtNombreSorteo = $("#txtNombreSorteo").val();             
        var txtDescripcionSorteo = $("#txtDescripcionSorteo").val();             
        var txtRdSorteo = $("#txtRdSorteo").val();             
        var txtFechaInicio = $("#txtFechaInicio").val();             
        var txtFechaFin = $("#txtFechaFin").val();             
        var txtDescripcionRestriccion = $("#txtDescripcionRestriccion").val();             
        var txtValorApuesta = $("#txtValorApuesta").val();  
        var txtTiempoCaducidadTicket = $("#txtTiempoCaducidadTicket").val(); 
        var txtPorRegiones =0; 
        if ($('#chkRegiones').is(':checked')==true) 
        {   
            txtPorRegiones =1; 
        }         
        var arrBeneficios =[];                     
        $('.beneficio').each(function(i, obj) {            
            var descBeneficio=$(obj).find('input').val();
            var tipoBeneficio=$(obj).find('select').val();
            if(descBeneficio!='' && tipoBeneficio!=''){
                arrBeneficios.push(
                    {
                        'beneficioDescripcion':descBeneficio,
                        'tipoBeneficioId':tipoBeneficio
                    });
            }              
        });              
        var esvalido=validarInputs(arrBeneficios);             
        if(esvalido.response==false){            
            toastr.error(esvalido.mensaje, "Mensaje Servidor");     
            return false;            
        }         
        var dateIni = new Date($("#txtFechaInicio").val());
        var dateFin = new Date($("#txtFechaFin").val());
        if(dateIni>dateFin){
            toastr.error("La Fecha de Inicio no puede ser mayor a la fecha Fin del Sorteo.", "Mensaje Servidor");     
            return false;
        }
        $.ajax({
            url: "/GuardarSorteo",
            data:{
                txtNombreSorteo:txtNombreSorteo,
                txtDescripcionSorteo:txtDescripcionSorteo,
                txtRdSorteo:txtRdSorteo,
                txtFechaInicio:txtFechaInicio,
                txtFechaFin:txtFechaFin,
                txtDescripcionRestriccion:txtDescripcionRestriccion,
                txtValorApuesta:txtValorApuesta,
                txtTiempoCaducidadTicket:txtTiempoCaducidadTicket,                
                txtPorRegiones:txtPorRegiones,                
                arrBeneficios:arrBeneficios,
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) { 
                if(response.respuesta==true){
                    toastr.success(response.mensaje, "Mensaje Servidor");                    
                }   
                else{
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }                            
                $("#btnGuardarSorteo").attr('disabled','disabled');
            },
            error: function (jqXHR, textStatus, errorThrown) {                    
            }                
        });           
    }); 
});
function validarInputs(arrBeneficios){    
    var respuesta = {};
    if($("#txtNombreSorteo").val()==''){    
        return respuesta = {response:false, mensaje:"Ingrese Nombre De Sorteo"};                        
    };
    if($("#txtDescripcionSorteo").val()==''){
        return respuesta = {response:false, mensaje:"Ingrese Descripcion De Sorteo"};                        
    };
    // if($("#txtRdSorteo").val()==''){
    //     return respuesta = {response:false, mensaje:"Ingrese RD De Sorteo"};                 
    // };
    if($("#txtDescripcionRestriccion").val()==''){
        return respuesta = {response:false, mensaje:"Ingrese Descripcion De Restriccion"};                 
    };
    if($("#txtValorApuesta").val()==''){
        return respuesta = {response:false, mensaje:"Ingrese Valor De Apuesta"};                         
    }else{
        if ($("#txtValorApuesta").val() % 1 === 0){

        }else{
            return respuesta = {response:false, mensaje:"Ingrese Valor Entero - Valor De Apuesta"};                 
        }
    };
    if($("#txtTiempoCaducidadTicket").val()==''){
        return respuesta = {response:false, mensaje:"Ingrese Tiempo De Caducidad"};                 
    }else{
        if ($("#txtTiempoCaducidadTicket").val() % 1 === 0){

        }else{
            return respuesta = {response:false, mensaje:"Ingrese Valor Entero - Tiempo De Caducidad"};                 
        }
    };
    if(arrBeneficios.length==0){
        return respuesta = {response:false, mensaje:"Ingrese Beneficios"};    
    };
    return respuesta = {response:true, mensaje:""};    
};