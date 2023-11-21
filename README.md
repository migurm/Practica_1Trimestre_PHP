# Tienda en Línea - Proyecto de Desarrollo Web Entorno Cliente

![Tienda en Línea]([https://tu_url_imagen.com/tienda.png](https://www.dongee.com/tutoriales/content/images/size/w1000/2023/01/image-65.png))

Un proyecto de tienda en línea como parte de la asignatura "Desarrollo Web Entorno Servidor". Esta tienda utiliza una variedad de tecnologías para brindar una experiencia de compra en línea completa y atractiva.

## Vista Previa

![Vista Previa de la Tienda](https://tu_url_imagen.com/vista_previa.png)

## Características Destacadas

- **Registro de Usuarios:** Permite a los clientes crear una cuenta y gestionar sus detalles personales.
- **Inicio de Sesión:** Los usuarios registrados pueden iniciar sesión para acceder a su cuenta.
- **Catálogo de Productos:** Muestra una amplia gama de productos en una interfaz atractiva.
- **Cesta de Compras:** Permite a los usuarios agregar productos a su cesta antes de la compra.
- **Administración de Productos:** Los administradores pueden gestionar productos a través del formulario de administración.
- **Integración con Base de Datos:** Utiliza MySQL para almacenar productos y detalles de usuario.

## Tecnologías Utilizadas

- **PHP:** Para el desarrollo del lado del servidor.
- **HTML:** Para la estructura del sitio web.
- **CSS (con Bootstrap):** Para el diseño y la interfaz de usuario.
- **MySQL:** Para la base de datos de productos y usuarios.

## Funciones empleadas
<details>
<summary><b>depurar</b></summary>
Esta función recibe una entrada y la depura eliminando caracteres especiales y espacios adicionales.

```php
Copy code
function depurar($entrada) {
    $salida = htmlspecialchars($entrada);
    $salida = trim($salida);
    return $salida;
}
</details>
<details>
<summary><b>espacios_intermedios</b></summary>
Esta función reemplaza los espacios intermedios adicionales en una cadena, dejando solo uno.

```php
Copy code
function espacios_intermedios($entrada){
    return preg_replace('/ +/', ' ', $entrada);
}
</details>
<details>
<summary><b>carac_num_espacios</b></summary>
Esta función devuelve true si la cadena contiene solo números, letras, eñes y espacios.

```php
Copy code
function carac_num_espacios($entrada){
    return preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ 0-9]{0,40}$/', $entrada);
}
</details>
<details>
<summary><b>carac_barraBaja</b></summary>
Esta función devuelve true si la cadena tiene entre 4 y 12 caracteres y solo contiene letras y barras bajas.

```php
Copy code
function carac_barraBaja($entrada){
    return preg_match('/^[a-zA-Z_]{4,12}$/', $entrada);
}
</details>

<details>
<summary><b>formato_date</b></summary>

Esta función devuelve true si la cadena sigue el formato AAAA/MM/DD.

```php
function formato_date($entrada){
    return preg_match('/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$/', $entrada);
}
</details>

<details>
<summary><b>mostrar_disponibilidad</b></summary>

Esta función muestra la disponibilidad de un artículo, indicando si está fuera de stock o la cantidad disponible.

```php
function mostrar_disponibilidad($disponibles){
    if ($disponibles <= 0)
        return "<p style='color:red;'>Fuera de stock</p>";
    else{
        return $disponibles." disponibles";
    }
}
</details>
<details>
<summary><b>validar_nombre_usuario</b></summary>
Esta función valida el nombre de usuario, asegurándose de que cumpla con ciertos requisitos y no esté duplicado en la base de datos.

php
Copy code
function validar_nombre_usuario(String $temp_nombre_usuario): String {
    // ... (ver código para más detalles)
}
</details>
<details>
<summary><b>validar_contrasena_usuario</b></summary>
Esta función valida la contraseña del usuario.

php
Copy code
function validar_contrasena_usuario(String $temp_contrasena_usuario): String {
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>validar_fecha_nacimiento</b></summary>

Esta función valida la fecha de nacimiento del usuario.

```php
function validar_fecha_nacimiento(String $temp_fecha_nacimiento, int $maximo, int $minimo): String {
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>validar_nombre_producto</b></summary>

Esta función valida el nombre de un producto.

```php
function validar_nombre_producto(String $temp_nombre_producto): String {
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>validar_precio_producto</b></summary>

Esta función valida el precio de un producto.

```php
function validar_precio_producto(String $temp_precio_producto): String {
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>validar_descripcion_producto</b></summary>

Esta función valida la descripción de un producto.

```php
function validar_descripcion_producto(String $temp_descripcion_producto): String {
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>validar_cantidad_producto</b></summary>

Esta función valida la cantidad de un producto.

```php
function validar_cantidad_producto(String $temp_cantidad_producto): String {
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>validar_imagen</b></summary>

Esta función valida la imagen de un producto.

```php
function validar_imagen($imagen):String {
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>valor_cesta</b></summary>

Esta función devuelve el valor total de la cesta de un usuario.

```php
function valor_cesta($usuario){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>cantidad_correcta</b></summary>

Esta función verifica si la cantidad de un producto a eliminar es correcta.

```php
function cantidad_correcta($cesta, $id_producto, $cantidad_a_eliminar){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>stock_correcto</b></summary>

Esta función verifica si hay suficiente stock para un producto.

```php
function stock_correcto($id_producto, $cantidad){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>restar_stock</b></summary>

Esta función resta la cantidad de productos al stock.

```php
function restar_stock($id_producto, $cantidad){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>agrega_productos_cestas</b></summary>

Esta función agrega productos a la tabla productos_cestas.

```php
function agrega_productos_cestas($id_producto, $cantidad, $usuario){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>agregar_a_carrito</b></summary>

Esta función agrega un producto al carrito y actualiza el stock.

```php
function agregar_a_carrito($id_producto, $cantidad, $usuario){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>asigna_cesta</b></summary>

Esta función asigna una cesta a un usuario.

```php
function asigna_cesta($usuario){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>productos_cestas_array</b></summary>

Esta función devuelve un array de objetos ProductoCesta a partir de una cesta.

```php
function productos_cestas_array($cesta){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>comprobar_valores</b></summary>

Esta función comprueba que no se hayan alterado los datos en el formulario.

```php
function comprobar_valores($array_productos_cestas, $id_producto, $cantidad, $cantidad_a_eliminar){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>reestablecer_stock</b></summary>

Esta función restablece el stock eliminado de la cesta en la tabla producto.

```php
function reestablecer_stock($id_producto, $cantidad_a_eliminar){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>restar_productos_cestas</b></summary>

Esta función resta la cantidad de productos de la cesta.

```php
function restar_productos_cestas($id_producto, $cesta, $cantidad_a_eliminar){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>restar_valor_cesta</b></summary>

Esta función resta el importe del valor total de la cesta.

```php
function restar_valor_cesta($cesta, $cantidad_a_eliminar, $id_producto){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>eliminar_productos_productos_cestas</b></summary>

Esta función elimina los productos de la cesta cuya cantidad a comprar se queda a cero.

```php
function eliminar_productos_productos_cestas(){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>formalizar_pedido</b></summary>

Esta función formaliza un pedido, crea un pedido asociado al usuario y realiza inserciones en la tabla lineas_pedidos.

```php
function formalizar_pedido($array_productos_cestas, $usuario, $cesta){
    // ... (ver código para más detalles)
}
</details>

<details>
<summary><b>comprobar_datos</b></summary>

Esta función comprueba que el id del producto está en la página y que la cantidad a añadir no excede lo ofrecido.

```php
function comprobar_datos($id_producto, $cantidad, $productos){
    // ... (ver código para más detalles)
}
</details>

Esta es una descripción general de las funciones en el código PHP. Para obtener más detalles, consulta el propio código fuente.
