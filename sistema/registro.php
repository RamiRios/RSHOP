<?php
	
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';
	
	$errors = array();
	
	if(!empty($_POST))
{

$nombre = 		$mysqli -> real_escape_string($_POST['nombre']);
$direccion = 	$mysqli -> real_escape_string($_POST['direccion']);
$usuario = 		$mysqli -> real_escape_string($_POST['usuario']);
$password = 	$mysqli -> real_escape_string($_POST['password']);
$con_password = $mysqli -> real_escape_string($_POST['con_password']);
$email = 		$mysqli -> real_escape_string($_POST['email']);
$captcha = 		$mysqli -> real_escape_string($_POST['g-recaptcha-response']);


$activo = 0;
$tipo_usuario = 2;

$ciudad = "Cadereyta Jimenez N.L.";

$secret = '6Ld0LsogAAAAALnc6tGMyFstNYaU5pCmLgV26Gye';

if(!$captcha){
	$errors[]="Verifica el captcha";
}

if(isNull($nombre, $usuario, $password, $con_password, $email)){
	$errors[] = "Debe llenar todos los campos";
}

if(!isEmail($email)){
	$errors[] = "Correo inválido";
}

if(!validaPassword($password, $con_password)){
	$errors[] = "Las contraseñas no coinciden";
}

if(usuarioExiste($usuario)){
	$errors[] = "El usuario $usuario ya existe";
}

if(emailExiste($email)){
	$errors[] = "Este correo electronico ya está registrado";
}

if(count($errors)==0)
{
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");

	$arr = json_decode($response, TRUE);

	if($arr['success'])
	{
		$pass_hash = hashPassword($password);
		$token 	   = generateToken ();

		$registro = registraUsuario($usuario, $pass_hash, $nombre, $ciudad, $direccion, $email, $activo, $token, $tipo_usuario);

		if($registro > 0 )
		{
			$url ='http://'.$_SERVER["SERVER_NAME"].
			'/rshop/sistema/activar.php?id='.$registro.'&val='.$token;

			$asunto = 'Confirma tu cuenta de R-shop';
			$cuerpo = "Hola $nombre, gracias por registrarte en R-shop.<br /><br />
			Valida tu cuenta para empezar a adquirir productos en nuestro sitio.
			Haz clic en la siguiente enlace para validar tu cuenta: <a href='$url'> Confirmar cuenta </a>";

			if(enviarEmail($email, $nombre, $asunto, $cuerpo)){

				echo "Para terminar con el proceso de registro siga las instrucciones que hemos enviado al correo electrónico: $email";
				echo "<br><a href='index.php'>Iniciar sesión</a>";
				exit;
			}else{
				$errors[] = "Error al enviar Email";
			}

		}else{
			$errors[] = "Error al registrar";

		}
			}else{
			$errors[] = 'Error al comprobar el captcha'; 
	}
}


}
?>

<!doctype html>

<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Registro</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script>
    function SoloLetras(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toString();
        letras = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚabcdefghijklmnopqrstuvwxyzáéíóú";

        especiales = [8, 13];
        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }
    </script>
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
                    <li><a href="../aplicacion/catalogo.php" class="nav-link px-2 text-white"><i class="fa-solid fa-house"></i> Inicio</a></li>
                </ul>

            </div>
        </div>
    </header>
<br>
<main class="main">
    <div class="container">
    <div class="row row-cols-1 row-cols-lg-3 mb-2">
        <div class="container">
            <div id="loginbox" style="margin-top:50px; padding-right: 30 px" class="card mb-4 rounded-3 shadow-sm">
                <div class="card card-default">
                    <div class="card-heading">
                        <div class="card-header py-3 text-left"><strong>Reg&iacute;strate</strong></div>
                        <div class="card-header py-20 text-center"><a id="signinlink" href="index.php">Iniciar
                                Sesi&oacute;n</a></div>
                    </div>


                    <div style="padding-top:30px" class="card-body">

                        <form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>"
                            method="POST" autocomplete="off">

                            <div id="signupalert" style="display:none" class="alert alert-danger">
                                <p>Error:</p>
                                <span></span>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <input onkeypress="return SoloLetras(event);" minlength="4" maxlength="8" size="10"
                                        type="text" class="form-control" name="nombre" placeholder="Nombre"
                                        value="<?php if(isset($nombre)) echo $nombre; ?>" style="margin-bottom: 25px"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Dirección"
                                        value="Cadereyta Jiménez N.L." style="margin-bottom: 25px" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="direccion" placeholder="Dirección"
                                        value="<?php if(isset($direccion)) echo $direccion; ?>"
                                        style="margin-bottom: 25px" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="usuario" placeholder="Usuario"
                                        value="<?php if(isset($usuario)) echo $usuario; ?>" style="margin-bottom: 25px"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <input minlength="8" maxlength="16" type="password" class="form-control"
                                        name="password" placeholder="Contraseña" style="margin-bottom: 25px" required>
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="con_password"
                                        placeholder="Confirmar contraseña" style="margin-bottom: 25px" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                        value="<?php if(isset($email)) echo $email; ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="captcha" class="col-md-3 control-label"></label>
                                <div class="g-recaptcha col-md-9"
                                    data-sitekey="6Ld0LsogAAAAAJ_uvuPZojhe6-CuL2WYWWnsZKxZ"></div>
                            </div>
                            <br>

                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <button id="btn-signup" type="submit" class="btn btn-dark"><i
                                            class="icon-hand-right"></i>Registrar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>