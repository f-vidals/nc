<?php
    include '../funciones/funciones.php';
    include '../funciones/funciones_pendientes.php';
    validaSesionAjax();
    $accion = $_POST["ajx_accion"];
    if(isset($accion)){$db = DataBase::getInstance();}
    switch($accion)
    {
        case 'refreshtabla':        # Genera tabla de imeis faltantes en html
            $tipo = $_POST["ajx_tipo"];
            $pagina = $_POST["ajx_pagina"];
            $id_tipodepto = $_SESSION['deptotipo'];
            //$id_tipodepto = 2;
            switch ($tipo)
            {
                case 1: # Conciliación 1
                    echo genera_tabla_datos_ventasVS5archivos($db,$pagina,$id_tipodepto);
                    break;
                case 2: # Conciliación 2
                    echo genera_tabla_datos_5archivosVSsap($db,$pagina,$id_tipodepto);
                    break;
            }
            break;
        case 'cambiaestado':
            $jsonDatos=JsonHandler::decode($_POST['ajx_jsonDatos']);
            if($jsonDatos->etapanueva==5)
            {
                echo JsonHandler::encode( regresa_estado($db,$jsonDatos,$_SESSION['id_usuario'],$_SESSION['nombre']) );
            }
            else
            {
                echo JsonHandler::encode( cambia_estado ($db,$jsonDatos,$_SESSION['id_usuario'],$_SESSION['nombre']) );
            }
            break;
         case 'exportar':
            $tipo = $_POST["ajx_tipo"];
            $id_tipodepto = $_SESSION['deptotipo'];
            switch ($tipo)
            {
                case 1: # Conciliación 1
                    echo JsonHandler::encode( genera_datos_exportar_ventasVS5archivos($db,$id_tipodepto) );
                    break;
                case 2: # Conciliación 2
                    echo JsonHandler::encode( genera_datos_exportar_5archivosVSsap($db,$id_tipodepto) );
                    break;
            }
            break;
   }
?>
