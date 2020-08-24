<?php
    include '../funciones/funciones.php';
    include '../funciones/funciones_notificaciones.php';
    validaSesionAjax();
    $accion = $_POST["accion"];
    if(isset($accion)){$db = DataBase::getInstance();}
    switch($accion)
    {
        case 'refresh':
            $etapa=$_POST["ajx_etapa"];
            echo genera_tabla_datos($db,$etapa);
            break;
        case 'get_usuarios':
            echo obtiene_usuarios($db);
            break;
        case 'add_usuarios':
            $id_usuario=$_POST['ajx_id'];
            $etapa=$_POST['ajx_etapa'];
            echo JsonHandler::encode(agrega_usuarios($db,$id_usuario,$etapa));
            break;
        case 'del_usuarios':
            $id_usuario=$_POST['ajx_id'];
            $etapa=$_POST['ajx_etapa'];
            echo JsonHandler::encode(quita_usuarios($db,$id_usuario,$etapa));
            break;
   }
?>
