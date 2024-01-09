<?php

    require_once dirname( __DIR__ )."/db/conexion.php";
    class VentasController{
        
        // valida si el usuario es un administrador
        public function ValidateAdmin(){
            if(isset($_SESSION["usuario"]) and isset($_SESSION["rol"])){
                $rol = $_SESSION["rol"];
                if($rol =="administrador"){
                    return true;
                }else{return false;}
            }else{
                return false;
            }
        }
        // FUNCIONES DE ADMINISTRADOR
        public function VerUltimasVentas(){
            $queryVentas = "SELECT i.*, u.nombre, u.apellido, u.email FROM info_venta i INNER JOIN usuarios u ON u.id = i.idUser ORDER BY i.id DESC LIMIT 10;";
            $ultimasVentas = $GLOBALS["NEWCONEXION"]->consultar($queryVentas);
            for($i = 0;$i < count($ultimasVentas);$i ++){
                $idInfoVenta = $ultimasVentas[$i]["id"];
                $infoVentas = "SELECT SUM(v.precio) AS 'precioTotal', COUNT(v.idProducto) AS 'NumDePedidos' FROM ventas v INNER JOIN info_venta i ON v.idInfoVenta = i.id WHERE v.idInfoVenta = $idInfoVenta GROUP BY v.idInfoVenta;";
                $infoventa = $GLOBALS["NEWCONEXION"]->consultar($infoVentas);
                $ultimasVentas[$i]["infoVenta"] = $infoventa;
            }
            return $ultimasVentas;
        }
        public function VerTodasVentas(){
            $queryVentas = "SELECT i.*, u.nombre, u.apellido, u.email FROM info_venta i INNER JOIN usuarios u ON u.id = i.idUser ORDER BY i.id DESC;";
            $ultimasVentas = $GLOBALS["NEWCONEXION"]->consultar($queryVentas);
            for($i = 0;$i < count($ultimasVentas);$i ++){
                $idInfoVenta = $ultimasVentas[$i]["id"];
                $infoVentas = "SELECT SUM(v.precio) AS 'precioTotal', COUNT(v.idProducto) AS 'NumDePedidos' FROM ventas v INNER JOIN info_venta i ON v.idInfoVenta = i.id WHERE v.idInfoVenta = $idInfoVenta GROUP BY v.idInfoVenta;";
                $infoventa = $GLOBALS["NEWCONEXION"]->consultar($infoVentas);
                $ultimasVentas[$i]["infoVenta"] = $infoventa;
            }
            return $ultimasVentas;
        }
        
        public function VerUsuarios(){
            $queryUsuarios = "SELECT nombre,apellido,email,telefono FROM usuarios;";
            $usuarios = $GLOBALS["NEWCONEXION"]->consultar($queryUsuarios);
            return $usuarios;
        }
        public function VerPedidosDeVenta($idInfoVenta){
            $queryPedidos = "SELECT v.cantidad ,v.precio AS 'total', p.nombre,p.imagen,p.precio FROM ventas v INNER JOIN productos p ON v.idProducto = p.id WHERE idInfoVenta = $idInfoVenta;";
            $pedidos = $GLOBALS["NEWCONEXION"]->consultar($queryPedidos);
            return $pedidos;
        }
        public function VerUserDeVenta($idInfoVenta){
            $queryPedidos = "SELECT i.fechaPeticion ,u.nombre,u.apellido,u.telefono, u.email FROM info_venta i INNER JOIN usuarios u ON i.idUser = u.id WHERE i.id = $idInfoVenta;";
            $pedidos = $GLOBALS["NEWCONEXION"]->consultar($queryPedidos);
            return $pedidos[0];
        }
        public function CancelarVenta($idInfoVenta){
            $queryPedidos = "DELETE FROM info_venta WHERE id = $idInfoVenta;";
            $GLOBALS["NEWCONEXION"]->ejecutarPeticion($queryPedidos);
            return true;
        }
        
        
    }

?>