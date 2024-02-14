<?php

/* FUNCIONES COMUNES -------------------------*/


// Funcion para conectarse a BBDD

function conn()
{
    $servername = "localhost";
    $dbname = "inmobiliaria";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}

//Comprobamos conexion

function bbddStatus($conn)
{
    if ($conn) {

        return "conexion establecida";
    }
}

// Funcion Generica leer usuarios

function leerUsuarios($conn)
{
    $output = "";

    try {
        $conn->beginTransaction();

        $sql = "SELECT * FROM `usuario`";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= "<tr>";
            $output .= "<th scope='row'>" . $row["usuario_id"] . "</th>";
            $output .= "<td>" . $row["nombres"] . "</td>";
            $output .= "<td>" . $row["correo"] . "</td>";
            $output .= "<td>" . $row["clave"] . "</td>";
            $output .= "</tr>";
        }

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo  $exception->getMessage();
    }

    return $output;
}

//Funcion generica leer pisos

function leerPisos($conn)
{
    $output = "";

    try {
        $conn->beginTransaction();

        $sql = "SELECT * FROM `pisos`";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= "<tr>";
            $output .= "<th scope='row'>" . $row["Codigo_piso"] . "</th>";
            $output .= "<td>" . $row["calle"] . "</td>";
            $output .= "<td>" . $row["numero"] . "</td>";
            $output .= "<td>" . $row["piso"] . "</td>";
            $output .= "<td>" . $row["puerta"] . "</td>";
            $output .= "<td>" . $row["cp"] . "</td>";
            $output .= "<td>" . $row["metros"] . "</td>";
            $output .= "<td>" . $row["zona"] . "</td>";
            $output .= "<td>" . $row["precio"] . "</td>";
            $output .= "<td>" . $row["imagen"] . "</td>";
            $output .= "<td>" . $row["usuario_id"] . "</td>";
            $output .= "</tr>";
        }

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo  $exception->getMessage();
    }

    return $output;
}

/* CRUD PISOS -------------------------------*/


// Funcion para leer el select de pisos

function leerPisosSelect($conn, $data)
{
    $output = "";

    try {
        $conn->beginTransaction();

        $sql = "SELECT * FROM `pisos`";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($data == $row["Codigo_piso"]) {
                $output .= "<tr>";
                $output .= "<th scope='row'>" . $row["Codigo_piso"] . "</th>";
                $output .= "<td>" . $row["calle"] . "</td>";
                $output .= "<td>" . $row["numero"] . "</td>";
                $output .= "<td>" . $row["piso"] . "</td>";
                $output .= "<td>" . $row["puerta"] . "</td>";
                $output .= "<td>" . $row["cp"] . "</td>";
                $output .= "<td>" . $row["metros"] . "</td>";
                $output .= "<td>" . $row["zona"] . "</td>";
                $output .= "<td>" . $row["precio"] . "</td>";
                $output .= "<td>" . $row["imagen"] . "</td>";
                $output .= "<td>" . $row["usuario_id"] . "</td>";
                $output .= "</tr>";
            }
        }

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo  $exception->getMessage();
    }

    return $output;
}

//Funcion generica para hacer un select con los pisos

function selectPisos($conn)
{
    $output = "";

    try {
        $conn->beginTransaction();

        $sql = "SELECT * FROM `pisos`";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $output .= "<option value=" . $row["Codigo_piso"] . ">" . $row["Codigo_piso"] . " - " . $row["calle"] . "</option>";
        }

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo  $exception->getMessage();
    }

    return $output;
}

// Funcion Insertar Piso

function insertPiso($conn)
{
    $codigoPiso = isset($_POST["codigoPiso"]) ? trim(strip_tags($_POST["codigoPiso"])) : "";
    $calle = isset($_POST["calle"]) ? trim(strip_tags($_POST["calle"])) : "";
    $numero = isset($_POST["numero"]) ? trim(strip_tags($_POST["numero"])) : "";
    $piso = isset($_POST["piso"]) ? trim(strip_tags($_POST["piso"])) : "";
    $puerta = isset($_POST["puerta"]) ? trim(strip_tags($_POST["puerta"])) : "";
    $cp = isset($_POST["cp"]) ? trim(strip_tags($_POST["cp"])) : "";
    $metros = isset($_POST["metros"]) ? trim(strip_tags($_POST["metros"])) : "";
    $zona = isset($_POST["zona"]) ? trim(strip_tags($_POST["zona"])) : "";
    $precio = isset($_POST["precio"]) ? trim(strip_tags($_POST["precio"])) : "";
    $imagen = isset($_POST["imagen"]) ? trim(strip_tags($_POST["imagen"])) : "";
    $usuarioId = isset($_POST["usuario_id"]) ? trim(strip_tags($_POST["usuario_id"])) : "";

    try {
        if ($codigoPiso && $calle && $numero && $piso && $puerta && $cp && $metros && $zona && $precio && $imagen && $usuarioId) {

            $conn->beginTransaction();

            $stmt = $conn->prepare("INSERT INTO `pisos` (`Codigo_piso`, `calle`, `numero`, `piso`, `puerta`, `cp`,`metros`, `zona`, `precio`, `imagen`, `usuario_id`) VALUES (:1,:2,:3,:4,:5,:6,:7,:8,:9,:10,:11)");

            $stmt->bindParam(':1', $codigoPiso, PDO::PARAM_STR);
            $stmt->bindParam(':2', $calle, PDO::PARAM_STR);
            $stmt->bindParam(':3', $numero, PDO::PARAM_STR);
            $stmt->bindParam(':4', $piso, PDO::PARAM_STR);
            $stmt->bindParam(':5', $puerta, PDO::PARAM_STR);
            $stmt->bindParam(':6', $cp, PDO::PARAM_STR);
            $stmt->bindParam(':7', $metros, PDO::PARAM_STR);
            $stmt->bindParam(':8', $zona, PDO::PARAM_STR);
            $stmt->bindParam(':9', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':10', $imagen, PDO::PARAM_STR);
            $stmt->bindParam(':11', $usuarioId, PDO::PARAM_STR);


            $stmt->execute();

            $conn->commit();
        }
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo $exception->getMessage();
    }
}

// Funcion de borrado de piso

function deletePiso($conn, $data)
{
    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM `pisos` WHERE `Codigo_piso` = :code");

        $stmt->bindParam(':code', $data, PDO::PARAM_INT);
        $stmt->execute();

        $conn->commit();

        return "Usuario eliminado correctamente";
    } catch (PDOException $exception) {
        $conn->rollBack();
        return "Error al eliminar usuario: " . $exception->getMessage();
    }
}

//Modificar Piso

function updatePiso($conn)
{
    $codigoPiso = isset($_POST["codigoPisoMod"]) ? trim(strip_tags($_POST["codigoPisoMod"])) : "";
    $calle = isset($_POST["calleMod"]) ? trim(strip_tags($_POST["calleMod"])) : "";
    $numero = isset($_POST["numeroMod"]) ? trim(strip_tags($_POST["numeroMod"])) : "";
    $piso = isset($_POST["pisoMod"]) ? trim(strip_tags($_POST["pisoMod"])) : "";
    $puerta = isset($_POST["puertaMod"]) ? trim(strip_tags($_POST["puertaMod"])) : "";
    $cp = isset($_POST["cpMod"]) ? trim(strip_tags($_POST["cpMod"])) : "";
    $metros = isset($_POST["metrosMod"]) ? trim(strip_tags($_POST["metrosMod"])) : "";
    $zona = isset($_POST["zonaMod"]) ? trim(strip_tags($_POST["zonaMod"])) : "";
    $precio = isset($_POST["precioMod"]) ? trim(strip_tags($_POST["precioMod"])) : "";
    $imagen = isset($_POST["imagenMod"]) ? trim(strip_tags($_POST["imagenMod"])) : "";
    $usuarioId = isset($_POST["usuario_idMod"]) ? trim(strip_tags($_POST["usuario_idMod"])) : "";

    try {


        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE `pisos` SET  `calle`=:2, `numero`=:3, `piso`=:4, `puerta`=:5, `cp`=:6, `metros`=:7, `zona`=:8, `precio`=:9, `imagen`=:10, `usuario_id`=:11 WHERE `Codigo_piso`='$codigoPiso'");

    
        $stmt->bindParam(':2', $calle, PDO::PARAM_STR);
        $stmt->bindParam(':3', $numero, PDO::PARAM_STR);
        $stmt->bindParam(':4', $piso, PDO::PARAM_STR);
        $stmt->bindParam(':5', $puerta, PDO::PARAM_STR);
        $stmt->bindParam(':6', $cp, PDO::PARAM_STR);
        $stmt->bindParam(':7', $metros, PDO::PARAM_STR);
        $stmt->bindParam(':8', $zona, PDO::PARAM_STR);
        $stmt->bindParam(':9', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':10', $imagen, PDO::PARAM_STR);
        $stmt->bindParam(':11', $usuarioId, PDO::PARAM_STR);

        $stmt->execute();

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo $exception->getMessage();
    }
}




/* CRUD USUARIOS  --------------------------*/


//Insertar usuario

function insertUser($conn)
{
    $userNameIn = isset($_POST["nombreIn"]) ? trim(strip_tags($_POST["nombreIn"])) : "";
    $userEmailIn = isset($_POST["emailIn"]) ? trim(strip_tags($_POST["emailIn"])) : "";
    $userClaveIn = isset($_POST["claveIn"]) ? trim(strip_tags($_POST["claveIn"])) : "";

    try {
        if ($userClaveIn && $userEmailIn && $userNameIn) {

            $conn->beginTransaction();

            $stmt = $conn->prepare("INSERT INTO `usuario` (`nombres`, `correo`, `clave`) VALUES (:1, :2, :3)");

            $stmt->bindParam(':1', $userNameIn, PDO::PARAM_STR);
            $stmt->bindParam(':2', $userEmailIn, PDO::PARAM_STR);
            $stmt->bindParam(':3', $userClaveIn, PDO::PARAM_STR);


            $stmt->execute();

            $conn->commit();
        }
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo $exception->getMessage();
    }
}

//Borrar Usuario

function deleteUser($conn, $data)
{
    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM `usuario` WHERE `usuario_id` = :usuario_id");
        $stmt->bindParam(':usuario_id', $data, PDO::PARAM_INT);
        $stmt->execute();

        $conn->commit();

        return "Usuario eliminado correctamente";
    } catch (PDOException $exception) {
        $conn->rollBack();
        return "Error al eliminar usuario: " . $exception->getMessage();
    }
}

//Modificar Usuario

function updateUser($conn)
{
    $userNameMod = isset($_POST["nombreMod"]) ? trim(strip_tags($_POST["nombreMod"])) : "";
    $userEmailMod = isset($_POST["emailMod"]) ? trim(strip_tags($_POST["emailMod"])) : "";
    $userClaveMod = isset($_POST["claveMod"]) ? trim(strip_tags($_POST["claveMod"])) : "";
    $userIdMod = isset($_POST["usuarioIdMod"]) ? trim(strip_tags($_POST["usuarioIdMod"])) : "";

    try {
        if ($userClaveMod && $userEmailMod && $userNameMod) {

            $conn->beginTransaction();

            $stmt = $conn->prepare("UPDATE `usuario` SET `nombres`=:nombre, `correo`=:correo, `clave`=:clave WHERE `usuario_id`=:usuario_id");
            $stmt->bindParam(':nombre', $userNameMod, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $userEmailMod, PDO::PARAM_STR);
            $stmt->bindParam(':clave', $userClaveMod, PDO::PARAM_STR);
            $stmt->bindParam(':usuario_id', $userIdMod, PDO::PARAM_INT);
      
            $stmt->execute();

            $conn->commit();
        }
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo $exception->getMessage();
    }
}

// Funcion para imprimir las selecciones en html del select 

function leerUsuariosSelect($conn, $data)
{
    $output = "";

    try {
        $conn->beginTransaction();

        $sql = "SELECT * FROM `usuario`";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($data == $row["usuario_id"]) {
                $output .= "<tr>";
                $output .= "<th scope='row'>" . $row["usuario_id"] . "</th>";
                $output .= "<td>" . $row["nombres"] . "</td>";
                $output .= "<td>" . $row["correo"] . "</td>";
                $output .= "<td>" . $row["clave"] . "</td>";
                $output .= "</tr>";
            }
        }

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo  $exception->getMessage();
    }

    return $output;
}

// Funcion generica para hacer un select de usuarios

function selectUsuarios($conn)
{
    $output = "";

    try {
        $conn->beginTransaction();

        $sql = "SELECT * FROM `usuario`";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $output .= "<option value=" . $row["usuario_id"] . ">" . $row["usuario_id"] . " - " . $row["nombres"] . "</option>";
        }

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        echo  $exception->getMessage();
    }

    return $output;
}