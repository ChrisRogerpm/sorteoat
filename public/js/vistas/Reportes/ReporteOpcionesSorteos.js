$(document).ready(function () {
    var dateNow = new Date();
    $("#txtFechaInicio").datetimepicker({
        // pickTime: false,
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
    });

    $("#txtFechaFin").datetimepicker({
        // pickTime: false,
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
    });
    llenarlocales();
    
    $('#btnGuardarSorteo').on('click', function (e) {                   
        e.preventDefault();  
        $('.dropdown-list1').hide('slow');
        $('.dropdown-list2').hide('slow');
        var arrLocales =[];                     
        var arrJuegos =[]; 
        $('.local:checkbox:checked').map(function() {
            arrLocales.push(this.getAttribute("name"));
        }).get();
        $('.juego:checkbox:checked').map(function() {
            arrJuegos.push(this.getAttribute("name"));
        }).get();           

        var txtFechaInicio = $("#txtFechaInicio").val();             
        var txtFechaFin = $("#txtFechaFin").val();    

        //debugger;                                               
        $.ajax({
            url: '/ReporteOpcionesSorteosJson',
            data:{                
                txtFechaInicio:txtFechaInicio,
                txtFechaFin:txtFechaFin,
                arrJuegos:arrJuegos,
                arrLocales:arrLocales,
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
                    dom: 'Bfrtip',
                    
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title: 'Reporte Opciones Sorteos'
                            
                        },
                        
                        {
                            extend: 'pdfHtml5',
                            title: 'Reporte Opciones Sorteos'
                        },
                        {
                            extend: 'print',
                            title: 'Reporte Opciones Sorteos'
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
                    data: response.data,
                    columns: [
                       //cliente,local,ticket,juego,monto,opciones,fecha hora
                        {data: "nombre", title: "Cliente"},
                        {data: "local", title: "Local"},
                        {data: "ticket_id", title: "Ticket"},
                        {data: "game", title: "Juego"},
                        {data: "stake_amount", title: "Monto"},
                        {data: "cantidad_opciones", title: "Opciones"},
                        {data: "time_played", title: "time_played" }],
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
    $('.fechaSorteo').datetimepicker({
        format: 'YYYY-MM-DD',
    });
    //ListarSorteo();    
    $(document).on('click', '.btnEditar', function () {
        var idEmpresa = $(this).data("id");
        var url = basePath + "EmpresaEditar/" + idEmpresa;
        window.location.replace(url);
    });

    //region nueva
    $('.dropdown-container1')
	.on('click', '.dropdown-button1', function() {
        $(this).siblings('.dropdown-list1').toggle();
	})
	.on('input', '.dropdown-search', function() {
    	var target = $(this);
        var dropdownList = target.closest('.dropdown-list1');
    	var search = target.val().toLowerCase();
    
    	if (!search) {
            dropdownList.find('li').show();
            return false;
        }
    
    	dropdownList.find('li').each(function() {
        	var text = $(this).text().toLowerCase();
            var match = text.indexOf(search) > -1;
            $(this).toggle(match);
        });
	})
	.on('change', '[type="checkbox"]', function() {
        var container = $(this).closest('.dropdown-container1');
        var numChecked = container. find('[type="checkbox"]:checked').length;
        container.find('.quantity').text(numChecked || 'Any');
        if($(this).attr('id')=='0'){
            $('.local:checkbox').map(function() {
                this.checked = false;
            });
            $(this).prop('checked', true);
        }else{
            $('.local:checkbox').map(function() {
                if(this.getAttribute("name")=='0'){
                    this.checked = false;
                }
            });            
        }        
    });
    ////2
    $('.dropdown-container2')
	.on('click', '.dropdown-button2', function() {        
        $(this).siblings('.dropdown-list2').toggle();
	})
	.on('input', '.dropdown-search2', function() {
    	var target = $(this);
        var dropdownList = target.closest('.dropdown-list2');
    	var search = target.val().toLowerCase();
    
    	if (!search) {
            dropdownList.find('li').show();
            return false;
        }
    
    	dropdownList.find('li').each(function() {
        	var text = $(this).text().toLowerCase();
            var match = text.indexOf(search) > -1;
            $(this).toggle(match);
        });
	})
	.on('change', '[type="checkbox"]', function() { 
        var container = $(this).closest('.dropdown-container2');
        var numChecked = container. find('[type="checkbox"]:checked').length;
        container.find('.quantity2').text(numChecked || 'Any');                  
        if($(this).attr('id')=='0'){
            $('.juego:checkbox').map(function() {
                this.checked = false;
            });
            $(this).prop('checked', true);
        }else{
            $('.juego:checkbox').map(function() {
                if(this.getAttribute("name")=='0'){
                    this.checked = false;
                }
            });            
        }    
         
    });
    ///3
    

    // JSON of States for demo purposes
    // var usStates = [
    //     { name: 'Todos', abbreviation: '0'},
    //     { name: 'local', abbreviation: 'local'},
    //     { name: '99265', abbreviation: '99265'},
    //     { name: '99266', abbreviation: '99266'}
    // ];
    var arrJuegos = [
        { name: 'Todos', abbreviation: '0'},
        { name: 'Dogs', abbreviation: 'gr'},
        { name: 'Keno', abbreviation: 'kn'},
        { name: 'Roulette', abbreviation: 'rl'},
        { name: 'Poker', abbreviation: 'pk'},
        { name: 'Soccer', abbreviation: 'gg'},
        { name: 'Speedway', abbreviation: 'sp'},
        { name: 'Cup', abbreviation: 'cg'},
        { name: 'League', abbreviation: 'gl'},
        { name: 'Live Keno', abbreviation: 'lk'},
        { name: 'Mega 6', abbreviation: 'll'},
        { name: 'Fighting', abbreviation: 'fg'},
        { name: 'Motorbikes', abbreviation: 'mt'},
        { name: 'Karts', abbreviation: 'kt'},
        { name: 'Spin 2 Win', abbreviation: 'sn'},
        { name: 'Perfect Six', abbreviation: 'sx'},
        { name: 'World Cup', abbreviation: 'wc'},
        { name: 'Champions', abbreviation: 'ch'},
        { name: 'Ram Fight', abbreviation: 'rf'}
    ];

    // <li> template
    var stateTemplateLocales = _.template(
        '<li>' +
            '<input class="local" id="<%= abbreviation %>" name="<%= abbreviation %>" type="checkbox">' +
            '<label style="margin-left: 8px;" for="<%= abbreviation %>"><%= capName %></label>' +
        '</li>'
    );
    // <li> template
    var stateTemplateJuegos = _.template(
        '<li>' +
            '<input class="juego" id="<%= abbreviation %>" name="<%= abbreviation %>" type="checkbox">' +
            '<label style="margin-left: 8px;" for="<%= abbreviation %>"><%= capName %></label>' +
        '</li>'
    );

    // Populate list with states
    // _.each(usStates, function(s) {
    //     s.capName = _.startCase(s.name.toLowerCase());
    //     $('#ulLocales').append(stateTemplateLocales(s));
    // });

    _.each(arrJuegos, function(s) {
        s.capName = _.startCase(s.name.toLowerCase());
        $('#uljuegos').append(stateTemplateJuegos(s));
    });

});

function llenarlocales(){               
    $.ajax({
        async:false,
        type: 'get',
        url: '/ListadoLocalesJson',
        data:{},            
        success: function (response) {  
            ArrLocales=response.data;
            response.data.unshift({ cc_id: '0', nombre: 'Todos',unit_ids:["0"]}); 
            var stateTemplateLocales = _.template(
                '<li>' +
                    '<input class="local" id="<%= cc_id %>" name="<%= cc_id %>" type="checkbox">' +
                    '<label style="margin-left: 8px;" for="<%= cc_id %>"><%= capName %></label>' +
                '</li>'
            );              
            _.each(response.data, function(s) {
                s.capName = _.startCase(s.nombre.toLowerCase());
                $('#ulLocales').append(stateTemplateLocales(s));
            }); 
            // var locales = [
            //     { name: 'Todos', abbreviation: '0'},
            //     { name: 'local', abbreviation: 'local'},
            //     { name: '99265', abbreviation: '99265'},
            //     { name: '99266', abbreviation: '99266'}
            // ];        
            // $('#Cbo'+idSorteo).html("");                                                              
            // var myoptions = "<option value=''>Seleccione</option>";
            // $.each(response.data, function(i, elemento){
            //     myoptions += "<option value='"+elemento.id+"'>"+elemento.premio+"</option>";      
            // });
            // $('#Cbo'+idSorteo).html(myoptions);                 
        },
    });      
}






