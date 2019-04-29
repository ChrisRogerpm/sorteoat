/////IMPRIMIR DEL NAVEGADOR
function Imprimir(elem)
{
    //////CONFIGURAR NAVEGADOR   MARGENES =>  NINGUNO
    var mywindow = window.open('', 'PRINT', 'height=800,width=700');
    // mywindow.onafterprint = function(){
    //  mywindow.opener.TerminoImprimir(1);mywindow.close()
    // }
   


    mywindow.document.write('<html><head>');
    mywindow.document.write('</head><body>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    // mywindow.print();
    mywindow.onafterprint = function(e){
        $(mywindow).off('mousemove', mywindow.onafterprint);
        mywindow.opener.TerminoImprimir(1);mywindow.close()
    };
    mywindow.print();
    setTimeout(function(){
        $(mywindow).one('mousemove', mywindow.onafterprint);
    }, 1);
    //setTimeout(function(){ mywindow.opener.TerminoImprimir(1);mywindow.close();},100)
    return true;
}

function TerminoImprimir(valor) {
    if(valor==1){
        // alert("result of popup is: " + valor);
       setTimeout(function(){window.location.reload(true);},1000) 
    }
}

////////////////

data=[];
$(document).ready(function () {
    $('#txtTicket').focus();
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
    $('#btnImprimir').on('click', function (e) {
        if(data.length==0){
            return false;
        }
        $.ajax({
            url: "/GenerarTicketAgrupadoJson",
            data: { data: data },
            type: "POST",
            beforeSend: function () {
                $("#example").LoadingOverlay("show");
            },
            complete: function () {
                $("#example").LoadingOverlay("hide");
            },
            success: function (response) { 
                // alert(response.data);                 
                // alert(response.arrayInsertados);                 
                var arrayInsertados=response.arrayInsertados;                  
                $.each(data, function( index, value ) {
                    var insertado = arrayInsertados.includes(value.NroTicket);
                    if(insertado==true){
                        value.valido=1;
                    }else{
                        value.valido=0;
                    }
                });       
                $('#example').dataTable().fnClearTable();
                $('#example').dataTable().fnAddData(data);         
                $("#txtTicket").prop('disabled',true);    

                ////IMPRESIÓN TICKET
                if(response.data!=""){
                    codigo_barra_src=response.codigo_barra_src
                    TICKET_IMPRIMIR={}
                    TICKET_IMPRIMIR.PadreId=response.data;
                    TICKET_IMPRIMIR.Detalles=response.arrayInsertados;
                    var date = new Date();
                    var fechahora = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " +  date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                    TICKET_IMPRIMIR.ImpresoEn=fechahora;
                    $("#modal_imprimir #divimpresion #IDTique").text(TICKET_IMPRIMIR.PadreId);
                    $("#modal_imprimir #divimpresion #impreso_en").text(TICKET_IMPRIMIR.ImpresoEn);
                    $(TICKET_IMPRIMIR.Detalles).each(function(i,e){
                        $("#modal_imprimir #divimpresion #datos_filas").append($("<div>").attr("style","width:100%;display:table")
                                 .append(
                                $("<div>").attr("style","width:100%;;text-align:right").text(e)
                                    )
                                // .append(
                                // $("<div>").attr("style","width:50%;float:LEFT;text-align:left").text(" ")
                                //     )
                                // .append(
                                // $("<div>").attr("style","width:50%;float:LEFT;text-align:right").text(e)
                                //     )
                        )
                    })
                    $("#modal_imprimir #imagen_codigobarra").attr("src","data:image/png;base64,"+codigo_barra_src);
                    $("#modal_imprimir #btnimprimir").off("click").on("click",function(){
                        Imprimir("divimpresion");
                    })
                    setTimeout(function(){
                        $("#btnimprimir").click()
                    },1000)
                    $("#modal_imprimir").modal("show");
                }
                else
                {
                    toastr.error("No hay datos para Impresión")
                }
                ////FIN IMPRESIÓN TICKET            
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });              
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
            {
                data: 'valido', title: 'Estado',
                render: function (data, type, row, meta) {
                    var str = "";                    
                    if (data == 2) {
                        str = '<span class="label label-info">PENDIENTE</span>';
                    } 
                    if (data == 1) {
                        str = '<span class="label label-success">GUARDADO</span>';
                    } 
                    if (data == 0) {
                        str = '<span class="label label-danger">ERROR AL GUARDAr</span>';
                    }                   
                    return str;
                }
            },
            {
                data: null, title: '',
                render: function (val, type, row, meta) {   
                    if(val.valido==2){
                        return '<span style="color:red;cursor:pointer;"data-id="'+val.NroTicket+'" class="remove"><i class="material-icons">delete_forever</i></span>';
                    }else{
                        return '<span style="color:green;cursor:pointer;"><i class="material-icons">done</i></span>';
                    }
                }
            }
        ]
    });      
    $("form").submit(function (e) {
        return false;
    });   
    $(document).on("click",".remove",function() { 
        var id=$(this).data("id");                                  
        data = data.filter(function( obj ) {        
            return obj.NroTicket != id;
        });     
        $('#example').dataTable().fnClearTable();
        if(data.length>0){
            $('#example').dataTable().fnAddData(data);    
        }
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
function cargarData(){
    var nroTicket=$("#txtTicket").val().replace(/\D/g,'');
    if(nroTicket!=""){
        var obj={
            "NroTicket": nroTicket,                
            "valido":  2
        };
        if( ((/^\d+$/.test(nroTicket))&& (nroTicket.length > 4) ) ==true ){                   
            data.unshift(obj);   
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnAddData(data);                
        }              
        $("#txtTicket").val("");
    } 
    return false;          
};
