<?php
    session_start();
    require_once 'Operaciones.php';
    require_once 'sanitize.php';

    $streamBD = mysql_connect('localhost', 'root', 'eti11$$$');

    if(!$streamBD)
    {
        die('No pudo conectarse: ' . mysql_error());
    }

print <<< EOC
        <table style="table-layout: fixed; width: 800px">
            <thead>
                <tr>
                    <th>Asunto</th>
                    <th>Resumen</th>
                    <th>Fecha Ingreso</th>
                    <th>Secretaría Reponsable</th>
                    <th>Estatus</th>
                </tr>
            </thead>
EOC;

    try {

        $bufferEmpRFC = $_SESSION['RFC'];

        $auxIdDocBox = 0;

        $baseseleccionada = mysql_select_db('sntsep5_internaldocbox', $streamBD) or die('No se pudo conectar a la base de Tramites');

        $resultadoNumEmp = mysql_query("SELECT id_trabajador from empleados where filiacion = '$bufferEmpRFC'");

        $numeroRegNumEmp = mysql_num_rows($resultadoNumEmp);

        if($numeroRegNumEmp > 0) {
            while($registro = mysql_fetch_array($resultadoNumEmp)) {
                $auxIdDocBox = $registro['id_trabajador'];
            }
        } else {
            $auxIdDocBox = 0;
        }

        if($auxIdDocBox > 0) {
            $resultado = mysql_query("SELECT reso.ResumenOficialia, info.Resumen_Gral ,info.fecha_recepcion, secre.secretaria, info.estatus from informacion info join secretarias secre on info.id_secretaria = secre.Id_Secretaria join resumenoficialia reso on info.Id_ResOficialia = reso.Id_ResOficialia where info.id_trabajador = 6655");

            $numeroRegistro = mysql_num_rows($resultado);
               
            if($numeroRegistro > 0) {
                echo '<tbody>';
                while($registro = mysql_fetch_assoc($resultado)) {
                    echo '<tr>';
                    echo '<td style="font-size: 12px">' . $registro['ResumenOficialia'] . '</td>';
                    echo '<td><div style="font-size: 13px; overflow: auto;">' . $registro['Resumen_Gral'] . '</div></td>';
                    echo '<td style="text-align:center">' . $registro['fecha_recepcion'] . '</td>';
                    echo '<td style="font-size: 12px">' . $registro['secretaria'] . '</td>';
                    
                    if($registro['estatus'] ==  'PENDIENTE') {
                        $estatusBuffer = 'EN PROCESO';
                    } else {
                        $estatusBuffer = $registro['estatus'];
                    }
                    echo '<td style="text-align:center; font-size: 12px">' . $estatusBuffer . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
            } else {
                echo 'nothing here';
            }
        } else {
            echo 'no se pudo recuperar nada';
        }
    } catch (Exception $e) {
        mysql_close($streamBD);
        throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
    }

    mysql_close($streamBD);

    echo '</table>';
?>
