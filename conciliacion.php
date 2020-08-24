<?php
    include 'funciones/funciones.php';
    include 'funciones/funciones_conciliacion.php';
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
        <script language="JavaScript" type="text/javascript" src="js/funciones_conciliacion.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php tab_icon(); ?>
        <script type="text/javascript">
            var pag=Number('<?php echo $pagina;?>');
        </script>
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
                <form id="id_form_detalles" action="conciliacion2.php" method="post">
                    <input type="text" id="id_form_detalles_tipo" name="tipo" style="display:none">
                    <input type="text" id="id_form_detalles_idventasdiarias" name="id" style="display:none">
                    <input type="text" id="id_form_detalles_fecha" name="fecha" style="display:none">
                    <input type="text" id="id_form_detalles_total" name="total" style="display:none">
                    <input type="text" id="id_form_detalles_faltan" name="faltan" style="display:none">
                    <input type="text" id="id_form_detalles_pagina" name="pagina" style="display:none">
                </form>
                <table>
                    <tr>
                        <td colspan="2">
                            <div class="viewport">
                                <div id="id_div_tabla_datos"></div>
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
            //Carga tabla
            $.ajax({
                url:"ajax/ajax_conciliacion.php",type:"POST",async:false,cache:false,
                data:{accion:'refresh',ajx_pagina:pag,ajx_buscar:''},
                success: function(result_html)
                {
                    $("#id_div_tabla_datos").html(result_html);
                }
            });
            //Menus
            $("#id_menu_exportar").click(function(){exportarCSV();});
        });
    </script>

    <!-- --------------- DIALOGOS --------------- -->

    <!-- +++++ LOADING +++++ -->

    <div id='loadingmessage' class="loader" ></div>

    <!-- +++++ CAMBIA CONTRASEÑA +++++ -->

    <?php dialogoContraseña() // y eventos click del menu usuario ?>

</html>
