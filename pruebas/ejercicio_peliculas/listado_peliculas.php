<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'base_de_datos.php' ?>
</head>
<body>
    <div class="container">
        <h1>Listado de películas</h1>
    </div> 
    <div>
        <?php
        $sql = "SELECT * FROM peliculas";
        $resultado = $conexion -> query($sql);
        ?>
        <table class="table table-hover">
            <thead class="table table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Fecha estreno</th>
                    <th>Edad recomendada</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
        <?php
        while($fila = $resultado -> fetch_assoc()){/* fetch_assoc() crea una especie de array asociativo con las filas*/
            echo "<tr>";
            echo "<td>".$fila["id_pelicula"]."</td>";
            echo "<td>".$fila["titulo"]."</td>";
            echo "<td>".$fila["fecha_estreno"]."</td>";
            echo "<td>".$fila["edad_recomendada"]."</td>";
            echo "<td>";
            ?>
                <img width="50" height="100" src="<?php echo $fila["imagen"] ?>">
            <?php
            echo "</td>";
            echo "</tr>";
        } 
        ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>