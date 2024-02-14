<?php

require("../biblioteca/funciones.php");

$nombreValue = "";
$nombreCorreo = "";
$nombreClave = "";
$usuarioid = "";

//Establecemos conexion

$connexion = conn();

insertUser($connexion);


//Borrar Usuario------

$selectUserToDelete = isset($_POST['selectUserDelete']) ? $_POST['selectUserDelete'] : "";

deleteUser($connexion, $selectUserToDelete);


//Leer usuario para rellenar los values del update-----

$selectUserToMod = isset($_POST['selectUserMod']) ? $_POST['selectUserMod'] : "";

try {
    $connexion->beginTransaction();

    $sql = "SELECT * FROM `usuario`";
    $stmt = $connexion->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        if ($row["usuario_id"] == $selectUserToMod) {

            $nombreValue = $row["nombres"];
            $nombreCorreo = $row["correo"];
            $nombreClave = $row["clave"];
            $usuarioid = $row["usuario_id"];
        }
    }

    $connexion->commit();
} catch (PDOException $exception) {
    $connexion->rollBack();
    echo  $exception->getMessage();
}


//Update usuario------

updateUser($connexion);

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
                    <a class="navbar-brand" href="#">Crud BBDD PDO->USUARIOS</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Navegación de palanca"> <span class="navbar-toggler-icon"></span> </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item"> <a class="nav-link active" aria-current="page" href="../index.php">Index</a> </li>
                        </ul>
                        <form class="d-flex">
                            <button class="btn btn-outline-success" type="submit"><?php echo bbddStatus($connexion) ?></button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>


        <div class="row mb-5">
            <div class="col-6 mx-auto border-end border-bottom"><!--  Form de insert User -->
                <h3 class="text-center bg-light">Inserta Usuario</h3>
                <form action="#" method="post">
                    <div class="mb-3"><!--  nombre -->
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombreIn">
                    </div>
                    <div class="mb-3"> <!--  email -->
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="emailIn">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3"><!--  clave -->
                        <label for="clave" class="form-label">Clave</label>
                        <input type="text" class="form-control" id="clave" name="claveIn">
                    </div>
                    <button type="submit" class="btn btn-primary">Insertar</button>
                </form>
            </div>


            <div class="col-5 border-bottom"><!--  Form select usuario a borrar -->
                <h3 class="text-center bg-light">Borra Usuario</h3>
                <form action="#" method="post">
                    <select class="form-select mt-5" aria-label="Default select example" name="selectUserDelete">
                        <option selected>Selecciona Usuario a borrar</option>
                        <?php echo selectUsuarios($connexion) ?>
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Borrar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mx-auto border-end">
                <h3 class="text-center bg-light">Modifica Usuario</h3>
                <form action="#" method="post">
                    <div class="mb-3"><!--  usuario Id -->
                        <label for="name" class="form-label">Id</label>
                        <input type="text" class="form-control" id="nombre" name="usuarioIdMod" readonly value="<?php echo $usuarioid ?>">
                    </div>
                    <div class="mb-3"><!--  nombre -->
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombreMod" value="<?php echo  $nombreValue ?> ">
                    </div>
                    <div class="mb-3"> <!--  email -->
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="emailMod" value="<?php echo $nombreCorreo ?> ">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3"><!--  clave -->
                        <label for="clave" class="form-label">Clave</label>
                        <input type="text" class="form-control" id="clave" name="claveMod" value="<?php echo $nombreClave ?> ">
                    </div>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </form>
            </div>
            <div class="col-5 border-bottom"><!--  Form select usuario a modificar -->
                <h3 class="text-center bg-light">Selecciona Usuario a Modificar</h3>
                <form action="#" method="post">
                    <select class="form-select mt-5" aria-label="Default select example" name="selectUserMod">
                        <option selected>Selecciona Usuario a Modificar</option>
                        <?php echo selectUsuarios($connexion) ?>
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>