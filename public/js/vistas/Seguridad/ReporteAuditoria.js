$(document).ready(function () {

    var dateNow = new Date();
    $(".fechaSorteo").datetimepicker({
        pickTime: true,
        format: 'DD-MM-YYYY hh:mm:ss A',
        defaultDate: dateNow, 
        autoClose: true,    
        keepOpen: false,
    });

    selectUsuario();

    $('#btnBuscar').on('click', function (e) {                   
        e.preventDefault();
        var txtUsuario = $("#txtUsuario").val();
        var txtFechaInicio = $("#txtFechaInicio").val();             
        var txtFechaFin = $("#txtFechaFin").val();                                                   
        $.ajax({
            url: './ListdoAuditoriaJson',
            data:{                
                txtUsuario:txtUsuario,
                txtFechaInicio:txtFechaInicio,
                txtFechaFin:txtFechaFin,
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                
                $("#table").DataTable({
                    "bDestroy": true,
                    "bSort": true,
                    "scrollCollapse": true,
                    "scrollX": false,
                    "paging": true,
                    "autoWidth": false,
                    "bProcessing": true,
                    "bDeferRender": true,
                    "aaSorting": [],
                    data: response.data,
                    columns: [
                        {data: "fecha_registro", title: "Fecha Registro","render": function (o) {
                                return moment(o).format("DD-MM-YYYY HH:mm:ss A");
                            }
                        },
                        {data: "nombre", title: "Usuario"},
                        {data: "permiso", title: "Permiso"},
                        {data: "controller", title: "Controlador"},
                        {data: "method", title: "Metodo"}, 
                        {data: "id", title: "","bSortable": false,
                            "render": function (o) {
                                return '<button type="button" class="btn btn-xs btn-warning btnmodalAuditoria" data-id="'+o+'"><i class="glyphicon glyphicon-list"></i></button>';
                            }
                        },                        
                    ],
                    "drawCallback": function (settings) {                        
                    }
                });                           
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
    
    $(document).on('click','.btnmodalAuditoria',function(){
        var id = $(this).data("id");
        $.ajax({
            url: './DataAuditoriaRegistroFk',
            data:{   
                txtAuditoriaID:id             
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var dataAuditoria = response.data;
                var datos = $.parseJSON(dataAuditoria.data);
                console.log(datos);
                $("#bodyModalAuditoria").html("");
                $.each(datos, function( key, value ) {
                    var lista = value;
                   
                    // if (value && typeof value === "object") {
                    //         lista+="<div style='float:right'>";
                    //         $.each($.parseJSON(value), function( key_, value_ ) {
                    //             lista+="<div>"+key_+":"+value_+"</div>";
                    //         });
                    //         lista+="</div>";
                    // }
                    // else{
                    //     lista=value;
                    // }                  
                    $("#bodyModalAuditoria").append("<div class='col-md-6'><div class='form-control' style='margin-bottom:5px;'>"+key.replace("txt", "")+":"+lista+"</div></div>");
                });
                if($.isEmptyObject(datos)){
                     toastr.error("No tiene Data", "Mensaje Servidor"); 
                }
                else{
                    $("#modalAuditoria").modal("show");
                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {                    
            }                
        });
       
    });

    function selectUsuario() {
        // body...
        $.ajax({
            url: './ListdoUsuariosSelectFk',
            data:{                
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                $('#txtUsuario').html("<option value='t'>--Todos--</option>");
                $.each(response.data, function(s,val) {
                    $('#txtUsuario').append("<option value='"+val.id+"'>"+val.nombre+"</option>");
                });
                 $('#txtUsuario').select2();                     
            },
            error: function (jqXHR, textStatus, errorThrown) {                    
            }                
        });    
    }
});





