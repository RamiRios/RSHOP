<?php
	
	session_start();
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';


	if(!isset($_SESSION["id_usuario"])){
		header("Location: index.php");

	}

	$idUsuario = $_SESSION['id_usuario'];

	$sql = "SELECT id, nombre, direccion, usuario, correo FROM usuarios WHERE id = '$idUsuario'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

?>

<!doctype html>
<html lang="es">

<head>

    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <script src="js/bootstrap.min.js"></script>

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
                    <?php if($_SESSION['tipo_usuario']==1) { ?>
                    <ul class='nav navbar-nav'>
                        <li><a class="nav-link px-2 text-white" href='../ingProduc/index.php'><i
                                    class="fa-solid fa-cart-plus"></i> Administrar
                                productos</a></li>
                    </ul>
                    <li><a class="nav-link px-2 text-white" href='../pedidos/Administrar_pedidos.php'>
                    <i class="fa-solid fa-bag-shopping"></i> Pedidos</a></li>
                    <li><a class="nav-link px-2 text-white" href='../pedidos/ventas.php'>
                    <i class="fa-solid fa-clipboard-check"></i> Ventas</a></li>
                    <?php } ?>
                </ul>

                <a class="nav-link px-10 text-white" style="padding: 0px 50px;" href='logout.php'><i
                        class="fa-solid fa-power-off"></i> Cerrar
                    Sesi&oacute;n</a>

            </div>
        </div>
    </header>
    <br>

    <div class="container">

        <nav class='navbar navbar-default'>
            <div class='container-fluid'>
                <div class='navbar-header'>

                </div>

                <div id='navbar' class='navbar-collapse collapse'>
                    <ul class='nav navbar-nav'>
                        <li class='active'><a href='welcome.php'>Inicio</a></li>
                    </ul>



                    <ul class='nav navbar-nav navbar-right'>
                        <li><a href='logout.php'>Cerrar Sesi&oacute;n</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="jumbotron card shadow-lg" style="padding-left: 2em; ">
        <br>
                        <img src="../imagenes/usuario.png" width="150" height="150">
                        
                        <br>
            <h3><?php echo 'Nombre: '.utf8_decode($row['nombre']); ?></h3>
            <h3><?php echo 'Correo: '.utf8_decode($row['correo']); ?></h3>
            <h3><?php echo 'Nombre de usuario: '.utf8_decode($row['usuario']); ?></h3>
            <h3><?php echo 'Dirección: '.utf8_decode($row['direccion']); ?></h3>
            <br />



        </div>
    </div>
    <br><br><br><br>
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