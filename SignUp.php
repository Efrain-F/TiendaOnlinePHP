<?php
include("./admin/controllers/SessionController.php")
?>
<?php
    $errorSession = false;
    if($_POST) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        $contrasena = $_POST["contrasena"];

        if($email == "" or $contrasena == "" or $nombre == "" or $apellido == "" or $telefono == "" ){
            $errorSession = true;
        }else{
            // crear o comprobar si el usuario es correcto
            $validate = $sessionController->CreateSession($nombre,$apellido,$telefono,$email,$contrasena);
            $validate == false ? $errorSession = true:null;
        }

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="stylesheet" href="./public/style/session.css">

</head>
<body>
    <section class="container-session">
        <article class="session-info">
            <h1>Tienda Online</h1>
            <p>Crea una Cunta, para facilitar los formularios de compra.</p>
        </article>
        <section class="session-form">
            <?php
                if($errorSession){
                    echo "error en la session";
                }
            ?>
            <form action="SignUp.php" method="POST" class="form-inputSession">
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre">
                </div>
                <div>
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email">
                </div>
                <div>
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono">
                </div>
                <div>
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena">
                </div>
                <button type="submit">Crear Cuenta</button>
                <a href="Login.php">Login</a>
            </form>
        </section>
    </section>
</body>
</html>