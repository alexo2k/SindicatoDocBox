<?php
    session_start();
    require_once 'Operaciones.php';
    require_once 'sanitize.php';
    $bufferOperaciones = new Operaciones();
    
    $AcumuladoAdeudo = $bufferOperaciones->recuperaAdeudo($_SESSION['idEmpleado']);
    
    if($AcumuladoAdeudo['adeudo'] == 0){
        $AdeudoTotal = 'No existe adeudo';
        $AdeudoFecha = 'No aplica';
    } else {
        $AdeudoTotal = '$' . number_format($AcumuladoAdeudo['adeudo'],2);
        $AdeudoFecha = date_format(new DateTime($AcumuladoAdeudo['fechaAdeudo']),'d-m-Y');
    }
    
    $ApPaterno = ucfirst(strtolower($_SESSION['ApPaterno']));
    $ApMaterno = ucfirst(strtolower($_SESSION['ApMaterno']));
    $Nombre = capitalizaNombre($_SESSION['Nombre']);
    
    $_SESSION['timeOut'] = time(); 
    
echo <<< _END
   <table>
        <thead>
            <tr>
                <th>Apellidos</th>
                <th>Nombre(s)</th>
                <th>Adeudo Total</th>
                <th>Final del Adeudo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>$ApPaterno $ApMaterno</td>
                <td>$Nombre</td>
                <td>$AdeudoTotal</td>
                <td>$AdeudoFecha</td>
            </tr>
        </tbody>
    </table>

_END;
?>
