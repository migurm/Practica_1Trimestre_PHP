<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
	<?php require "../util/funciones.php" ?>
	<?php require "../util/base_de_datos.php"?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>

	<?php
	    session_start();

	if(isset($_SESSION["usuario"])){//Si tenemos una sesión iniciada
			$usuario = $_SESSION["usuario"];
			$rol = $_SESSION["rol"];
			if($rol != 'admin'){
				session_start();
                $_SESSION["usuario"] = $usuario;
                header('location: login.php');
			}

	}else{
		//header('location: iniciar_sesion.php'); O mandamos a otra página
		//O le llamamos al usuario invitado
		$usuario = $_SESSION["usuario"] = "invitado";
	}
 
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Por defecto, todo espacio innecesario intermedio será eliminado antes de nada cuando proceda
		$temp_nombre_producto = espacios_intermedios(depurar($_POST["nombre_producto"]));
		$temp_precio_producto = depurar($_POST["precio_producto"]);
		$temp_descripcion_producto = espacios_intermedios(depurar($_POST["descripcion_producto"]));
		$temp_cantidad_producto = depurar($_POST["cantidad_producto"]);
		
		//Controlamos el nombre del producto.
		if(strlen(validar_nombre_producto($temp_nombre_producto)) == 0){
			$nombre_producto = $temp_nombre_producto;
		}else{
			$err_nombre_producto = validar_nombre_producto($temp_nombre_producto);
		}

		//Controlamos el precio.
		if(strlen(validar_precio_producto($temp_precio_producto)) == 0){
			$precio_producto = (float)$temp_precio_producto;
		}else{
			$err_precio_producto = validar_precio_producto($temp_precio_producto);
		}


		//Controlamos la descripcion del producto
		if(strlen(validar_descripcion_producto($temp_descripcion_producto)) == 0){
			$descripcion_producto = $temp_descripcion_producto;
		}else{
			$err_descripcion_producto = validar_descripcion_producto($temp_descripcion_producto);
		}

		//Controlamos la cantidad de producto
		if(strlen(validar_cantidad_producto($temp_cantidad_producto)) == 0){
			$cantidad_producto = (int)$temp_cantidad_producto;
		}else{
			$err_cantidad_producto = validar_cantidad_producto($temp_cantidad_producto);
		}

		//Validamos la imagen
		//No parece muy exhaustivo

		//Recibir un fichero con $_FILES ["combreCampo"]["queQueremosCoger"] -> TYPE, NAME, SIZE, TMP_NAME
		//TMP_NAME es una especie de ruta temporal donde se aloja la imagen hasta saber que hacer con ella
		//Sacar el nombre del fichero.
		if(strlen(validar_imagen($_FILES["imagen"])) == 0){
			$nombre_imagen = depurar($_FILES["imagen"]["name"]);
			$tipo_imagen = depurar($_FILES["imagen"]["type"]);
			$tamano_imagen = depurar($_FILES["imagen"]["size"]);
			$ruta_temporal = depurar($_FILES["imagen"]["tmp_name"]);

			$ruta_final = "images/".$nombre_imagen;
			move_uploaded_file($ruta_temporal, $ruta_final);
		}else{
			$err_imagen = validar_imagen($_FILES["imagen"]);
		}
	}

	?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">¿PHP? mi pasión</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href='principal.php'>Ir a tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='cerrar_sesion.php'>Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
	<div class="container mt-5">
		<form action="" method="POST" enctype="multipart/form-data">
			<fieldset>
				<legend>Nuevo producto</legend>

				<div class="form-group">
					<label for="nombre_producto">Nombre del producto:</label>
					<input type="text" class="form-control" id="nombre_producto" name="nombre_producto">
					<?php if(isset($err_nombre_producto)) echo "<p class='text-danger'>$err_nombre_producto</p>"; ?>
				</div>

				<div class="form-group">
					<label for="precio_producto">Precio:</label>
					<input type="text" class="form-control" id="precio_producto" name="precio_producto">
					<?php if(isset($err_precio_producto)) echo "<p class='text-danger'>$err_precio_producto</p>"; ?>
				</div>

				<div class="form-group">
					<label for="descripcion_producto">Descripción:</label>
					<input type="text" class="form-control" id="descripcion_producto" name="descripcion_producto">
					<?php if(isset($err_descripcion_producto)) echo "<p class='text-danger'>$err_descripcion_producto</p>"; ?>
				</div>

				<div class="form-group">
					<label for="cantidad_producto">Cantidad:</label>
					<input type="text" class="form-control" id="cantidad_producto" name="cantidad_producto">
					<?php if(isset($err_cantidad_producto)) echo "<p class='text-danger'>$err_cantidad_producto</p>"; ?>
				</div>
				<!-- Agregamos la petición de imágenes -->
				<div class="form-group">
                    <label class="form-label">Imagen</label>
                    <input class="form-control" type="file" name="imagen">
					<?php if(isset($err_imagen)) echo "<p class='text-danger'>$err_imagen</p>"; ?>
                </div>

				<input type="submit" class="btn btn-primary mt-2" value="Registrar">
			</fieldset>
		</form>
	</div>
	<?php
		if((isset($nombre_producto))&& isset($precio_producto) && isset($descripcion_producto) && isset($cantidad_producto) && isset($ruta_final)){
			echo "<p>Producto registrado exitosamente.</p>";
			echo "<div class='alert alert-success mt-3' role='alert'>";
			echo "<strong>¡Producto añadido con éxito!</strong> Todos los campos están correctos.";
			echo "</div>";

		$sql = "INSERT INTO productos (nombreProducto, precio, descripcion, cantidad, imagen)
            VALUES ('$nombre_producto', '$precio_producto', '$descripcion_producto', '$cantidad_producto', '$ruta_final')";

        $conexion -> query($sql);
    	}
	
	?>
    
</body>
</html>