$(document).ready(function () {    
    var inputDni = document.getElementById("TxtDni");   
    inputDni.addEventListener("keyup", function (event) {        
        if (event.keyCode === 13) {        
            $('#btnBuscar').click();
        }
    });   
    var inputCorreo = document.getElementById("TxtCorreoBusqueda");   
    inputCorreo.addEventListener("keyup", function (event) {        
        if (event.keyCode === 13) {        
            $('#btnBuscar').click();
        }
    });    
    $('#btnBuscar').on('click', function (e) {                   
        e.preventDefault();

        var TxtDni = $("#TxtDni").val().replace(/ /g,'');         
        if(TxtDni!=""){
            if(((/^\d+$/.test(TxtDni)) && TxtDni.length == 8)==false)
            {   
                return false;              
            }
        }        
        var TxtCorreoBusqueda = $("#TxtCorreoBusqueda").val().replace(/ /g,'');  
        $("#TxtDni").val(TxtDni);  
        $("#TxtCorreoBusqueda").val(TxtCorreoBusqueda);                                                                  
        $.ajax({
            url: '/BuscarClientesJson',
            data:{                                
                TxtDni:TxtDni,
                TxtCorreoBusqueda:TxtCorreoBusqueda
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) {                                                                                 
                if(response.data!=null)
                {   
                    $("#TxtIdCliente").val(response.data.ID); 
                    $("#TxtDni").prop("readonly",true);    
                    $("#TxtCorreoBusqueda").prop("readonly",true);                                                                                                                                
                    $("#TxtCorreo").val(response.data.email); 
                    $("#TxtCorreo").prop("readonly",false);                                                          
                    $("#TxtCelular").val(response.data.celular); 
                    $("#TxtCelular").prop("readonly",false);  
                    if(response.data.bloqueado==1){
                        $("#chkBloqueado").prop("checked",true);
                    }  
                    if(response.data.verificacionCorreo==1){
                        $("#chkVerificacionCorreo").prop("checked",true);
                    }     
                    $("#chkBloqueado").prop("disabled",false);
                    $("#chkVerificacionCorreo").prop("disabled",false);                                  
                }                                                                            
            },
            error: function (jqXHR, textStatus, errorThrown) {                    
            }                
        });           
    });  
    $('#btnLimpiar').on('click', function (e) {                   
        e.preventDefault();
        $("#TxtIdCliente").val(""); 
        $("#TxtDni").val(""); 
        $("#TxtDni").prop("readonly",false);   
        $("#TxtCorreoBusqueda").val(""); 
        $("#TxtCorreoBusqueda").prop("readonly",false);                                                                                                                    
        $("#TxtCorreo").val(""); 
        $("#TxtCorreo").prop("readonly",true);                                                          
        $("#TxtCelular").val(""); 
        $("#TxtCelular").prop("readonly",true)   
        $("#chkBloqueado").prop("checked",false);
        $("#chkVerificacionCorreo").prop("checked",false);   
        $("#chkBloqueado").prop("disabled",true);                                  
        $("#chkVerificacionCorreo").prop("disabled",true);                                  
        $("#TxtDni").focus();
    });                  
    $('#btnGuardar').on('click', function (e) {                   
        e.preventDefault();
         
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;  
        var TxtCorreo = $("#TxtCorreo").val().replace(/ /g,'');  
        if(TxtCorreo==""){
            toastr.error("Ingrese Correo", "Mensaje del Servidor"); 
            return false;
        }else{
            if(testEmail.test(TxtCorreo)==false)
            {   
                toastr.error("Ingrese Correo Valido", "Mensaje del Servidor");     
                return false;    
            }
        }       
        var TxtCelular = $("#TxtCelular").val().replace(/ /g,''); 
        if(TxtCelular==""){
            toastr.error("Ingrese Celular", "Mensaje del Servidor"); 
            return false;
        }else{
            if(((/^\d+$/.test(TxtCelular)) && TxtCelular.length == 9)==false)
            {   
                toastr.error("Ingrese Celular Valido", "Mensaje del Servidor");     
                return false;            
            }
        }      
        var chkBloqueado=0;
        if($("#chkBloqueado").is(":checked")){
            chkBloqueado=1;
        }
        var chkVerificacionCorreo=0;
        if($("#chkVerificacionCorreo").is(":checked")){
            chkVerificacionCorreo=1;
        }
        var TxtIdCliente= $("#TxtIdCliente").val(); 
        if(TxtIdCliente==""){
            return false;
        };

        $.ajax({
            url: '/ActualizarDNIClienteJson',
            data:{                                            
                TxtCorreo:TxtCorreo,
                TxtCelular:TxtCelular,
                chkBloqueado:chkBloqueado,
                chkVerificacionCorreo:chkVerificacionCorreo,
                TxtIdCliente:TxtIdCliente
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) {                   
                if(response.data==true)
                {
                    toastr.success("Datos Guardatos Correctamente", "Mensaje del Servidor");  
                    $("#TxtIdCliente").val(""); 
                    $("#TxtDni").val(""); 
                    $("#TxtDni").prop("readonly",false);  
                    $("#TxtCorreoBusqueda").val(""); 
                    $("#TxtCorreoBusqueda").prop("readonly",false);                                                                                                                                
                    $("#TxtCorreo").val(""); 
                    $("#TxtCorreo").prop("readonly",true);                                                          
                    $("#TxtCelular").val(""); 
                    $("#TxtCelular").prop("readonly",true);  
                    $("#chkBloqueado").prop("checked",false);
                    $("#chkVerificacionCorreo").prop("checked",false);   
                    $("#chkBloqueado").prop("disabled",true);                                  
                    $("#chkVerificacionCorreo").prop("disabled",true);   
                }   
                else{
                    toastr.error("Error", "Mensaje del Servidor");     
                }                                                                         
            },
            error: function (jqXHR, textStatus, errorThrown) {       

            }                
        });           
    }); 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });        

});






