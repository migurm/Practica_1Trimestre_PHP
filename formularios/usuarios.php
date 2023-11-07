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
	if((isset($nombre_usuario))&& isset($contrasena_usuario) && isset($fecha_nacimiento)){
			echo "<p>Usuario registrado exitosamente.</p>";

		$sql = "INSERT INTO usuarios (usuario, contrasena, fechaNacimiento)
            VALUES ('$nombre_usuario', '$contrasena_usuario', '$fecha_nacimiento')";

        $conexion -> query($sql);
    }
	?>
    
</body>
</html>