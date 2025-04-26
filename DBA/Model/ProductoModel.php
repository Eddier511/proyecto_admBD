<?php
require_once(__DIR__ . '/BaseDatosModel.php');

class ReservaModel {
    public function obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida) {
        $conn = AbrirBaseDatos();
        $habitaciones = array();
        
        try {
            $sql = "BEGIN
                        operaciones_tablas.sp_obtener_habitaciones_disponibles(
                            TO_DATE(:fecha_entrada, 'YYYY-MM-DD'),
                            TO_DATE(:fecha_salida, 'YYYY-MM-DD'),
                            :cursor_habitaciones,
                            :mensaje_error
                        );
                    END;";
            
            $stmt = oci_parse($conn, $sql);
            
            // Bind de parámetros de entrada
            oci_bind_by_name($stmt, ':fecha_entrada', $fechaEntrada);
            oci_bind_by_name($stmt, ':fecha_salida', $fechaSalida);
            
            // Bind de parámetros de salida
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ':cursor_habitaciones', $cursor, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':mensaje_error', $mensajeError, 2000);
            
            // Ejecutar
            if (!oci_execute($stmt)) {
                throw new Exception("Error al ejecutar procedimiento");
            }
            
            // Si hay mensaje de error
            if (!empty($mensajeError)) {
                throw new Exception($mensajeError);
            }
            
            // Ejecutar el cursor
            oci_execute($cursor);
            
            // Obtener resultados
            while ($hab = oci_fetch_assoc($cursor)) {
                $habitaciones[] = $hab;
            }
            
            return $habitaciones;
            
        } finally {
            if (isset($cursor)) oci_free_statement($cursor);
            if (isset($stmt)) oci_free_statement($stmt);
            CerrarBaseDatos($conn);
        }
    }
    
    public function crearReserva($idCliente, $idHabitacion, $fechaEntrada, $fechaSalida, $tipoPago) {
        $conn = AbrirBaseDatos();
        
        try {
            $sql = "BEGIN
                        operaciones_tablas.sp_crear_reserva(
                            :p_id_cliente,
                            :p_id_habitacion,
                            TO_DATE(:p_fecha_entrada, 'YYYY-MM-DD'),
                            TO_DATE(:p_fecha_salida, 'YYYY-MM-DD'),
                            :p_tipo_pago,
                            :p_id_reserva,
                            :p_mensaje_error
                        );
                    END;";
            
            $stmt = oci_parse($conn, $sql);
            
            // Bind de parámetros
            oci_bind_by_name($stmt, ':p_id_cliente', $idCliente);
            oci_bind_by_name($stmt, ':p_id_habitacion', $idHabitacion);
            oci_bind_by_name($stmt, ':p_fecha_entrada', $fechaEntrada);
            oci_bind_by_name($stmt, ':p_fecha_salida', $fechaSalida);
            oci_bind_by_name($stmt, ':p_tipo_pago', $tipoPago);
            oci_bind_by_name($stmt, ':p_id_reserva', $idReserva, 32);
            oci_bind_by_name($stmt, ':p_mensaje_error', $mensajeError, 2000);
            
            if (!oci_execute($stmt)) {
                throw new Exception("Error al ejecutar procedimiento");
            }
            
            if (!empty($mensajeError)) {
                throw new Exception($mensajeError);
            }
            
            return $idReserva;
            
        } finally {
            if (isset($stmt)) oci_free_statement($stmt);
            CerrarBaseDatos($conn);
        }
    }
}
?>