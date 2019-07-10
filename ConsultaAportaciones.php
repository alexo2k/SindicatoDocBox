<?php
    session_start();    
    require_once 'lib/Operaciones.php';
    require_once 'lib/sanitize.php';
    $cap = 'noHay';

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
    
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if($_GET['salir']=='true'){
            session_destroy();
        }
    }
    
    if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']== "true")){
        header('Location: portalEmpleado.php');  
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $auxOperaciones = new Operaciones();
            $numeroEmpleado = $auxOperaciones->recuperaId($_POST['pwdLogin']);
            
            if($numeroEmpleado > 0){
                $_SESSION['idEmpleado'] = $numeroEmpleado;
                $_SESSION['loggedIn'] = "true";
                $_SESSION['timeOut'] = time();              
                header('Location: portalEmpleado.php');
                die();               
            } else{
                $mensaje="La clave no es correcta";
            }
  }
  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Consulta Online</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="CSSConsulta.css">
    </head>
    <body>
        <form class="formContacto" action ="ConsultaAportaciones.php" method="post">
            <ul>
<?php
echo <<<_END
                <li>
                    <img id="banner" src="../movil/www/BANERS PAGINA  HTML/principal.png">
                </li>
_END;
?>
                  <h2>Portal para Consultar Aportaciones</h2>
                </li>
                <li>
                    <label for="Login">Ingresa la Clave de Acceso:</label>
                    <input type="password" name="pwdLogin" id="pwdLogin" required autocomplete="off" placeholder="Introduce Clave Aqui">
                </li>
                <li>
                    <input class="switch" type="checkbox" required id="acepto" name="acepto">
                    <label for="acepto" id="labelAcepto">He leido el aviso de privacidad y estoy de acuerdo.</label>
                    <button class="submit" id="btnAcepto" onclick="window.location='declaracionprivacidad.html';">Aviso de Privacidad</button>
                </li>
                <li>
                    <button class="submit" type="submit" value="formulario">Acceder</button>
                    <button class="submit" onclick="window.location='../index.php';">Regresar</button>
                </li>
                <br>
                <li style="color: white !important">
                    <span style="padding-left: 50px" >En este portal se muestran el saldo actual, en caso de requerir el estado de cuenta solicitalo al área pertinente.</span>
                </li>
                <li>
                    <p class="error"> <? echo $mensaje ?> </p>
                </li>
            </ul>
            <footer>
                <div>
                    <img id="plecaInferior" src="../web/PLECAS/pleca_inferior.png">
                </div>
            </footer>
        </form>
    </body>
</html>
