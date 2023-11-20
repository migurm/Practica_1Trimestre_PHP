<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../util/base_de_datos.php" ?>
    <?php require "../util/funciones.php" ?>
    <?php require "../util/Producto.php" ?>
</head>
<body>

    <?php //Gestiones de inicio de sesión si lo hay.
    session_start();

    if(isset($_SESSION["usuario"])){
        $usuario = $_SESSION["usuario"];
        $valorCesta = valor_cesta($usuario);

    }else{
        //header('location: iniciar_sesion.php'); O mandamos a otra página
        //O le llamamos al usuario invitado
        $usuario = $_SESSION["usuario"] = "invitado";
        $valorCesta = "0.00";
    }
    ?>

    <?php //Gestiones de agregar artículos a la cesta.
    //En primer lugar, si el usuario es invitado, le vamos a avisar de que tiene que registrarse para hacer compras.
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["agregar_a_carrito"]) && $usuario != "invitado"){
        $id_producto = depurar($_POST["id_producto"]);//Las inyecciones de sql mejor que no
        $cantidad = depurar($_POST["cantidad"]);

        if(stock_correcto($id_producto, $cantidad)){
            echo "<h2>Tenemos stock!!</h2>";
            agregar_a_carrito($id_producto, $cantidad, $usuario);
        }else{
            echo "<h2>No tenemos stock memo</h2>";
        }
    }
    ?>


    <div class="container">
        <h1>Página principal</h1>
        <h2>Usuari@: <?php echo $usuario ?></h2>
        <h3>Cesta: <?php echo $valorCesta ?>€</h3>
        <!--  Enlace a cierre de sesión -->
        <a href="cerrar_sesion.php">Cerrar sesión</a>

        <!-- Enlace a iniciar sesion -->
        <a href=""></a>

        
    </div>
    <div>
        <?php
        $sql = "SELECT * FROM productos";
        $resultado = $conexion -> query($sql);
        ?>

        <table class="table table-hover">
            <thead class="table table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Artículo</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>En almacén</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $productos = [];
                while($fila = $resultado -> fetch_assoc()){/* fetch_assoc() crea una especie de array asociativo con las filas*/
                    $nuevo_producto = new Producto ($fila["idProducto"], $fila["nombreProducto"], 
                    $fila["precio"], $fila["descripcion"], 
                    $fila["cantidad"], $fila["imagen"]);

                    array_push($productos, $nuevo_producto);
                } 
                foreach($productos as $producto){ ?>
                    <tr class="text-center align-middle">
                        <td><?php echo $producto -> id_producto ?></td>
                        <td><?php echo $producto -> nombre_producto ?></td>
                        <td><?php echo $producto -> precio_producto ?> €</td>
                        <td><?php echo $producto -> descripcion ?></td>
                        <td><?php $disponibles = $producto->cantidad;//Mostraremos el stock de una manera u otra si hay o no
                        echo mostrar_disponibilidad($disponibles);?></td>

                        <td><img width="80" height="100" src="<?php echo $producto -> imagen ?>"></td>
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
 
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>