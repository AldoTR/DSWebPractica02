<?php
$host = '172.17.0.2';
$dbname = 'mydb';
$username = 'postgres';
$password = 'postgres';
$port = '5432';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

function guardarRegistro($clave, $nombre, $direccion, $telefono) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM ejemplo WHERE clave = ?");
    $stmt->execute([$clave]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $stmt = $pdo->prepare("UPDATE ejemplo SET nombre = ?, direccion = ?, telefono = ? WHERE clave = ?");
        $stmt->execute([$nombre, $direccion, $telefono, $clave]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO ejemplo (clave, nombre, direccion, telefono) VALUES (?, ?, ?, ?)");
        $stmt->execute([$clave, $nombre, $direccion, $telefono]);
    }
}

function obtenerRegistros() {
    global $pdo;

    $stmt = $pdo->query("SELECT * FROM ejemplo");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function eliminarRegistro($clave) {
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM ejemplo WHERE clave = ?");
    $stmt->execute([$clave]);
}

function obtenerClave($clave) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM ejemplo WHERE clave = ?");
    $stmt->execute([$clave]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['guardar']) && $_GET['guardar'] === 'true') {
    $clave = $_GET['clave'];
    $nombre = $_GET['nombre'];
    $direccion = $_GET['direccion'];
    $telefono = $_GET['telefono'];

    guardarRegistro($clave, $nombre, $direccion, $telefono);

    header("Location: index.php");
    exit();
}

if (isset($_GET['clave'])) {
    $clave = $_GET['clave'];
    $registro = obtenerClave($clave);

    if ($registro) {
        header('Content-Type: application/json');
        echo json_encode($registro);
    }
}

if (isset($_GET['editar'])) {
    $clave = $_GET['editar'];
    //Editar
}

if (isset($_GET['eliminar'])) {
    $clave = $_GET['eliminar'];
    eliminarRegistro($clave);
    header("Location: index.php");
    exit();
}

function lista(){
    $registros = obtenerRegistros();

    foreach ($registros as $registro) {
        echo "<tr>";
        echo "<td><a href='javascript:void(0);' onclick='llenarCampo(\"{$registro['clave']}\");'> {$registro['clave']} </a></td>";
        echo "<td>{$registro['nombre']}</td>";
        echo "<td>{$registro['direccion']}</td>";
        echo "<td>{$registro['telefono']}</td>";
        echo "<td><a href='conexion.php?editar={$registro['clave']}'>Editar</a></td>";
        echo "<td><a href='javascript:void(0);' onclick='mostrarConfirmacionEliminar(\"{$registro['clave']}\");'>Eliminar</a></td>";
        echo "</tr>";
    }
}

?>