<?php
	//Creamos una variable donde vamos a almacenar la IP 
	//en la que se encuentra la base de datos
	$_servidor = 'localhost';
	//Usuario nuestro de la base de datos
	$_usuario = 'root';
	$_contrasena = 'medac';
	//Este archivo solo tiene que estar en el server de la base de datos
	//es muy importante que no se filtre el dia de mañana.
	$_base_de_datos = 'db_tienda';
	//Ahora vamos a hacer la conexión, pàra eso creamos un objeto de tipo Mysqli
	//Nos permite interactuar con las bbdd este tipo de objeto.
	$conexion = new Mysqli($_servidor, $_usuario, $_contrasena, $_base_de_datos)
	or die("Error de conexión");
	//Y or die por si no funciona.
?>