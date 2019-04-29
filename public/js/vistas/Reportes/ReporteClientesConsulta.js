
$(document).ready(function () {
   
    $('#btnConsultarCliente').on('click', function (e) {                   
        e.preventDefault();

        var txtNombre = $("#txtNombre").val();             
        var txtApellido = $("#txtApellido").val();     
        var txtDni = $("#txtDni").val();     
      
        $.ajax({
            url: '/ListadoClientesConsultaJson',
            data:{                
                txtNombre:txtNombre,
                txtApellido:txtApellido,
                txtDni:txtDni
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) {        debugger        
                $("#table").DataTable({
                    dom: 'Bfrtip',
                    
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title: 'Reporte Lista de Usuarios'
                            
                        },
                        
                        {
                            extend: 'pdfHtml5',
                            title: 'Reporte Lista de Usuarios'
                        },
                        {
                            extend: 'print',
                            title: 'Reporte Lista de Usuarios'
                        }
                        
                    ],
                    "bDestroy": true,
                    "bSort": true,
                    "scrollCollapse": true,
                    "scrollX": true,
                    "paging": true,
                    "autoWidth": false,
                    "bProcessing": true,
                    "bDeferRender": true,
                    data: response.data,
                    columns: [
                      
                        
                            // {data: "ID", title: "ID"},
                            // {data: "tipo_cliente_id", title: "tipo_cliente_id"},
                            // {data: "ruc", title: "ruc"},
                            {data: "dni", title: "dni"},
                            // {data: "razon_social", title: "razon_social"},
                            {data: "nombre", title: "nombre"},
                            {data: "apellidoPaterno", title: "apellidoPaterno"},
                            {data: "apellidoMaterno", title: "apellidoMaterno"},
                            {data: "email", title: "email"},
                            {data: "telefono", title: "telefono"},
                            {data: "celular", title: "celular"},
                            // {data: "direccion", title: "direccion"},
                            // {data: "ubigeo_id", title: "ubigeo_id"},
                            // {data: "banco_id", title: "banco_id"},
                            // {data: "moneda_id", title: "moneda_id"},
                            // {data: "numero_cuenta", title: "numero_cuenta"},
                            // {data: "representante_id", title: "representante_id"},
                            // {data: "infocorp", title: "infocorp"},
                            // {data: "como_se_entero", title: "como_se_entero"},
                            // {data: "como_se_entero_des", title: "como_se_entero_des"},
                            {data: "estado", title: "estado"},
                            {data: "verificacion", title: "verificacion"},
                            {data: "verificacionCorreo", title: "verificacionCorreo"},
                            // {data: "editado", title: "editado"},
                            {data: "bloqueado", title: "bloqueado"},
                            // {data: "fechaBloqueo", title: "fechaBloqueo"} 
                        
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

});






