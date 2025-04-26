<?php
require_once(__DIR__ . '/BaseDatosModel.php');

class ProductoModel {

    /**
     * Obtiene todos los productos o un producto específico si se pasa el ID
     */
    public function obtenerTodosLosProductos() {
        $conn = AbrirBaseDatos();
        $productos = array();

        try {
            $sql = "BEGIN
                        operaciones_tablas.sp_obtener_productos(
                            :cursor_productos,
                            :mensaje_error
                        );
                    END;";

            $stmt = oci_parse($conn, $sql);

            // Bind de parámetros de salida
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ':cursor_productos', $cursor, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':mensaje_error', $mensajeError, 2000);

            // Ejecutar
            if (!oci_execute($stmt)) {
                throw new Exception("Error al ejecutar procedimiento");
            }

            if (!empty($mensajeError)) {
                throw new Exception($mensajeError);
            }

            oci_execute($cursor);

            while ($producto = oci_fetch_assoc($cursor)) {
                $productos[] = $producto;
            }

            return $productos;

        } finally {
            if (isset($cursor)) oci_free_statement($cursor);
            if (isset($stmt)) oci_free_statement($stmt);
            CerrarBaseDatos($conn);
        }
    }

    /**
     * Obtiene un producto por ID
     */
    public function obtenerProductoPorId($idProducto) {
        $conn = AbrirBaseDatos();

        try {
            $sql = "BEGIN
                        operaciones_tablas.sp_obtener_producto_por_id(
                            :p_id_producto,
                            :cursor_producto,
                            :mensaje_error
                        );
                    END;";

            $stmt = oci_parse($conn, $sql);

            // Bind de parámetros
            oci_bind_by_name($stmt, ':p_id_producto', $idProducto, 50);
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ':cursor_producto', $cursor, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':mensaje_error', $mensajeError, 2000);

            if (!oci_execute($stmt)) {
                throw new Exception("Error al ejecutar procedimiento");
            }

            if (!empty($mensajeError)) {
                throw new Exception($mensajeError);
            }

            oci_execute($cursor);

            $producto = oci_fetch_assoc($cursor);

            return $producto ?: null;

        } finally {
            if (isset($cursor)) oci_free_statement($cursor);
            if (isset($stmt)) oci_free_statement($stmt);
            CerrarBaseDatos($conn);
        }
    }

    /**
     * Crea un nuevo producto
     */
    public function crearProducto($idProducto, $idCategoria, $nombre, $precio, $stock) {
        $conn = AbrirBaseDatos();

        try {
            $sql = "BEGIN
                        operaciones_tablas.sp_crear_producto(
                            :p_id_producto,
                            :p_id_categoria,
                            :p_nombre,
                            :p_precio,
                            :p_stock,
                            :p_mensaje_error
                        );
                    END;";

            $stmt = oci_parse($conn, $sql);

            // Bind de parámetros
            oci_bind_by_name($stmt, ':p_id_producto', $idProducto, 50);
            oci_bind_by_name($stmt, ':p_id_categoria', $idCategoria, 50);
            oci_bind_by_name($stmt, ':p_nombre', $nombre, 100);
            oci_bind_by_name($stmt, ':p_precio', $precio);
            oci_bind_by_name($stmt, ':p_stock', $stock);
            oci_bind_by_name($stmt, ':p_mensaje_error', $mensajeError, 2000);

            if (!oci_execute($stmt)) {
                throw new Exception("Error al ejecutar procedimiento");
            }

            if (!empty($mensajeError)) {
                throw new Exception($mensajeError);
            }

            return $idProducto;

        } finally {
            if (isset($stmt)) oci_free_statement($stmt);
            CerrarBaseDatos($conn);
        }
    }
}
?>