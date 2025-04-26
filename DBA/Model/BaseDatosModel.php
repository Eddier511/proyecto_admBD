<?php
function AbrirBaseDatos()
{
    $usuario = 'usuario_consulta';
    $contrasena = 'Usuario123';
    $conexion = oci_connect($usuario, $contrasena, 'localhost/XE'); // XE es el nombre por defecto de la base Oracle Express

    if (!$conexion) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }

    return $conexion;
}

function CerrarBaseDatos($conexion)
{
    oci_close($conexion);
}
?>