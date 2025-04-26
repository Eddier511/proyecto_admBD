<?php
require_once(__DIR__ . '/../Model/ProductoModel.php');

class ProductoController {
    private $productoModel;

    public function __construct() {
        $this->productoModel = new ProductoModel();
    }

    public function mostrarTodosProductos() {
        try {
            return $this->model->consultarTodosProductos();
        } catch (Exception $e) {
            throw new Exception("Error en ProductoController: " . $e->getMessage());
        }
    }

}

// Uso del controlador
$controller = new ProductoController();
$controller->handleRequest();
?>