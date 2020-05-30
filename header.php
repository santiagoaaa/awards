<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

    <!--custom-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">

    <title>Inicio</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">
                <img class="img-fluid" id="img-logo" src="imagenes/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lista-concursos.php">Concursos</a>
                    </li>
                    <?php
                        if (isset($_SESSION['email'])) {
                    ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="perfil.php">Mi perfil</a>
                        </li>
                    <?php
                            
                        }else{
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="iniciar-sesion.php">Entrar</a>
                        </li>

                    <?php
                            
                        }
                    ?>

                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>