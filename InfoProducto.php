<?php  include("templates/cabecera.php"); ?>
<?php
    require "./admin/controllers/VentasController.php";
    $ventasController = new VentasController;
    
    // usaremos $productosController
    require("./admin/controllers/ProductosController.php");
    $error = false;
    $producto = array();
    
    $Estados = $productosController->EstadosProducto();
    $Categorias = $productosController->CategoriasProducto();

    if($ventasController->ValidateAdmin()){
        if($_POST){
            $accion = $_POST["accion"];
            $id = $_POST["idProducto"];
            if($accion == "actualizar"){
                $nombre = $_POST["nombre"];
                $descripcion = $_POST["descripcion"];
                $precioTxt = $_POST["precio"];
                $categoria = $_POST["categoria"];
                $estado = $_POST["estado"];
                $imagenActual = $_POST["imagenActual"]; // imagen que actualmente usa
                $precio = floatval($precioTxt);
                $precio<=0?$error=true:NULL;
                
                // nueva imagen
                $tmp = $_FILES["txtImagen"]["tmp_name"];
                $type = $_FILES["txtImagen"]["type"];
                $name = $_FILES["txtImagen"]["name"];
                $error = $_FILES["txtImagen"]["error"];
                if($error){
                    $productosController->UpdateProducto($id,$nombre,$imagenActual,$precio,$descripcion,$estado,$categoria);
                    header("location:PanelProductos.php");
                }else if($type == "image/jpeg" || $type == "image/png"){
                    $imageRemoveUrl = "public/img/imgProductos/$imagenActual";
                    //unlink($imageRemoveUrl); // eliminaremos la imagen actual para ahorrar espacio
                    $newImageUrl = "public/img/imgProductos/$name";
                    move_uploaded_file($tmp,$newImageUrl);
                    $productosController->UpdateProducto($id,$nombre,$name,$precio,$descripcion,$estado,$categoria);
                    header("location:PanelProductos.php");
                }
            }else if($accion =="eliminar"){
                $productosController->RemoveProducto($id);
                header("location:PanelProductos.php");
            }
        }
        if(isset($_GET["producto"])){
            $id = $_GET["producto"];
            $producto = $productosController->ProductoInfo($id);
        }
    }else{$error = true;}
    
?>
<?php if($error){?>
    <?php  include("templates/noAccess.php"); ?>
<?php } else{?>
    <section class="container-infoProducto">
        <form action="InfoProducto.php" method="post" enctype="multipart/form-data" class="form-infoProducto">
            <div>
                <label for="">Nombre</label>
                <input type="text" name="nombre" value="<?php echo $producto[0]["nombre"];?>">
            </div>
            <div>
                <label for="">Vista</label>
                <input type="file" name="txtImagen" id="txtImagen" placeholder="ID">
            </div>
            <div>
                <label for="">Descripcion</label>
                <textarea name="descripcion" id="" cols="30" rows="10">
<?php echo $producto[0]["descripcion"];?>
                </textarea>
            </div>
            <div>
                <label for="">Precio</label>
                <input type="text" name="precio" value="<?php echo $producto[0]["precio"];?>">
            </div>
            <div>
                <label for="categoria">Categorias</label>
                <select name="categoria" id="" >
                        <?php foreach($Categorias as $categ) { ?>
                            <option <?php if($producto[0]["nombreCategoria"]==$categ['nombreCategoria']){echo "selected";} ?>  value="<?php echo $categ['id']; ?>"><?php echo $categ["nombreCategoria"];?></option>
                        <?php } ?>
                </select>
            </div>
            <div>
                <label for="estado">Estados</label>
                <select name="estado" id="">
                        <?php foreach($Estados as $estad) { ?>
                            <option <?php if($producto[0]["nombreEstado"]==$estad['nombreEstado']){echo "selected";} ?>  value="<?php echo $estad['id']; ?>"><?php echo $estad["nombreEstado"];?></option>
                        <?php } ?>
                </select>
            </div>
            
            <div class="form-acciones-producto">
                <input type="hidden" name="imagenActual" value="<?php echo $producto[0]["imagen"];?>">
                <input type="hidden" name="idProducto" value="<?php echo $producto[0]["id"];?>">
                <button type="submit" name="accion" value="actualizar" style="background-color:rgb(192, 241, 159)">Actualizar</button>
                <button type="submit" name="accion" value="eliminar" style="background-color:rgb(244, 176, 176)">Eliminar</button>
            </div>
        </form>
    </section>
<?php }?>
<?php  include("templates/pie.php"); ?>
