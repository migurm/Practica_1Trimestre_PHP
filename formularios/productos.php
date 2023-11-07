<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
	<?php require "../php/funciones.php" ?>
	<?php require "../php/base_de_datos.php"?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>
	<?php
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


	}

	?>
	<div class="container mt-5">
		<form action="" method="POST">
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

				<input type="submit" class="btn btn-primary mt-2" value="Registrar">
			</fieldset>
		</form>
	</div>
	<?php
		if((isset($nombre_producto))&& ($precio_producto) && ($descripcion_producto) && ($cantidad_producto)){
			echo "<p>Producto registrado exitosamente.</p>";

		$sql = "INSERT INTO productos (nombreProducto, precio, descripcion, cantidad)
            VALUES ('$nombre_producto', '$precio_producto', '$descripcion_producto', '$cantidad_producto')";

        $conexion -> query($sql);
    }
	
	?>
    
</body>
</html>