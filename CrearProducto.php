<?php  include("templates/cabecera.php"); ?>
<?php
    require "./admin/controllers/VentasController.php";
    $ventasController = new VentasController;
    
    // usaremos $productosController
    require("./admin/controllers/ProductosController.php");
    $Estados = $productosController->EstadosProducto();
    $Categorias = $productosController->CategoriasProducto();
    $error=false;
    if($ventasController->ValidateAdmin()){
        if($_POST){
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $precioTxt = $_POST["precio"];
            
            
            $categoria = $_POST["categoria"];
            $estado = $_POST["estado"];
            
            // nueva imagen
            $tmp = $_FILES["txtImagen"]["tmp_name"];
            $type = $_FILES["txtImagen"]["type"];
            $imagenName = $_FILES["txtImagen"]["name"];
            $error = $_FILES["txtImagen"]["error"];
            
            // revisar precio 
            $precio = floatval($precioTxt);

            $precio<=0?$error=true:NULL;
            if($error){
                header("location:PanelProductos.php");
            }else if($type == "image/jpeg" || $type == "image/png"){
                $newImageUrl = "public/img/imgProductos/$imagenName";
                move_uploaded_file($tmp,$newImageUrl);
                $productosController->CreateProducto($nombre,$imagenName,$precio,$descripcion,$estado,$categoria);
                header("location:PanelProductos.php");
            }
        }
    }else{$error = true;}
    
?>
<?php if($error){?>
    <?php  include("templates/noAccess.php"); ?>
<?php } else{?>
    <section class="container-pedidos">
    <form action="CrearProducto.php" method="post" enctype="multipart/form-data" class="form-infoProducto">
            <div>
                <label for="">Nombre</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label for="">Vista</label>
                <input type="file" name="txtImagen" id="txtImagen" placeholder="ID" required>
            </div>
            <div>
                <label for="">Descripcion</label>
<textarea name="descripcion" id="" cols="30" rows="10" required></textarea>
            </div>
            <div>
                <label for="">Precio</label>
                <input type="text" name="precio" required>
            </div>
            <div>
                <label for="categoria">Categorias</label>
                <select name="categoria" id="" >
                        <?php foreach($Categorias as $categ) { ?>
                            <option value="<?php echo $categ['id']; ?>"><?php echo $categ['nombreCategoria']; ?></option>
                        <?php } ?>
                </select>
            </div>
            <div>
                <label for="estado">Estados</label>
                <select name="estado" id="">
                        <?php foreach($Estados as $estad) { ?>
                            <option  value="<?php echo $estad['id']; ?>"><?php echo $estad["nombreEstado"]; ?></option>
                        <?php } ?>
                </select>
            </div>
            
            <div class="form-acciones-producto">
                <button type="submit" style="background-color:rgb(192, 241, 159)">Crear</button>
            </div>
        </form>
    </section>
<?php }?>
<?php  include("templates/pie.php"); ?>
