$(document).ready(function () {
    ListarLocalVenta();

    $(document).on('click', '#btnSincronizar', function () {
        $.ajax({
            type: 'POST',
            url: basePath + "SincronizarLocalVentaJson",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var respuesta = response.respuesta;
                if (respuesta === true) {
                    toastr.success("Se Sincronizo Correctamente", "Mensaje Servidor");
                    ListarLocalVenta();
                } else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }
            }
        })
    });
    $(document).on('click', '.btnActualizar', function () {
        const cc_id = $(this).data('id');
        const url = basePath + "SincronizarLocalVentaIdFk";

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                'cc_id': cc_id
            },
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var respuesta = response.respuesta;
                if (respuesta === true) {
                    toastr.success("Se Actualizo Correctamente", "Mensaje Servidor");
                    ListarLocalVenta();
                } else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }
            }
        })

    });
});

function ListarLocalVenta() {
    $.ajax({
        type: 'POST',
        url: basePath + "ListarLocalJson",
        success: function (response) {
            $("#table").DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Reporte Lista de Locales'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Reporte Lista de Locales'
                    },
                    {
                        extend: 'print',
                        title: 'Reporte Lista de Locales'
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
                "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Todos"]],
                data: response.data,
                columns: [
                    {data: "id", title: "Id", class: "text-center"},
                    {data: "Ubigeo", title: "Nombre", class: "text-center"},
                    {data: "LocalVenta", title: "Local de Venta", class: "text-center"},
                    {data: "cc_id", title: "CC_ID", class: "text-center"},
                    {data: "unit_ids", title: "Unit_Id", class: "text-center"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnActualizar" data-id="' + value.cc_id + '"><i class="icon fa fa-fw fa-refresh"></i></button>'
                        }, class: "text-center"
                    }
                ],
                "drawCallback": function (settings) {
                    $(".btnActualizar").tooltip({
                        title: "Actualizar"
                    })
                }
            });
            $("#table_wrapper").css("overflow", "scroll");
        }
    })
}