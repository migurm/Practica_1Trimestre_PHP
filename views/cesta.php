<!DOCTYPE html>
<html lang="es">
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
    $array_productos_cestas = productos_cestas_array(intval($cesta));
    ?>
    <?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["eliminar_producto"])){
            //Botón de eliminar un producto de la cesta.
            $id_producto = depurar($_POST["id_producto"]);
            echo "Producto numero: ".$id_producto."<br>";
            $cantidad_a_eliminar = depurar($_POST["cantidad"]);
            $cantidad = depurar($_POST["cantidad_inicial"]);
            if(comprobar_valores($array_productos_cestas, intval($id_producto), intval($cantidad), intval($cantidad_a_eliminar))){
                echo"No lo has modificado<br>";
                if(cantidad_correcta(intval($cesta), $id_producto, $cantidad_a_eliminar)){
                    echo "Se puede operar<br>";
                    reestablecer_stock($id_producto, $cantidad_a_eliminar);
                    restar_productos_cestas($id_producto, $cesta, $cantidad_a_eliminar);
                    restar_valor_cesta($cesta, $cantidad_a_eliminar, $id_producto);
                    eliminar_productos_productos_cestas();
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit();
                }
            }else{
                echo "Está feo modificar los formularios ajenos!";
            }
        }else if(isset($_POST["formalizar_pedido"])){
            echo "<p>Formalizar el pedido</p>";
            //Vale, aquí nos da igual si se ha tocado la web con el inspeccionar
            //Nuestra materia prima es el array de ProductoCesta.
            formalizar_pedido($array_productos_cestas, $usuario, $cesta);
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">¿PHP? mi pasión</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href='principal.php'>Volver a tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='cerrar_sesion.php'>Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Mi cesta</h1>
        <div id="cesta" class="card">
            <ul class="list-group lista-productos">
            <?php
            if(empty($array_productos_cestas)){
                echo "<h3>No tienes productos todavía en la cesta.</h3>";//No tenemos nada en el array de objetos ProductosCesta

            }else{
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
                        <form action="" method="POST">
                            <input type="hidden" name="cantidad_inicial" value="<?php echo $producto->cantidad ?>">
                            <input type="hidden" name="id_producto" value="<?php echo $producto->id_producto ?>">
                            <select name="cantidad">
                                <?php 
                                    for($i = 1; $i <= $producto->cantidad; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                            <button class="btn btn-danger btn-eliminar" name="eliminar_producto">Eliminar</button>

                        </form>
                    </li>
                <?php
                }
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
                        <span class="badge bg-secondary">0%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total
                        <span class="badge bg-secondary"><?php echo number_format($sumatorioPrecio, 2) ?> €</span>
                    </li>
                </ul>
                <form action="" method="POST">
                    <button class="btn btn-success btn-pago mt-3" name="formalizar_pedido">Formalizar pedido</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
