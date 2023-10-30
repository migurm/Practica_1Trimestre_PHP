<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
	<?php require "../php/funciones.php" ?>
</head>
<body>
<form action="" method="POST">
		<fieldset>
			<legend>
				Usuarios
			</legend>
			<label>
				Nombre:
			</label>
			<input type="text" name="nombre_usuario">
			
			<label>
				Contreaseña: 
			</label>
			<input type="text" name="contrasena_usuario">
			<label>
				Fecha de nacimiento:
			</label>
			<input type="date" name="fecha_nacimiento">
            <input type="submit" value="Registrar">
		</fieldset>
	</form>
    
</body>
</html>