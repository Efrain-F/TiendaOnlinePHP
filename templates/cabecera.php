
<?php
    // usaremos su controlaro $sessionController
    require dirname( __DIR__ )."./admin/controllers/SessionController.php";
    session_start();

    if(isset($_SESSION["carrito"])==false){
        $_SESSION["carrito"] = array();
    }
    $userName;
    if(isset($_SESSION["usuario"])){
        $userId = $_SESSION["usuario"];
        if($userId!= null or $userId!= ""){
            $userName = $sessionController->nameUserSession($userId);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./public/style/cabecera.css">
    <link rel="stylesheet" href="./public/style/carrito.css">
    <link rel="stylesheet" href="./public/style/productos.css">
    <link rel="stylesheet" href="./public/style/home.css">
    <link rel="stylesheet" href="./public/style/PanelPedidos.css">
    <link rel="stylesheet" href="./public/style/PanelProductos.css">
</head>
<body>
    <section class="container">
        <header class="container-header">
            <div>
                <a href="index.php">
                    <h1>StoreOnline</h1>
                </a>
            </div>
            <div>
                <?php if(isset($_SESSION["rol"])){ ?>
                    <?php if($_SESSION["rol"] == "cliente"){ ?>
                        <?php  include("templates/navegacion.php"); ?>
                        <div class="carrito-nav">
                            <i class='bx bxs-cart bx-md' id="btn-carrList" style='color:#ffffff' ></i>
                            <h3 class="carrito-count"></h3>
                        </div>
                    <?php } elseif($_SESSION["rol"] == "administrador") {?>
                        <?php include("templates/navegacionAdmin.php"); ?>
                    <?php }?>
                <?php } else {?>
                    <?php  include("templates/navegacionNoRegister.php"); ?>
                <?php } ?>

                <?php if(isset($_SESSION["usuario"])){ ?>
                    <div class="session">
                        <i class='bx bxs-user bx-md' style='color:#ffffff'></i>
                        <h3><?php print_r($userName[0]["nombre"]);?></h3>
                        <form action="Login.php" method="POST">
                            <button type="submit" name="cerrar" class="session-close">Cerrar Session</button>
                        </form>
                    </div>
                <?php }else{?>
                    <div class="session">
                        <a class="btn-session" href="Login.php">Login</a>
                        <a class="btn-session" href="SignUp.php">SignUp</a>
                    </div>
                <?php }?>
                <i class='bx bx-menu bx-md' id="btn-barrMenu" style='color:#ffffff' ></i>
            </div>
        </header>
        
        <div class="container-listaCompra">
            <h2>Lista de compra</h2>
            <ul id="listaCompraCarrito">
            </ul>
            <a href="carrito.php">Ver Info</a>
        </div>