<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario peliculas de Migue</title>
    <!-- Importamos bootstrap online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'base_de_datos.php' ?>
</head>
<body>
    <?php
    function depurar($entrada) {
        $salida = htmlspecialchars($entrada);
        $salida = trim($salida);
        return $salida;
    }
    function calificacion_correcta($valor){
        switch ($valor){
            case "0":
            case "3":
            case "7":
            case "12":
            case "16":
            case "18":
                return 1;
                break;
            default:
                return 0;
        }
    }       

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $temp_id_pelicula = depurar($_POST["id_pelicula"]);
        $temp_titulo = depurar(preg_replace('/ +/', ' ', $_POST["titulo"]));
        //Aquí hemos usado una expresión regular para que si encuentra mas
        //de un espacio, los sustituye por un unico espacio.
        $temp_fecha_estreno = depurar($_POST["fecha_estreno"]);
        $temp_calificacion_edad = depurar($_POST["calificacion_edad"]);
    
    //Controlamos primero el id_pelicuna (requisito numero 8 cifras)
    if(strlen($temp_id_pelicula) > 8 || strlen($temp_id_pelicula) < 8){ //Nos valen todas hasta 8 cifras, CAMBIAR!!
        $err_id_pelicula = "Debe ser un numero de 8 cifras";
    } else {
        $id_pelicula = (int)($temp_id_pelicula);//Al no haber aceptado texto, no hemos comprobado con filter_var($cvvariable, FILTER_VALIDATE_INT) === FALSE
        //Recomendable tambien comprobar que no sea negativo.
    }
    //No parece muy exhaustivo

    //Recibir un fichero con $_FILES ["combreCampo"]["queQueremosCoger"] -> TYPE, NAME, SIZE, TMP_NAME
    //TMP_NAME es una especie de ruta temporal donde se aloja la imagen hasta saber que hacer con ella
    //Sacar el nombre del fichero.
    $nombre_imagen = $_FILES["imagen"]["name"];
    echo $nombre_imagen;
    $tipo_imagen = $_FILES["imagen"]["type"];
    $tamano_imagen = $_FILES["imagen"]["size"];
    $ruta_temporal = $_FILES["imagen"]["tmp_name"];

    //El size dividido en 1024 nos da los megabytes

    //Para guardar la imagen.
    $ruta_final = "../contenedor_imagenes/".$nombre_imagen;
    move_uploaded_file($ruta_temporal, $ruta_final);

    echo $nombre_imagen." ".$tipo_imagen." ".$tamano_imagen." ".$ruta_temporal;



    if((strlen($temp_titulo) > 80) || (strlen($temp_titulo) <= 0)){
        $err_titulo = "El titulo debe contener entre 0 y 80 caracteres";
    } else {
        $titulo_pelicula = $temp_titulo;
    }
    //A por la fecha
    $fecha_limite = new DateTime('1895-01-01');
    $fecha_introducida = new DateTime($temp_fecha_estreno);
    if(strlen($temp_fecha_estreno) == 0){
        $err_fecha_estreno = "La fecha de nacimiento es obligatoria";
    }else if($fecha_introducida < $fecha_limite){
        $err_fecha_estreno = "No hay peliculas anteriores a 1895";
    }else{
        $fecha_estreno = $temp_fecha_estreno;
    }

    //Calificacion por edad
    if(!calificacion_correcta($temp_calificacion_edad)){
        $err_calificacion_edad="Error en la calificacion de edad";
    }else{
        $calificacion_edad = (int)$temp_calificacion_edad;
    }

    }
    ?>
    <div class="container"><!-- Vamos a aplicarle bootstrap -->
        <div class="col-6">
            <form action="" method = "POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <fieldset>
                        <legend>Información de la película</legend>
                    <div class="mb-3">
                        <label class="form-label">Identificador: </label>
                        <input class="form-control" type="number" name="id_pelicula">
                        <?php if(isset($err_id_pelicula)) echo $err_id_pelicula ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Titulo de la pelicula: </label>
                        <input class="form-control" type="text" name="titulo">
                        <?php if(isset($err_titulo)) echo $err_titulo ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de estreno: </label>
                        <input class="form-control" type="date" name="fecha_estreno">
                        <?php if(isset($err_fecha_estreno)) echo $err_fecha_estreno ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Calificación por edad: </label>
                            <select class="form-select" name="calificacion_edad">
                                <option value="0" selected>Todos los públicos</option>
                                <option value="3">Mayores de 3 años</option>
                                <option value="7">Mayores de 7 años</option>
                                <option value="12">Mayores de 12 años</option>
                                <option value="16">Mayores de 16 años</option>
                                <option value="18">Mayores de 18 años</option>
                            </select>
                            <?php if(isset($err_calificacion_edad)) echo $err_calificacion_edad ?>
                            <div class="mb-3">
                                <label class="form-label">Imagen</label>
                                <input class="form-control" type="file" name="imagen">

                            </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Enviar</button>          
                    </fieldset>
                </div>
            </form>
        </div>
    </div>
    <?php

    if(isset($id_pelicula) && isset($titulo_pelicula) && isset($fecha_estreno) && isset($calificacion_edad)){
        echo "<h3>ID: $id_pelicula</h3>";
        echo "<h3>Título: $titulo_pelicula</h3>";
        echo "<h3>Fecha estreno: $fecha_estreno</h3>";
        echo "<h3>Calificacion edad: $calificacion_edad</h3>";

        //Enviamos los datos a nuestra base de datos de peliculas.
        $sql = "INSERT INTO peliculas(id_pelicula, titulo, fecha_estreno, edad_recomendada, imagen) /* Si va el orden correcto, no hace falta especificar las columnas */
            VALUES ($id_pelicula,'$titulo_pelicula','$fecha_estreno','$calificacion_edad', '$ruta_final')";

        $conexion -> query($sql);

    }else{

        echo "No se ha insertado el valor";
    }
    ?>
    <!-- Importamos bootstrap online -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>