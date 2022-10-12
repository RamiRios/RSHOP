<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Ingresar producto</title>


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="../lib/js/jquery-2.1.4.min.js"></script>
    <script src="../lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../lib/css/bootstrap.css">
    </link>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <script src="js/bootstrap.min.js"></script>

    <script src="../app.js"></script>
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

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-3 justify-content-center mb-md-0">
                    <li><a href="../aplicacion/catalogo.php" class="nav-link px-2 text-white"><i
                                class="fa-solid fa-house"></i> Inicio</a></li>

                    <li><a href="../sistema/usuario.php" class="nav-link px-2 text-white"><i
                                class="fa-solid fa-user"></i> Usuario</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="nav-link px-10 text-white" href='../sistema/logout.php'><i
                                class="fa-solid fa-power-off"></i> Cerrar Sesi&oacute;n</a></li>
                </ul>
            </div>
        </div>
    </header>
    <br>
    <div class="container">
        <br><br>
        <h2>Ingresar los datos del producto </h2>
        <br><br>
        <div class="col-sm-6">
            <form id="frm_registrar" method="POST">
                <label>Nombre: </label>
                <input name="txtNombre" type="text" class="form-control">

                <label> Descripción: </label>
                <input name="txtDescripcion" type="text" class="form-control">

                <label>Precio: </label>
                <input name="txtPrecio" type="text" class="form-control">

                <label>Imagen: </label>
                <select id="fotoSelect" class="form-control" name="txtFoto" style="font-size: 15px;">
                    <option value="../imagenes/img0.jpg">Seleccionar</option>
                    <option value="../imagenes/img1.jpg">Imagen 1</option>
                    <option value="../imagenes/img2.jpg">Imagen 2</option>
                    <option value="../imagenes/img3.jpg">Imagen 3</option>
                    <option value="../imagenes/img4.jpg">Imagen 4</option>
                    <option value="../imagenes/img5.jpg">Imagen 5</option>
                    <option value="../imagenes/img6.jpg">Imagen 6</option>
                </select>

                <br>
                <img id="foto" width="300" height="300" src="../imagenes/img0.jpg" />

                <script type="text/javascript">
                fotoSelect.addEventListener("change", () => {
                    foto.setAttribute("src", fotoSelect.selectedOptions[0].value)
                })
                </script>



                <br><br>
                <button type="button" id="btnGuardar" class="btn btn-lg btn-dark"> Guardar </button>
                <button type="reset" id="btnCancelar" class="btn btn-lg btn-outline-dark"> Cancelar </button>



            </form>

        </div>

        <div class="col-sm-6">
            <table class="table table.responsive">
                <thead>
                    <tr>
                        <th>Nombre</th>

                        <th>Precio</th>
                        <th>Foto</th>

                    </tr>
                </thead>

                <?php

                include "../conexion/conexion.php";

                $sql = "SELECT * FROM producto";
                $ejecutar = mysqli_query($conexion, $sql);

                while ($fila = mysqli_fetch_array($ejecutar)) {

                    $datos = $fila[0] . "||" .
                        $fila[1] . "||" .
                        $fila[2] . "||" .
                        $fila[3] . "||" .
                        $fila[4] . "||" .
                        $fila[5];

                ?>

                <tbody>
                    <td> <?php echo $fila[1] ?> </td>
                    <td> <?php echo $fila[3] ?> </td>
                    <td> <img src="<?php echo $fila[4] ?>" width="50" height="50"> </td>



                    <th><button class="btn btn-lg btn-danger modal-trigger" data-toggle="modal"
                            data-target="#modal_editar" onclick="llenarModalActualizar('<?php echo $datos ?>');">
                            Eliminar </button></th>


                </tbody>

                <?php
                    
                    }

                            ?>
            </table>

        </div>


        <!---------VENTANA MODAL---------->



        <div id="modal_editar" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">¿Está seguro que quiere eliminar?</h4>
                    </div>


                    <div class="modal-body">
                        <!--Formulario de Actualizar aquí-->



                        <form id="frm_actualizar" method="POST">



                            <input style="display:none;" id="e_id" name="e_id" type="text" class="form-control">
                            <div class="container-fluid h-100">
                                <div class="row w-100 align-items-center">
                                    <div class="col text-center">
                                        <button type="button" id="btnEliminar" class="btn btn-lg btn-danger"> Sí, estoy
                                            seguro que deseo eliminar</button>
                                    </div>
                                </div>




                        </form>


                    </div>
                </div>

            </div>
        </div>


        <!-------------------------------->
    </div>

</body>

</html>