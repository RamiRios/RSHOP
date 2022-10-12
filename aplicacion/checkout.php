<?php

    require '../conexion/config.php';
    require '../conexion/conexion2.php';
    $db = new Database();
    $con = $db->conectar();
    error_reporting(0);

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    $idUsuario = $_SESSION['id_usuario'];
    $sql = "SELECT id, correo FROM usuarios WHERE id = '$idUsuario'";
    //print_r($_SESSION);

    $lista_carrito = array();

    if($productos != null){
      foreach($productos as $clave => $cantidad){

        $sql = $con->prepare("SELECT id, nombre, precio, foto, $cantidad AS cantidad FROM producto WHERE id=? AND activo=1");
        $sql->execute([$clave]);
    $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    
      }
    }



    //session_destroy();
   

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

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
    if($lista_carrito == null){
      echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
    } else {
      $total = 0;
      foreach($lista_carrito as $producto){
        $_id = $producto['id'];
        $nombre = $producto['nombre'];
        $precio = $producto['precio'];
        $cantidad = $producto['cantidad'];
        $foto = $producto['foto'];
        $subtotal = $precio * $cantidad;
        $total += $subtotal;
        ?>


                        <tr>
                            <td><img src="<?php echo $foto; ?>" width="50" height="50"></td>
                            <td><?php echo $nombre; ?></td>
                            <td>$ <?php echo $precio; ?></td>
                            <td>
                                <input type="number" min="1" max="50" step="1" value="<?php echo $cantidad; ?>" size="5"
                                    id="cantidad_<?php echo $_id; ?>"
                                    onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                    <?php echo number_format($subtotal, 2, '.', ',');  ?>
                                </div>
                            </td>
                            <td> <a href="#" id="eliminar" class="btn btn-danger btn-sm"
                                    data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal"
                                    data-bs-target="#eliminaModal">Eliminar</a>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">
                                <p class="h3" id="total">$ <?php echo number_format($total, 2, '.', ','); ?> </p>
                            </td>
                        </tr>

                    </tbody>
                    <?php } ?>
                </table>
            </div>

            <?php
    if($lista_carrito != null){
             if($idUsuario == null){ ?>

            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="../sistema/index.php" class="btn btn-danger btn-lg">Registrate</a>
                </div>
            </div>
            <?php   } else { ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="../pagos/pagos.php" class="btn btn-warning btn-lg">Realizar pedido</a>
                </div>
            </div>
            <?php } }?>
        </div>

    </main>
    <br><br><br><br>
    <!---MODAL-ELIMINAR---->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminaModalLabel">ALERTA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Eliminar producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-elimina" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
    let eliminaModal = document.getElementById('eliminaModal')
    eliminaModal.addEventListener('show.bs.modal', function(event) {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
        buttonElimina.value = id
    })

    function actualizaCantidad(cantidad, id) {
        let url = '../aplicacion/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('action', 'agregar')
        formData.append('id', id)
        formData.append('cantidad', cantidad)


        fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if (data.ok) {

                    let divsubtotal = document.getElementById('subtotal_' + id)
                    divsubtotal.innerHTML = data.sub

                    let total = 0.00
                    let list = document.getElementsByName('subtotal[]')

                    for (let i = 0; i < list.length; i++) {
                        total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                    }

                    total = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2
                    }).format(total)
                    document.getElementById('total').innerHTML = "$ " + total
                }
            })

    }

    function eliminar() {

        let botonElimina = document.getElementById('btn-elimina')
        let id = botonElimina.value

        let url = '../aplicacion/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('action', 'eliminar')
        formData.append('id', id)


        fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if (data.ok) {

                    location.reload()

                }
            })

    }
    </script>
    <br>
    <footer style="position: absolute; bottom: 0px; width: 100%; heigth: 205px; padding: 1em 0;"
        class="bg-dark text-center text-white">
        <div class="text-center p-2" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022:
            <a class="text-white" href="https://mdbootstrap.com/">Rio Proveedora</a>
            <p>Contactanos: 828 173 5148</p>
            <div>
                <p>Redes sociales:                 <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-whatsapp"></i></p>

            </div>

        </div>

    </footer>

</body>

</html>