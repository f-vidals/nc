<?php
    include '../funciones/funciones.php';
    include '../funciones/funciones_conciliacion.php';
    validaSesionAjax();
    $accion = $_POST["accion"];
    if(isset($accion)){$db = DataBase::getInstance();}
    switch($accion)
    {
        case 'buscar':
            $cadena=$_POST['ajx_cadena'];
            echo genera_tabla_datos($db,1,$cadena); //(bd,pagina,cadena busqueda)
            break;
        case 'refresh':
            $pagina=isset($_POST['ajx_pagina'])?$_POST['ajx_pagina']:1;
            $cadena=isset($_POST['ajx_buscar'])?$_POST['ajx_buscar']:null;
            if($cadena==null){
                echo genera_tabla_datos($db,$pagina); //(bd,pagina)
            }
            else {
                echo genera_tabla_datos($db,$pagina,$cadena); //(bd,pagina,cadena búsqueda)
            }
            break;
        case 'exportar':
            echo JsonHandler::encode( genera_datos_exportar($db) );
            break;
   }
?>
