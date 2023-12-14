function llenarCampo(clave) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'conexion.php?clave=' + clave, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var registro = JSON.parse(xhr.responseText);
            document.getElementsByName('clave')[0].value = registro.clave;
            document.getElementsByName('nombre')[0].value = registro.nombre;
            document.getElementsByName('direccion')[0].value = registro.direccion;
            document.getElementsByName('telefono')[0].value = registro.telefono;
        }
    };

    xhr.send();
}

function mostrarConfirmacionEliminar(clave) {
    const confirmacion = confirm("¿Quieres eliminar a este usuario?");
    if (confirmacion) {
        window.location.href = `conexion.php?eliminar=${clave}`;
    }
}
document.getElementById("botonGuardar").addEventListener("click", validarCamposVacios);

function validarCamposVacios() {
    const clave = document.querySelector('input[name="clave"]').value;
    const nombre = document.querySelector('input[name="nombre"]').value;
    const direccion = document.querySelector('input[name="direccion"]').value;
    const telefono = document.querySelector('input[name="telefono"]').value;

    if (clave.trim() === '') {
        alert("El campo 'Clave' está vacío.");
    } else if (nombre.trim() === '') {
        alert("El campo 'Nombre' está vacío.");
    } else if (direccion.trim() === '') {
        alert("El campo 'Dirección' está vacío.");
    } else if (telefono.trim() === '') {
        alert("El campo 'Teléfono' está vacío.");
    } else {
        window.location.href = `conexion.php?guardar=true&clave=${clave}&nombre=${nombre}&direccion=${direccion}&telefono=${telefono}`;
    }
}


