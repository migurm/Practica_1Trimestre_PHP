<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
	<?php require "../php/funciones.php" ?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$temp_nombre_producto = espacios_intermedios(depurar($_POST["nombre_producto"]));
		$temp_precio_producto = depurar($_POST["precio_producto"]);
		$temp_descripcion_producto = espacios_intermedios(depurar($_POST["descripcion_producto"]));
		$temp_cantidad_producto = depurar($_POST["cantidad_producto"]);
		
		//Controlamos el nombre del producto.
		if(strlen($temp_nombre_producto) == 0){
			$err_nombre_producto = "El nombre es obligatorio.";
		}else if(strlen($temp_nombre_producto) > 40){
			$err_nombre_producto = "El nombre del producto no puede exceder los 40 caracteres";
		}else if(!carac_num_espacios($temp_nombre_producto)){
			$err_nombre_producto = "El nombre solo puede contener números, letras y espacios en blanco.";
		}else{
			$nombre_producto = $temp_nombre_producto;
		}

		//Controlamos el precio.
		if(strlen($temp_precio_producto) == 0){
			$err_precio_producto = "El precio es obligatorio";
		}else if(!is_numeric($temp_precio_producto)){
			$err_precio_producto = "El precio debe ser un número";
		}else if((float)$temp_precio_producto < 0){
			$err_precio_producto = "El precio mínimo es 0";
		}else if((float)$temp_precio_producto > 99999.99){
			$err_precio_producto ="El precio no puede exceder 99999.99";
		}else{
			$precio_producto = (float)$temp_precio_producto;
		}

		//Controlamos la descripcion del producto
		if(strlen($temp_descripcion_producto) == 0){
			$err_descripcion_producto = "La descripción del producto es obligatoria";
		}else if(strlen($temp_descripcion_producto) > 255){
			$err_descripcion_producto = "La descripción no puede exceder de 255 caracteres";
		}else{
			$descripcion_producto = $temp_descripcion_producto;
		}

		//Controlamos la cantidad de producto
		if(strlen($temp_cantidad_producto) == 0){
			$err_cantidad_producto = "Debe introducir una cantidad";
		}else if(!is_numeric($temp_cantidad_producto)){
			$err_cantidad_producto = "Debe introducir una cantidad numérica.";
		}else if((int)$temp_cantidad_producto < 0){
			$err_cantidad_producto = "Debe introducir una cantidad mayor a cero";
		}else if((int)$temp_cantidad_producto > 99999){
			$err_cantidad_producto = "La cantidad no puede exceder 99.999 unidades";
		}else{
			$cantidad_producto = (int)($temp_cantidad_producto);
		}

		

	}

	?>
	<form action="" method="POST">
		<fieldset>
			<legend>
				Productos
			</legend>
			<label>
				Nombre del producto:
			</label>
			<input type="text" name="nombre_producto">
			<?php if(isset($err_nombre_producto)) echo "<p>$err_nombre_producto</p>" ?>
			<label>
				Precio: 
			</label>
			<input type="text" name="precio_producto">
			<?php if(isset($err_precio_producto)) echo "<p>$err_precio_producto</p>" ?>
			<label>
				Descripción:
			</label>
			<input type="text" name="descripcion_producto">
			<?php if(isset($err_descripcion_producto)) echo "<p>$err_descripcion_producto</p>" ?>
			<label>
				Cantidad:
			</label>
			<input type="text" name="cantidad_producto">
			<?php if(isset($err_cantidad_producto)) echo "<p>$err_cantidad_producto</p>" ?>
			<input type="submit" value="Registrar">
		</fieldset>
	</form>
    
</body>
</html>