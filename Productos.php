<?php  
include("templates/cabecera.php"); 
?>

<?php
    // usaremos $productosController
    require("./admin/controllers/ProductosController.php");
    $Productos = $productosController->AllProductos();

    // Filtrado por:
    $Estados = $productosController->EstadosProducto();
    $Categorias = $productosController->CategoriasProducto();

    $categoria = "todos";
    $estado = "todos";
    
    // FILTRADO DE PRODUCTOS
    if($_GET){
        $categoria = $_GET["categoria"];
        $estado = $_GET["estado"];
        if($categoria != "todos" and $estado != "todos"){
            $Productos = $productosController->ProductoEstadoCategoria($estado,$categoria);
        }elseif($categoria != "todos"){
            $Productos = $productosController->ProductoCategoria($categoria);
        }elseif($estado != "todos"){
            $Productos = $productosController->ProductoEstado($estado);
        }
    }
?>


<?php if(isset($_SESSION["rol"])== false){ ?>
    <div class="alertNoRegister">Por favor, para realizar las compras usted tiene que crearse o logearse en una cuenta.</div>
<?php } ?>
<section class="container-listaProductos">
    <article class="listaProductos-filtros">
        <h3>FILTROS</h3>
        <div class="filtros-options">
            <form action="Productos.php" method="GET">
                
                <div>
                    <label for="categoria">Categorias</label>
                    <select name="categoria" id="" >
                        <option value="todos">Todos</option>
                        <?php foreach($Categorias as $categ) { ?>
                            <option <?php if($categoria==$categ['id']){echo "selected";} ?>  value="<?php echo $categ['id']; ?>"><?php echo $categ["nombreCategoria"];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="estado">Estados</label>
                    <select name="estado" id="">
                        <option value="todos">Todos</option>
                        <?php foreach($Estados as $estad) { ?>
                            <option <?php if($estado==$estad['id']){echo "selected";} ?> value="<?php echo $estad['id']; ?>"><?php echo $estad["nombreEstado"];?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" >Filtrar</button>
            </form>
        </div>
    </article>
    <ul class="listaProductos-listCards">
        <?php foreach($Productos as $producto){ ?>
            <li class="listCard-card">
                <img src="public/img/imgProductos/<?php echo $producto['imagen']; ?>" alt="">
                <div class="card-info">
                    <h2><?php echo $producto["nombre"]; ?></h2>
                    <p><?php echo $producto["descripcion"]; ?></p>
                    <h3>$ <?php echo $producto["precio"]; ?></h3>
                </div>
                <?php if($producto["nombreEstado"]=="Agotado"){?>
                        <div class="agotado">Agotado</div>
                <?php } elseif($producto["nombreEstado"]=="No Disponible"){?>
                        <div class="agotado">No disponible</div>
                <?php } else{?>
                    <button class="btn-addProducto" name="productoId" value="<?php echo $producto['id']; ?>" >Agregar Compra</button>
                <?php } ?>

            </li>
        <?php } ?>
    </ul>
</section>





<?php  include("templates/pie.php"); ?>