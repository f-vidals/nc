<?php
    include '../funciones/funciones.php';
    include '../funciones/funciones_busqueda.php';
    validaSesionAjax();
    $accion = $_POST["accion"];
    if(isset($accion)){$db = DataBase::getInstance();}
    switch($accion)
    {
        case 'buscar':
            $cadena=$_POST['ajx_buscar'];
            $pagina=$_POST['ajx_pagina'];
            $tipo=$_POST['ajx_tipo'];
            switch ($tipo)
            {
                case 1: //Conciliacion 1
                    echo genera_tabla_datos_1($db,$pagina,$cadena); //(bd,pagina,cadena busqueda)
                    break;
                case 2: //Conciliacion 2
                    echo genera_tabla_datos_2($db,$pagina,$cadena); //(bd,pagina,cadena busqueda)
                    break;
            }
         break;
   }
?>
