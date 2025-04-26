
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Montserrat", sans-serif;
        }
        h1{
            font-size: 60px;
            font-weight: 700;
        }
        p{
            font-size: 20px;
            font-weight: 500;
        }
        .home {
            position: relative;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/bgHome.jpg') center/cover no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
        }

        a {
            padding: 15px 100px;
            text-decoration: none;
            border-radius: 3px;
            background-color: #fff;
            color: #000;
            transition: 0.3s ease;
            margin-top: 10px;
            border: 2px solid #fff;
        }

        a:hover {
            background-color: transparent;
            color: #fff;
        }
    </style>
    <title>Super Naomy</title>
</head>

<body>

    <section class="container-fluid home">
        <div>
            <h1 class="animate__animated animate__fadeInDown">Super Naomy</h1>
            <p class="animate__animated animate__fadeInUp animate__delay-1s">Ingrese para realizar sus consultas</p>

            <div class="pt-3">
                <a href="home.php" class="animate__animated animate__bounceIn animate__delay-2s">Iniciar</a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>

</html>