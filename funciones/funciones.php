<?php
    date_default_timezone_set('America/Mexico_City');
    // -----------------------------------------------------------------------------------------------------------------------
    // Clase Data Base Singleton para CURSOS
    // Usa PHP Data Objects (PDO) (yum install php-pdo)
    // -----------------------------------------------------------------------------------------------------------------------
    class DataBase
    {
        private static $instance = null;

        private $hostDB= $_ENV["DATABASE_SERVICE_NAME"];

        //private $BD = "ncbd";
        private $BD = $_ENV["MYSQL_DATABASE"];

        //private $usrBD = "td";
        private $usrBD = $_ENV["MYSQL_USER"];

        //private $pwdBD = "td..";
        private $pwdBD = $_ENV["MYSQL_PASSWORD"];

        private $conn = null;
        private $query = null;
        private $result = null;
        private $rows = null;
        private $errorMSG = null;
        private $errorCODE = null;
        private function __clone() {}

        public static function getInstance()
        {
            if(is_null(self::$instance)){self::$instance = new DataBase();}
            return self::$instance;
        }

        private function __construct()
        {
            try
            {
                #$this->conn = new PDO("mysql:host=localhost;dbname=".$this->BD.";charset=utf8",$this->usrBD,$this->pwdBD);
                $this->conn = new PDO("mysql:host=$this->hostBD;dbname=".$this->BD.";charset=utf8",$this->usrBD,$this->pwdBD);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,FALSE);
                $this->conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,TRUE);
                $this->conn->setAttribute(PDO::ATTR_TIMEOUT,5);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {
                $this->errorMSG=$e->getMessage();
                $this->errorCODE=$this->conn->errorCode();
                echo $this->errorMSG;
                exit();
            }
        }

        function __destruct(){$this->conn=null;self::$instance=null;}

        public function ejecutarQueryPreparado($sql,$data)
        {
            //Varias filas
            // foreach($rows as $row)
            // {
            //    $row["id"]
            // }
            try
            {
                $sqlprepare=$this->conn->prepare($sql);
                $sqlprepare->execute($data);
                $this->rows=$sqlprepare->rowCount();
                if(!preg_match('/^(UPDATE|INSERT|DELETE)/',$sql))
                {
                    $this->result=$sqlprepare->fetchAll(PDO::FETCH_ASSOC);
               /*
                    PDO::FETCH_NUM		-> array con llaves numéricas (0,1,2,3...)
                    PDO::FETCH_ASSOC	-> array con llaves de campos (nombres de las columnas del query)
                    PDO::FETCH_BOTH	-> Ambos
                                            Array (
                                               [nombre] => R9NEZECSCF01
                                               [0] => R9NEZECSCF01
                                               [fecha] => 2016-06-09 16:15:00
                                               [1] => 2016-06-09 16:15:00
                                               [valor] => 90.91
                                               [2] => 90.91 )
                    echo $array[row][col] -> Genera array de 2 dimensiones*/
                }
            }
            catch (PDOException $e)
            {
                $this->errorMSG=$e->getMessage();
                //$this->errorCODE=$this->conn->errorCode();
                //$this->errorCODE=$sqlprepare->errorCode();
                $this->errorCODE=$e->getCode();
                return false;
            }
            return true;
        }

        public function ejecutarQueryPreparadoOneRow($sql,$data) //Tambien para procedimientos almacenados
        {
            //Una sola fila
            //$row["id"];
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE); //PHP Warning:  Packets out of order
            $salida=true;
            try
            {
                $sqlprepare=$this->conn->prepare($sql);
                $sqlprepare->execute($data);
                $this->rows=1;
                if(!preg_match('/^(UPDATE|INSERT|DELETE)/',$sql)) { $this->result=$sqlprepare->fetch(PDO::FETCH_ASSOC); }
            }
            catch (PDOException $e)
            {
                $this->errorMSG=$e->getMessage();
                $this->errorCODE=$e->getCode();
                $salida=false;
            }
            finally
            {
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,FALSE);
                return $salida;
            }
        }

        public function obtieneResultado()
        {
            return $this->result;
        }

        public function obtieneRowsCountResultados()
        {
            return $this->rows;
        }

        public function obtieneError()
        {
            return $this->errorCODE.'|'.$this->errorMSG;
        }

        // --- TRANSACCIONES ---
        /*
        $arrayResult=array();
        try
        {
            $db->iniciaTransaccion();
            $sql="INSERT ..."
            foreach
            {
                $data=array(...);
                $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));
            }
            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"asignacionid"=>$asignacion_id,"errormsg"=>"");
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayError=explode("|",$e->getMessage());
            $arrayResult=array("ejecutado"=>0,"asignacionid"=>"","errormsg"=>"$arrayError[1]");
        }
        finally
        {
            return $arrayResult;
        }
        */

        public function iniciaTransaccion()
        {
            $this->conn->beginTransaction();
        }

        public function terminaTransaccion()
        {
            $this->conn->commit();
        }

        public function rollbackTransaccion()
        {
            $this->conn->rollBack();
        }

        public function obtieneLastID()
        {
            return $this->conn->lastInsertId();
        }

        public function revisaExepcionTransaccion($ejecutado) //Generar excepción
        {
            if(!$ejecutado){throw new Exception($this->obtieneError());}
        }

        public function revisaExepcionTransaccionIgnoraDuplicado($ejecutado) //Generar excepción, ignora codigo 23000
        {
            $arrayError=explode("|",$this->obtieneError());
            if($arrayError[0]!=23000)
            {
                if(!$ejecutado){throw new Exception($this->obtieneError());}
            }
        }

        public function revisaExepcionTransaccionProcedure($ejecutado) //Generar excepcion si hay error en el procedimiento
        {
            /*
            Resultado del procedimiento:
                SELECT @sqlstate AS status, @text AS texto;
                SELECT 0 AS status ,@salida AS texto;
            */
            if(!$ejecutado){throw new Exception($this->obtieneError());}
            else
            {
                $error=$this->obtieneResultado();
                if($error['status']!=0)
                throw new Exception($error['status'].'|'.$error['texto']);
            }
        }

    }

    // -----------------------------------------------------------------------------------------------------------------------
    // Clase para leer JSON
    // //$jsonCursos=JsonHandler::decode($_POST['ajx_arrayCurso']); -> Decodificar(javascript json -> array php)
    // -----------------------------------------------------------------------------------------------------------------------
    class JsonHandler
    {
        protected static $mensajes = array(
            JSON_ERROR_NONE           => 'No ha habido ningún error',
            JSON_ERROR_DEPTH          => 'Se ha alcanzado el máximo nivel de profundidad',
            JSON_ERROR_STATE_MISMATCH => 'JSON inválido o mal formado',
            JSON_ERROR_CTRL_CHAR      => 'Error de control de caracteres, posiblemente incorrectamente codificado',
            JSON_ERROR_SYNTAX         => 'Error de sintaxis',
            JSON_ERROR_UTF8           => 'Caracteres UTF-8 mal formados, posiblemente incorrectamente codificado'
        );
        public static function encode($value, $options = 0)
        {
            $result = json_encode($value, $options);
            if ($result){return $result;}
            throw new RuntimeException(static::$mensajes[json_last_error()]);
        }
        public static function decode($json, $assoc = false)
        {
            $result = json_decode($json, $assoc);
            if ($result){return $result;}
            throw new RuntimeException(static::$mensajes[json_last_error()]);
        }
    }
    // -----------------------------------------------------------------------------------------------------------------------
    // FUNCIONES GENERAL
    // -----------------------------------------------------------------------------------------------------------------------


    function set_estilo_tipo($tipo)
    {
        $estilo;
        switch($tipo)
        {
            //Tipo de venta
            case 'activaciones':
                $estilo='background-color:#009688;';
                break;
            case 'cambio de equipos':
                $estilo='background-color:#F2B53F;';
                break;
            case 'cambio de plan':
                $estilo='background-color:#619BF2;';
                break;
            //  Tipo de perfil
            case 1:
                $estilo='background-color:#CC3000;';
                break;
            case 2:
                $estilo='background-color:#99CC00;';
                    break;
            case 3:
                $estilo='background-color:#0066CC;';
                break;
            case 4:
                $estilo='background-color:#CC6600;';
                break;
            case 5:
                $estilo='background-color:#FFCC00;';
                break;
            default:
                $estilo='background-color:lightgrey;';
                break;
        }
        return $estilo;
    }

    function set_estilo_etapa($etapa)
    {
        $estilo;
        switch($etapa)
        {
            // case 1:
            //     $estilo='background-color:#DF0101;';
            //     break;
            // case 2:
            //     $estilo='background-color:#FE9A2E;';
            //     break;
            case 1:
                $estilo='background-color:#5858FA;';
                break;
            case 4:
                $estilo='background-color:#A4A4A4;';
                break;
        }
        return $estilo;
    }

    function set_barra($porcentaje,$tipo)
    {
        #$estilo='width:'.$porcentaje.'%;background-color:#29C3BE;';
        #$estilo='width:'.$porcentaje.'%;background-color:#FE2E2E;';
        if ($porcentaje>0)
        {
            $estilo='width:100%;background-color:#FE2E2E;color:white;';

        }
        else
        {
            $estilo='width:100%;color:black;';
        }
        return $estilo;
   }

    function tab_icon()
    {
        echo '<link rel="shortcut icon" href="img/notas.png">';
    }

    function scriptActual()
    {
        $file = explode('/',$_SERVER["SCRIPT_NAME"]);
        return $file[count($file)-1];
    }

    function menuIzquierdo()
    {
        $opcion=scriptActual();
        echo PHP_EOL;
        echo '<table class="tabla-menu">';
        if($_SESSION['perfil']['graficos'])
        {
            echo '<tr>';
                $colormenu=($opcion=="graficos.php")?'<td style="background-color:#254AA5;">':'<td>';
                    echo $colormenu;
                    echo '<a href="graficos.php">';
                        echo '<table width=200px>';
                            echo '<tr>';
                                echo '<td width=20%>';
                                    echo '<img src="img/baseline_assessment_white_36dp.png">';
                                echo '</td>';
                                echo '<td width=10%></td>';
                                echo '<td width=70%> Graficos </td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</a>';
                echo '</td>';
            echo '</tr>';
            echo PHP_EOL;
        }
        if($_SESSION['perfil']['conciliacion'])
        {
            echo '<tr>';
                $colormenu=($opcion=="conciliacion.php" || $opcion=="conciliacion2.php")?'<td style="background-color:#254AA5;">':'<td>';
                    echo $colormenu;
                    echo '<a href="conciliacion.php">';
                        echo '<table width=200px>';
                            echo '<tr>';
                                echo '<td width=20%>';
                                    echo '<img src="img/baseline_view_list_white_36dp.png">';
                                echo '</td>';
                                echo '<td width=10%></td>';
                                echo '<td width=70%> Conciliación </td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</a>';
                echo '</td>';
            echo '</tr>';
            echo PHP_EOL;
        }
        if($_SESSION['perfil']['busqueda'])
        {
            echo '<tr>';
                $colormenu=($opcion=="pendientes.php")?'<td style="background-color:#254AA5;">':'<td>';
                    echo $colormenu;
                    echo '<a href="pendientes.php">';
                        echo '<table width=200px>';
                            echo '<tr>';
                                echo '<td width=20%>';
                                    echo '<img src="img/baseline_pending_actions_white_36dp.png">';
                                echo '</td>';
                                echo '<td width=10%></td>';
                                echo '<td width=70%> Pendientes </td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</a>';
                echo '</td>';
            echo '</tr>';
            echo PHP_EOL;
        }
        if($_SESSION['perfil']['busqueda'])
        {
            echo '<tr>';
                $colormenu=($opcion=="busqueda.php")?'<td style="background-color:#254AA5;">':'<td>';
                    echo $colormenu;
                    echo '<a href="busqueda.php">';
                        echo '<table width=200px>';
                            echo '<tr>';
                                echo '<td width=20%>';
                                    echo '<img src="img/baseline_find_in_page_white_36dp.png">';
                                echo '</td>';
                                echo '<td width=10%></td>';
                                echo '<td width=70%> Búsqueda </td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</a>';
                echo '</td>';
            echo '</tr>';
            echo PHP_EOL;
        }
        if($_SESSION['perfil']['notificaciones'])
        {
            echo '<tr>';
                $colormenu=($opcion=="notificaciones.php")?'<td style="background-color:#254AA5;">':'<td>';
                    echo $colormenu;
                    echo '<a href="notificaciones.php">';
                        echo '<table width=200px>';
                            echo '<tr>';
                                echo '<td width=20%>';
                                    echo '<img src="img/baseline_mail_white_36dp.png">';
                                echo '</td>';
                                echo '<td width=10%></td>';
                                echo '<td width=70%> Notificaciones </td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</a>';
                echo '</td>';
            echo '</tr>';
            echo PHP_EOL;
        }
        if($_SESSION['perfil']['usuarios'])
        {
            echo '<tr>';
                $colormenu=($opcion=="usuarios.php")?'<td style="background-color:#254AA5;">':'<td>';
                    echo $colormenu;
                    echo '<a href="usuarios.php">';
                        echo '<table width=200px>';
                            echo '<tr>';
                                echo '<td width=20%>';
                                    echo '<img src="img/baseline_account_box_white_36dp.png">';
                                echo '</td>';
                                echo '<td width=10%></td>';
                                echo '<td width=70%> Usuarios </td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</a>';
                echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo PHP_EOL;
        echo '<br><br>';
    }

    // -------------------- Paginacion --------------------

    function calculaPaginacion($pagina)
    {
        $limit = 10;                  // maximo por pagina
        $pag = (int) $pagina;         // página pedida
        if ($pag < 1) {$pag = 1;}
        $offset = ($pag-1) * $limit;  //Inicia desde un registro
        return array($pag,$limit,$offset);
    }
    function barraDePaginacion($total,$limit,$page)
    {
        //Utiliza style.css
        // Requiere funcion en javascript para ajax
        // Requere que la consulta tenga SELECT SQL_CALC_FOUND_ROWS
        $totalPag = ceil($total/$limit);
        $paginacion='<div class="pagination"><a href="#">&laquo;</a>';
        for( $i=1; $i<=$totalPag; $i++)
        {
            if( ($i>($page-3))&&($i<($page+3)))
            {
                if($i==$page)
                {
                    $paginacion.='<a class="active" href="#">'.$i.'</a>';   // Selecciona la pagina actual
                }
                else
                {
                    $paginacion.='<a href="#">'.$i.'</a>';
                }
            }
        }
        $paginacion.='<a href="#">&raquo;</a>';
        return array($totalPag,$paginacion);
    }

    // -------------------- Sesión --------------------

    function validaSesion()
    {
        session_start();
        if( $_SESSION['autenticado']==false )
        {
            session_destroy();
            header("Location: ./");
        }
        elseif ( isset($_SESSION['timeout']) )
        {
            $duration = time() - (int)$_SESSION['timeout'];
            if($duration > 5400) //segundos
            {
                session_destroy();
                header("Location: ./");
            }
            else {
                $_SESSION['timeout']=time();
            }
        }
    }
    function validaSesionAjax()
    {
        session_start();
        if( $_SESSION['autenticado']==false )
        {
            session_destroy();
            echo "No logeado";
        }
        elseif ( isset($_SESSION['timeout']) )
        {
            $duration = time() - (int)$_SESSION['timeout'];
            if($duration > 5400) //segundos
            {
                session_destroy();
                echo "TimeOut";
            }
            else {
                $_SESSION['timeout']=time();
            }
        }
    }

    // -------------------- Crea dialogo cambiar contraseña --------------------

    function dialogoContraseña()
    {
        $salida = "";
        $salida .= '<div id="id_dialog_password" title="Cambiar contraseña" style="display:none">';
        $salida .= '<table width=100%>';
        $salida .= '<tr>';
        $salida .= '<td>';
        $salida .= 'Contraseña actual:';
        $salida .= '</td>';
        $salida .= '<td>';
        $salida .= '<input type="password" id="id_dialog_actual" style="width:10em;" maxlength="15"></input>';
        $salida .= '</td>';
        $salida .= '</tr>';
        $salida .= '<tr>';
        $salida .= '<td>';
        $salida .= 'Contraseña nueva:';
        $salida .= '</td>';
        $salida .= '<td>';
        $salida .= '<input type="password" id="id_dialog_nueva1" style="width:10em;" maxlength="15"></input>';
        $salida .= '</td>';
        $salida .= '</tr>';
        $salida .= '<tr>';
        $salida .= '<td>';
        $salida .= 'Contraseña nueva:';
        $salida .= '</td>';
        $salida .= '<td>';
        $salida .= '<input type="password" id="id_dialog_nueva2" style="width:10em;" maxlength="15"></input>';
        $salida .= '</td>';
        $salida .= '</tr>';
        $salida .= '</table>';
        $salida .= '</div>'.PHP_EOL;
        $salida .= '<script type="text/javascript">';
        $salida .= '$(document).ready(function()';
        $salida .= '{';
        $salida .= '$("#id_dialog_password").dialog(';
        $salida .= '{';
        $salida .= 'modal:true,height:250,width:350,autoOpen:false,show:"fade",hide:"fade",';
        $salida .= 'open:function(e,ui) {';
        $salida .= '$(this).keyup(function(e) {';
        $salida .= 'if (e.keyCode == 13) {$(this).parent().find(".ui-dialog-buttonpane button:eq(0)").trigger("click");}';
        $salida .= '});';
        $salida .= '},';
        $salida .= 'buttons:';
        $salida .= '{';
        $salida .= 'Aceptar: function()';
        $salida .= '{';
        $salida .= 'var actual=$("#id_dialog_actual").val();';
        $salida .= 'var nueva1=$("#id_dialog_nueva1").val();';
        $salida .= 'var nueva2=$("#id_dialog_nueva2").val();';
        $salida .= 'var patt=/^(?=.*\d)(?=.*[A-Z])(?!.*(.)\1)\S{8,15}$/;';
        $salida .= 'if(actual.length<7||nueva1.length<7||nueva2.length<7)';
        $salida .= '{alert("Longitud no permitida");}';
        $salida .= 'else';
        $salida .= '{';
        $salida .= 'if(nueva1==nueva2 && patt.test(nueva1))';
        $salida .= '{';
        $salida .= '$.ajax({';
        $salida .= 'url:"ajax/ajax_index.php",type:"POST",async:false,cache:false,dataType:"json",';
        $salida .= 'data:{ajx_accion:"cambiar",ajx_actual:actual,ajx_nueva:nueva2},';
        $salida .= 'success: function(result_json)';
        $salida .= '{';
        $salida .= 'if(result_json.ejecutado==1){';
        $salida .= 'if(result_json.coincide==1){';
        $salida .= 'if(result_json.cambiado==1){alert("Contraseña cambiada");}';
        $salida .= 'else {alert("Error: "+result_json.errorMSG);}';
        $salida .= '}';
        $salida .= 'else {alert("Error, no coincide contraseña actual");}';
        $salida .= '}';
        $salida .= 'else {alert(result_json.errorMSG);}';
        $salida .= '}';
        $salida .= '});';
        $salida .= '}';
        $salida .= 'else {alert("Error en nuevas contraseñas");}';
        $salida .= '$(this).dialog("close");';
        $salida .= '}';
        $salida .= '},';
        $salida .= 'Cancelar: function(){$(this).dialog("close");}';
        $salida .= '}';
        $salida .= '});';
        $salida .= '$("#id_dialog_password").on("dialogclose",function(event)';
        $salida .= '{';
        $salida .= '$("#id_dialog_actual").val("");';
        $salida .= '$("#id_dialog_nueva1").val("");';
        $salida .= '$("#id_dialog_nueva2").val("");';
        $salida .='});'.PHP_EOL;
        $salida .= '$("#id_menu_passw").click(function(){$("#id_dialog_password").show(); $("#id_dialog_password").dialog("open");});';
        $salida .= '$("#id_menu_salir").click(function(){logout()});';
        $salida .= '});';
        $salida .= '</script>';
        echo $salida;
    }
?>
