<?php
function AbrirBaseDatos()
{
    $usuario = 'usuario_consulta';
    $contrasena = 'Usuario123';
    $charset = 'AL32UTF8';
    $conexion = oci_connect($usuario, $contrasena, 'localhost/XE',$charset); // XE es el nombre por defecto de la base Oracle Express

    if (!$conexion) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
    $sql = "ALTER SESSION SET NLS_LANGUAGE='SPANISH' NLS_TERRITORY='SPAIN' NLS_CHARACTERSET='AL32UTF8'";
    $stmt = oci_parse($conexion, $sql);
    return $conexion;
}

function CerrarBaseDatos($conexion)
{
    oci_close($conexion);
}
?>