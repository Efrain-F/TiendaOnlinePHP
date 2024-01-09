<?php

    require_once "./admin/db/conexion.php";

    class ProductosController{
        public function AllProductos(){
            $Querysdf = "SELECT p.*,c.nombreCategoria,e.nombreEstado FROM productos p INNER JOIN categorias c on c.id = p.idCategoria INNER JOIN estado e on e.id = p.idEstado";
            $allProductos = $GLOBALS["NEWCONEXION"]->consultar($Querysdf);
            return $allProductos;
        }
        public function ProductoInfo($id){
            $productoSQL = "SELECT p.*,c.nombreCategoria,e.nombreEstado FROM productos p INNER JOIN categorias c on c.id = p.idCategoria INNER JOIN estado e on e.id = p.idEstado WHERE p.id = $id;";
            $producto = $GLOBALS["NEWCONEXION"]->consultar($productoSQL);
            return $producto;
        }

        // OPCIONES!!! DE FILTRADO (retornan las categorias o estados que existen)
        public function CategoriasProducto(){
            $Query = "SELECT * FROM categorias;";
            $categorias = $GLOBALS["NEWCONEXION"]->consultar($Query);
            return $categorias;
        }
        public function EstadosProducto(){
            $Query = "SELECT * FROM estado;";
            $estados = $GLOBALS["NEWCONEXION"]->consultar($Query);
            return $estados;
        }

        // FILTRADO DE PRODUCTOS (los parametros deben de ser id's)
        public function ProductoCategoria($categoria){
            $Query = "SELECT p.*,c.nombreCategoria,e.nombreEstado FROM productos p INNER JOIN categorias c on c.id = p.idCategoria INNER JOIN estado e on e.id = p.idEstado WHERE p.idCategoria = $categoria;";
            $productos = $GLOBALS["NEWCONEXION"]->consultar($Query);
            return $productos;
        }
        public function ProductoEstado($estado){
            $Query = "SELECT p.*,c.nombreCategoria,e.nombreEstado FROM productos p INNER JOIN estado e on e.id = p.idEstado INNER JOIN categorias c on c.id = p.idCategoria WHERE p.idEstado = $estado;";
            $productos = $GLOBALS["NEWCONEXION"]->consultar($Query);
            return $productos;
        }
        public function ProductoEstadoCategoria($estado,$categoria){
            $Query = "SELECT p.*,c.nombreCategoria,e.nombreEstado FROM productos p INNER JOIN categorias c on c.id = p.idCategoria INNER JOIN estado e on e.id = p.idEstado WHERE p.idEstado = $estado AND p.idCategoria = $categoria;";
            $productos = $GLOBALS["NEWCONEXION"]->consultar($Query);
            return $productos;
        }
        // FUNCIONES DE ADMINISTRADOR
        public function CreateProducto($nombre,$imagen,$precio,$descripcion,$estado,$categoria){
            $Query = "INSERT INTO productos (nombre,descripcion,imagen,precio,idCategoria,idEstado) VALUES ('$nombre','$descripvion','$imagen','$precio','$categoria','$estado');";
            $newProducto = $GLOBALS["NEWCONEXION"]->ejecutarPeticion($Query);
        }
        public function RemoveProducto($id){
            $Query = "DELETE FROM productos WHERE id=$id";
            $removeProducto = $GLOBALS["NEWCONEXION"]->ejecutarPeticion($Query);
        }
        public function UpdateProducto($id,$nombre,$imagen,$precio,$descripcion,$estado,$categoria){
            $Query = "UPDATE productos SET nombre = '$nombre',imagen='$imagen',precio=$precio,descripcion='$descripcion',idEstado=$estado,idCategoria=$categoria WHERE id = $id;";
            $UpdateProducto = $GLOBALS["NEWCONEXION"]->ejecutarPeticion($Query);
        }
    }

    $productosController = new ProductosController;
?>