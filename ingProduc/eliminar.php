<?php

include "../conexion/conexion.php";

$id = $_POST['e_id'];
$sql = "DELETE from producto WHERE id = '$id'";

echo mysqli_query($conexion, $sql);

?>