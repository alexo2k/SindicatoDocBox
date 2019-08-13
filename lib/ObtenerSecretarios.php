<?php
    session_start();
    require_once 'Operaciones.php';
    require_once 'sanitize.php';
?>
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
    <button id="doSome">Do something</button>
</div>
