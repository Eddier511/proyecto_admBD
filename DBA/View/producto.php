<?php 
require_once("../View/layout.php");
require_once(__DIR__ . '/../Model/ProductoModel.php');

// Crear instancia del modelo
$productoModel = new ProductoModel();
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>

<body>
    <?php BarraNavegacion(); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <h5>Consulta de Productos</h5>

                <div style="text-align:right; margin:10px;">
                    <a class="btn btn-outline-primary" href="registroProducto.php">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div>

                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            // Obtener los datos usando el modelo
                            $cursor = $productoModel->consultarTodosProductos();
                            
                            while ($row = oci_fetch_assoc($cursor)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_PRODUCTO']) . "</td>";
                                echo "<td>" . htmlspecialchars(mb_convert_encoding($row['NOMBRE_CATEGORIA'], 'UTF-8', 'UTF-8')) . "</td>";
                                echo "<td>" . htmlspecialchars($row['NOMBRE']) . "</td>";
                                echo "<td>$ " . number_format($row['PRECIO'], 2) . "</td>";
                                echo "<td>" . htmlspecialchars($row['STOCK']) . "</td>";
                                echo "<td>
                                <a href='eliminarProducto.php?id=" . htmlspecialchars($row['ID_PRODUCTO']) . "' 
                                   class='btn-eliminar' 
                                   onclick='return confirm(\"¿Estás seguro de eliminar este producto?\");'>
                                   <i class='fa fa-trash text-danger'></i>
                                </a>
                            </td>";
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