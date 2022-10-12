<?php
	session_start();
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';

	$errors = array();

	if(!empty($_POST))
	{
		$usuario = $mysqli->real_escape_string($_POST['usuario']);
		$password = $mysqli->real_escape_string($_POST['password']);

		if (isNullLogin($usuario, $password))
		{
			$errors[] = "Por favor llene todo los campos antes de continuar";
		}

		$errors[] = login($usuario, $password);


	}

	
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Login</title>

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
                </ul>
            </div>
        </div>
    </header>
    <br>
    <main class="main">
    <div class="container">
    <div class="row row-cols-1 row-cols-md-3 mb-3  ">
        <div class="container">
            <div id="loginbox" style="margin-top:50px; padding-right: 20 px" class="card mb-4 rounded-3 shadow-sm">
                <div class="card card-default">
                    <div class="card-heading">
                        <div class="card-header py-3 text-left"><strong>Iniciar Sesi&oacute;n</strong> </div>
                        <!---
                        <div class="card-header py-20 text-center"><a href="recupera.php">¿Se te olvid&oacute; tu
                                contraseña?</a></div>
                                --->
                    </div>


                    <div style="padding-top:30px" class="card-body">

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>"
                            method="POST" autocomplete="off">

                            <div style="margin-bottom: 25px " class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="usuario" type="text" class="form-control" name="usuario" value=""
                                    placeholder="usuario o email" required>
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password"
                                    placeholder="contraseña" required>
                            </div>

                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <button id="btn-login" type="submit" class="btn btn-md btn-dark">Iniciar
                                        Sesi&oacute;n</button>
                                    <button id="btn-cancel" type="submit" class="btn btn-md btn-secondary">
                                        <a style="color: white" href="google.com">Cancelar</a></button>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 0px solid#888; padding-top:15px; font-size:90%">
                                        <a href="registro.php">¿No tienes una cuenta? Registrate aquí</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php echo resultBlock($errors); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>