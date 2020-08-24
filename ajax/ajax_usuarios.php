<?php
    include '../funciones/funciones.php';
    include '../funciones/funciones_usuarios.php';
    validaSesionAjax();
    $accion = $_POST["accion"];
    if(isset($accion)){$db = DataBase::getInstance();}
    switch($accion)
    {
        case 'refresh':
            echo genera_tabla_datos($db);
            break;
        case 'obtienePerfiles':
            echo JsonHandler::encode( obtiene_perfiles($db) );
            break;
        case 'obtieneTipoDepto':
            echo JsonHandler::encode( obtiene_tipodepto($db) );
            break;
        case 'agregar':
            $jsonDatos=JsonHandler::decode($_POST["ajx_datos"]);
            echo JsonHandler::encode( agrega_usuario($db,$jsonDatos) );
            break;
        case 'modificar':
            $jsonDatos=JsonHandler::decode($_POST["ajx_datos"]);
            $id=$_POST['ajx_id'];
            echo JsonHandler::encode( modifica_usuario($db,$jsonDatos,$id) );
            break;
        case 'eliminar':
            $id=$_POST['ajx_id'];
            echo JsonHandler::encode( elimina_usuario($db,$id) );
            break;
   }
?>
