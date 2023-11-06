<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
	<?php require "../php/funciones.php" ?>
	<?php require "../php/base_de_datos.php" ?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$temp_nombre_usuario = depurar($_POST["nombre_usuario"]);
		$temp_contrasena_usuario = depurar($_POST["contrasena_usuario"]);
		$temp_fecha_nacimiento = depurar($_POST["fecha_nacimiento"]);

		if(strlen($_POST["fecha_nacimiento"]) == 0){//Nos aseguramos de que haya input como mínimo
			$err_fecha_nacimiento = "La fecha de nacimiento es obligatoria";
		}else{
			$temp_fecha_nacimiento = $_POST["fecha_nacimiento"];
		}
	//Comprobamos nombre usuario.
	if(strlen($temp_nombre_usuario) == 0){
		$err_nombre_usuario = "El nombre de usuario es obligatorio";
	}else if(strlen($temp_nombre_usuario) < 4){
		$err_nombre_usuario = "El nombre de usuario debe tener al menos 4 caracteres";
	}else if (strlen($temp_nombre_usuario) > 12){
		$err_nombre_usuario = "El nombre de usuario debe tener como máximo 12 caracteres";
	}else if (!carac_barraBaja($temp_nombre_usuario)){
		$err_nombre_usuario ="El nombre solo puede contener letras y barras bajas ( _ )";
	}else{
		$nombre_usuario = $temp_nombre_usuario;
	}
	
	//Controlamos la contraseña
	if(strlen($temp_contrasena_usuario) == 0){
		$err_contrasena_usuario = "La contraseña es obligatoria";
	}else if(strlen($temp_contrasena_usuario) > 255){
		$err_contrasena_usuario = "La contraseña no puede exceder los 255 caracteres";
	}else{ //
		$contrasena_usuario = password_hash($temp_contrasena_usuario, PASSWORD_DEFAULT);
	}

	//Controlamos la fecha
	if(strlen($temp_fecha_nacimiento) == 0){
		$err_fecha_nacimiento = "La fecha de nacimiento es obligatoria";
	}else if (!formato_date($temp_fecha_nacimiento)){
		$err_fecha_nacimiento = "El formato de fecha debe ser AAAA/MM/DD";
	}else{
		$fecha_introducida = new DateTime($temp_fecha_nacimiento);
		$fecha_actual = new DateTime(date('Y-m-d'));
		$diferencia = $fecha_actual -> diff($fecha_introducida);
		$years = $diferencia -> y;
		if ($years < 12){
			$err_fecha_nacimiento = "Los menores de 12 años no pueden registrarse";
		}else if ($years > 120){
			$err_fecha_nacimiento = "Desgraciadamente, aun no podemos vivir más de 120 años";
		}else{
			$fecha_nacimiento = $temp_fecha_nacimiento;
		}
	}

	}
	?>
	<form action="" method="POST">
		<fieldset>
			<legend>
				Usuarios
			</legend>
			<label>
				Nombre:
			</label>
			<input type="text" name="nombre_usuario">
			<?php if(isset($err_nombre_usuario)) echo "<p>$err_nombre_usuario</p>" ?>
			<label>
				Contreaseña: 
			</label>
			<input type="text" name="contrasena_usuario">
			<?php if(isset($err_contrasena_usuario)) echo "<p>$err_contrasena_usuario</p>" ?>
			<label>
				Fecha de nacimiento:
			</label>
			<input type="date" name="fecha_nacimiento">
			<?php if(isset($err_fecha_nacimiento)) echo "<p>$err_fecha_nacimiento</p>" ?>
            <input type="submit" value="Registrar">
		</fieldset>
	</form>
	<?php
	if((isset($nombre_usuario))&& ($contrasena_usuario) && ($fecha_nacimiento)){
			echo "<p>Usuario registrado exitosamente.</p>";

		$sql = "INSERT INTO usuarios (usuario, contrasena, fechaNacimiento)
            VALUES ('$nombre_usuario', '$contrasena_usuario', '$fecha_nacimiento')";

        $conexion -> query($sql);
    }
	?>
    
</body>
</html>