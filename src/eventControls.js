
const btn_barrMenu = document.getElementById("btn-barrMenu")
const btn_carrList = document.getElementById("btn-carrList")


const barrMenu = document.querySelector(".navegacion")
const carrList = document.querySelector(".container-listaCompra")


let showBarrMenu = true;
btn_barrMenu.addEventListener("click",()=>{
    if(showBarrMenu){
        barrMenu.style.width = "260px"
        showBarrMenu = !showBarrMenu
    }else{
        barrMenu.style.width = "0px"
        showBarrMenu = !showBarrMenu
    }
})
let showCarrList = true;
btn_carrList.addEventListener("click",()=>{
    if(showCarrList){
        carrList.style.right = "0"
        showCarrList = !showCarrList
    }else{
        carrList.style.right = "-280px"
        showCarrList = !showCarrList
    }
})





