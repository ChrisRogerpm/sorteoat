$(document).ready(function () {
    cargarData();  
    if($("#TxtApPaterno").val()!=undefined)
    {
        $(".imgHeaderWeb").css('padding-top','1vh');
    } 
    $('#btnGuardarFormulario1').attr("disabled",true);  
    $('[data-toggle="tooltip"]').tooltip();     
    $('#TxtVerific').on('click', function (e) {                        
        setTimeout(function(){ $("#TxtVerific").tooltip("show"); }, 500);
    }); 
    $('.custom-checkbox').on('click', function (e) {                                
        if($('#chkTerminosyCondiciones').is(":checked"))
        {
            $('#btnGuardarFormulario1').attr("disabled",false);
        }
        else
        {
            $('#btnGuardarFormulario1').attr("disabled",true);
        }
    }); 
    $('#TxtVerific').on('click mouseover', function () {
        setTimeout(function(){ $("#TxtVerific").tooltip("show"); }, 5);
    });
    $( "#TxtVerific" ).focus(function() {        
        setTimeout(function(){ $("#TxtVerific").tooltip("show"); }, 50);
    });
    if ($("#TxtEmail").length > 0){
        $("#btnFormulario").text('Guardar');
    }
    $(document).on('show.bs.modal','#exampleModal', function () {
        $("#contenedorBoton").css('display','block');
    });
    $(document).on('hide.bs.modal','#exampleModal', function () {
        $("#contenedorBoton").css('display','none');
    });
    $("#btncloseModal").on('click', function (e) {                                
        $("#exampleModal").modal("hide")
    }); 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#formClienteDatos").submit(function (e) {        
        var esValido=true;                            
        var TxtEmail = $.trim($("#TxtEmail").val());             
        var txtCelular = $.trim($("#TxtCelular").val()); 
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;          
        if($("#txtCelular").val()!=undefined){
            if(((/^\d+$/.test(txtCelular)) && txtCelular.length == 9)==false)
            {   
                esValido=false;                  
                $("#txtErrorCelular").show('slow');                 
            }
        } 
        if($("#TxtEmail").val()!=undefined){
            if(testEmail.test(TxtEmail)==false)
            {   
                esValido=false;                
                $("#txtErrorEmail").show('slow');   
            }
        }                                             
        if(esValido==false)
        {
            return false;
        }
    });
    $("#formDni").submit(function (e) {                                        
        var txtDni = $("#TxtDni").val().replace(/ /g,'');         
        if(((/^\d+$/.test(txtDni)) && txtDni.length == 8)==false)
        {   
            return false;              
        }
        $("#TxtDni").val(txtDni);
        var TxtVerific = $("#TxtVerific").val().replace(/ /g,'');         
        if(((/^\d+$/.test(TxtVerific)) && TxtVerific.length == 1)==false)
        {   
            return false;              
        }
        $("#TxtVerific").val(TxtVerific);
    });         
});
function cargarData(){
    $.ajax({
        url: "/ObtenerTerminoCondicionClienteJson",         
        type: "get",
        async:false,
        beforeSend: function () {    
        },
        complete: function () {    
        },
        success: function (response) { 
            $("#cuerpoModal").append(response.data.descripcion);            
        },
        error: function (jqXHR, textStatus, errorThrown) {                    
        }                
    }); 
}