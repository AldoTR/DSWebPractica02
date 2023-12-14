<?php
function cerrarSesion() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();

    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    cerrarSesion();
}


function iniciarSesion() {
    $host = '172.17.0.2';
    $dbname = 'mydb';
    $username = 'postgres';
    $password = 'postgres';
    $port = '5432';

    try {
        $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);

        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        $consulta = "SELECT * FROM usuarios WHERE nombre = :usuario AND pass = :contrasena";

        $stmt = $conexion->prepare($consulta);

        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":contrasena", $contrasena);

        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count == 1) {
            $_SESSION['usuario_autenticado'] = true;
            $_SESSION['usuario'] = $usuario;
            header("Location: home.php");
            exit();
        } else {
            $error = "Credenciales incorrectas. Intente nuevamente.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function agregarUsuario($id, $nombre, $contrasena) {
    $host = '172.17.0.2';
    $dbname = 'mydb';
    $username = 'postgres';
    $password = 'postgres';
    $port = '5432';

    try {
        $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $consulta = "INSERT INTO usuarios (id, nombre, pass) VALUES (:id, :nombre, :contrasena)";

        $stmt = $conexion->prepare($consulta);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":contrasena", $contrasena);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['registrar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    agregarUsuario($id, $nombre, $contrasena);

    header("Location: login.php");
    exit();
}

?>