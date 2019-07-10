<?php
    session_start();
    
    class Operaciones
    {
        protected $servidor;
        protected $usuario;
        protected $contrasena;
        protected $baseDeDatos;
        
        public function __construct() 
        {
            //inicializamos propiedades
            //$this->servidor = 'localhost';
            //$this->usuario = 'sntsep5_consulta';
            //$this->contrasena = 'consultaSNT2k13';
            //$this->baseDeDatos = 'sntsep5_sistemaaportaciones';
            $this->servidor = '127.0.0.1';
            $this->usuario = 'root';
            $this->contrasena = 'eti11$$';
            $this->baseDeDatos = 'sistemaaportaciones';
        }
        
        public function cadenaConexion()
        {
            return 'server=' . $this->servidor . ';User Id=' . $this->usuario . ';Password=\'' . $this->contrasena .'\';Database=' . $this->baseDeDatos . ';';
        }
        
        public function actualizaStamp($idEmpleado)
        {
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Aportaciones');

                $sqlQuery = 'UPDATE StatusEmpleado SET UltimaVisita = now() WHERE Id_Empleado = ' . $idEmpleado;
                
                if(!mysql_query($sqlQuery,$streamBD)) 
                {
                    die('Error: ' . mysql_error());
                    $registrosActualizados = mysql_affected_rows();
                } else 
                {
                    $registrosActualizados = 0;
                }    
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al actualizar el tiempo. ERR:' . $e->getMessage());
            }
            
            //mysql_close($streamBD);
            
            return $registrosActualizados;
        }
        
        public function recuperaId($passUsuario)
        {
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Aportaciones');
            
                $resultado = mysql_query('SELECT ValidaCredencial(\'' . $passUsuario . '\') Id_Empleado ');
                
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0)
                {
                    while($registro = mysql_fetch_array($resultado))
                    {
                        $idEmpleado = $registro{'Id_Empleado'};
                        //$this->actualizaStamp($idEmpleado);
                    }
                }
                else 
                {
                    $idEmpleado = 0;
                }
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
            }
            
            mysql_close($streamBD);
            
            return $idEmpleado;
        }
        
        public function recuperaDatosPersonales($idEmpleado)
        {
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Aportaciones');
                
                $resultado = mysql_query("SELECT * FROM DatosPersonales WHERE Id_Empleado = $idEmpleado");
                
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0)
                {
                    while($registro = mysql_fetch_array($resultado))
                    {
                        $idEmpleado = $registro{'Id_Empleado'};
                        $_SESSION['IdEmpleado'] = $idEmpleado;
                        $_SESSION['ApPaterno'] = $registro{'ApPaterno'};
                        $_SESSION['ApMaterno'] = $registro{'ApMaterno'};
                        $_SESSION['Nombre'] = $registro{'Nombre'};
                        $_SESSION['RFC'] = $registro{'RFC'};
                    }
                }
                else 
                {
                    $idEmpleado = 0;
                }
                
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
            }
            
            mysql_close($streamBD);
            
            return $idEmpleado;
        }
        
        public function recuperaAportacion($idEmpleado)
        {
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Aportaciones');
                
                $resultado = mysql_query("SELECT * FROM AcumuladoAportaciones WHERE Id_Empleado = $idEmpleado");
                
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0)
                {
                    while($registro = mysql_fetch_array($resultado))
                    {
                        $aportacionSindical = $registro{'AportacionSindical'};
                    }
                }
                else 
                {
                    $aportacionSindical = 0;
                }
                
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
            }
            
            mysql_close($streamBD);
            
            return $aportacionSindical;
        }
        
        public function recuperaAdeudo($idEmpleado)
        {
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Aportaciones');
                
                $resultado = mysql_query("SELECT * FROM Adeudo WHERE Id_Empleado = $idEmpleado");
                
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0)
                {
                    while($registro = mysql_fetch_array($resultado))
                    {
                        $arrayAdeudo = array
                        (
                            "adeudo" => $registro{'AdeudoPrestamo'},
                            "fechaAdeudo" => $registro{'FechaTerminoAdeudo'}
                        );
                    }
                }
                else 
                {
                    $arrayAdeudo = NULL;
                }
                
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
            }
            
            mysql_close($streamBD);
            
            return $arrayAdeudo;
        }
    }
?>
