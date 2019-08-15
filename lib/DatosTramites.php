<?php 
    $noEmpAux = 0;
    $auxfInicio = '';
    $auxfFinal = '';

    if(isset($_POST['valor'])) {
        $noEmpAux = $_POST['valor'];
        $auxfInicio = $_POST['fInicio'];
        $auxfFinal = $_POST['fFinal'];
    } else {
        die('No se encontró');
    }

    $servidor = 'localhost';
    $usuario = 'root';
    $contrasena = 'eti11$$$';
    $baseDocBox = 'sntsep5_internaldocbox';

    $result_array = array();

    $streamBD = mysql_connect($servidor, $usuario, $contrasena);

    if(!$streamBD) 
    {
        die("No pudo conectarse: " . mysql_error());
    }

    try {
        $baseseleccionada = mysql_select_db($baseDocBox, $streamBD) or die('No se pudo conectar a la base DocBox');
        
        $resultado = mysql_query("SELECT sec.secretaria, info.Fecha_Recepcion, info.Control_Interno, info.Numero_Oficio, info.Oficio_Referencia, info.Medio_Entrega, info.Procedencia, info.NombreEscrito, reso.ResumenOficialia, info.Asunto, info.Control_Seguridad, info.Estatus, info.Resumen_Gral FROM informacion info JOIN secretarias sec ON info.Id_Secretaria = sec.Id_Secretaria JOIN resumenoficialia reso ON info.Id_ResOficialia = reso.Id_ResOficialia WHERE sec.Id_Secretaria = $noEmpAux AND info.Fecha_Recepcion > '$auxfInicio' AND info.Fecha_Recepcion < '$auxfFinal'");

        $numeroRegistro = mysql_num_rows($resultado);

        if($numeroRegistro > 0) 
        {
            while($registro = mysql_fetch_assoc($resultado)) 
            {
                array_push($result_array, $registro);
            }
        } 

        echo json_encode($result_array);

        mysql_close($streamBD);

    } catch(Exception $ex) 
    {
        mysql_close($streamBD);
    }
?>