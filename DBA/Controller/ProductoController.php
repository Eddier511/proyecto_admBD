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

    /**
     * Crea un nuevo producto
     */
    private function crearProducto() {
        try {
            // Validar datos de entrada
            $this->validarDatosProducto($_POST);

            // Crear el producto
            $idProducto = $this->productoModel->crearProducto(
                $_POST['id_producto'],
                $_POST['id_categoria'],
                $_POST['nombre'],
                $_POST['precio'],
                $_POST['stock']
            );

            // Preparar respuesta exitosa
            $response = [
                'success' => true,
                'message' => 'Producto creado exitosamente',
                'id_producto' => $idProducto,
                'redirect' => 'exito_producto.php?id=' . $idProducto
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (Exception $e) {
            $this->responderError($e->getMessage());
        }
    }

    /**
     * Valida los datos básicos de un producto
     */
    private function validarDatosProducto($data) {
        $required = ['id_producto', 'id_categoria', 'nombre', 'precio', 'stock'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("El campo $field es requerido");
            }
        }

        if (!is_numeric($data['precio'])) {
            throw new Exception("El precio debe ser un número válido");
        }

        if (!is_numeric($data['stock'])) {
            throw new Exception("El stock debe ser un número válido");
        }
    }

    /**
     * Devuelve una respuesta de error estandarizada
     */
    private function responderError($message, $httpCode = 400) {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $message
        ]);
        exit();
    }
}

// Uso del controlador
$controller = new ProductoController();
$controller->handleRequest();
?>