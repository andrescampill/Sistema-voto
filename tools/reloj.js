function reloj(){
    var Dia = new Date();
    var hora = Dia.getHours();
    var minutos = Dia.getMinutes();
    var segundos = Dia.getSeconds();

    if (segundos < 10){
        var segundos = '0' + segundos;
    }
    if (hora <= 9){
        var hora = '0' + hora;
    }
    if (minutos < 10){
        var minutos = '0' + minutos;
    }

    document.getElementById('hora').innerHTML =  hora + " : " + minutos + " : " + segundos;
}
setInterval(reloj, 500)