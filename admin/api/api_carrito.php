

<?php
    require "../controllers/CarritoController.php";
    //$sdf = new CarritoCompra;
    session_start();
    
    // un objeto que pasaremos cuando ocurra un error
    $errorObjet = array(
        "status"=>404,
        "message"=>"Error"
    );

    if(isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch($accion){
            case "mostrar";
            mostrar();
            break;
            case "agregar";
            agregar();
            break;
            case "remover";
            remover();
            break;
            case "comprar";
            comprar();
            break;
        }
    }else{
        print_r(json_encode($errorObjet));
    }

    function mostrar(){
        $carritoControlador = new CarritoCompra();
        $lista = $carritoControlador->setCarritoCompra();
        if($lista == false){
            print_r(json_encode($errorObjet));
        }else{
            print_r(json_encode($lista));
        }
    }
    function agregar(){
        $errorObjet = array(
            "status"=>404,
            "message"=>"Error en la compra"
        );
        $carritoControlador = new CarritoCompra();
        if(isset($_GET["idProducto"])){
            $productoId = $_GET["idProducto"];
            $state = $carritoControlador->agregarCompra($productoId,1);
            if($state == false){
                print_r(json_encode($errorObjet));
            }else{
                $okObjet = array(
                    "status"=>200,
                    "message"=>"Se agrego nueva compra"
                );
                print_r(json_encode($okObjet));
            }
        }else{
            print_r(json_encode($errorObjet));
        }
    }
    function remover(){
        if(isset($_GET["idProducto"])){
            
        }else{

        }
    }
    function comprar(){
        $errorObjet = array(
            "status"=>404,
            "message"=>"Error en la compra del carrito"
        );
        try{
            $formularioObj = array(
                "status" =>400,
                "message" => "No esta logeado tiene que rellenar el formulario"
            );
            // verificar que compre algo
            if(count($_SESSION["carrito"])<=0){
                $errorObjet = array(
                    "status"=>403,
                    "message"=>"No tiene nada en el carrito"
                );
                print_r(json_encode($errorObjet));
            }else{
                // en caso de que este logeado no sera necesario el formulario y realizara la compra directo
                if(isset($_SESSION["usuario"])){
                    $carritoControlador = new CarritoCompra();
                    $isOk = $carritoControlador->realizarCompraSinDatos();
                    if($isOk == false){
                        $errorObjet = array(
                            "status"=>403,
                            "message"=>"No tiene nada en el carrito"
                        );
                        print_r(json_encode($errorObjet));
                    }else{
                        $okObjet = array(
                            "status"=>200,
                            "message"=>"Se agrego nueva compra",
                            "rol"=>$_SESSION["rol"],
                            "usuario"=>$_SESSION["usuario"]
                        );
                        print_r(json_encode($okObjet));
                    }
                }else{ // en caso contrario tendra que rellenar un formulario
                    print_r(json_encode($formularioObj));
                }
            }
        }catch(Exception $e){
            print_r(json_encode($errorObjet));
        }
    }
?>
