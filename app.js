$(document).ready(function(){

$('#btnGuardar').on('click', function(){

//alert('Has dado click al boton')
    var datos = $('#frm_registrar').serialize();

    $.ajax({
        type:'POST',
        url: '../ingProduc/insertar.php',
        data: datos,
        success: function(e){
                //alert("Registro almacenado con exito");
                $('body').load('../ingProduc/index.php');
        }
    })
})
$('#btnEliminar').on('click', function(){

    var datos = $('#frm_actualizar').serialize();

    $.ajax({
        method:'POST',
        url: '../ingProduc/eliminar.php',
        data: datos,
        success: function(e){
              //alert("eliminado");
                $('body').load('../ingProduc/index.php');
        }
    })

})


})

function llenarModalActualizar(datos){

    d = datos.split('||');
    $('#e_id').val(d[0]);


}

