<?php
include("./admin/controllers/SessionController.php")
?>
<?php
    session_start();
    $errorSession = false;
    if($_POST) {
        if(isset($_POST["cerrar"])){
            session_destroy();
        }else{
            $email = $_POST["email"];
            $contrasena = $_POST["contrasena"];
    
            if($email == "" or $contrasena == ""){
                $errorSession = true;
            }else{
                // realizamos la respectiva validacion
                $validate = $sessionController->ValidarSession($email,$contrasena);
                // el controlador puede retornar false si hubo un error con el usuario
                $validate == false ? $errorSession = true:null;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./public/style/session.css">
</head>
<body>

    <section class="container-session">
        <article class="session-info">
            <h1>Tienda Online</h1>
            <p>Inicia sesion, para entrar a tu cuenta y facilitar los formularios de compra.</p>
        </article>
        <section class="session-form">
            <?php
                if($errorSession){
                    echo "error en la session";
                }
            ?>
            <form action="Login.php" method="POST" class="form-inputSession">
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email">
                </div>
                <div>
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena">
                </div>

                <button type="submit">Iniciar Session</button>
                <a href="SignUp.php">SignUp</a>

            </form>
        </section>
    </section>
    
</body>
</html>