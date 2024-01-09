<?php  include("templates/cabecera.php"); ?>
<?php
    require "./admin/controllers/VentasController.php";
    $error = false;
    $ventasController = new VentasController;
    $ventas=array();
    if($ventasController->ValidateAdmin()){
        if($_POST){
            $ventas = $ventasController->VerTodasVentas();
        }else{
            $ventas = $ventasController->VerUltimasVentas();
        }
    }else{$error = true;}
?>
<?php if($error){?>
    <?php  include("templates/noAccess.php"); ?>
<?php } else{?>
    <section class="container-pedidos">
        <table class="carrito-table">
            <thead class="table-thead">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>N°Pedidos</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody class="table-tbody">
                <?php foreach($ventas as $venta){ ?>
                    <br>
                    <br>
                    <tr class="table-fila">
                        <td><?php echo $venta["id"];?></td>
                        <td><?php echo $venta["nombre"]." ".$venta["apellido"];?></td>
                        <td><?php echo $venta["email"];?></td>
                        <td><?php echo $venta["infoVenta"][0]["NumDePedidos"];?></td>
                        <td>$ <?php echo $venta["infoVenta"][0]["precioTotal"];?></td>
                        <td><?php echo $venta["fechaPeticion"];?></td>
                        <td>
                            <form action="InfoPedido.php" method="get">
                                <input type="hidden" name="idVenta" value="<?php echo $venta['id'];?>">
                                <button type="submit">
                                    <i class='bx bxs-show bx-md' style='color:#b1b1b1'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <form action="PanelPedidos.php" method="POST">
            <button type="submit" name="verTodo" value="1" class="verTodo">Ver Todos</button>
        </form>
    </section>
<?php }?>
<?php  include("templates/pie.php"); ?>
