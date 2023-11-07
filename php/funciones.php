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

//Nombre de usuario
function validar_nombre_usuario(String $temp_nombre_usuario): String {

    if(strlen($temp_nombre_usuario) == 0){
        return "El nombre de usuario es obligatorio.";
    }else if(strlen($temp_nombre_usuario) < 4){
        return "El nombre de usuario debe tener al menos 4 caracteres.";
    }else if(strlen($temp_nombre_usuario) > 12){
        return "El nombre de usuario debe tener como máximo 12 caracteres.";
    }else if(!carac_barraBaja($temp_nombre_usuario)){
        return "El nombre solo puede contener letras y barras bajas.";
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







?>
