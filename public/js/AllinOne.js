data=[];
estadoCancelar=false;
$(document).ready(function () {
    $('#txtTicket').focus()
    $(document).ajaxError(function (event, XMLHttpRequest, textStatus, errorThrow) {
        if(XMLHttpRequest.status == 400) {
            console.log(XMLHttpRequest.responseText, "Mensaje Servidor");
        } else if (XMLHttpRequest.status == 403) {
            console.log("No tiene permisos", "Mensaje Servidor");
        }
        else if (XMLHttpRequest.status == 401) {
            console.log("No tiene permisos", "Mensaje Servidor");   
        }
        else if (XMLHttpRequest.status == 500) {
            var cadena = $.parseJSON(XMLHttpRequest.responseText);
            console.log(cadena.message, "Mensaje Servidor");   
        }
        else {
            console.log("Servidor No Disponible");
        }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#example').DataTable({
        "paging": false,
        "responsive": true,
        "ordering": false,
        "info": false,
        "searching": false,
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "language": {
            "emptyTable": "Registre sus Tiquetes"
        },
        data: data,
        columns: [
            { data: 'NroTicket', title: 'ID Tique' },
            { data: 'Mjugado', title: 'Monto Jugado' },
            { data: 'oportunidades', title: 'Opciones' },
            {
                data: 'valido', title: 'Estado',
                render: function (data, type, row, meta) {
                    var str = "";
                    if (data == 1) {
                        str = '<span class="label label-success">TICKET VALIDADO</span>';
                    }
                    if (data == 0) {
                        str = '<span class="label label-danger">Inválido</span>';
                    }
                    if (data == 2) {
                        str = '<span class="label label-info">PENDIENTE</span>';
                    }
                    if (data == 3) {
                        str = '<span class="label label-danger">TICKET YA REGISTRADO</span>';
                    }
                    if (data == 4) {
                        str = '<span class="label label-danger">APUESTA INSUFICIENTE</span>';
                    }
                    if (data == 5) {
                        str = '<span class="label label-danger">TICKET FUERA DE FECHA</span>';
                    }
                    if (data == 6) {
                        str = '<span class="label label-danger">TICKET NO EXISTE</span>';
                    }
                    if (data == 7) {
                        str = '<span class="label label-danger">JUEGO NO VÁLIDO</span>';
                    }
                    if (data == 8) {
                        str = '<span class="label label-danger">TICKET NO VÁLIDO</span>';
                    }
                    if (data == 9) {
                        str = '<span class="label label-danger">TICKET AGRUPADO YA REGISTRADO</span>';
                    }
                    if (data == 10) {
                        str = '<span class="label label-danger">TICKET RESERVADO</span>';
                    }
                    return str;
                }
            }
        ]
    });  
    $('#btnSiguiente').on('click', function (e) {
        estadoCancelar=false;        
    }); 
    $('#btnCancelar').on('click', function (e) {
        estadoCancelar=true;        
    });  
    $("form").submit(function (e) {
        return false;
    });       
    $('#btnAgregarTicket').on('click', function (e) {
        e.preventDefault();
        var nuevoTicket=data.filter(x=>x.NroTicket==($("#txtTicket").val().replace(/\D/g,'')))
        if(nuevoTicket.length==0){
            cargarData();
        }else{
            $("#txtTicket").val("");
        }         
    });
    $('#btnTerminar').on('click', function (e) {
        Swal.fire(
            'Datos Registrados!',
            '',
            'success'
          ).then(function() {
            window.location = "/LogOut";
        });
    });
    
    var input = document.getElementById("txtTicket");
    input.addEventListener("keyup", function (event) {
        event.preventDefault();
        if (event.keyCode === 13) {        
            var nuevoTicket=data.filter(x=>x.NroTicket==($("#txtTicket").val().replace(/\D/g,'')))
            if(nuevoTicket.length==0){
                cargarData();
            }else{
                $("#txtTicket").val("");
            }
        }
    });
});
function actualizarDatosUsuario(){
	var esValido=true;         
	var esActualizado=false;         
    var idCliente = $("#idCliente").val();             
    var txtCorreoElectronico = $.trim($("#txtCorreoElectronico").val());             
    var txtCelular = $.trim($("#txtCelular").val()); 
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if(testEmail.test(txtCorreoElectronico)==false)
    {   
        esValido=false; 
        $("#txtCorreoElectronico").css("color","red");
        $("#txtErrorCorreo").show('slow');   
    }
    if(((/^\d+$/.test(txtCelular)) && txtCelular.length == 9)==false)
    {   
        esValido=false;  
        $("#txtCelular").css("color","red");
        $("#txtErrorCelular").show('slow');     
    }
    if(esValido==true){
        $.ajax({
            async:false,
            url: "/GuardarDatosUsuario",
            data:{txtidCliente:idCliente,txtTelefono:txtCelular,txtCorreoElectronico:txtCorreoElectronico}, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) {                                                
                esActualizado=response.esActualizado;
               if(esActualizado==true){
                   //alert("Datos Registrados Correctamente");               
               }
               else{
                   location.reload();
               }   
               $("#btnDatosUsuario").attr('disabled',true);
            },                          
        });  
    }  
    var obj={
        esActualizado:esActualizado,
        esValido:esValido,
    };                 
	return obj;         
};
function cargarData(){        
    var nroTicket=$("#txtTicket").val();
    if(nroTicket.toLowerCase().includes('at')){
        nroTicket=$("#txtTicket").val();
    }
    else{
        nroTicket=$("#txtTicket").val().replace(/\D/g,'');
    }
    if(nroTicket!=""){
        var obj={
            "NroTicket": nroTicket,
            "Mjugado":   0,
            "oportunidades":  0,
            "valido":  2
        };
        enviarTicket(nroTicket);               
        $("#txtTicket").val("");
    } 
    return false;          
};
function enviarTicket(nroTicketPrm){    
    var url="";
    var idCliente = $("#idCliente").val();   
    var objEnvio={
        "NroTicket": nroTicketPrm,
        "Mjugado":   0,
        "oportunidades":  0,
        "valido":  2
    };
    dataEnvio=[];
    dataEnvio.push(objEnvio);
    url="/ConsultarTicket";
    if(nroTicketPrm.toLowerCase().includes('at')){
        url="/ConsultarTickets";
    }    
    $.ajax({
        url: url,
        data: { arrTickets: dataEnvio,idCliente:idCliente },
        type: "POST",
        beforeSend: function () {
            $("#example").LoadingOverlay("show");
        },
        complete: function () {
            $("#example").LoadingOverlay("hide");
        },
        success: function (response) { 
            debugger 
            var puntos=0;
            if(nroTicketPrm.toLowerCase().includes('at')){                
                $(response.data).each(function(index ,value ) {
                    data.unshift(value);
                });
                datasuma=response.data.filter(x=>x.valido==1);
                puntos=datasuma.reduce((a, b) => +a + +b.oportunidades, 0);                               
            }    
            else
            {
                objEnvio.Mjugado=response.stake_amount;   
                objEnvio.valido=response.EstadoTicket;                         
                objEnvio.oportunidades=response.puntosGenerados;   
                data.unshift(objEnvio);  
                puntos=parseInt(response.puntosGenerados);                                              
            }      
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnAddData(data);   
            $("#txtTotalOpciones").val(parseInt($("#txtTotalOpciones").val())+parseInt(puntos));  
            if(response.bloqueado==true){
                location.reload();
            }                                  
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });    
}
