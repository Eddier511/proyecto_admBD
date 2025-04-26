<?php 
require_once("../View/layout.php");
require_once(__DIR__ . '/../Model/ProductoModel.php');

$productoModel = new ProductoModel(); 
$mensajeError = '';
$productos = [];

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
        
        $productos = $productoModel->obtenerProductosDisponibles(
            $_POST['fecha_entrada'],
            $_POST['fecha_salida']
        );
        
        if (empty($productos)) {
            $mensajeError = "No hay productos disponibles para las fechas seleccionadas.";
        }
    } catch (Exception $e) {
        $mensajeError = $e->getMessage();
    }
}

// Procesar creación de reserva de producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservar'])) {
    try {
        if (empty($_POST['id_cliente']) || empty($_POST['id_producto']) || empty($_POST['tipo_pago'])) {
            throw new Exception("Todos los campos son requeridos para realizar la compra.");
        }
        
        $productoModel->crearReservaProducto(
            $_POST['id_cliente'],
            $_POST['id_producto'],
            $_POST['fecha_entrada'],
            $_POST['fecha_salida'],
            $_POST['tipo_pago']
        );

        header('Location: /ruta-confirmacion.php'); // Cambia esta ruta si quieres
        exit;
        
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
        <h2 class="mb-4">Formulario de Compra de Productos</h2>
        
        <?php if ($mensajeError): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensajeError) ?></div>
        <?php endif; ?>
        
        <form id="formProducto" method="post" class="bg-light p-4 shadow rounded">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_cliente" class="form-label">ID Cliente</label>
                        <input type="text" id="id_cliente" name="id_cliente" class="form-control" required
                               value="<?= htmlspecialchars($_POST['id_cliente'] ?? '') ?>">
                        <small class="text-muted">Ingrese el ID del cliente existente</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_entrada" class="form-label">Fecha de Pedido</label>
                        <input type="date" id="fecha_entrada" name="fecha_entrada" class="form-control" required
                               value="<?= htmlspecialchars($_POST['fecha_entrada'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_salida" class="form-label">Fecha de Entrega</label>
                        <input type="date" id="fecha_salida" name="fecha_salida" class="form-control" required
                               value="<?= htmlspecialchars($_POST['fecha_salida'] ?? '') ?>">
                    </div>
                    
                    <button type="submit" name="consultar_disponibilidad" value="1" 
                            class="btn btn-info mb-3" data-action="consultar_disponibilidad">
                        Consultar Productos Disponibles
                    </button>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_producto" class="form-label">Producto Disponible</label>
                        <select id="id_producto" name="id_producto" class="form-select" required
                                <?= empty($productos) ? 'disabled' : '' ?>>
                            <option value=""><?= empty($productos) ? 'Seleccione fechas primero' : 'Seleccione un producto' ?></option>
                            <?php foreach ($productos as $prod): ?>
                                <option value="<?= $prod['ID_PRODUCTO'] ?>">
                                    <?= $prod['NOMBRE'] ?> - $<?= number_format($prod['PRECIO'], 2) ?>
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
                            <?= empty($productos) ? 'disabled' : '' ?>>
                        Confirmar Compra
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