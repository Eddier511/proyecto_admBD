<?php 
require_once("../View/layout.php");
require_once(__DIR__ . '/../Model/InventarioModel.php');

// Crear instancia del modelo
$productoModel = new InventarioModel();
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>

<body>
    <?php BarraNavegacion(); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <h5>Consulta de Inventarios</h5>
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Tienda</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            // Obtener los datos usando el modelo
                            $cursor = $productoModel->consultarInventarios();
                            
                            while ($row = oci_fetch_assoc($cursor)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_INVENTARIO']) . "</td>";
                                echo "<td>" . htmlspecialchars(mb_convert_encoding($row['NOMBRE'], 'UTF-8', 'UTF-8')) . "</td>";
                                echo "<td>" . htmlspecialchars($row['NOMBRE_TIENDA']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['CANTIDAD'], 2) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FECHA_ACTUALIZACION']) . "</td>";
                            echo "</tr>";
                            }
                            
                            oci_free_statement($cursor);
                        } catch (Exception $e) {
                            echo "<tr><td colspan='6' class='text-danger'>Error al cargar los productos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php PrintFooter(); ?>
    <?php PrintScript(); ?>
</body>
</html>