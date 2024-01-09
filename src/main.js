
const listaCompra = document.getElementById("listaCompraCarrito");
const cantidadCarrito= document.querySelector(".carrito-count");

// botones
const btnAddProducto= document.querySelectorAll(".btn-addProducto");
const btnComprarCarrito= document.getElementById("btn-comprarCarrito")

// EVENTOS
btnAddProducto.forEach(btnProduct => {
    btnProduct.addEventListener("click",(e)=>{
        agregarProductoListaCompra(e.target.value)
    })
});
if(btnComprarCarrito){
    btnComprarCarrito.addEventListener("click",()=>{
        comprarProductosCarrito()
    })
}


function agregarListaHtml(data){
    listaCompra.innerHTML =""
    data.forEach(product => {
        listaCompra.innerHTML +=`
            <li class="listaCompra-producto">
                <img src="public/img/imgProductos/${product.imagen}" alt="">
                <div>
                    <h3>${product.nombre}</h3>
                    <h3>$ ${product.total}</h3>
                </div>
            </li>`
    });
    cantidadCarrito.innerText = data.length
}
function obtenerListaCompra(){
    const url = "http://localhost/TiendaOnline/admin/api/api_carrito.php?accion=mostrar"
    fetch(url)
    .then(res=>res.json())
    .then(data=>{
        agregarListaHtml(data)
    })
}
function agregarProductoListaCompra(id){
    
    const url = "http://localhost/TiendaOnline/admin/api/api_carrito.php?accion=agregar&idProducto="+id
    fetch(url)
    .then(res=>res.json())
    .then(data=>{
        // en caso de error
        if(data.status!=200){
            console.log("error en la peticion")
        }else{
            obtenerListaCompra()
        }
    })
}
function comprarProductosCarrito(){
    const url = "http://localhost/TiendaOnline/admin/api/api_carrito.php?accion=comprar"
    console.log("llego")
    fetch(url)
    .then(res=>res.json())
    .then(data=>{
        // en caso de error
        console.log(data)
        if(data.status==400){
            console.log("formi")
            window.location.assign("RealizarPedido.php")
        }else if(data.status==404){
            console.log("error en la peticion")
        }else if(data.status==403){
            console.log("error en el carrito")
        }else if(data.status==200){
            console.log(data)
            window.location.assign("Productos.php")
        }
    })
}






obtenerListaCompra()