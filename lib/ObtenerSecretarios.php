<?php
    session_start();
    require_once 'Operaciones.php';
    require_once 'sanitize.php';
?>
<script>
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
</script>
<div>
    <h2>Reporte de trámites</h2>
</div>
<br/>
<div>
    <h3>Selecciona el periodo del reporte</h3>
</div>
<div>
    <input type="text" id="dtpInicio">
    <input type="text" id="dtpFin">
    <button type="button" id="btnRecuperaInfo">Buscar trámites</button>
</div>
<button type="button" id="btnExporta" onclick="exportTableToExcel('tblTest')">Exportar</button>
<div id="tablaDatos"></div>
<table id="tblTest" class="table table-bordered"></table>
