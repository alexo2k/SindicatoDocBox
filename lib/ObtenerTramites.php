<?php
    session_start();
    require_once 'Operaciones.php';
    require_once 'sanitize.php';

    $streamBD = mysql_connect('localhost', 'root', 'eti11$$$');

    if(!$streamBD)
    {
        die('No pudo conectarse: ' . mysql_error());
    }

    echo '<table><thead><tr><th>Asunto</th><th>Fecha Ingreso</th><th>Secretaría Responsable</th><th>Estatus</th></tr></thead>';

    try {
        $baseseleccionada = mysql_select_db('sntsep5_internaldocbox', $streamBD) or die('No se pudo conectar a la base de Tramites');

        $resultado = mysql_query("SELECT info.asunto, info.fecha_recepcion, secre.secretaria, info.estatus from informacion info join secretarias secre on info.id_secretaria = secre.Id_Secretaria where info.id_trabajador = 9");

        $numeroRegistro = mysql_num_rows($resultado);
               
        if($numeroRegistro > 0) {
            echo '<tbody>';
            while($registro = mysql_fetch_assoc($resultado)) {
                echo '<tr>';
                echo '<td>' . $registro['asunto'] . '</td>';
                echo '<td>' . $registro['fecha_recepcion'] . '</td>';
                echo '<td>' . $registro['secretaria'] . '</td>';
                echo '<td>' . $registro['estatus'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
        } else {
            echo 'nothing here';
        }
    } catch (Exception $e) {
        mysql_close($streamBD);
        throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
    }

    mysql_close($streamBD);

    echo '</table>';

//     $bufferOperaciones = new Operaciones();
    
//     $tramitesActuales = $bufferOperaciones->recuperaTramites($_SESSION['idEmpleado']);

//     if($tramitesActuales != null) {
//         $asuntoTramite = $tramitesActuales['asunto'];
//         $fechaTramite = $tramitesActuales['fecha_recepcion'];
//         $secretariaTramite = $tramitesActuales['secretaria']; 
//         $estatusTramite = $tramitesActuales['estatus'];
//     }
    
//     $_SESSION['timeOut'] = time(); 
    
// echo <<<_END
//    <table>
//         <thead>
//             <tr>
//                 <th>Asunto</th>
//                 <th>Fecha Ingreso</th>
//                 <th>Secretaría Responsable</th>
//                 <th>Estatus</th>
//             </tr>
//         </thead>
//         <tbody>
//             <tr>
//                 <td>$asuntoTramite</td>
//                 <td>$fechaTramite</td>
//                 <td>$secretariaTramite</td>
//                 <td>$estatusTramite</td>
//             </tr>
//         </tbody>
//     </table>

// _END;
?>
