<?php 
require_once("../View/layout.php");
require_once(__DIR__ . '/../Model/ProductoModel.php');

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
                        <a class="btn btn-outline-primary" href="agregarOfertas.php"><i class="fa fa-plus"></i> Agregar
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

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $datos = ConsultarProductos(false);

                                while($row = mysqli_fetch_array($datos))
                                {
                                    echo "<tr>";
                                    echo "<td>" . $row["ID_PRODUCTO"] . "</td>";
                                    echo "<td>" . $row["NOMBRE_CATEGORIA"] . "</td>";
                                    echo "<td>" . $row["NOMBRE"] . "</td>";
                                    echo "<td>"  . "$ " . $row["PRECIO"] . "</td>";
                                    echo "<td>" . $row["STOCK"] . "</td>";
                                    echo "<td><a href='actualizarOfertas.php?q=" . $row["Id"] . "'><i class='fa fa-edit'></i></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>

    <?php PrintFooter(); ?>
    <?php PrintScript(); ?>
</body>
</html>