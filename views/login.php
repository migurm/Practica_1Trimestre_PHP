<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../util/base_de_datos.php" ?>
    <?php require "../util/funciones.php" ?>
    <style>
        body{
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">¿PHP? mi pasión</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href='principal.php'>Entrar como invitado</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='usuarios.php'>¿Eres nuev@? Regístrese</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $conexion -> query($sql);

        if($resultado -> num_rows === 0) { 
        ?>
            <div class="alert alert-danger mt-3" role="alert">
                <strong>Error: </strong>El usuario no existe.
            </div>
        <?php
        } else {

            while($fila = $resultado -> fetch_assoc()) {

                $contrasena_cifrada = $fila["contrasena"];

                $rol = $fila["rol"];
            }

            $acceso_valido = password_verify($contrasena, $contrasena_cifrada);
    
            if($acceso_valido) {
                echo "NOS HEMOS LOGEADO CON ÉXITO";
                session_start();
                $_SESSION["usuario"] = $usuario;
                $_SESSION["rol"] = $rol;
                header('location: principal.php');
            } else {
                ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <strong>Error: </strong>La contraseña es incorrecta.
                </div>
                <?php
            }
        }
    }
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h1 class="card-header text-center">Iniciar sesión</h1>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Usuario:</label>
                                <input class="form-control" type="text" name="usuario">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña:</label>
                                <input class="form-control" type="password" name="contrasena">
                            </div>
                            <input class="btn btn-primary" type="submit" value="Iniciar sesión">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>