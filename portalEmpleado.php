<?php
    session_start();
    require_once 'lib/Operaciones.php';
    require_once 'lib/sanitize.php';
    require_once 'lib/PHPMailer/class.phpmailer.php';
    
    if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
        session_destroy();
        header('Location: ConsultaAportaciones.php');  
    }
    
    $_SESSION['timeOut'] = time();
    
    $auxOperaciones = new Operaciones();
    $informacion = $auxOperaciones->recuperaDatosPersonales($_SESSION['idEmpleado']);
    
    $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");

    if ($iphone || $android || $palmpre || $ipod || $berry == true) 
    { 
        $esMovil = TRUE;
    } else 
    {
        $esMovil = FALSE;
    }   
    
    $auxPrivacidad = $auxOperaciones->validaPrivacidad($_SESSION['idEmpleado']);   
    $ip = "0.0.0.0";
    $fechaActual = date('Y-m-d H:i:s');
    
    if($auxPrivacidad == 0 && !isset($_SESSION['PrivacidadAceptada'])) {  
        
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
           $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        elseif (isset($_SERVER['HTTP_VIA'])) {  
           $ip = $_SERVER['HTTP_VIA'];  
        }  
        elseif (isset($_SERVER['REMOTE_ADDR'])) {  
           $ip = $_SERVER['REMOTE_ADDR'];  
        }  
        else {  
           $ip = "unknown";  
        }  
        
        $resultadoCorreo = 'N'; 
        
        if($_SESSION['PrivacidadAceptada'] != 'true' && isset($_SESSION['idEmpleado'])) {
            
        $mail = new PHPMailer();
        
        $mail->IsSMTP();
        $mail->Host = 'vps2467.inmotionhosting.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alertas_privacidad@sntsepomex.org';
        $mail->Password = 'er4mDIxK7unT';
        $mail->SMTPSecure = 'tls';
        
        $mail->From = 'alertas_privacidad@sntsepomex.org';
        $mail->FromName = 'Alertas Privacidad';
        $mail->AddAddress('privacity_accepted@sntsepomex.org');
        $mail->AddReplyTo('alertas_privacidad@sntsepomex.org');
        $mail->WordWrap=200;
        
        $mail->Subject = 'El usuario ' . $_SESSION['ApPaterno'] . ' ' . $_SESSION['ApMaterno'] . ' ' . $_SESSION['Nombre'] . ' ha aceptado los terminos de privacidad.';
        $mail->Body = 'El empleado numero: ' . $_SESSION['idEmpleado'] . ' con nombre: ' . $_SESSION['ApPaterno'] . ' ' . $_SESSION['ApMaterno'] . ' ' . $_SESSION['Nombre'] . ' ha aceptado los terminos y condiciones desde la direccion Ip: ' . $ip . ' en la fecha: ' . $fechaActual;
            
            
            if(!$mail->Send()) {
                $resultadoCorreo = 'N';
            } else {
                $resultadoCorreo = 'S';
            }
        }
        
        $resultadoAceptacion = $auxOperaciones->aceptacionPrivacidad($_SESSION['idEmpleado'],$_SESSION['RFC'], $ip, $resultadoCorreo);
    
        $_SESSION['PrivacidadAceptada'] == 'true';
    }
    
    $nombreUsuario = capitalizaNombre($_SESSION['Nombre']) . ' ' . ucfirst(strtolower($_SESSION['ApPaterno'])) . ' ' . ucfirst(strtolower($_SESSION['ApMaterno']));
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Consultas Sindicato Nacional SEPOMEX</title>
        <meta charset="UTF-8">
        <script src="lib/portalEmpleado.js"></script>
        <link rel="stylesheet" type="text/css" href="CSSportalEmpleado.css">
    </head>
    <body>
        <header>
            <?php
    if(!$esMovil) {
echo <<<_END
        <li>
            <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="800" height="100">
                <param name="movie" value="../web/PLECAS/banner principal.swf" />
                <param name="quality" value="high" />
                <param name="wmode" value="transparent" />
                <param name="swfversion" value="6.0.65.0" />
                <param name="expressinstall" value="Scripts/expressInstall.swf" />

                <object type="application/x-shockwave-flash" data="../web/PLECAS/banner principal.swf" width="800" height="100">
                   <param name="quality" value="high" />
                   <param name="wmode" value="transparent" />
                   <param name="swfversion" value="6.0.65.0" />
                   <param name="expressinstall" value="Scripts/expressInstall.swf" />
                   <div>
                       <h4>El contenido de esta página requiere una versión más reciente de Adobe Flash Player.</h4>
                       <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
                   </div>
               </object>
            </object>
        </li>
_END;
    } else 
    {
echo <<<_END
        <li>
            <img id="banner" src="../movil/www/BANERS PAGINA  HTML/principal.png">
        </li>
_END;
    }
?>
            <h2><? echo "BIENVENIDO $nombreUsuario"; ?></h2>
            <h3><? echo $_SESSION['RFC'] ?></h3>
            <nav>
                <ul id="nav">
                    <li>
                        <input type="button" name="boton0" onclick="window.location='../index.php';" value="Home">
                    </li>
                    <li>
                        <input type="button" name="boton1" onclick="recuperaAcumulado()" value="Total de Aportaciones">
                    </li>
                    <li>
                        <input type="button" name="boton2" onclick="recuperaAdeudo()" value="Total de Adeudo">
                    </li>
                    <li>
                        <input type="button" name="boton3" onclick="recuperaTramites()" value="Trámites">
                    </li>
                    <li>
                        <input type="button" name="boton3" onclick="cerrarSesion()" value="CerrarSesion">
                    </li>                   
                </ul>
            </nav>
        </header>
        <div id="divTotal"> </div>
    </body>
</html>

