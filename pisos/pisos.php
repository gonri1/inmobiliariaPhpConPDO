<?php

require("../biblioteca/funciones.php");

$connexion = conn();

$codigoPiso = "";
$calle = "";
$numero = "";
$piso = "";
$puerta = "";
$cp = "";
$metros = "";
$zona = "";
$precio = "";
$imagen = "";
$usuarioId = "";


//Insertar piso

insertPiso($connexion);

//Borrado Piso

$selectPisoDelete = isset($_POST["selectPisoDelete"]) ? $_POST["selectPisoDelete"] : "";

deletePiso($connexion, $selectPisoDelete);


//Leer pisos para rellenar los values del update-----

$selectPisoToMod = isset($_POST['selectPisoMod']) ? $_POST['selectPisoMod'] : "";

try {
    $connexion->beginTransaction();

    $sql = "SELECT * FROM `pisos`";
    $stmt = $connexion->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        if ($row["Codigo_piso"] == $selectPisoToMod) {

            $codigoPiso = $row["Codigo_piso"];
            $calle = $row["calle"];
            $numero = $row["numero"];
            $piso = $row["piso"];
            $puerta = $row["puerta"];
            $cp = $row["cp"];
            $metros = $row["metros"];
            $zona = $row["zona"];
            $precio = $row["precio"];
            $imagen = $row["imagen"];
            $usuarioId = $row["usuario_id"];
        }
    }

    $connexion->commit();
} catch (PDOException $exception) {
    $connexion->rollBack();
    echo  $exception->getMessage();
}


//Modificar piso

updatePiso($connexion); 

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
                    <a class="navbar-brand" href="#">Crud BBDD PDO->PISOS</a>
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
            <div class="col-6 mx-auto border-end border-bottom"><!--  Form de insert Piso -->
                <h3 class="text-center bg-light">Inserta Piso</h3>
                <form action="#" method="post">
                    <div class="mb-3"><!--  nombre -->
                        <label class="form-label">Codigo Piso</label>
                        <input type="number" class="form-control" name="codigoPiso" required>
                    </div>
                    <div class="mb-3"><!--  calle -->
                        <label class="form-label">Calle</label>
                        <input type="text" class="form-control" name="calle" required>
                    </div>
                    <div class="mb-3"><!--  Numero -->
                        <label for="clave" class="form-label">Numero</label>
                        <input type="text" class="form-control" name="numero" required>
                    </div>
                    <div class="mb-3"><!--  piso -->
                        <label class="form-label">Piso</label>
                        <input type="text" class="form-control" name="piso" required>
                    </div>
                    <div class="mb-3"><!--  puerta -->
                        <label class="form-label">Puerta</label>
                        <input type="text" class="form-control" name="puerta" required>
                    </div>
                    <div class="mb-3"><!--  cp -->
                        <label class="form-label">Cp</label>
                        <input type="text" class="form-control" name="cp" required>
                    </div>
                    <div class="mb-3"><!--  metros -->
                        <label class="form-label">Metros</label>
                        <input type="text" class="form-control" name="metros" required>
                    </div>
                    <div class="mb-3"><!--  zona -->
                        <label class="form-label">Zona</label>
                        <input type="text" class="form-control" name="zona" required>
                    </div>
                    <div class="mb-3"><!--  precio -->
                        <label class="form-label">Precio</label>
                        <input type="text" class="form-control" name="precio" required>
                    </div>
                    <div class="mb-3"><!--  imagen -->
                        <label class="form-label">Imagen</label>
                        <input type="text" class="form-control" name="imagen" required>
                    </div>
                    <div class="mb-3"><!--  Usuario Id -->
                        <label class="form-label">Usuario id</label>
                        <input type="text" class="form-control" name="usuario_id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Insertar</button>
                </form>
            </div>


            <div class="col-5 border-bottom"><!--  Form select piso a borrar -->
                <h3 class="text-center bg-light">Borra Piso</h3>
                <form action="#" method="post">

                    <select class="form-select mt-5" aria-label="Default select example" name="selectPisoDelete">
                        <option selected>Selecciona Piso a borrar</option>
                        <?php echo selectPisos($connexion) ?>
                    </select>

                    <button type="submit" class="btn btn-primary mt-3">Borrar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mx-auto border-end border-bottom"><!--  Form de modificacion Piso -->
                <h3 class="text-center bg-light">Modifica Piso</h3>
                <form action="#" method="post">
                    <div class="mb-3"><!--  nombre -->
                        <label class="form-label">Codigo Piso</label>
                        <input type="number" class="form-control" name="codigoPisoMod" value="<?php echo $codigoPiso ?>" readonly>
                    </div>
                    <div class="mb-3"><!--  calle -->
                        <label class="form-label">Calle</label>
                        <input type="text" class="form-control" name="calleMod" value="<?php echo $calle ?>">
                    </div>
                    <div class="mb-3"><!--  Numero -->
                        <label for="clave" class="form-label">Numero</label>
                        <input type="text" class="form-control" name="numeroMod" value="<?php echo $numero ?>">
                    </div>
                    <div class="mb-3"><!--  piso -->
                        <label class="form-label">Piso</label>
                        <input type="text" class="form-control" name="pisoMod" value="<?php echo $piso ?>">
                    </div>
                    <div class="mb-3"><!--  puerta -->
                        <label class="form-label">Puerta</label>
                        <input type="text" class="form-control" name="puertaMod" value="<?php echo $puerta ?>">
                    </div>
                    <div class="mb-3"><!--  cp -->
                        <label class="form-label">Cp</label>
                        <input type="text" class="form-control" name="cpMod" value="<?php echo $cp ?>">
                    </div>
                    <div class="mb-3"><!--  metros -->
                        <label class="form-label">Metros</label>
                        <input type="text" class="form-control" name="metrosMod" value="<?php echo $metros ?>">
                    </div>
                    <div class="mb-3"><!--  zona -->
                        <label class="form-label">Zona</label>
                        <input type="text" class="form-control" name="zonaMod" value="<?php echo $zona ?>">
                    </div>
                    <div class="mb-3"><!--  precio -->
                        <label class="form-label">Precio</label>
                        <input type="text" class="form-control" name="precioMod" value="<?php echo $precio ?>">
                    </div>
                    <div class="mb-3"><!--  imagen -->
                        <label class="form-label">Imagen</label>
                        <input type="text" class="form-control" name="imagenMod" value="<?php echo $imagen ?>">
                    </div>
                    <div class="mb-3"><!--  Usuario Id -->
                        <label class="form-label">Usuario id</label>
                        <input type="text" class="form-control" name="usuario_idMod" value="<?php echo $usuarioId ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </form>
            </div>
            <div class="col-5 border-bottom"><!--  Form select usuario a modificar -->
                <h3 class="text-center bg-light">Selecciona Piso a Modificar</h3>
                <form action="#" method="post">

                    <select class="form-select mt-5" aria-label="Default select example" name="selectPisoMod">
                        <option selected>Selecciona Usuario a Modificar</option>
                        <?php echo selectPisos($connexion) ?>
                    </select>

                    <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>