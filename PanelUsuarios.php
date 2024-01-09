<?php  include("templates/cabecera.php"); ?>

<?php
    require "./admin/controllers/VentasController.php";

    $ventasController = new VentasController;
    $error = false;
    if($ventasController->ValidateAdmin()){
        $usuarios = $ventasController->VerUsuarios();
    }else{
        $error = true;
    }
?>
<?php if($error){?>
    <?php  include("templates/noAccess.php"); ?>
<?php }else{?>
    <section class="container-pedidos">
        <table class="carrito-table">
            <thead class="table-thead">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                </tr>
            </thead>
            <tbody class="table-tbody">
                <?php foreach($usuarios as $usuario){ ?>
                    <tr class="table-fila">
                        <td><?php echo $usuario["nombre"]." ".$usuario["apellido"];?></td>
                        <td><?php echo $usuario["email"];?></td>
                        <td><?php echo $usuario["telefono"];?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
<?php }?>

<?php  include("templates/pie.php"); ?>