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

            function pad(numb) {
                return (numb < 10 ? '0' : '') + numb;
            }

            function convertToDate(pDateValue) {

                var year = pad(pDateValue.getFullYear());
                var month = pad(pDateValue.getMonth() + 1);
                var day = pad(pDateValue.getDate());

                return year + "-" + month + "-" + day;
            }

            $('#dtpInicio').datepicker();
            $('#dtpFin').datepicker();

            $('#btnRecuperaInfo').click(function() {

                if ($('#dtpInicio').val() == '' || $('#dtpFin').val() == '') {
                    alert("Por favor selecciona un periodo válido.");
                } else {
                    var idSecretario = $("#idInterno").val();

                    var pFInicio = convertToDate($('#dtpInicio').datepicker('getDate'));
                    var pFFinal = convertToDate($('#dtpFin').datepicker('getDate'));

                    $.ajax({
                        method: "POST",
                        url: "lib/DatosTramites.php",
                        data: {
                            "valor": idSecretario,
                            "fInicio": pFInicio,
                            "fFinal": pFFinal
                        }
                    }).done(function(data) {
                        var result = $.parseJSON(data);
                        var string = '';

                        $.each(result, function(key, value) {
                            string += "<tr> <td>" + value['secretaria'] + "</td> <td> " + value['Fecha_Recepcion'] + "</td> <td style=\"display:none;\">" + value['Control_Interno'] + "</td> <td style=\"display:none;\">" + value['Numero_Oficio'] +
                                "</td> <td style=\"display:none;\">" + value['Oficio_Referencia'] + "</td> <td style=\"display:none;\">" + value['Medio_Entrega'] + "</td> <td style=\"display:none;\">" + value['Procedencia'] + "</td> <td style=\"display:none;\">" + value['NombreEscrito'] +
                                "</td> <td>" + value['ResumenOficialia'] + "</td> <td style=\"display:none;\">" + value['Asunto'] + "</td> <td style=\"display:none;\">" + value['Control_Seguridad'] + "</td> <td style=\"display:none;\">" + value['Estatus'] + "</td> <td style=\"display:none;\">" +
                                value['Resumen_Gral'] + "</td> </tr>";
                        });

                        $('#tblCuerpo').html(string);
                        $('#tblTest').DataTable({
                            dom: 'Bfrtip',
                            "scrollY": "400px",
                            "scrollCollapse": true,
                            "paging": false,
                            "searching": false,
                            buttons: [{
                                extend: 'excel',
                                text: 'Descargar reporte',
                                className: 'btnSindicato'
                            }],
                            language: {
                                infoEmpty: '0 solicitudes',
                                emptyTable: 'No se encontraron solicitudes'
                            }
                        });
                    });
                }
            });
        });
    });

    $('#btnAdeudo').click(function() {
        $('#divTotal').load("lib/ObtenerAdeudo.php");
    });

    $('#btnTramites').click(function() {
        $('#divTotal').load("lib/ObtenerTramites.php");
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

function exportTableToExcel(tableId, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableId);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    filename = filename ? filename + '.xls' : 'excel_data.xls';

    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        downloadLink.download = filename;

        downloadLink.click();
    }
}