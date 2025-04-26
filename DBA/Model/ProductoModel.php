<?php
require_once(__DIR__ . '/BaseDatosModel.php');

class ProductoModel {

    /**
     * Obtiene todos los productos
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

            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ':cursor_productos', $cursor, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':mensaje_error', $mensajeError, 2000);

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

    /**
     * Obtiene productos disponibles para compra
     */
    public function obtenerProductosDisponibles($fechaEntrada, $fechaSalida) {
        $conn = AbrirBaseDatos();
        $productos = array();

        try {
            $sql = "SELECT * FROM productos WHERE DISPONIBLE = 1";

            $stmt = oci_parse($conn, $sql);

            if (!oci_execute($stmt)) {
                throw new Exception("Error al consultar productos disponibles");
            }

            while ($producto = oci_fetch_assoc($stmt)) {
                $productos[] = $producto;
            }

            return $productos;

        } finally {
            if (isset($stmt)) oci_free_statement($stmt);
            CerrarBaseDatos($conn);
        }
    }

    /**
     * Crea una "reserva" de un producto (compra)
     */
    public function crearReservaProducto($idCliente, $idProducto, $fechaEntrada, $fechaSalida, $tipoPago) {
        $conn = AbrirBaseDatos();

        try {
            $sql = "INSERT INTO reservas_productos (ID_CLIENTE, ID_PRODUCTO, FECHA_PEDIDO, FECHA_ENTREGA, TIPO_PAGO)
                    VALUES (:idCliente, :idProducto, TO_DATE(:fechaEntrada, 'YYYY-MM-DD'), TO_DATE(:fechaSalida, 'YYYY-MM-DD'), :tipoPago)";

            $stmt = oci_parse($conn, $sql);

            oci_bind_by_name($stmt, ':idCliente', $idCliente);
            oci_bind_by_name($stmt, ':idProducto', $idProducto);
            oci_bind_by_name($stmt, ':fechaEntrada', $fechaEntrada);
            oci_bind_by_name($stmt, ':fechaSalida', $fechaSalida);
            oci_bind_by_name($stmt, ':tipoPago', $tipoPago);

            if (!oci_execute($stmt)) {
                throw new Exception("Error al insertar la reserva de producto");
            }

        } finally {
            if (isset($stmt)) oci_free_statement($stmt);
            CerrarBaseDatos($conn);
        }
    }
}
?>