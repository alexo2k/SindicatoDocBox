<?php
    function sanitizeString($var){
        if(get_magic_quotes_gpc()) $var=stripslashes($var);
        $var = htmlentities($var);
        $var = strip_tags($var);
        return $var;
    }
    
    function sanitizeMySQL($var){
        $var = mysql_real_escape_string($var);
        $var = sanitizeString($var);
        return $var;
    }
    
    function capitalizaNombre($pNombre){
        $auxNombreSplit = explode(" ",$pNombre);
        $nombreCapitalizado ="";
    
        foreach ($auxNombreSplit as $splitNombre) 
        {
            $nombreCapitalizado = $nombreCapitalizado . ucfirst(strtolower($splitNombre)) . " ";
        }
    
        trim($nombreCapitalizado);
        
        return $nombreCapitalizado;
    }
?>
