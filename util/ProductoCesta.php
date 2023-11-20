<?php
class ProductoCesta {
    public $id_producto;//Este no lo vamos a mostrar
    public $nombre_producto;
    public $imagen;
    public $precio_unitario;
    public $importe;
    
    public function __construc($id_producto, $nombre_producto, $imagen, $precio_unitario, $importe){
        $this->id_producto = $id_producto;
        $this->nombre_producto = $nombre_producto;
        $this->imagen = $imagen;
        $this->precio_unitario = $precio_unitario;
        $this->importe = $importe;
    }
}

?>