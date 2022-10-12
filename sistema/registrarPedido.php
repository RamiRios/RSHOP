<?php

include "../conexion/conexion.php";

$nombreCliente                 = $_POST['txtNombre_Cliente'];
$producto            = $_POST['txtProducto'];
$cantidad                 = $_POST['txtCantidad'];
$direccion                 = $_POST['txtDireccion'];
$fecha                  =$_POST['txtFecha'];
$total                = $_POST['txtTotal'];
$estado = "pedido";

$sql = "INSERT INTO pedidos (  cliente, 
                                producto,
                                cantidad,
                                direccion, 
                                fecha,
                                total,
                                estado)

VALUES ('$nombreCliente', 
        '$producto', 
        '$cantidad', 
        '$direccion',
        '$fecha',
        '$total',
        '$estado') ";

echo mysqli_query($conexion, $sql);

?>