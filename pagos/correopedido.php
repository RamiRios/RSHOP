<?php
	function enviarEmail2($email, $nombre, $asunto, $cuerpo){

		require '../sistema/vendor/autoload.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
		//$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; //Modificar
        $mail->Host = 'smtp.office365.com';
        $mail->Port = '587'; //Modificar

        $mail->Username = 'RshopRioProveedora@hotmail.com'; //Modificar
        $mail->Password = 'Rioproveedora'; //Modificar

        $mail->setFrom('RshopRioProveedora@hotmail.com', 'RioProveedora'); //Modificar
        $mail->addAddress($email, $nombre);

        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->IsHTML(true);

        if($mail->send())
        return true;
        else
        return false;
    }


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




    $email = $row['correo'];
    $nombre = $row['nombre'];
    $asunto = 'Gracias por comprar en R-shop';
    $cuerpo = "Hola $nombre, gracias por comprar en R-shop.<br /><br />
    Si tienes alguna duda de tu pedido por favor contacta a este numero: 828 173 5148";
    

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

    unset($_SESSION['carrito']['productos']);
   

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
  
    <main class="main">

  <?php  if (enviarEmail2($email, $nombre, $asunto, $cuerpo)){
echo "Gracias por pedir con R-shop, se le enviara un correo con información de contacto";
    }
    ?>
    </main>

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