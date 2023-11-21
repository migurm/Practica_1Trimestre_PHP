<?php require "../util/base_de_datos.php" ?> 
<?php require "ProductoCesta.php" ?>

<?php

//BLOQUE PARA FUNCIONES (Alguna son simplemente comprobaciónes de un determinado patron en una cadena)
function depurar($entrada) {
        $salida = htmlspecialchars($entrada);
        $salida = trim($salida);
        return $salida;
}
//Esta función sustituye en un string los espacios intermedios extra, solo deja uno.
function espacios_intermedios($entrada){
    return preg_replace('/ +/', ' ', $entrada);
}
//True ->compuesto por numeros, letras, eñes y espacios
function carac_num_espacios($entrada){
    return preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ 0-9]{0,40}$/', $entrada);
}

function carac_barraBaja($entrada){
    return preg_match('/^[a-zA-Z_]{4,12}$/', $entrada);
}

function formato_date($entrada){
    return preg_match('/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$/', $entrada);
}

//Mostrar la disponibilidad de un artículo, si hay cero mostraremos fuera de stock
function mostrar_disponibilidad($disponibles){
    if ($disponibles <= 0)
        return "<p style='color:red;'>Fuera de stock</p>";
    else{
        return $disponibles." disponibles";
    }
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

//Contraseña del usuario parte BONUS
function validar_contrasena_usuario_bonus(String $temp_contrasena_usuario): String {
    $exp_reg = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_+=])[A-Za-z\d!@#$%^&*()-_+=]+$/';
    /*
    ^ Inicio de la cadena
    (?=.*[a-z]) -> al menos una minúscula en cualquier posición
    (?=.*[A-Z]) -> al menos una mayúscula en cualquier posición
    (?=.*\d) -> al menos un dígito (0-9) en cualquier posición
    (?=.*[!@#$%^&*()-_+=]) -> mínimo un caracter especial de estos !@#$%^&*()-_+=
    [A-Za-z\d!@#$%^&*()-_+=]+ -> La secuencia que debe seguir, no vamos a comprobar el tamaño, porque ya lo comprobamos antes
    $ Fin de la cadena
    */

    if(strlen($temp_contrasena_usuario) < 8 || strlen($temp_contrasena_usuario) > 20){
        return "La contraseña debe tener entre 8 y 20 caracteres";
    }else if(!preg_match($exp_reg, $temp_contrasena_usuario)){
        return "La contraseña debe contener una mayúscula, una minúscula, un número, y un caracter especial.";
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

//Validación de imágenes
function validar_imagen($imagen):String {
    $formatos_correctos = ["image/jpg", "image/jpeg", "image/png"];
    $tam_maximo = 1048576;

    if(strlen(depurar($imagen["name"])) == 0){
        return "Este campo es obligatorio";
    }else if(!in_array($imagen["type"], $formatos_correctos)){
        return "Sólo aceptamos jpg, jpeg y png";
    }else if($imagen["size"] > $tam_maximo){
        return "El tamaño máximo para una foto es de 1MB.";
    }
    global $conexion;
    $temp_nombre_imagen = depurar($imagen["name"]);
    $consulta_nombre_imagen = "SELECT imagen FROM productos WHERE imagen = 'images/$temp_nombre_imagen'";
    $resultado = $conexion->query($consulta_nombre_imagen);

    if($resultado){//No se ha roto la bbdd.
        if($resultado->num_rows > 0){
            return "Ya existe una imagen con el mismo nombre";
        }else{
            return "";
        }
    }else{
        $conexion->error;
        return "Error al realizar la consulta";
    }
}

?>

<?php
//BLOQUE PARA CONSULTAS EN LA BBDD

// Funcion que nos va a dar el valor de la cesta de un usuario.
function valor_cesta($usuario){
    global $conexion;

    $consulta = "SELECT precioTotal FROM cestas WHERE usuario = '$usuario'";
    $resultado = $conexion->query($consulta);

    if(!$resultado){
        die("Error en la consulta: ". $conexion->error);
    }

    $fila = $resultado->fetch_assoc();

    if($fila !== NULL && isset($fila['precioTotal'])){
        return $fila['precioTotal'];
    }else{
        return "0.00";
    }
    $valor = $fila['precioTotal'];
    return $valor;
}

//Comprobación de si la cantidad de producto que vamos a eliminar es correcta
function cantidad_correcta($cesta, $id_producto, $cantidad_a_eliminar){
    global $conexion;
    //Primero vamos a buscar la cantidad de producto que tenemos en la cesta del usuario.
    $consulta = "SELECT cantidad FROM productos_cestas WHERE idProducto = $id_producto AND idCesta = $cesta";
    $resultado = $conexion->query($consulta);

    if($resultado && $fila = $resultado->fetch_assoc()){
        $cantidad_actual = $fila['cantidad'];
        //Si la cantidad del producto es mayor o igual a la cantidad a eliminar lo damos por bueno
        if(intval($cantidad_actual) >= intval($cantidad_a_eliminar)){
            return 1;
        }else{
            return 0;
            echo "No se puede... buen intento ;)";
        }
    }else{
        //ups
        echo "No se rompen las páginas de los demas, por favor, esas manitas!!";
        $conexion->error;
        return 0;
    }
}

//Comprobación de que tenemos stock suficiente
function stock_correcto($id_producto, $cantidad){
    global $conexion;

    $consulta = "SELECT cantidad FROM productos WHERE idProducto = '$id_producto'";
    $resultado = $conexion->query($consulta);

    if($resultado && $fila = $resultado->fetch_assoc()){
        $stock_actual = $fila['cantidad'];

        if(intval($stock_actual) >= intval($cantidad)) //intval por si se encuentra un 0 y lo interpreta como NULL
            return true;
        else
            return false;
    }else{
        return false;
    }
}


//Función dependiente de agregar_a_carrito(), toma los parametros necesarios y resta al stock la cantidad insertada en el carrito
function restar_stock($id_producto, $cantidad){
    global $conexion;

    $orden_resta = "UPDATE productos SET cantidad = cantidad - $cantidad WHERE idProducto = $id_producto";

    if($conexion->query($orden_resta) === TRUE){
        echo "Stock actualizado";
    }else{
        $conexion->error;
    }

}
//Función dependiende de agragar_a_carrito(), toma los parámetros necesarios y realiza inserciones en productos_cestas
function agrega_productos_cestas($id_producto, $cantidad, $usuario){
    global $conexion;

    //Necesitamos la cesta del usuario.
    $consulta_cesta = "SELECT idCesta FROM cestas WHERE usuario = '$usuario'";
    $temp_cesta = $conexion->query($consulta_cesta);
    //Necesitamos comprobar si ya estaba ese producto en la cesta o no.

    if($temp_cesta && $fila_cesta = $temp_cesta->fetch_assoc()){
        $id_cesta = $fila_cesta['idCesta'];

        //Comprobamos si ya estaba este producto en la cesta determinada del usuario.
        $consulta_existencia = "SELECT * FROM productos_cestas WHERE idProducto ='$id_producto' AND idCesta = '$id_cesta'";
        $temp_existencia_anterior = $conexion->query($consulta_existencia);

        if($temp_existencia_anterior->num_rows == 0){
            //Esto quiere decir que el producto NO está en la cesta, lo insertamos tal cual entonces.
            $orden_insertar = "INSERT INTO productos_cestas VALUES ('$id_producto', '$id_cesta', '$cantidad')";
            $conexion->query($orden_insertar);
        }else{
            //El producto ya se encontraba en la cesta que estamos gestionando, entonces solo aumentaremos la cantidad.
            $orden_incrementar_cantidad = "UPDATE productos_cestas SET cantidad = cantidad + $cantidad WHERE idProducto = '$id_producto' AND idCesta = '$id_cesta'";

            $conexion->query($orden_incrementar_cantidad);
        }
        //Insertamos los valores.
    }
}

//Agregar un producto al carrito, y restar esas unidades al stock
function agregar_a_carrito($id_producto, $cantidad, $usuario){
    global $conexion;
    //Lo primero es obtener el precio del producto de la BBDD
    $consulta_precio = "SELECT precio FROM productos WHERE idProducto = '$id_producto'";

    $temp_precio_producto = $conexion->query($consulta_precio);

    if($temp_precio_producto && $fila_precio = $temp_precio_producto->fetch_assoc()){
        $precio_producto = $fila_precio['precio'];

        //Calculamos el precio total de la selección del usuario
        $precio_total = $cantidad * $precio_producto;

        //Actualizamos la suma del valor total de la cesta.
        $orden_actualizar = "UPDATE cestas SET precioTotal = precioTotal + $precio_total WHERE usuario = '$usuario'";

        $conexion->query($orden_actualizar);
        restar_stock($id_producto, $cantidad);
        agrega_productos_cestas($id_producto, $cantidad, $usuario);
        header("Location: principal.php");
        exit();

    }else{
        //No se pudo :( 
    }
}

//Función para devolver la cesta de un usuario.
function asigna_cesta($usuario){
    global $conexion;

    $consulta_cesta = "SELECT idCesta FROM cestas WHERE usuario = '$usuario'";
    $resultado = $conexion->query($consulta_cesta);

    if($resultado){
        $fila = $resultado->fetch_assoc();
        return $fila['idCesta'];
    }
    else
        die("Error en la consulta de la cesta: ". $conexion->error);
}

//Funcion que, partiendo de una cesta (de su ID) nos va a devolver un array del objeto ProductoCesta, para colocarlos en la pagina cesta
function productos_cestas_array($cesta){
    global $conexion;

    $array_productos = [];

    $consulta_productos_cesta = "SELECT pc.idProducto, pc.cantidad, p.nombreProducto, p.imagen, p.precio
                                    FROM productos_cestas pc JOIN productos p ON pc.idProducto = p.idProducto
                                    WHERE pc.idCesta = $cesta;"; 
    
    $resultado_productos_cesta = $conexion->query($consulta_productos_cesta);

    //No ha funcionado
    if(!$resultado_productos_cesta){
        die("Error en la funcion productos_cestas_array: ". $conexion->error);
    }

        while($fila = $resultado_productos_cesta -> fetch_assoc()){/* fetch_assoc() crea una especie de array asociativo con las filas*/
            $nuevo_producto = new ProductoCesta (
            $fila["idProducto"],
            $fila["nombreProducto"], 
            $fila["imagen"], 
            $fila["precio"], 
            $fila["cantidad"],
            number_format($fila["cantidad"]*$fila["precio"], 2) // Almacenamos directamente la operacion, con formato de dos decimales.
            );

            array_push($array_productos, $nuevo_producto);
        } 
        return $array_productos;
}

//Funcion para comprobar que no se han alterado los datos en el formulario, tienen que coincidir con el objeto que se mostró
function comprobar_valores($array_productos_cestas, $id_producto, $cantidad, $cantidad_a_eliminar){

    foreach($array_productos_cestas as $producto){
        echo "ID Producto: {$producto->id_producto}, Cantidad: {$producto->cantidad}, Cantidad a Eliminar: ($cantidad>=$cantidad_a_eliminar)<br>";

        if (($producto->id_producto === $id_producto) &&
            ($producto->cantidad === $cantidad) &&
            ($producto->cantidad >= $cantidad_a_eliminar)){
               return true; 
            }
                    
    }
    return false;
}

//Funcion para reestablecer el stock eliminado de la cesta en la tabla producto.
function reestablecer_stock($id_producto, $cantidad_a_eliminar){
    global $conexion;

    $orden_suma = "UPDATE productos SET cantidad = cantidad + $cantidad_a_eliminar WHERE idProducto = $id_producto";

    if($conexion->query($orden_suma) === TRUE){
        echo "Stock actualizado";
    }else{
        $conexion->error;
    }
}

//Funcion para eliminar los productos de la cesta
function restar_productos_cestas($id_producto, $cesta, $cantidad_a_eliminar){
    global $conexion;

    $orden_resta = "UPDATE productos_cestas SET cantidad = cantidad - $cantidad_a_eliminar WHERE idProducto = $id_producto AND idCesta = $cesta";

    if($conexion->query($orden_resta) === TRUE){
        echo "Productos cestas actualizados";
    }else{
        $conexion->error;
    }
}

//Función que va a reducir el importe del valor total de la cesta, dependiendo de los productos que saque de la cesta el usuario
function restar_valor_cesta($cesta, $cantidad_a_eliminar, $id_producto){
    global $conexion;

    $consulta_precio = "SELECT precio FROM productos WHERE idProducto = $id_producto";
    $temp_precio = $conexion->query($consulta_precio);

    if($temp_precio){
        $fila = $temp_precio->fetch_assoc();
        $precio = $fila['precio'];
        $resta = $precio*$cantidad_a_eliminar;
        $orden_suma_valor = "UPDATE cestas SET precioTotal = precioTotal - $resta WHERE idCesta = $cesta";

        if($conexion->query($orden_suma_valor) === TRUE){
            echo "El valo de tu cesta ha sido actualizado";
        }else{
            $conexion->error;
        }
    }else{
        die("Error en la consulta: ". $conexion->error);
    }

}

//Función que va a eliminar los productos de la cesta cuya cantidad a comprar se quede a cero.
function eliminar_productos_productos_cestas(){
    global $conexion;

    $orden_eliminar = "DELETE FROM productos_cestas WHERE cantidad = 0";
    if($conexion->query($orden_eliminar) === TRUE){
        echo "productos eliminados de la cesta";
    }else{
        $conexion->error;
    }

}

//Y por fin... La función para formalizar el pedido.
/*
Esta funcion recibe por parametros el array de objetos ProductoCesta con el que trabajamos en la pagina cesta.
Creamos un pedido asociado al usuario, y nos quedamos con el autogenerado
Recorremos todos los objetos existentes en la cesta, realizando una insercion por cada uno de ellos en lineas_pedidos
Vaciamos la cesta (precioTotal a cero)
Eliminamos todos los registros de productos_cestas que acabamos de procesar.
*/

function formalizar_pedido($array_productos_cestas, $usuario, $cesta){
    global $conexion;
 
    $consulta_valor = "SELECT precioTotal FROM cestas WHERE idCesta=$cesta";
    $resultado = $conexion->query($consulta_valor);

    if(!$resultado){
        die("Error en la funcion formalizar_pedido al consultar precioTotal: ". $conexion->error);
    }else{
        $fila = $resultado->fetch_assoc();
        $precio_total = $fila['precioTotal'];
        //Creamos el pedido, y nos quedamos con el autogenerado al instante.
        $orden_crear_pedido = "INSERT INTO pedidos (usuario, precioTotal) VALUES ('$usuario', $precio_total)";
        if($conexion -> query($orden_crear_pedido)){//Necesitamos el id del pedido que se acaba de autogenerar
            $id_pedido = $conexion->insert_id; //MAGIA
        }
        $lineaPedido = 1;
        //Ahora recorremos el array de objetos, por cada uno, haremos la inserción que se pide.
        foreach($array_productos_cestas as $producto){
            $nueva_insercion = "INSERT INTO lineas_pedidos (lineaPedido, idProducto, idPedido, precioUnitario, cantidad)
                                VALUES($lineaPedido, $producto->id_producto, $id_pedido, $producto->precio_unitario, $producto->cantidad)";
            
            if($conexion->query($nueva_insercion) === FALSE) {
                echo "Error en el foreach de inserciones de la funcion formalizar pedido: ".$conexion->error;
                break; //En caso de error, salimos del bucle e indicamos el error.
            }
            $lineaPedido++;
        }
        //Establecemos en 0 el valor de la cesta del usuario pasado por parámetro
        $orden_vaciar_cesta = "UPDATE cestas SET precioTotal = 0 WHERE usuario = '$usuario'";
        $conexion->query($orden_vaciar_cesta);

        //Eliminamos todos los productos_cestas asociados a el número de cesta pasado por parámetro
        $orden_despejar_productos_cestas = "DELETE FROM productos_cestas WHERE idCesta = $cesta";
        $conexion->query($orden_despejar_productos_cestas);
    }
}

//Función para la página principal para asegurarnos de que el id del producto está en la página
//Y para asegurarnos de que la cantidad a añadir no excede de lo que se ofrece en el select

function comprobar_datos($id_producto, $cantidad, $productos){
    if($cantidad > 5)
        return 0;
    foreach($productos as $producto){
        if(($producto->id_producto == $id_producto) && ($producto->cantidad >= $cantidad)){
            return 1;
        }
    }
    return 0;
}

?>
