<?php
require_once(__DIR__ . '/BaseDatosModel.php');

class ProductoModel {
    
    private $db;

    public function __construct() {
        $this->db = AbrirBaseDatos();
    }

    public function __destruct() {
        CerrarBaseDatos($this->db);
    }

    public function consultarTodosProductos() {
        $query = "BEGIN ADMIN_FACTURACION.PRODUCTOS_CONSULTAR_PRODUCTOS_SP(:result); END;";
        
        $stmt = oci_parse($this->db, $query);
        $result = oci_new_cursor($this->db);
        
        oci_bind_by_name($stmt, ":result", $result, -1, OCI_B_CURSOR);
        
        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            throw new Exception("Error al ejecutar procedimiento: " . $e['message']);
        }
        
        if (!oci_execute($result)) {
            $e = oci_error($result);
            throw new Exception("Error al ejecutar cursor: " . $e['message']);
        }
        
        return $result;
    }

}
?>