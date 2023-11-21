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
        if($usuario != "invitado"){
            $rol = $_SESSION["rol"];    
        }
        

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
            echo "<h2>No tenemos stock, nice try</h2>";
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
                    <li>
                        <span class="nav-link"><?php echo $usuario; ?></span>
                    </li>
                    <?php
                        
                        if(isset($rol) && ($rol === "admin")){
                            echo "<li class='nav-item'>";
                            echo"<a class='nav-link' href='productos.php'>AGREGAR PRODUCTOS</a></li>";
                            echo"</li>";
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cesta.php">Cesta: <?php echo $valorCesta; ?>€</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if($usuario != "invitado"){
                            echo "<a class='nav-link' href='cerrar_sesion.php'>Cerrar sesión</a>";
                        }else{
                            echo "<a class='nav-link' href='login.php'>Iniciar sesion</a>";
                            echo "</li><li class='nav-item'>";
                            echo "<a class='nav-link' href='usuarios.php'>Regístrese</a>";
                        }
                        
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron text-center">
        <h2 class="display-4">Bienvenido a libros para programar</h2>
        <p class="lead">Observe nuestra amplia selección de libros, adaptados a todos los niveles, desde <b>sumar</b> a <b>machine learning</b></p>
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