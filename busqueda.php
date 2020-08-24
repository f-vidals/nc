<?php
    include 'funciones/funciones.php';
    include 'funciones/funciones_busqueda.php';
    validaSesion();
    $pagina=( isset($_GET['p']) )?$_GET['p']:1;
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Notas de Crédito</title>
        <script language="JavaScript" type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones_busqueda.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php tab_icon(); ?>
    </head>

    <body class="body_class">

        <!-- --------------- ENCABEZADO --------------- -->
        <div class="top_class">
            <?php encabezado(); ?>
        </div>

        <div class="container_class">

            <!-- --------------- MENU IZQUIERDO --------------- -->
            <div class="left_class">
                <?php menuIzquierdo(); ?>
            </div>

            <!-- --------------- CONTENIDO --------------- -->
            <div class="right_class">
                <table>
                    <tr>
                        <td colspan="2">
                            <div class="viewport">
                                <div id="id_div_tabla_datos_1">
                                    <p><h3 style="color:lightgrey;">Resultado de la búsqueda Ventas VS 5archivos</h3></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="viewport">
                                <div id="id_div_tabla_datos_2">
                                    <p><h3 style="color:lightgrey;">Resultado de la búsqueda 5archivos VS SAP</h3></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    <body>

    <script type="text/javascript">
        $(document).ready(function()
        {
            //Busqueda
            $("#id_busqueda_txt").keyup(function(e){if(e.keyCode==13)
            {
                var dato=$("#id_busqueda_txt").val().trim();
                if(validar_campo(dato))
                {
                    $.ajax({
                        url:"ajax/ajax_busqueda.php",type:"POST",async:false,cache:false,
                        data:{accion:'buscar',ajx_pagina:1,ajx_buscar:dato,ajx_tipo:1},
                        success: function(result_html){$("#id_div_tabla_datos_1").html(result_html);}
                    });
                    $.ajax({
                        url:"ajax/ajax_busqueda.php",type:"POST",async:false,cache:false,
                        data:{accion:'buscar',ajx_pagina:1,ajx_buscar:dato,ajx_tipo:2},
                        success: function(result_html){$("#id_div_tabla_datos_2").html(result_html);}
                    });
                }
            }});
        });
    </script>

    <!-- --------------- DIALOGOS --------------- -->

    <!-- +++++ LOADING +++++ -->

    <div id='loadingmessage' class="loader" ></div>

    <!-- +++++ CAMBIA CONTRASEÑA +++++ -->

    <?php dialogoContraseña() // y eventos click del menu usuario ?>

    <!-- +++++ ETAPAS +++++ -->

    <div id="id_dialog_etapas" title="Etapas">

        <table id="id_tabla_dialog" width=100% style="display:none">
            <tr>
                <td width=100% align="center">
                    <img id="id_etapas_img" src="">
                </td>
            </tr>
            <tr>
                <td>
                    <div class="cuadro_titulo_class" style="height:250px;">
                        <h4 class="viewport_title"> Historial </h4>
                           <div id="id_div_tabla_direcciones" class="viewport_div">
                               <table class="tablaviewport" >
                                   <thead>
                                       <tr>
                                           <th>Fecha</th><th>Etapa</th><th>Usuario</th><th>Estatus</th><th>Comentario</th>
                                       </tr>
                                   </thead>
                                   <tbody id="id_historico_tr">
                                   </tbody>
                               </table>
                           </div>
                     </div>
                </td>
            </tr>
        </table>

    </div>

    <script type="text/javascript">
    $(document).ready(function()
    {
        $("#id_dialog_etapas").dialog({modal:true,height:510,width:850,autoOpen:false,show:"fade",hide:"fade"});
        $("#id_dialog_etapas").on('dialogclose',function(event){$("#id_historico_tr").html('');});
    });
    </script>

</html>
