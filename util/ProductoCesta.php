<?php
class ProductoCesta {
    public int $id_producto;//Este no lo vamos a mostrar
    public string $nombre_producto;
    public string $imagen;
    public float $precio_unitario;
    public int $cantidad;
    public float $importe;
    
    public function __construct($id_producto, $nombre_producto, $imagen, $precio_unitario, $cantidad, $importe){
        $this->id_producto = $id_producto;
        $this->nombre_producto = $nombre_producto;
        $this->imagen = $imagen;
        $this->precio_unitario = $precio_unitario;
        $this->cantidad = $cantidad;
        $this->importe = $importe;
    }
}

?>