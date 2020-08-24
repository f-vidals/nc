<?php
    include '../funciones/funciones.php';
    include '../funciones/funciones_index.php';
    $accion = $_POST["ajx_accion"];
    if(isset($accion)){$db = DataBase::getInstance();}
    switch($accion)
    {
        case 'login':
            $usuario = $_POST["ajx_usr"];
            $password = $_POST["ajx_pwd"];
            echo JsonHandler::encode(logeo($db,$usuario,$password));
            break;
        case 'recupera':
            $usuario = $_POST["ajx_usr"];
            echo JsonHandler::encode(recupera($db,$usuario));
            break;
        case 'logout';
            validaSesion();
            session_destroy();
            break;
        case 'cambiar':
            validaSesion();
            $actual=$_POST['ajx_actual'];
            $nueva=$_POST['ajx_nueva'];
            echo JsonHandler::encode(cambio($db,$_SESSION['usuario'],$actual,$nueva));
            break;
    }
?>
