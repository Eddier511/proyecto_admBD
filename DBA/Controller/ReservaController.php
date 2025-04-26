<?php
require_once(__DIR__ . '/../Model/ReservaModel.php');

class ReservaController {
    private $reservaModel;

    public function __construct() {
        $this->reservaModel = new ReservaModel();
    }

    /**
     * Maneja las solicitudes POST para crear reservas o consultar disponibilidad
     */
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'consultar_disponibilidad':
                        $this->consultarDisponibilidad();
                        break;
                    case 'crear_reserva':
                        $this->crearReserva();
                        break;
                    default:
                        $this->responderError("Acción no válida");
                }
            } else {
                $this->responderError("Parámetro 'action' no especificado");
            }
        } else {
            $this->responderError("Método no permitido", 405);
        }
    }

    /**
     * Consulta habitaciones disponibles para las fechas especificadas
     */
    private function consultarDisponibilidad() {
        try {
            // Validar datos de entrada
            $this->validarFechas($_POST['fecha_entrada'], $_POST['fecha_salida']);

            // Obtener habitaciones disponibles
            $habitaciones = $this->reservaModel->obtenerHabitacionesDisponibles(
                $_POST['fecha_entrada'],
                $_POST['fecha_salida']
            );

            // Preparar respuesta
            $response = [
                'success' => true,
                'habitaciones' => $habitaciones,
                'fecha_entrada' => $_POST['fecha_entrada'],
                'fecha_salida' => $_POST['fecha_salida']
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (Exception $e) {
            $this->responderError($e->getMessage());
        }
    }

    /**
     * Crea una nueva reserva
     */
    private function crearReserva() {
        try {
            // Validar datos de entrada
            $this->validarDatosReserva($_POST);

            // Crear la reserva
            $idReserva = $this->reservaModel->crearReserva(
                $_POST['id_cliente'],
                $_POST['id_habitacion'],
                $_POST['fecha_entrada'],
                $_POST['fecha_salida'],
                $_POST['tipo_pago']
            );

            // Preparar respuesta exitosa
            $response = [
                'success' => true,
                'message' => 'Reserva creada exitosamente',
                'id_reserva' => $idReserva,
                'redirect' => 'exito.php?id=' . $idReserva
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (Exception $e) {
            $this->responderError($e->getMessage());
        }
    }

    /**
     * Valida los datos básicos de una reserva
     */
    private function validarDatosReserva($data) {
        $required = ['id_cliente', 'id_habitacion', 'fecha_entrada', 'fecha_salida', 'tipo_pago'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("El campo $field es requerido");
            }
        }

        $this->validarFechas($data['fecha_entrada'], $data['fecha_salida']);

        if (!is_numeric($data['id_cliente']) {
            throw new Exception("ID de cliente no válido");
        }

        if (!is_numeric($data['id_habitacion'])) {
            throw new Exception("ID de habitación no válido");
        }
    }

    /**
     * Valida que las fechas sean correctas
     */
    private function validarFechas($fechaEntrada, $fechaSalida) {
        if (strtotime($fechaSalida) <= strtotime($fechaEntrada)) {
            throw new Exception("La fecha de salida debe ser posterior a la fecha de entrada");
        }

        if (strtotime($fechaEntrada) < strtotime(date('Y-m-d'))) {
            throw new Exception("No se pueden hacer reservas con fechas pasadas");
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
$controller = new ReservaController();
$controller->handleRequest();
?>