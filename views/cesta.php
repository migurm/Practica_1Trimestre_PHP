<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi cesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../util/base_de_datos.php" ?>
    <?php require "../util/funciones.php" ?>
</head>
<body>
    <?php //Gestiones de inicio de sesión si lo hay.
        session_start();
        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] != "invitado"){
            $usuario = $_SESSION["usuario"];
            $cesta = asigna_cesta($usuario);//Ya tiene su id de cesta, ahora podemos extraer los datos
        }else{
            header('location: login.php'); 
        }
    ?>
    <?php
    //Las variables que vamos a usar en esta pagina
    $sumatorioPrecio = 0;
    //Creamos un objeto para mostrar todos los elementos de manera mas sencilla
    //Vamos a por esos datos ;)
    $array_productos_cestas = productos_cestas_array($cesta);
    ?>



    <div class="container mt-5">
        <h1 class="mb-4">Mi cesta</h1>
        <div id="cesta" class="card">
            <ul class="list-group lista-productos">
            <?php
            foreach($array_productos_cestas as $producto){
                $sumatorioPrecio += ($producto->cantidad * $producto->precio_unitario);
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="detalles-producto d-flex alignt-items-center">
                            <img src="<?php echo $producto->imagen ?>" alt="aquí iria la imagen" class="mr-3" style="width: 80px; height: 100px;">
                            <div class="d-flex flex-column justify-content-center align-items-center space">
                                <p class="mb-1"><?php echo $producto->nombre_producto ?></p>
                                <p class="mb-1">Precio (ud): <?php echo $producto->precio_unitario ?>€</p>
                                <p class="mb-1">Cantidad: <?php echo $producto->cantidad ?></p>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-eliminar">Eliminar</button>
                </li>
            <?php
            }?>
            </ul>

            <div id="total-cesta" class="card-footer mt-4">
                <h5 class="mb-3">Detalles de la cesta:</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Subtotal
                        <span class="badge bg-secondary"><?php echo number_format($sumatorioPrecio, 2) ?> €</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Impuestos
                        <span class="badge bg-secondary">21%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total
                        <span class="badge bg-secondary"><?php echo number_format($sumatorioPrecio*1.21, 2) ?> €</span>
                    </li>
                </ul>
                <button class="btn btn-success btn-pago mt-3">Proceder al Pago</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>





<form action="" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo $producto->id_producto ?>">
                            <td>
                                <select name="cantidad" <?php if($disponibles <= 0 || $usuario == "invitado")  echo 'disabled=true'?>>
                                <?php
                                    for($i = 1; $i <= 5; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }    
                                ?>
                                </select>
                            </td>
                            <td>
                                <input class="btn btn-warning" type="submit" 
                                <?php if($disponibles <= 0 || $usuario == "invitado") echo 'disabled=true' ?>name="agregar_a_carrito" value="Añadir">
                            </td>
                        </form>