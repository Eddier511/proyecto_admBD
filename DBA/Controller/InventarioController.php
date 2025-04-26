<?php
require_once(__DIR__ . '/../Model/InventarioModel.php');

class InventarioController {
    private $InventarioModel;

    public function __construct() {
        $this->InventarioModel = new InventarioModel();
    }

    public function mostrarInvetnarios() {
        try {
            return $this->model->consultarInventarios();
        } catch (Exception $e) {
            throw new Exception("Error en ProductoController: " . $e->getMessage());
        }
    }

}

// Uso del controlador
$controller = new InventarioController();
$controller->handleRequest();
?>