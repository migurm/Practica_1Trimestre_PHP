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
    $productos_cestas = productos_cestas_array($cesta);

    ?>
    <div class="container mt-5">
        <h1>Mi cesta</h1>
        <div id="cesta">
            <ul class="list-group lista-productos">
                <li class="list-gruop-item d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="detalles-producto d-flex alignt-items-center">
                            <img src="" alt="aquí iria la imagen" class="mr-3" style="width: 100px; height: 100px;">
                            <div>
                                <p class="mb-1">Nombre del Producto</p>
                                <p class="mb-1">Precio (1ud): 2</p>
                                <p class="mb-1">Unidades: 5</p>
                                <p class="mb-1">Subtotal: 10</p>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-eliminar">Eliminar</button>
                </li>
            <!-- Otros elementos de la lista de productos -->
            </ul>

            <div id="total-cesta" class="mt-4">
                <h5>Detalles de la cesta:</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between aling-items-center">
                        Subtotal
                        <span class="badge bg-secondary">120€</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between aling-items-center">
                        Impuestos
                        <span class="badge bg-secondary">20€</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between aling-items-center">
                        Total
                        <span class="badge bg-secondary">120€</span>
                    </li>
                </ul>
                <button class="btn btn-success btn-pago mt-3">Proceder al Pago</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>