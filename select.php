<?php

require("biblioteca/funciones.php");

//Establecemos conexion

$connexion = conn();


//cogemos por post los datos de los select

$selectUser = isset($_POST["selectUser"]) ? strip_tags(trim($_POST["selectUser"])) : "";
$selectPiso = isset($_POST["selectPiso"]) ? strip_tags(trim($_POST["selectPiso"])) : "";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBDD con PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row"><!-- Menu navegacion e info -->
            <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Crud BBDD PDO</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Navegación de palanca"> <span class="navbar-toggler-icon"></span> </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item"> <a class="nav-link active" aria-current="page" href="index.php">Index</a> </li>
                            <li class="nav-item"> <a class="nav-link active" aria-current="page" href="usuarios/usuarios.php">Usuarios</a> </li>
                            <li class="nav-item"> <a class="nav-link active" aria-current="page" href="pisos/pisos.php">Pisos</a> </li>
                            <li class="nav-item"> <a class="nav-link active" aria-current="page" href="select.php">Select</a> </li>
                        </ul>
                        <form class="d-flex">
                            <button class="btn btn-outline-success" type="submit"><?php echo bbddStatus($connexion) ?></button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <div class="row ms-5">
            <div class="col-5 ms-1"><!-- Select usuarios -->
                <form action="#" method="post">
                    <select class="form-select" aria-label="Default select example" name="selectUser">
                        <option selected>Selecciona Usuario</option>
                        <?php echo selectUsuarios($connexion) ?>
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                </form>
            </div>
            <div class="col-5 ms-1"><!-- Select pisos -->
                <form action="#" method="post">
                    <select class="form-select" aria-label="Default select example" name="selectPiso">
                        <option selected>Selecciona Piso</option>
                        <?php echo selectPisos($connexion) ?>
                    </select>
                    <button type="submit" class="btn btn-success mt-3">Enviar</button>
                </form>
            </div>
        </div>

        <div class="row ms-5 mt-3">
            <div class="col-5 border-top"> <!-- Mostrar usuarios -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Clave</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo leerUsuariosSelect($connexion, $selectUser) ?>
                    </tbody>
                </table>
            </div>

            <div class="col-5 border-top"> <!-- Mostrar Pisos -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Clave</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo leerPisosSelect($connexion, $selectPiso) ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>