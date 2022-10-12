<?php


    require '../conexion/config.php';
    require '../conexion/conexion2.php';
    $db = new Database();
    $con = $db->conectar();

    $sql = $con->prepare("SELECT id, nombre, precio, foto FROM producto WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


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


    <!------------------------------>




    <title>Catálogo</title>

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
            <div class="row row-cols-2 row-cols-sm-1 row-cols-md-5 g-3">
                <?php foreach($resultado as $row) { ?>
                <div class="">
                    <div class="card shadow-sm">

                        <img width="100" height="100" src="<?php echo $row['foto']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                            <p class="card-text">$ <?php echo $row['precio']; ?></p>
                            <div class="d-flex justify-content-between align-items-centre">
                                <div class="btn-group">
                                    <a href="../aplicacion/producto.php?id=<?php echo $row['id']; 
                                ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>"
                                        class="btn btn-danger">Detalles</a>
                                </div>
                                <button class="btn btn-warning" type="button"
                                    onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar</button>

                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>

    </main>
<br><br><br><br>

    <script>
    function addProducto(id, token) {
        let url = '../aplicacion/carrito.php'
        let formData = new FormData()
        formData.append('id', id)
        formData.append('token', token)


        fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
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