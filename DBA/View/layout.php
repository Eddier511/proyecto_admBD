<?php
function PrintCss()
{
    echo '<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Reserva Hotel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="../View/Styles/estilos.css" rel="stylesheet">
    </head>';
}

function BarraNavegacion()
{
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
            <a class="navbar-brand" href="../View/home.php">Reserva Hotel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="../View/registro.php">Registrar Reserva</a></li>

                </ul>
            </div>
        </nav>';
}

function PrintFooter()
{
    echo '<footer class="bg-light text-center text-muted py-3">
            <div class="container">
                <small>&copy; ' . date("Y") . ' Sistema de Reservas</small>
            </div>
          </footer>';
}

function PrintScript()
{

    echo '
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/Scripts/reserva.js"></script>';
}

?>