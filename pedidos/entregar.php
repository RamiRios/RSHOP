<?php
include "../conexion/conexion.php";

$id = $_POST['e_id'];
$sql = "UPDATE pedidos SET estado = 'entregado' WHERE id = '$id'";

echo mysqli_query($conexion, $sql);

?>