var ArrLocales = [];
var ArrJuegos = [
    {name: 'Todos', abbreviation: '0'},
    {name: 'Dogs', abbreviation: 'gr'},
    {name: 'Keno', abbreviation: 'kn'},
    {name: 'Roulette', abbreviation: 'rl'},
    {name: 'Poker', abbreviation: 'pk'},
    {name: 'Soccer', abbreviation: 'gg'},
    {name: 'Speedway', abbreviation: 'sp'},
    {name: 'Cup', abbreviation: 'cg'},
    {name: 'League', abbreviation: 'gl'},
    {name: 'Live Keno', abbreviation: 'lk'},
    {name: 'Mega 6', abbreviation: 'll'},
    {name: 'Fighting', abbreviation: 'fg'},
    {name: 'Motorbikes', abbreviation: 'mt'},
    {name: 'Karts', abbreviation: 'kt'},
    {name: 'Spin 2 Win', abbreviation: 'sn'},
    {name: 'Perfect Six', abbreviation: 'sx'},
    {name: 'World Cup', abbreviation: 'wc'},
    {name: 'Champions', abbreviation: 'ch'},
    {name: 'Ram Fight', abbreviation: 'rf'}
];

$(document).ready(function () {
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;
    $("#txtFechaInicio").val(output + " 00:01");
    $("#txtFechaFin").val(output + " 23:59");

    var dateNow = new Date();
    $("#txtFechaFin").datetimepicker({
        // pickTime: false,
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
    });

    llenarlocales();
    $('#btnGuardarSorteo').on('click', function (e) {
        e.preventDefault();

        $('.dropdown-list1').hide('slow');
        $('.dropdown-list2').hide('slow');
        var arrLocales = [];
        var arrJuegos = [];
        $('.local:checkbox:checked').map(function () {
            arrLocales.push(this.getAttribute("name"));
        }).get();
        $('.juego:checkbox:checked').map(function () {
            arrJuegos.push(this.getAttribute("name"));
        }).get();
        if (arrLocales.length == 0) {
            toastr.error("Seleccione Local", "Mensaje del Servidor");
            return false;
        }
        if (arrJuegos.length == 0) {
            toastr.error("Seleccione Juego", "Mensaje del Servidor");
            return false;
        }
        var strLocales = "";
        $.each(arrLocales, function (indx, local) {
            cc = ArrLocales.find(x => x.cc_id == local);
            $.each(cc.unit_ids, function (j, unit_id) {
                strLocales = strLocales + "," + unit_id;
            });
        });
        strLocales = strLocales.substr(1);
        strJuegos = arrJuegos.join('","');
        strJuegos = '"' + strJuegos + '"';
        var txtFechaInicio = $("#txtFechaInicio").val();
        var txtFechaFin = $("#txtFechaFin").val();
        var txtNombre = $("#txtNombre").val();
        var txtApellido = $("#txtApellido").val();
        var txtDni = $("#txtDni").val();
        $.ajax({
            url: '/ReporteClientesJson',
            data: {
                txtFechaInicio: txtFechaInicio,
                txtFechaFin: txtFechaFin,
                txtNombre: txtNombre,
                txtApellido: txtApellido,
                txtDni: txtDni,
                strLocales: strLocales,
                strJuegos: strJuegos,
                arrJuegos: arrJuegos,
                arrLocales: arrLocales,
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
                        {data:"id",title:"Id"},
                        {
                            data: null, title: "Centro de Costo",
                            "render": function (value) {
                                var local = ArrLocales.filter(x => x.unit_ids.includes(value.unit_id))
                                return (local.length > 0) ? local[0].nombre : 'No Registrado';
                            }
                        },
                        // {data: "unit_id", title: "local"},
                        {data: "nombre", title: "Nombre"},
                        {data: "apellidoPaterno", title: "Apellido Paterno"},
                        {data: "apellidoMaterno", title: "Apellido Materno"},
                        {data: "dni", title: "DNI"},
                        {
                            data: null, title: "Juego",
                            "render": function (value) {
                                var juego = ArrJuegos.filter(x => x.abbreviation === value.game);
                                console.log(juego);
                                return (juego.length > 0) ? juego[0].name : 'No Registrado';
                            }
                        },
                        {data: "cantidad_opciones", title: "Opciones"},
                        {data: "fecha_registro", title: "Fecha Registro"},
                        {data: "Departamento", title: "Departamento"},
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
    $('.fechaSorteo').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
    });
    //ListarSorteo();    
    $(document).on('click', '.btnEditar', function () {
        var idEmpresa = $(this).data("id");
        var url = basePath + "EmpresaEditar/" + idEmpresa;
        window.location.replace(url);
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
    $('.dropdown-container2')
        .on('click', '.dropdown-button2', function () {
            $(this).siblings('.dropdown-list2').toggle();
        })
        .on('input', '.dropdown-search2', function () {
            var target = $(this);
            var dropdownList = target.closest('.dropdown-list2');
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
                $('.juego:checkbox').map(function () {
                    this.checked = false;
                });
                $(this).prop('checked', true);
            } else {
                $('.juego:checkbox').map(function () {
                    if (this.getAttribute("name") == '0') {
                        this.checked = false;
                    }
                });
            }
            var container = $(this).closest('.dropdown-container2');
            var numChecked = container.find('[type="checkbox"]:checked').length;
            container.find('.quantity2').text(numChecked || 'Any');
        });

    var stateTemplateJuegos = _.template(
        '<li>' +
        '<input class="juego" id="<%= abbreviation %>" name="<%= abbreviation %>" type="checkbox">' +
        '<label style="margin-left: 8px;" for="<%= abbreviation %>"><%= capName %></label>' +
        '</li>'
    );
    _.each(ArrJuegos, function (s) {
        s.capName = _.startCase(s.name.toLowerCase());
        $('#uljuegos').append(stateTemplateJuegos(s));
    });
    $("#0.juego").prop('checked', true);

});

function llenarlocales() {
    $.ajax({
        async: false,
        type: 'get',
        url: '/ListadoLocalesJson',
        data: {},
        success: function (response) {
            ArrLocales = response.data;
            response.data.unshift({cc_id: '0', nombre: 'Todos', unit_ids: ["0"]});
            var stateTemplateLocales = _.template(
                '<li>' +
                '<input class="local" id="<%= cc_id %>" name="<%= cc_id %>" type="checkbox">' +
                '<label style="margin-left: 8px;" for="<%= cc_id %>"><%= capName %></label>' +
                '</li>'
            );
            _.each(response.data, function (s) {
                s.capName = _.startCase(s.nombre.toLowerCase());
                $('#ulLocales').append(stateTemplateLocales(s));
            });
            $("#0.local").prop('checked', true);
        },
    });
}




