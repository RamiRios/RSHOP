<?php

    require '../conexion/config.php';
    require '../conexion/conexion2.php';
    require '../sistema/funcs/conexion.php';
	require '../sistema/funcs/funcs.php';
    $db = new Database();
    $con = $db->conectar();
    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    $idUsuario = $_SESSION['id_usuario'];
    $sql = "SELECT id, nombre, direccion, usuario, correo FROM usuarios WHERE id = '$idUsuario'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
    $fecha_actual = date("Y-m-d");

    $lista_carrito = array(); 


    if($productos != null){
      foreach($productos as $clave => $cantidad){

        $sql = $con->prepare("SELECT id, nombre, precio, foto, $cantidad AS cantidad FROM producto WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    
      }
    } else {
        header("Location: ../aplicacion/catalogo.php");
        exit;
    }

if($idUsuario == null){

    header("Location: ../aplicacion/checkout.php");
    exit;
    }

   

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Pagina</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body style="padding-bottom: 5em; position: relative; min-height: 100vh;">
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="../aplicacion/catalogo.php"
                    class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="../imagenes/logo.png" width="150" height="70">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../aplicacion/catalogo.php" class="nav-link px-2 text-white"><i
                                class="fa-solid fa-house"></i> Inicio</a></li>
                    <li><a href="../sistema/usuario.php" class="nav-link px-2 text-white"><i
                                class="fa-solid fa-user"></i> Usuario</a></li>
                    <a href="../aplicacion/checkout.php" class="btn btn-dark"><i class="fa-solid fa-cart-shopping"></i>
                        Carrito <span id="num_cart" class="badge bg-secondary">
                            <?php echo $num_cart ?>
                        </span></a>
                </ul>
            </div>
        </div>
    </header>
    <br>
    <main class="main">

        <div class="container">
            <H1>Informacion del pedido</H1>
            <div class="table-responsive">
                <table class="table">


                    <tbody>

                        <?php
    if($lista_carrito == null){
      echo '<tr><td colspan="3" class="text-center"><b>Lista vacia</b></td></tr>';
    } else {
        $nomPedido = "";
        $cantPedido = "";
      $total = 0;
      foreach($lista_carrito as $producto){
        $_id = $producto['id'];
        $nombre = $producto['nombre'];
        $nomPedido .= "$nombre, ";
        $precio = $producto['precio'];
        $cantidad = $producto['cantidad'];
        $cantPedido .= "$cantidad, ";
        $subtotal = $precio * $cantidad;
        $total += $subtotal;
        ?>

                        <form id="frmPedido" method="POST">
                            <div class>
                            <div class="col-md-4 input-group input-group-lg" >
                                <input type="text" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" class="form-control text-white bg-dark" placeholder="Dirección"
                                    value="<?php echo $nombre; ?> Cantidad: <?php echo $cantidad; ?> Subtotal: <?php echo number_format($subtotal, 2, '.', ',');  ?>"
                                    style="margin-bottom: 25px;" readonly>
                            </div>
                            <input name="txtNombre_Cliente" type="hidden"
                                value="<?php echo utf8_decode($row['usuario']); ?>">
                            <input name="txtProducto" type="hidden" value="<?php echo $nomPedido; ?>">
                            <input name="txtCantidad" type="hidden" value="<?php echo $cantPedido; ?>">
                            <input name="txtDireccion" type="hidden"
                                value="<?php echo utf8_decode($row['direccion']); ?>">
                            <input name="txtFecha" type="hidden" value="<?php echo $fecha_actual; ?>">
                            <input name="txtTotal" type="hidden"
                                value="<?php echo $total;  ?>">

                            <?php } ?>
                            <tr>
                            </div>
                                <td colspan="3">
                                    <p class="h3" id="total">Total: $ <?php echo number_format($total, 2, '.', ','); ?>

                                    </p>
                                </td>

                            </tr>

                    </tbody>
                    <?php } ?>
                </table>
            </div>

            <?php
    if($lista_carrito != null){ ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <button id="btnPedido" type="button" class="btn btn-warning btn-lg">Confirmar pedido</button>
                </div>

            </div>
            </form>
            <?php } ?>
        </div>

    </main>
<br><br><br><br>
    <br>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="../lib/js/jquery-2.1.4.min.js"></script>
    <script src="../app.js"></script>
    <script>
    $('#btnPedido').on('click', function() {

        //alert('Has dado click al boton')
        var datos = $('#frmPedido').serialize();

        $.ajax({
            type: 'POST',
            url: '../sistema/registrarPedido.php',
            data: datos,
            success: function(e) {
                $('body').load('../pagos/correopedido.php');
            }
        })
    })
    </script>
        <footer style="position: absolute; bottom: 0px; width: 100%; heigth: 205px; padding: 1em 0;"
        class="bg-dark text-center text-white">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022:
            <a class="text-white" href="https://mdbootstrap.com/">Rio Proveedora</a>
            <p>Contactanos: 828 173 5148</p>
        </div>

    </footer>
</body>


</html>