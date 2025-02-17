$(document).ready(function () {

    // $.when(llenarSelect(basePath + "CajaListarJson", {'_token': $("input[name='_token']").val()}, "cboCaja", "idCaja", "nombre", "")).then(function (response, textStatus) {
    //     $("#cboCaja").select2();
    // });

    // $.when(llenarSelect(basePath + "TurnoListarJson", {'_token': $("input[name='_token']").val()}, "cboTurno", "idTurno", "nombre", "")).then(function (response, textStatus) {
    //     $("#cboTurno").select2();
    // });

    var dateNow = new Date();
    
    $("#txtfechaOperacion").datetimepicker({
        pickTime: false,
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
    });
    $('#btnGuardar').on('click', function (e) {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "UsuarioInsertarJson";
            var dataForm = $('#frmNuevo').serializeFormJSON();
            $.ajax({
                url: url,
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(dataForm),
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var respuesta = response.respuesta;
                    if (respuesta === true) {
                        toastr.success("Se Registro Correctamente", "Mensaje Servidor");
                        $("#frmNuevo")[0].reset();
                    } else {
                        toastr.error(response.mensaje, "Mensaje Servidor");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }
    });
});

$("#frmNuevo")
    .validate({
        rules: {
            idCaja:
                {
                    required: true,
                },
            idTurno:
                {
                    required: true,
                },
            usuario:
                {
                    required: true,
                },
            fechaOperacion:
                {
                    required: true,
                }
        },
        messages: {
            idCaja:
                {
                    required: '',
                },
            idTurno:
                {
                    required: '',
                },
            usuario:
                {
                    required: '',
                },
            fechaOperacion:
                {
                    required: '',
                }
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            }
            else {
                error.insertAfter(element);
            }
        }
    });