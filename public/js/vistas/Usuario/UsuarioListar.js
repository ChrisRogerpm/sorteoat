$(document).ready(function () {
    ListarUsuario();
    $(document).on('click', '.btnEditar', function () {
        var idUsuario = $(this).data("id");
        var url = basePath + "UsuarioEditar/" + idUsuario;
        window.location.replace(url);
    })
});

function ListarUsuario() {
    $.ajax({
        type: 'POST',
        url: basePath + 'UsuarioListarJson',
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            debugger
            
            // estado: 1
            // fecha_registro: "2019-01-01 00:00:00"
            // id: 1
            // nombre: "victor"
            // perfil_id: 0
            // tienda_nombre: null

            
            var resp = response.data;
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
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                data: resp,
                columns: [
                    {data: "id", title: "id"},
                    {data: "nombre", title: "Nombre"},
                    {
                        data: "perfil_id", title: "perfil_id",
                        "render": function (value) {
                            var perfil = '';
                            if (value=="1") {
                                perfil = "Cajero"
                            }
                            if (value=="0") {
                                perfil = "Administrador"
                            }
                            return perfil;
                        }
                    },
                    {data: "tienda_nombre", title: "Tienda"},
                    {
                        data: "estado", title: "estado",
                        "render": function (value) {
                            var estado = '';
                            if (value=="1") {
                                estado = "Activo"
                            }
                            if (value=="0") {
                                estado = "Inactivo"
                            }
                            return estado;
                        }
                    },
                    
                    {
                        data: "fecha_registro", title: "Fecha Registro",
                        "render": function (o) {
                        return moment(o).format("DD-MM-YYYY HH:mm:ss A");
                    }
                    },
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.id + '"><i class="fa fa-edit"></i></button>';
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    $('.btnEditar').tooltip({
                        title: "Editar"
                    });
                }
            });
        },
    })
}