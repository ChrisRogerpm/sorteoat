$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    ListarSorteo();    
    $(document).on('click', '.btnIniciar', function () {               
        var idSorteo = $(this).data("id");        
        var idBeneficio = $("#Cbo"+idSorteo).val();  
        if(idBeneficio!='')
        {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: '¿ Desea Iniciar El Sorteo ?',
                theme: 'black',
                animationBounce: 1.5,
                columnClass: 'col-md-6 col-md-offset-3',
                confirmButtonClass: 'btn-info',
                cancelButtonClass: 'btn-warning',
                confirmButton: 'Iniciar',
                cancelButton: 'Cancelar',
                content: false,
                confirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: '/IniciarSorteoJson',
                        data:{
                            idSorteo:idSorteo,                
                            idBeneficio:idBeneficio,                
                        },            
                        success: function (response) {  
                            console.log(response);                                                                            
                            if(response.respuesta==true)
                            {
                                toastr.success(response.mensaje, "Mensaje Servidor");                    
                            }   
                            else
                            {
                                toastr.error(response.mensaje, "Mensaje Servidor");                    
                            }
                        },
                    }); 
                },
                cancel: function () {
                }
            });
            // -----------------------------------------
            // $.ajax({
            //     type: 'POST',
            //     url: '/IniciarSorteoJson',
            //     data:{
            //         idSorteo:idSorteo,                
            //         idBeneficio:idBeneficio,                
            //     },            
            //     success: function (response) {                                                  
            //         if(response.respuesta==true)
            //         {
            //             toastr.success(response.mensaje, "Mensaje Servidor");                    
            //         }   
            //         else
            //         {
            //             toastr.error(response.mensaje, "Mensaje Servidor");                    
            //         }
            //     },
            // });  
        }        
        else
        {
            toastr.error("Seleccione Beneficio", "Mensaje Servidor");                    
        }            
    });   
});
function ListarSorteo(){
    var arrSorteos=[];
    $.ajax({
        type: 'POST',
        url: '/SorteoListarJson',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {                                    
            arrSorteos = response.data;        
            $("#table").DataTable({
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
                    {data: "nombre_sorteo", title: "Nombre Sorteo"},
                    {data: "descripcion_sorteo", title: "Descripcion Sorteo"},
                    {data: "rd", title: "RD"},
                    {data: "fecha_inicio", title: "Fecha Inicio"},
                    {data: "fecha_fin", title: "Fecha Fin"},
                    {
                        data: null, title: "Beneficio",
                        "render": function (value) {
                            return '<select class="cboBeneficio" style="width:200px;" id="Cbo' + value.id + '"  data-id="' + value.id + '"><option value="">Seleccione</option></select>';
                        }
                    },                    
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-primary btn-sm btnIniciar" data-id="' + value.id + '"><i class="fa fa-play"></i></button>';
                        }
                    }
                ],
                "columnDefs": [
                    { "width": "10", "targets": 5 }
                  ],
                "drawCallback": function (settings) {
                    $('.btnEditar').tooltip({
                        title: "Editar"
                    });
                }
            });
        },
        complete: function() {
            $.each(arrSorteos, function(i, elemento){
                llenarBeneficios(elemento.id);     
            });            
        },
    })
}
function llenarBeneficios(idSorteo){               
    $.ajax({
        async:false,
        type: 'POST',
        url: '/ListadoBeneficioJson',
        data:{
            idSorteo:idSorteo,                
        },            
        success: function (response) {                 
            $('#Cbo'+idSorteo).html("");                                                              
            var myoptions = "<option value=''>Seleccione</option>";
            $.each(response.data, function(i, elemento){
                myoptions += "<option value='"+elemento.id+"'>"+elemento.premio+"</option>";      
            });
            $('#Cbo'+idSorteo).html(myoptions);                 
        },
    });      
}