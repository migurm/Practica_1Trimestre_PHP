<?php
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