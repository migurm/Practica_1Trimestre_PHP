<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>	
	<?php require "../util/funciones.php" ?>
	<?php require "../util/base_de_datos.php" ?>
</head>
<body>
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$temp_nombre_usuario = depurar($_POST["nombre_usuario"]);
		$temp_contrasena_usuario = depurar($_POST["contrasena_usuario"]);
		$temp_fecha_nacimiento = depurar($_POST["fecha_nacimiento"]);

	//Comprobamos nombre usuario.
	if(strlen(validar_nombre_usuario($temp_nombre_usuario)) == 0){
		$nombre_usuario = $temp_nombre_usuario;
	}else{
		$err_nombre_usuario= validar_nombre_usuario($temp_nombre_usuario);
	}

	//Controlamos la contraseña
	if(strlen(validar_contrasena_usuario($temp_contrasena_usuario)) == 0){
		$contrasena_usuario = password_hash($temp_contrasena_usuario, PASSWORD_DEFAULT);
	}else{
		$err_contrasena_usuario = validar_contrasena_usuario($temp_contrasena_usuario);
	}

	//Controlamos la fecha de nacimiento
	if(strlen(validar_fecha_nacimiento($temp_fecha_nacimiento, 120, 12)) == 0){
		$fecha_nacimiento = $temp_fecha_nacimiento;
	}else{
		$err_fecha_nacimiento = validar_fecha_nacimiento($temp_fecha_nacimiento, 120, 12);
	}

	}
	?>
	<div class="container mt-5">
		<form action="" method="POST">
			<fieldset>
				<legend>Nuevo usuario</legend>

				<div class="form-group">
					<label for="nombre_usuario">Nombre:</label>
					<input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario">
					<?php if(isset($err_nombre_usuario)) echo "<p class='text-danger'>$err_nombre_usuario</p>"; ?>
				</div>

				<div class="form-group">
					<label for="contrasena_usuario">Contraseña:</label>
					<input type="text" class="form-control" id="contrasena_usuario" name="contrasena_usuario">
					<?php if(isset($err_contrasena_usuario)) echo "<p class='text-danger'>$err_contrasena_usuario</p>"; ?>
				</div>
				
				<div class="form-group">
					<label>Fecha de nacimiento:</label>
					<input type="date" class ="form-control" id="fecha_nacimiento "name="fecha_nacimiento">
					<?php if(isset($err_fecha_nacimiento)) echo "<p class='text-danger'>$err_fecha_nacimiento</p>"; ?>
				</div>

				<input type="submit" class="btn btn-primary mt-2" value="Registrar">
			</fieldset>
		</form>
	</div>
	<?php
	if((isset($nombre_usuario))&& isset($contrasena_usuario) && isset($fecha_nacimiento)){
			echo "<p>Usuario registrado exitosamente.</p>";

		$sql = "INSERT INTO usuarios (usuario, contrasena, fechaNacimiento)
            VALUES ('$nombre_usuario', '$contrasena_usuario', '$fecha_nacimiento')";

        $conexion -> query($sql);
    }
	?>
    
</body>
</html>