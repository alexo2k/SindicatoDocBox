function recuperaAcumulado() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById('divTotal').innerHTML = xmlhttp.responseText;
        }
    };

    xmlhttp.open("GET", "lib/ObtenerAcumulado.php");
    xmlhttp.send();

}

function recuperaAdeudo() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById('divTotal').innerHTML = xmlhttp.responseText;
        }
    };

    xmlhttp.open("GET", "lib/ObtenerAdeudo.php");
    xmlhttp.send();

}

function recuperaTramites() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById('divTotal').innerHTML = xmlhttp.responseText;
        }
    };

    xmlhttp.open("GET", "lib/ObtenerTramites.php");
    xmlhttp.send();
}

function cerrarSesion() {
    document.getElementById('divTotal').innerHTML = "Cerrando Sesión";
    window.location.href = "ConsultaAportaciones.php?salir=true";
}