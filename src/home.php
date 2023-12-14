<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: login.php");
    exit();
}
include('conexion.php');
?>
<html>
<head>
    <title>CRUD</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
    <form method="POST" action="session.php">
        <input type="submit" name="logout" value="Cerrar Sesión">
    </form>
    <h1>CRUD</h1>
    
    <form>
        <table>
            <tr>
                <td>
                    <label for="clave">Clave:</label>
                    <input type="number" name="clave">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono">
                </td>
            </tr>
        </table>
        <button type="button" id="botonGuardar">Guardar</button>
    </form>

    <hr>

    <h2>Registros</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                lista();
            ?>
        </tbody>
    </table>
    <script src="notificacion.js"></script>
</body>
</html>