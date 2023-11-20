<?php require "../util/base_de_datos.php" ?> 

<?php

//BLOQUE PARA FUNCIONES
function depurar($entrada) {
        $salida = htmlspecialchars($entrada);
        $salida = trim($salida);
        return $salida;
};
//Esta función sustituye en un string los espacios intermedios extra, solo deja uno.
function espacios_intermedios($entrada){
    return preg_replace('/ +/', ' ', $entrada);
};
//True ->compuesto por numeros, letras, eñes y espacios
function carac_num_espacios($entrada){
    return preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ 0-9]{0,40}$/', $entrada);
};

function carac_barraBaja($entrada){
    return preg_match('/^[a-zA-Z_]{4,12}$/', $entrada);
}

function formato_date($entrada){
    return preg_match('/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$/', $entrada);
}
?>
<?php
//BLOQUE PARA VALIDACIONES
/* Explicación, estas validaciones van a devolver una cadena, esta cadena puede contener
detalladamente el error en el dato, o volver vacías, de volver vacías, damos el dato por bueno */

//Nombare de usuario
function validar_nombre_usuario(String $temp_nombre_usuario): String {
    //Comprobaremos si ya existe este nombre
    global $conexion;

    if(strlen($temp_nombre_usuario) == 0){
        return "El nombre de usuario es obligatorio.";
    }else if(strlen($temp_nombre_usuario) < 4){
        return "El nombre de usuario debe tener al menos 4 caracteres.";
    }else if(strlen($temp_nombre_usuario) > 12){
        return "El nombre de usuario debe tener como máximo 12 caracteres.";
    }else if(!carac_barraBaja($temp_nombre_usuario)){
        return "El nombre solo puede contener letras y barras bajas.";
    }else{
        //¿Existe en la bbdd?
        $consulta = "SELECT * FROM usuarios WHERE usuario = '$temp_nombre_usuario'";
        $resultado = $conexion->query($consulta);

        if($resultado->num_rows > 0) {
            return "Este nombre de usuario ya está ocupado, prueba con otro.";
        }
    }

    return "";
}

//Contraseña del usuario
function validar_contrasena_usuario(String $temp_contrasena_usuario): String {
    if(strlen($temp_contrasena_usuario) == 0){
        return "La contraseña es obligatoria";
    }else if(strlen($temp_contrasena_usuario) > 255){
        return "La contraseña no puede exceder los 255 caracteres";
    }

    return "";
}


//Edad del usuario, maximo y minimo permitido
function validar_fecha_nacimiento(String $temp_fecha_nacimiento, int $maximo, int $minimo): String {
    if(strlen($temp_fecha_nacimiento) == 0){
        return "La fecha de nacimiento es obligatoria";
    }else if (!formato_date($temp_fecha_nacimiento)){
        return "El formato de la fecha debe ser AAAA/MM/DD";
    }else{
        $fecha_introducida = new DateTime($temp_fecha_nacimiento);
        $fecha_actual = new DateTime(date('Y-m-d'));
        $diferencia = $fecha_actual -> diff($fecha_introducida);
        $years = $diferencia -> y;
        if($years < $minimo){
            return "Los menores de ".$minimo." años no puede registrarse";
        }else if($years > 120){
            return "Desgraciadamente, aún no podemos vivir más de ".$maximo." años";
        }
    }
    return "";
}

//Validación del nombre del producto

function validar_nombre_producto(String $temp_nombre_producto): String {
    if(strlen($temp_nombre_producto) == 0){
        return "El nombre es obligatorio";
    }else if(strlen($temp_nombre_producto) > 40){
        return "El nombre del producto no puede exceder los 40 caracteres";
    }else if(!carac_num_espacios($temp_nombre_producto)){
        return "El nombre del producto solo puede contener números, letras y espacios en blanco";
    }
    return "";
}

//Validación precio del producto

function validar_precio_producto(String $temp_precio_producto): String {
    if(strlen($temp_precio_producto) == 0){
        return "El precio del producto es obligatorio";
    }else if(!is_numeric($temp_precio_producto)){
        return "El precio debe ser un número";
    }else if((float)$temp_precio_producto < 0){
        return "El precio mínimo es 0";
    }else if((float)$temp_precio_producto > 99999.99){
        return "El precio no puede exceder los 99.999,99€";
    }
    return "";
}


//Validación de la descripción del producto

function validar_descripcion_producto(String $temp_descripcion_producto): String {
    if(strlen($temp_descripcion_producto) == 0){
        return "La descripción del producto es obligatoria";
    }else if(strlen($temp_descripcion_producto) > 255){
        return "La descripción del producto no puede exceder los 255 caracteres";
    }
    return "";
}

//Validación de la cantidad de producto

function validar_cantidad_producto(String $temp_cantidad_producto): String {
    if(strlen($temp_cantidad_producto) == 0){
        return "La cantidad de productos es obligatoria";
    }else if(!is_numeric($temp_cantidad_producto)){
        return "Debe introducir un número";
    }else if(!filter_var($temp_cantidad_producto, FILTER_VALIDATE_INT)){
        return "Debe ser un número entero";
    }else if((int)$temp_cantidad_producto < 0){
        return "No se pueden introducir cantidades negativas";
    }else if((int)$temp_cantidad_producto > 99999){
        return "La cantidad no puede exceder las 99.999 unidades";
    }
    return "";
}
?>

<?php
//BLOQUE PARA CONSULTAS EN LA BBDD

//Valor de la cesta de un usuario.

function valor_cesta($usuario){
    global $conexion;

    $consulta = "SELECT precioTotal FROM cestas WHERE usuario = '$usuario'";

    $resultado = $conexion->query($consulta);

    if(!$resultado){
        die("Error en la consulta: ". $conexion->error);
    }

    $fila = $resultado->fetch_assoc();
    $valor = $fila['precioTotal'];

    return $valor;
}

//Comprobación de que tenemos stock suficiente
function stock_correcto($id_producto, $cantidad){
    global $conexion;

    $consulta = "SELECT cantidad FROM productos WHERE idProducto = '$id_producto'";
    $resultado = $conexion->query($consulta);

    if($resultado && $fila = $resultado->fetch_assoc()){
        $stock_actual = $fila['cantidad'];

        if($stock_actual >= $cantidad)
            return true;
        else
            return false;
    }else{
        return false;
    }
}
?>
