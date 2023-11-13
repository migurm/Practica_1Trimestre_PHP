<?php
class Producto {
    public int $id_producto;
    public string $nombre_producto;
    public float $precio_producto;
    public string $descripcion;
    public int $cantidad;
    public string $imagen;

    function __construct($id_producto, $nombre_producto, $precio_producto, $descripcion, $cantidad, $imagen) {
        $this -> id_producto = $id_producto;
        $this -> nombre_producto = $nombre_producto;
        $this -> precio_producto = $precio_producto;
        $this -> descripcion = $descripcion;
        $this -> cantidad = $cantidad;
        $this -> imagen = $imagen;
    }
}
?>