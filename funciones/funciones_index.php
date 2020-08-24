<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    function enviacorreo($correo,$contraseña)
    {
        $mensaje='';
        $mail = new PHPMailer(true);
        try
        {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->CharSet = "utf-8";
            $mail->Host = '10.191.143.164';
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
            $mail->Port = 25;
            $mail->setFrom('conciliacion@mail.telcel.com');
            $mail->addAddress($correo);
            $mail->addReplyTo('no-replay@mail.telcel.com');
            $mail->isHTML(true);
            $mail->Subject = 'Conciliación Notas de Crédito Contraseña';
            $mail->Body='<p>'.$contraseña.'</p>';
            $mail->send();
            $mensaje='OK';
        }
        catch (Exception $e)
        {
            $mensaje= $mail->ErrorInfo;
        }
        return $mensaje;
    }

    function logeo($db,$usuario,$password)
    {
        $arrayResult=array();
        $sql="SELECT usuarios.id,
            usuarios.nombre,
            usuarios.password,
            usuarios.id_deptotipo,
            usuarios.id_perfil,
            perfiles.graficos,
            perfiles.conciliacion,
            perfiles.conciliaciondetalles,
            perfiles.detallesseleccion,
            perfiles.conciliacion1estadomenu,
            perfiles.conciliacion1seguimientomenu,
            perfiles.conciliacion1etapapermiso,
            perfiles.conciliacion2estadomenu,
            perfiles.conciliacion2seguimientomenu,
            perfiles.conciliacion2etapapermiso,
            perfiles.busqueda,
            perfiles.notificaciones,
            perfiles.usuarios
            FROM usuarios,perfiles
            WHERE usuarios.id_perfil=perfiles.id AND usuarios.usuario=?";
        $data=array($usuario);
        if($db->ejecutarQueryPreparadoOneRow($sql,$data))
        {
            $row=$db->obtieneResultado();
            if(password_verify($password,$row['password']))
            {
                $arrayResult=array("ejecutado"=>1, "coincide"=>1, "errormsg"=>"");
                session_start();
                session_regenerate_id();
                $_SESSION['autenticado']=true;
                $_SESSION['id_usuario']=$row['id'];
                $_SESSION['usuario']=$usuario;
                $_SESSION['deptotipo']=$row['id_deptotipo'];
                $_SESSION['id_perfil']=$row['id_perfil'];
                $_SESSION['nombre']=substr($row['nombre'],0,24);
                $_SESSION['timeout']=time();
                $_SESSION['perfil']=array(
                    "graficos"=>(bool)$row['graficos'] ,
                    "conciliacion"=>(bool)$row['conciliacion'],
                    "conciliaciondetalles"=>(bool)$row['conciliaciondetalles'],
                    "detallesseleccion"=>(bool)$row['detallesseleccion'],
                    "conciliacion1estadomenu"=> $row['conciliacion1estadomenu'],
                    "conciliacion1seguimientomenu"=> $row['conciliacion1seguimientomenu'],
                    "conciliacion1etapapermiso"=> $row['conciliacion1etapapermiso'],
                    "conciliacion2estadomenu"=> $row['conciliacion2estadomenu'],
                    "conciliacion2seguimientomenu"=> $row['conciliacion2seguimientomenu'],
                    "conciliacion2etapapermiso"=> $row['conciliacion2etapapermiso'],
                    "busqueda"=>(bool)$row['busqueda'],
                    "notificaciones"=>(bool)$row['notificaciones'] ,
                    "usuarios"=>(bool)$row['usuarios']);
                // Array
                // (
                //     [graficos] => 1
                //     [conciliacion] => 1
                //     [conciliaciondetalles] => 1
                //     [detallesseleccion] => 1
                //     [conciliacion1estadomenu] => 1,1,1,1
                //     [conciliacion1etapapermiso] => 1,1,1,1
                //     [conciliacion2estadomenu] => 1,1,1,1
                //     [busqueda] => 1
                //     [notificaciones] => 1
                //     [usuarios] => 1
                // )
            }
            else {
                $arrayResult=array("ejecutado"=>1, "coincide"=>0, "errormsg"=>"");
                session_destroy();
            }
        }
        else {
            $arrayResult=array("ejecutado"=>0,"coincide"=>"0", "errormsg"=>$db->obtieneError());
            session_destroy();
        }
        return $arrayResult;
    }

    //Cambio de contraseña
    function cambio($db,$usuario,$actual,$nueva)
    {
        $arrayResult=array();
        $sql="SELECT id,password FROM usuarios WHERE usuario=?";
        $data=array($usuario);
        if($db->ejecutarQueryPreparadoOneRow($sql,$data))
        {
            $row1=$db->obtieneResultado();
            if( password_verify($actual,$row1['password']) )
            {
                $sql="UPDATE usuarios SET password=? WHERE id=?";
                $data=array( password_hash($nueva, PASSWORD_BCRYPT),$row1['id'] );
                if($db->ejecutarQueryPreparadoOneRow($sql,$data)) {
                    $arrayResult=array("ejecutado"=>1, "coincide"=>1, "cambiado"=>1, "errormsg"=>"");
                }
                else {
                    $arrayResult=array("ejecutado"=>1, "coincide"=>1, "cambiado"=>0, "errormsg"=>$db->obtieneError());
                }
            }
            else {
                $arrayResult=array("ejecutado"=>1, "coincide"=>0, "cambiado"=>0, "errormsg"=>$db->obtieneError());
            }
        }
        else {
            $arrayResult=array("ejecutado"=>0,"coincide"=>0, "cambiado"=>0, "errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }

    //Recupera Contraseña
    function recupera($db,$usuario)
    {
        $arrayResult=array();
        $msg='';
        $sql="SELECT id,correo FROM usuarios WHERE usuario=?";
        $data=array("$usuario");
        if($db->ejecutarQueryPreparadoOneRow($sql,$data))
        {
            $row1=$db->obtieneResultado();
            if($row1['id']!=NULL)  // Si encuentra el usuario
            {
                $password=substr(md5(microtime()),4,8);
                $sql="UPDATE usuarios SET password=? WHERE id=?";
                $data=array( password_hash($password, PASSWORD_BCRYPT),$row1['id'] );
                if($db->ejecutarQueryPreparadoOneRow($sql,$data)) {
                    $msg=enviacorreo($row1['correo'],$password);
                    $arrayResult=array("ejecutado"=>1, "coincide"=>1, "cambiado"=>1, "errormsg"=>$msg);
                }
                else {
                    $arrayResult=array("ejecutado"=>1, "coincide"=>1, "cambiado"=>0, "errormsg"=>$db->obtieneError());
                }
            }
            else {
                $arrayResult=array("ejecutado"=>1, "coincide"=>0, "cambiado"=>0, "errormsg"=>$db->obtieneError());
            }
        }
        else {
            $arrayResult=array("ejecutado"=>0,"coincide"=>0, "cambiado"=>0, "errormsg"=>$db->obtieneError());

        }
        sleep(3);
        return $arrayResult;
    }

?>
