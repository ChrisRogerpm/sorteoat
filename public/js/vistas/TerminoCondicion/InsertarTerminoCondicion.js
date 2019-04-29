$(document).ready(function () {
    CKEDITOR.replace('editor', {
       
        enterMode: CKEDITOR.ENTER_BR,
        shiftEnterMode:CKEDITOR.ENTER_P,
        toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
                   { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
                   { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
                   { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                   { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                   { name: 'links', items: [ 'Link', 'Unlink' ] },
                   { name: 'insert', items: [ 'Image'] },
                   { name: 'spell', items: [ 'jQuerySpellChecker' ] },
                   { name: 'table', items: [ 'Table' ] }
                   ],
    });
    CKEDITOR.config.height = 450;  
    cargarData();
    $('#btnGuardar').on('click', function (e) {                   
        e.preventDefault();                
        var txtDescripcion = CKEDITOR.instances['editor'].getData();                          
        if(txtDescripcion==""){
            return false;
        }
        $.ajax({
            url: "/InsertarTerminoCondicionJson",
            data:{
                txtDescripcion:txtDescripcion,
            }, 
            type: "POST",
            beforeSend: function () {                    
                $.LoadingOverlay("show");
            },
            complete: function () {                    
                $.LoadingOverlay("hide");
            },
            success: function (response) { 
                if(response.data==true){
                    toastr.success(response.mensaje, "Mensaje Servidor");                    
                }   
                else{
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }                            
                $("#btnGuardar").attr('disabled','disabled');
            },
            error: function (jqXHR, textStatus, errorThrown) {                    
            }                
        });           
    });
});
function cargarData(){
    $.ajax({
        url: "/ObtenerTerminoCondicionJson",         
        type: "get",
        beforeSend: function () {                    
            $.LoadingOverlay("show");
        },
        complete: function () {                    
            $.LoadingOverlay("hide");
        },
        success: function (response) { 
            CKEDITOR.instances['editor'].setData(response.data.descripcion)
            debugger
            // if(response.data==true){
            //     toastr.success(response.mensaje, "Mensaje Servidor");                    
            // }   
            // else{
            //     toastr.error(response.mensaje, "Mensaje Servidor");
            // }                            
            // $("#btnGuardar").attr('disabled','disabled');
        },
        error: function (jqXHR, textStatus, errorThrown) {                    
        }                
    }); 
}