    <?php require_once("../View/layout.php"); ?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>

<body>
    <?php BarraNavegacion(); ?>

    <div class="container mt-5">
        <h1>Reportes Power BI</h1>


        <iframe title="Ventas" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=269a2c49-3950-4659-8586-e4e61410183f&autoAuth=true&ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59" frameborder="0" allowFullScreen="true"></iframe>
        <iframe title="Inventario y Productos" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=e68960e3-ecc6-4b23-94a3-eb405dcdfaa2&autoAuth=true&ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59" frameborder="0" allowFullScreen="true"></iframe>


    </div>
    <?php PrintFooter(); ?>
    <?php PrintScript(); ?>
</body>

</html>