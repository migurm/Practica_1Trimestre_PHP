<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../php/base_de_datos.php" ?>
    <?php require "../php/funciones.php" ?>
</head>
<body>
    <?php
    session_start();

    if(isset($_SESSION["usuario"])){
        $usuario = $_SESSION["usuario"];
    }else {         
        //header('location: iniciar_sesion.php'); O mandamos a otra página
        //O le llamamos al usuario invitado
        $usuario = $_SESSION["usuario"] = "invitado";
    }
    ?>
    <div class="container">
        <h1>Página principal</h1>
        <h2>Bienvenid@ <?php echo $usuario ?></h2>
    </div>
    <div>
        <?php
        $sql = "SELECT * FROM productos";
        $resultado = $conexion -> query($sql);
        ?>

        <table class="table table-hover">
            <thead class="table table-dark">
                <tr>
                    <th>ID</th>
                    <th>Artículo</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
        <?php
        while($fila = $resultado -> fetch_assoc()){/* fetch_assoc() crea una especie de array asociativo con las filas*/
            echo "<tr>";
            echo "<td>".$fila["idProducto"]."</td>";
            echo "<td>".$fila["nombreProducto"]."</td>";
            echo "<td>".$fila["precio"]."</td>";
            echo "<td>".$fila["descripcion"]."</td>";
            echo "<td>".$fila["cantidad"]."</td>";
            //Aquí faltaría lo de las fotos, pero para esto habría que ampliar el formulario
            echo "</tr>";
        } 
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>