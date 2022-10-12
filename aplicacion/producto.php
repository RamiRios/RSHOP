<?php
    require '../conexion/config.php';
    require '../conexion/conexion2.php';
    $db = new Database();
    $con = $db->conectar();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    if($id == '' || $token == ''){
        echo 'Error al procesar';
        exit;
    } else {
        $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

        if($token == $token_tmp){ 
            
            $sql = $con->prepare("SELECT count(id) FROM producto WHERE id=? AND activo=1");
            $sql->execute([$id]);
            if($sql->fetchColumn() > 0)
            {

                $sql = $con->prepare("SELECT nombre, descripcion, precio, foto FROM producto WHERE id=? AND activo=1 
                LIMIT 1");
                $sql->execute([$id]);
                $row = $sql ->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre'];
                $descripcion = $row['descripcion'];
                $precio = $row['precio'];
                $foto = $row['foto'];

            }


        } 
        else{
            echo 'Error al procesar 2';
            exit; 
        }
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



    <title>Detalles</title>

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
                                class="fa-solid fa-user"></i>
                            Usuario</a></li>
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
            <div style="padding-left: 1.5em; position: relative; min-height: 100vh;">
                <div class="">
                    <div class="row">
                        <div class="col-md-6 order-md-1">
                            <img src="<?php echo $row['foto']; ?>" class="d-block w-100 card shadow-lg">
                        </div>
                        <br><br><br>
                        <div style="padding-left: 3em; position: relative; min-height: 100vh;"
                            class="col-md-6 order-md-2">
                            <h2><?php echo $row['nombre']; ?></h2>
                            <h2>$ <?php echo $row['precio']; ?></h2>
                            <p class="lead" style="text-align: justify;">
                                <?php echo $row['descripcion']; ?>
                            </p>
                            <div class="col-md-5 offset-md-3 d-grid gap-2">
                                <!--     <button class="btn btn-primary" type="button">Comprar</button> -->
                                <button class="btn btn-lg btn-warning" type="button"
                                    onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Carrito</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </main>

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