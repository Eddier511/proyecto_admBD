<?php 
require_once("../View/layout.php");
require_once(__DIR__ . '/../Model/ProductoModel.php');

$reservaModel = new ReservaModel();
$mensajeError = '';
$habitaciones = [];

// Procesar consulta de disponibilidad
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['consultar_disponibilidad'])) {
    try {
        // Validar fechas primero
        if (empty($_POST['fecha_entrada']) || empty($_POST['fecha_salida'])) {
            throw new Exception("Debe ingresar ambas fechas");
        }
        
        if (strtotime($_POST['fecha_salida']) <= strtotime($_POST['fecha_entrada'])) {
            throw new Exception("La fecha de salida debe ser posterior a la entrada");
        }
        
        $habitaciones = $reservaModel->obtenerHabitacionesDisponibles(
            $_POST['fecha_entrada'],
            $_POST['fecha_salida']
        );
        
        if (empty($habitaciones)) {
            $mensajeError = "No hay habitaciones disponibles para las fechas seleccionadas";
        }
    } catch (Exception $e) {
        $mensajeError = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>

<body>
    <?php BarraNavegacion(); ?>

    <div class="container mt-5">
        <h2 class="mb-4">Formulario de Reserva</h2>
        
        <?php if ($mensajeError): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensajeError) ?></div>
        <?php endif; ?>
        
        <form id="formReserva" method="post" class="bg-light p-4 shadow rounded">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_cliente" class="form-label">ID Cliente</label>
                        <input type="text" id="id_cliente" name="id_cliente" class="form-control" required
                               value="<?= htmlspecialchars($_POST['id_cliente'] ?? '') ?>">
                        <small class="text-muted">Ingrese el ID del cliente existente</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
                        <input type="date" id="fecha_entrada" name="fecha_entrada" class="form-control" required
                               value="<?= htmlspecialchars($_POST['fecha_entrada'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                        <input type="date" id="fecha_salida" name="fecha_salida" class="form-control" required
                               value="<?= htmlspecialchars($_POST['fecha_salida'] ?? '') ?>">
                    </div>
                    
                    <button type="submit" name="consultar_disponibilidad" value="1" 
                            class="btn btn-info mb-3" data-action="consultar_disponibilidad">
                        Consultar Disponibilidad
                    </button>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_habitacion" class="form-label">Habitación Disponible</label>
                        <select id="id_habitacion" name="id_habitacion" class="form-select" required
                                <?= empty($habitaciones) ? 'disabled' : '' ?>>
                            <option value=""><?= empty($habitaciones) ? 'Seleccione fechas primero' : 'Seleccione habitación' ?></option>
                            <?php foreach ($habitaciones as $hab): ?>
                                <option value="<?= $hab['ID_HABITACION'] ?>">
                                    Hab. <?= $hab['ID_HABITACION'] ?> - <?= $hab['TIPO'] ?> 
                                    ($<?= number_format($hab['PRECIO_NOCHE'], 2) ?>/noche)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                        <select id="tipo_pago" name="tipo_pago" class="form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="TARJETA" <?= ($_POST['tipo_pago'] ?? '') == 'TARJETA' ? 'selected' : '' ?>>Tarjeta</option>
                            <option value="EFECTIVO" <?= ($_POST['tipo_pago'] ?? '') == 'EFECTIVO' ? 'selected' : '' ?>>Efectivo</option>
                            <option value="TRANSFERENCIA" <?= ($_POST['tipo_pago'] ?? '') == 'TRANSFERENCIA' ? 'selected' : '' ?>>Transferencia</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100" 
                            name="reservar" data-action="crear_reserva"
                            <?= empty($habitaciones) ? 'disabled' : '' ?>>
                        Confirmar Reserva
                    </button>
                </div>
            </div>
            
            <div id="error-message" class="alert alert-danger mt-3" style="display:none;"></div>
        </form>
    </div>

    <?php PrintFooter(); ?>
    <?php PrintScript(); ?>
</body>
</html>