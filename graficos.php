<?php
    include 'funciones/funciones.php';
    include 'funciones/funciones_graficos.php';
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
        <link rel="stylesheet" type="text/css" href="js/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="js/fusioncharts.js"></script>
        <script type="text/javascript" src="js/themes/fusioncharts.theme.fusion.js"></script>
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
                <?php
                //if($_SESSION['perfil']['detallesseleccion'])
                if(True)
                {
                    echo '<tr>';
                    echo     '<td colspan="2">';
                    echo         '<div class="viewport">';
                    echo             '<div id="chart-container-1"></div>';
                    echo         '</div>';
                    echo      '</td>';
                    echo '</tr>';
                }
                ?>
                    <tr>
                        <td colspan="1">
                            <div class="viewport">
                                <div id="chart-container-2">
                            </div>
                        </td>
                        <td colspan="1">
                            <div class="viewport">
                                <div id="chart-container-3">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    <body>

    <script type="text/javascript">
        FusionCharts.ready(function()
        {
            var myChart1 = new FusionCharts(
            {
                type: "spline",
                renderAt: "chart-container-1",
                width: "1100",
                height: "390",
                dataSource: "json/datossemanales.json",
                dataFormat: "jsonurl"
            }).render();
            var myChart2 = new FusionCharts(
            {
                type: 'column2d',
                renderAt: 'chart-container-2',
                width: '600',
                height: '390',
                dataSource:"json/datosmensuales.json",
                dataFormat: 'jsonurl'
            }).render();
            var myChart3 = new FusionCharts(
            {
                type: 'column2d',
                renderAt: 'chart-container-3',
                width: '600',
                height: '390',
                dataSource:"json/datosanuales.json",
                dataFormat: 'jsonurl'
            }).render();
      });
   </script>

    <!-- --------------- DIALOGOS --------------- -->

    <!-- +++++ LOADING +++++ -->

    <div id='loadingmessage' class="loader" ></div>

    <!-- +++++ CAMBIA CONTRASEÑA +++++ -->

    <?php dialogoContraseña() // y eventos click del menu usuario ?>

</html>
