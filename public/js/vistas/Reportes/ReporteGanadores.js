ArrSorteos = [];
$(document).ready(function () {
    llenarSorteos();
    $('#btnGuardarSorteo').on('click', function (e) {
        e.preventDefault();
        $('.dropdown-list1').hide('slow');
        var arrSorteos = [];
        $('.local:checkbox:checked').map(function () {
            arrSorteos.push(this.getAttribute("name"));
        }).get();
        if (arrSorteos.length == 0) {
            toastr.error("Seleccione Local", "Mensaje del Servidor");
            return false;
        }
        $.ajax({
            url: '/ReporteGanadoresJson',
            data: {
                arrSorteos: arrSorteos,
            },
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                debugger
                $("#table").DataTable({
                    dom: 'Blfrtip',
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
                    "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Todos"]],
                    data: response.data,
                    columns: [
                        {data: "nombre_sorteo", title: "Sorteo"},
                        {data: "premio", title: "Beneficio"},
                        {data: "nombre", title: "Nombre"},
                        {data: "apellidoPaterno", title: "Apellido Paterno"},
                        {data: "apellidoMaterno", title: "Apellido Materno"},
                        {
                            data: null, title: "Ranking", class: "text-center",
                            "render":function (value) {
                                var ranking = value.ranking == null ? '-' : value.ranking;
                                return '<span class="badge badge-warning" style="padding-top: 7px;padding-bottom: 7px;">' + ranking + '</span>'
                            }
                        },
                        {data: "fecha_registro_ganador", title: "Fecha Registro"}
                    ],
                    "drawCallback": function (settings) {
                    }
                });
                $("#table_wrapper").css("overflow", "scroll");
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

    //region nueva
    $('.dropdown-container1')
        .on('click', '.dropdown-button1', function () {
            $(this).siblings('.dropdown-list1').toggle();
        })
        .on('input', '.dropdown-search', function () {
            var target = $(this);
            var dropdownList = target.closest('.dropdown-list1');
            var search = target.val().toLowerCase();

            if (!search) {
                dropdownList.find('li').show();
                return false;
            }

            dropdownList.find('li').each(function () {
                var text = $(this).text().toLowerCase();
                var match = text.indexOf(search) > -1;
                $(this).toggle(match);
            });
        })
        .on('change', '[type="checkbox"]', function () {
            if ($(this).attr('id') == '0') {
                $('.local:checkbox').map(function () {
                    this.checked = false;
                });
                $(this).prop('checked', true);
            } else {
                $('.local:checkbox').map(function () {
                    if (this.getAttribute("name") == '0') {
                        this.checked = false;
                    }
                });
            }
            var container = $(this).closest('.dropdown-container1');
            var numChecked = container.find('[type="checkbox"]:checked').length;
            container.find('.quantity').text(numChecked || 'Any');
        });

});

function llenarSorteos() {
    $.ajax({
        async: false,
        type: 'post',
        url: '/SorteoListarJson',
        data: {},
        success: function (response) {
            ArrSorteos = response.data;
            response.data.unshift({id: '0', descripcion_sorteo: 'Todos'});
            var stateTemplateLocales = _.template(
                '<li>' +
                '<input class="local" id="<%= id %>" name="<%= id %>" type="checkbox">' +
                '<label style="margin-left: 8px;" for="<%= id %>"><%= descripcion_sorteo %></label>' +
                '</li>'
            );
            _.each(response.data, function (s) {
                s.descripcion_sorteo = _.startCase(s.descripcion_sorteo.toLowerCase());
                $('#ulLocales').append(stateTemplateLocales(s));
            });
            $("#0.local").prop('checked', true);
        },
    });
}





