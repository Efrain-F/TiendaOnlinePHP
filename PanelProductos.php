<?php  include("templates/cabecera.php"); ?>
<?php
    require "./admin/controllers/VentasController.php";
    $ventasController = new VentasController;
    
    // usaremos $productosController
    require("./admin/controllers/ProductosController.php");
    $error = false;
    $productos = array();

    // Filtrado por:
    $Estados = $productosController->EstadosProducto();
    $Categorias = $productosController->CategoriasProducto();
    $categoria = "todos";
    $estado = "todos";

    if($ventasController->ValidateAdmin()){
        if($_POST){
            if(isset($_POST["idProducto"])){
                $id = $_POST["idProducto"];
                $productosController->RemoveProducto($id);
            }
        }
        if($_GET){
            $categoria = isset($_GET["categoria"])?$_GET["categoria"]:"todos";
            $estado = isset($_GET["estado"])?$_GET["estado"]:"todos";
            if($categoria != "todos" and $estado != "todos"){
                $productos = $productosController->ProductoEstadoCategoria($estado,$categoria);
            }elseif($categoria != "todos"){
                $productos = $productosController->ProductoCategoria($categoria);
            }elseif($estado != "todos"){
                $productos = $productosController->ProductoEstado($estado);
            }else{
                $productos = $productosController->AllProductos();
            }
        }
        else{
            $productos = $productosController->AllProductos();
        }

    }else{$error = true;}
    
?>
<?php if($error){?>
    <?php  include("templates/noAccess.php"); ?>
<?php } else{?>
    <section class="container-pedidos">
        <article class="listaProductos-filtros">
            <h3>FILTROS</h3>
            <div class="filtros-options">
                <form action="PanelProductos.php" method="GET">
                    
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
        <a href="CrearProducto.php" class="crear-producto-btn">Crear Producto</a>
        <table class="carrito-table">
            <thead class="table-thead">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Vista</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Categoria</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody class="table-tbody">
                <?php foreach($productos as $producto){?>
                    <tr>
                        <td><?php echo $producto["id"];?></td>
                        <td><?php echo $producto["nombre"];?></td>
                        <td>
                            <img src="public/img/imgProductos/<?php echo $producto["imagen"];?>" alt="">
                        </td>
                        <td>$ <?php echo $producto["precio"];?></td>
                        <td><?php echo $producto["nombreEstado"];?></td>
                        <td><?php echo $producto["nombreCategoria"];?></td>
                        <td class="acciones">
                            <a href="infoProducto.php?producto=<?php echo $producto["id"];?>" class="info-prod">
                                <i class='bx bxs-show bx-md'></i>
                            </a>
                            <form action="PanelProductos.php" method="post">
                                <button type="submit" name="idProducto" value="<?php echo $producto["id"];?>" class="remove-prod">
                                    <i class='bx bx-trash bx-md'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </section>
<?php }?>
<?php  include("templates/pie.php"); ?>
