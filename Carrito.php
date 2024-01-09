<?php include("templates/cabecera.php"); ?>

<?php 
    //$carrito = $_SESSION["carrito"];
    require "./admin/controllers/CarritoController.php";
    $carritoControlador = new CarritoCompra();
    //$carritoControlador->borrarCarritoCompra();
    if($_POST){
        $accion = $_POST["accion"];
        $producto = $_POST["idProducto"];
        $cantidad = $_POST["cantidadProducto"];
        switch($accion){
            case "actualizar":
                if(is_numeric($cantidad)){
                    $carritoControlador->modificarCantidadCompra($producto,$cantidad);
                }
                break;
            case "borrar":
                unset($_SESSION["carrito"][$producto]);
                break;
        }
    }
    $carritoProductos = $carritoControlador->setCarritoCompra();
    if($carritoProductos == false){
        $carritoProductos = array();
    }
?>

<?php if(isset($_SESSION["rol"])== false){ ?>
        <div class="alertNoRegister">Por favor, para realizar las compras usted tiene que crearse o logearse en una cuenta.</div>
<?php } ?>
<section class="container-carrito">
    <?php if(isset($_SESSION["rol"])){ ?>
        <table class="carrito-table">
            <thead class="table-thead">
                <tr>
                    <th>Producto</th>
                    <th>Vista</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-tbody">
                <?php foreach($carritoProductos as $producto){?>
                    <form action="Carrito.php" method="POST">
                        <tr class="table-fila">
                            <td><?php echo $producto["nombre"];?></td>
                            <td>
                                <img class="imagen-table" src="public/img/imgProductos/<?php echo $producto['imagen'];?>" alt="">
                            </td>
                            <td>$ <?php echo $producto["precio"];?></td>
                            <td>
                                <input type="number" name="cantidadProducto" id="" value="<?php echo$producto['cantidad'];?>">
                            </td>
                            <td>$ <?php echo $producto["total"];?></td>
                            <td>
                                <input type="hidden" name="idProducto" value="<?php echo $producto["idProducto"];?>">
                                <button type="submit" class="btn-actualizar" name="accion" value="actualizar">Actualizar</button>
                                <button type="submit" class="btn-borrar" name="accion" value="borrar">Borrar</button>
                            </td>
                        </tr>
                    </form>
                <?php } ?>
            </tbody>
        </table>
        <button id="btn-comprarCarrito">Comprar</button>
    <?php }?>
</section>



<?php  include("templates/pie.php"); ?>