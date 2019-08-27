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
    <h2>Selecciona el periodo del reporte</h2>
</div>
<div>
<br/>
    <label for="dtpInicio" style="color:white; padding-left:30px">Fecha Inicial:</label>
    <input type="text" id="dtpInicio">
    <br/>
    <label for="dtpFin" style="color:white; padding-left:30px">Fecha Final:     </label>
    <input type="text" id="dtpFin" style="margin-left:8px">
    <br/><br>
    <button type="button" id="btnRecuperaInfo" class="centered submit">Buscar trámites</button>
</div>
<br/>
<!-- <button type="button" id="btnExporta" onclick="exportTableToExcel('tblTest')">Exportar</button> -->
<table id="tblTest" class="compact hover row-border stripe">
    <thead>
        <tr>
            <th>Secretaría</th>
            <th>Fecha recepción</th>
            <th style="display:none">Control interno</th>
            <th style="display:none">Número de oficio</th>
            <th style="display:none">Oficio de referencia</th>
            <th style="display:none">Medio de entrega</th>
            <th style="display:none">Procedencia</th>
            <th style="display:none">Nombre de escrito</th>
            <th>Resumen oficialia</th>
            <th style="display:none">Asunto</th>
            <th style="display:none">Control seguridad</th>
            <th style="display:none">Estatus</th>
            <th style="display:none">Resumen general</th>
        </tr>
    </thead>
    <tbody id="tblCuerpo"></tbody>
</table>
