<?php

    class Conexion{

        private $servidor = "localhost";
        private $usuario = "root";
        private $contrasena = "";
        private $conexion;

        private $error = false;
        // funcion para realizar la conexion
        public function __construct(){
            try{
                $this->conexion = new PDO("mysql:host=$this->servidor;dbname=tiendaonline",$this->usuario,$this->contrasena);
                
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $error){
                echo "erro de conexion";
                $this->error = $error;
            }
        }

        // funcion para ejecutar peticiones de crear o eliminar 
        public function ejecutarPeticion($sql){
            $this->conexion->exec($sql);
            return $this->conexion->lastInsertId();
        }
        // funciont para consultar y retornar datos de la peticion
        public function consultar($sql){
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll();
        }

    }
    $NEWCONEXION = new Conexion;
?>