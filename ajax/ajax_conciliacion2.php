<?php
    include '../funciones/funciones.php';
    include '../funciones/funciones_conciliacion2.php';
    validaSesionAjax();
    $accion = $_POST["ajx_accion"];
    if(isset($accion)){$db = DataBase::getInstance();}
    switch($accion)
    {
        case 'refreshtitulo':
            $tipo = $_POST["ajx_tipo"];
            $total = $_POST["ajx_total"];
            echo genera_tabla_titulo($tipo,$total);
            break;
        case 'refreshfecha':
            $fecha = $_POST["ajx_fecha"];
            echo genera_tabla_fecha($fecha);
            break;
        case 'refreshtabla':        # Genera tabla de imeis faltantes en html
            $tipo = $_POST["ajx_tipo"];
            $id_ventasdiarias = $_POST["ajx_id_ventasdiarias"];
            switch ($tipo)
            {
                case 1: # Conciliación 1
                    echo genera_tabla_datos_ventasVS5archivos($db,$id_ventasdiarias);
                    break;
                case 2: # Conciliación 2
                    echo genera_tabla_datos_5archivosVSsap($db,$id_ventasdiarias);
                    break;
            }
            break;
        case 'obtieneEstatus':       # Obtiene lista de estatus para colocar en combo cuando se pase a otra etapa en json
            $tipo = $_POST["ajx_tipo"];
            echo JsonHandler::encode( obtiene_estatus($db,$tipo) );
            /*
            {
                "ejecutado":1,
                "estatus":
                [
                    {"id":1,"id_etapa":1,"id_etapato":2,"estatus":"Faltante"},
                    {"id":2,"id_etapa":1,"id_etapato":4,"estatus":"Facturación directa"},
                    {"id":3,"id_etapa":1,"id_etapato":4,"estatus":"Nota de crédito manual"},
                    {"id":4,"id_etapa":2,"id_etapato":3,"estatus":"Financiamiento Cargado"},
                    {"id":5,"id_etapa":2,"id_etapato":3,"estatus":"Se reenvía movimiento en nuevo archivo"},
                    {"id":6,"id_etapa":2,"id_etapato":4,"estatus":"Movimiento cancelado"},
                    {"id":7,"id_etapa":3,"id_etapato":4,"estatus":"Nota de crédito corregida"}
                ],
                "errormsg":""
            }
            */
            break;
        case 'cambiaestado':
            $jsonDatos=JsonHandler::decode($_POST['ajx_jsonDatos']);
            $faltan=$_POST['ajx_faltan'];
            $id_ventasdiarias=$_POST['ajx_id'];
            $tipo=$_POST['ajx_tipo'];
            if($jsonDatos->etapanueva==5)
            {
                echo JsonHandler::encode( regresa_estado($db,$jsonDatos,$_SESSION['id_usuario'],$_SESSION['nombre'],$faltan,$id_ventasdiarias,$tipo) );
            }
            else
            {
                echo JsonHandler::encode( cambia_estado ($db,$jsonDatos,$_SESSION['id_usuario'],$_SESSION['nombre'],$faltan,$id_ventasdiarias,$tipo) );
            }
            break;
        case 'obtieneetapas':
            $tipo=$_POST['ajx_tipo'];
            $etapaActual=$_POST['ajx_etapa_actual'];
            echo JsonHandler::encode( obtiene_etapas($db,$tipo,$etapaActual) );
            break;
        case 'obtieneEtapasHistorico':
            $id_ventasfaltan=$_POST['ajx_id_ventasfaltan'];
            $tipo=$_POST['ajx_tipo'];
            echo JsonHandler::encode( obtienejson_historico($db,$id_ventasfaltan,$tipo) );
            break;
        case 'cambiaasignacion':
            $jsonDatos=JsonHandler::decode($_POST['ajx_jsonDatos']);
            $id_ventasdiarias=$_POST['ajx_id'];
            $tipo=$_POST['ajx_tipo'];
            echo JsonHandler::encode( cambia_asignacion ($db,$jsonDatos,$_SESSION['id_usuario'],$_SESSION['nombre'],$id_ventasdiarias,$tipo) );
            break;
        case 'comentar':
            $jsonDatos=JsonHandler::decode($_POST['ajx_jsonDatos']);
            $id_ventasdiarias=$_POST['ajx_id'];
            $tipo=$_POST['ajx_tipo'];
            echo JsonHandler::encode( comentar ($db,$jsonDatos,$_SESSION['id_usuario'],$_SESSION['nombre'],$id_ventasdiarias,$tipo) );
            break;
   }
?>
