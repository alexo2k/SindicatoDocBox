<?php
    session_start();
    require_once 'Operaciones.php';
    require_once 'sanitize.php';
    $bufferOperaciones = new Operaciones();
    $AcumuladoAportaciones = number_format($bufferOperaciones->recuperaAportacion($_SESSION['idEmpleado']),2);
    
    $ApPaterno = ucfirst(strtolower($_SESSION['ApPaterno']));
    $ApMaterno = ucfirst(strtolower($_SESSION['ApMaterno']));
    $Nombre = capitalizaNombre($_SESSION['Nombre']);
    
    $_SESSION['timeOut'] = time(); 
    
echo <<< _END
   <table>
       <thead>
            <tr>
                <th>Apellidos</th>
                <th>Nombre</th>
                <th>Acumulado de Aportacion</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>$ApPaterno $ApMaterno</td>
                <td>$Nombre</td>
                <td>\$$AcumuladoAportaciones</td>
            </tr>
        </tbody>
    </table>
_END;
?>

