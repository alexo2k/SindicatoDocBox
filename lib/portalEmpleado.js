$(document).ready(function() {

    var buffer = $('#idInterno').val();

    if (buffer == '0') {
        $("#btnSecretario").hide();
    }

    $('#btnAcumulado').click(function() {
        $("#divTotal").load("lib/ObtenerAcumulado.php");
    });

    $('#btnSecretario').click(function() {
        $('#divTotal').load("lib/ObtenerSecretarios.php", function() {
            $('#dtpInicio').datepicker();
            $('#dtpFin').datepicker();
            $('#doSome').click(function() {

            });
        });
    });

});

// $(document).on("click", "#doSome", function() {
//     alert("Its alive");
// });


function hazAlgo() {
    alert("algo");
}

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

function recuperaSecretarios() {
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

    xmlhttp.open("GET", "lib/ObtenerSecretarios.php");
    xmlhttp.send();
}

function cerrarSesion() {
    document.getElementById('divTotal').innerHTML = "Cerrando Sesión";
    window.location.href = "ConsultaAportaciones.php?salir=true";
}