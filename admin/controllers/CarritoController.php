<?php
    require_once dirname( __DIR__ )."/db/conexion.php";
    //$conexion = new Conexion;

    class CarritoCompra{
        public function agregarCompra($idProducto,$cantidad){
            try{ // false = error en la peticion, true= todo salido bien
                if(isset($_SESSION["carrito"][$idProducto])){return false;} // verificar si ya existe el producto
                $Query = "SELECT precio FROM productos WHERE id = $idProducto";
                $precio = $GLOBALS["NEWCONEXION"]->consultar($Query);
                $producto = array(
                    "idProducto"=>$idProducto,
                    "cantidad"=>$cantidad,
                    "total"=>$precio[0]["precio"]*$cantidad
                );
                // agregar la compra al carrito
                $_SESSION["carrito"][$idProducto] = $producto;
                return true;
            }
            catch (Exception $e){
                return false;
            }
        }
        public function setCarritoCompra(){
            try{
                $comprasCarr = array();
                $listaCompra = $_SESSION["carrito"];
                // si no hay nada en el carrito
                if($listaCompra == NULL or count($listaCompra) <= 0){
                    return false;
                }
                foreach($listaCompra as $compra){
                    $id = $compra['idProducto'];
                    $Query = "SELECT precio,nombre,imagen FROM productos WHERE id = $id;";
                    $compras= $GLOBALS["NEWCONEXION"]->consultar($Query);
                    $productoCompra = array(
                        "nombre"=>$compras[0]["nombre"],
                        "imagen"=>$compras[0]["imagen"],
                        "precio"=>$compras[0]["precio"],
                        "cantidad"=>$compra["cantidad"],
                        "total"=>$compra["total"],
                        "idProducto"=>$compra["idProducto"]
                    );
                    $comprasCarr[]=$productoCompra;
                }
                return $comprasCarr;
            }catch(Exception $e){
                return false;
            }
        }
        public function modificarCantidadCompra($producto,$cantidad){
            if($cantidad>0){
                $cantidadAhora = $_SESSION["carrito"][$producto]["cantidad"];
                $precioTotalAhora = $_SESSION["carrito"][$producto]["total"];
                $precioUnidad = $precioTotalAhora/$cantidadAhora;
                $_SESSION["carrito"][$producto]["cantidad"] = $cantidad;
                $_SESSION["carrito"][$producto]["total"] = $precioUnidad*$cantidad;
            }else{
                return false;
            }
        }
        public function borrarCarritoCompra(){
            $_SESSION["carrito"] = array();
        }
        public function realizarCompraSinDatos(){
            if($_SESSION["usuario"]!=NULL and $_SESSION["usuario"]!=""){
                $idUser = $_SESSION["usuario"];
                $fechaPeticion = date('m-d-Y h:i:s a', time());
                $estadoAtencion = "No atendido";
                $QueryInfoVenta = "INSERT INTO info_venta (idUser,fechaPeticion,estado) VALUES ($idUser,'$fechaPeticion','$estadoAtencion');";
                $IdInfoVenta = $GLOBALS["NEWCONEXION"]->ejecutarPeticion($QueryInfoVenta); // obtenemos el id de la informacion de la venta
                $listaCarritoCompra = $_SESSION["carrito"];
                foreach($listaCarritoCompra as $compra){
                    $idProducto = $compra["idProducto"];
                    $cantidad = $compra["cantidad"];
                    $totalPrecio = $compra["total"];
                    $QueryVenta = "INSERT INTO ventas (idInfoVenta,idProducto,cantidad,precio) VALUES ($IdInfoVenta,$idProducto,$cantidad,$totalPrecio);";
                    $GLOBALS["NEWCONEXION"]->ejecutarPeticion($QueryVenta);
                }
                $_SESSION["carrito"]= array();
                return true;
            }else{
                return false;
            }
        }
        public function realizarCompraConDatos($DataUser){
            
        }
    }

?>




