

<?php
    require_once dirname( __DIR__ )."/db/conexion.php";

    class SessionController{
        public function ValidarSession($email,$contrasena){
            $consultaHash = "SELECT contrasena,id FROM usuarios WHERE email = '$email';";
            $user = $GLOBALS["NEWCONEXION"]->consultar($consultaHash);
            if(count($user)>0){
                $hash = $user[0]["contrasena"];
                if(password_verify($contrasena,$hash)){
                    $_SESSION["usuario"] = $user[0]["id"];
                    $_SESSION["rol"] = "cliente";
                    $_SESSION["carrito"] = NULL;
                    header("location:index.php");
                }
            }else{
                // este modo de imcriptacion, se que no es la mas segura pero por falta de tiempo no pude integrar uno mas seguro
                $contrasenaHash = md5($contrasena);
                $consultaHashAdmin = "SELECT contrasena,id FROM administradores WHERE email = '$email' AND contrasena = '$contrasenaHash';";
                $administrador = $GLOBALS["NEWCONEXION"]->consultar($consultaHashAdmin);
                if(count($administrador)>0){
                    $_SESSION["usuario"] = $administrador[0]["id"];
                    $_SESSION["rol"] = "administrador";
                    $_SESSION["carrito"] = NULL;
                    header("location:index.php");
                }else{
                    return false;
                }
            }
        }
        public function CreateSession($nombre,$apellido,$telefono,$email,$contrasena){
            // creamos un hash para incriptar la contraseña en la db
            $hash = password_hash($contrasena,PASSWORD_DEFAULT,["cost"=>13]);
            // debemos validar que no hay otros usuario con el mismo correo
            $validateSQL = "SELECT email FROM usuarios WHERE email = '$email';";
            $emailValidate = $GLOBALS["NEWCONEXION"]->consultar($validateSQL);
            if(count($emailValidate)>0){
                return false;
            }else{
                // creamos al usuario
                $createSQL = "INSERT INTO usuarios (nombre,apellido,email,telefono,contrasena) VALUES ('$nombre','$apellido','$email','$telefono','$hash');";
                $userId = $GLOBALS["NEWCONEXION"]->ejecutarPeticion($createSQL);
                session_start();
                $_SESSION["usuario"] = $userId;
                $_SESSION["rol"] = "cliente";
                $_SESSION["carrito"] = NULL;
                header("location:index.php");
            }
        }
        public function InfoSession($idUser){
            $userInfoSQL = "SELECT nombre,apellido,email,telefono FROM usuarios WHERE id = $idUser;";
            $userInfo = $GLOBALS["NEWCONEXION"]->consultar($userInfoSQL);
            if(count($userInfo)>0){
                return $userInfo;
            }else{
                $adminInfoSQL = "SELECT nombre,email FROM administradores WHERE id = $idUser;";
                $adminInfo = $GLOBALS["NEWCONEXION"]->consultar($adminInfoSQL);
                return $adminInfo;
            }
        }
        public function nameUserSession($idUser){
            $userInfoSQL = "SELECT nombre FROM usuarios WHERE id = $idUser;";
            $userInfo = $GLOBALS["NEWCONEXION"]->consultar($userInfoSQL);
            return $userInfo;
        }
        public function cerrarSession(){
            session_destroy();
        }
    }

    $sessionController = new SessionController;

?>