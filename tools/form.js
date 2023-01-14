// Este documento es para poder comprobar si el usuario ha elegido el tipo predeterminado de votación o no.
var i = 2;
function formulario(choice){
    if (choice == "normal"){
        // Cuando eligen normal no hacemos nada.
        document.getElementById("opciones").style.display = "none";
    }
    if (choice == "per"){
        // Cuando elige el multi opción.
        document.getElementById("opciones").style.display = "inline";
    }
}

const input = document.querySelector(".opciones")

function add(){
    var form = document.getElementById("ops");
    var op = document.createElement("input");
    op.setAttribute("type", "text");
    op.setAttribute("name", "op" + (i + 1));
    op.setAttribute("placeholder", "Opción");
    form.appendChild(op);
    i++;
    var num = document.getElementById("num");
    num.setAttribute("value", i);
}