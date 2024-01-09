
<?php  include("templates/cabecera.php"); ?>

<?php
    require "./admin/controllers/VentasController.php";
    $ventasController = new VentasController;
    $pedidos = array();
    $userInfo = array();
    $idVenta = NULL;
    $ERROR = false;
    if($_GET){
        if($ventasController->ValidateAdmin()){
            $idVenta = $_GET["idVenta"];
            $pedidos = $ventasController->VerPedidosDeVenta($idVenta);
            $userInfo = $ventasController->VerUserDeVenta($idVenta);
        }else{
            $ERROR = true;
        }
    }
    if($_POST){
        if($ventasController->ValidateAdmin()){
            $idVenta = $_POST["idVenta"];
            if($idVenta != NULL){
                $ventasController->CancelarVenta($idVenta);
                header("location:PanelPedidos.php");
            }else{
                $ERROR = true;
            }
        }else{
            $ERROR = true;
        }
    }
    $precioTotalFinal = 0;
?>

<?php if($ERROR){?>
    <?php  include("templates/noAccess.php"); ?>
<?php } else{?>
    <section class="container-pedidos">
        <?php if($ERROR == false){?>
            <div>
                <h2>Informacion de la Orden</h2>
                <div class="pedido-info">
                    <div>
                        <h3>Nombres</h3>
                        <p><?php echo $userInfo["nombre"]; ?></p>
                    </div>
                    <div>
                        <h3>Apellido</h3>
                        <p><?php echo $userInfo["apellido"]; ?></p>
                    </div>
                    <div>
                        <h3>Email</h3>
                        <p><?php echo $userInfo["email"]; ?></p>
                    </div>
                    <div>
                        <h3>Telefono</h3>
                        <p><?php echo $userInfo["telefono"]; ?></p>
                    </div>
                    <div>
                        <h3>Fecha</h3>
                        <p><?php echo $userInfo["fechaPeticion"]; ?></p>
                    </div>
                </div>
            </div>
            <div>
                <h3>Productos Comprado</h3>
                <table class="carrito-table">
                    <thead class="table-thead">
                        <tr>
                            <th>Producto</th>
                            <th>Vista</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <?php foreach ($pedidos as $pedido){?>
                            <?php $precioTotalFinal +=  $pedido["total"];?>
                            <tr class="table-fila">
                                <td><?php echo $pedido["nombre"]; ?></td>
                                <td><?php echo $pedido["imagen"]; ?></td>
                                <td>$ <?php echo $pedido["precio"]; ?></td>
                                <td><?php echo $pedido["cantidad"]; ?></td>
                                <td>$ <?php echo $pedido["total"]; ?></td>
                            </tr>
                        <?php }?>
                        <tr class="table-fila">
                                <td colspan="4" class="total-precio">TOTAL:</td>
                                <td>$ <?php echo $precioTotalFinal;?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form action="" method="POST">
                <button type="submit" name="idVenta" value="<?php echo $idVenta;?>" class="pedido-cancelar">Cancelar Pedido</button>
                <a href="PanelPedidos.php" class="regresar">Regresar</a>
            </form>
        <?php }else{?>
            <?php  include("templates/noAccess.php"); ?>
        <?php }?>
    </section>
<?php }?>


<?php  include("templates/pie.php"); ?>