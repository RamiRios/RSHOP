<?php

include "../conexion/conexion.php";

$nombre                 = $_POST['txtNombre'];
$descripcion            = $_POST['txtDescripcion'];
$precio                 = $_POST['txtPrecio'];
$foto                   = $_POST['txtFoto'];
$activo = "1";

$sql = "INSERT INTO producto (  nombre, 
                                descripcion,
                                precio, 
                                foto,
                                activo)

VALUES ('$nombre', 
        '$descripcion', 
        '$precio', 
        '$foto',
        '$activo') ";

echo mysqli_query($conexion, $sql);

?>