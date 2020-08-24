<?php
    include 'funciones/funciones.php';
    include 'funciones/funciones_conciliacion2.php';
    validaSesion();
    $tipo=$_POST['tipo']; # 1. ventas vs 5archivos  ,  2. 5archivos vs SAP
    $id_ventasdiarias=$_POST['id'];
    $fecha=$_POST['fecha'];
    $total=$_POST['total'];
    $faltan=$_POST['faltan']; //Ventas faltan #
    $pagina=$_POST['pagina'];
    $etapasPermisos=($tipo==1)?$_SESSION['perfil']['conciliacion1etapapermiso']:$_SESSION['perfil']['conciliacion2etapapermiso']; // Permiso del perfil en cada etapa
    $deptotipo=$_SESSION['deptotipo'];
    $id_perfil=$_SESSION['id_perfil'];
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Notas de Crédito</title>
        <script language="JavaScript" type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones_conciliacion2.js"></script>
        <script type="text/javascript" src="js/fusioncharts.js"></script>
        <script type="text/javascript" src="js/themes/fusioncharts.theme.fusion.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php tab_icon(); ?>
        <script type="text/javascript">
            var tipo=Number('<?php echo $tipo;?>');
            var id=Number('<?php echo $id_ventasdiarias;?>');
            var fecha='<?php echo $fecha;?>';
            var total=Number('<?php echo $total;?>');
            var faltan=Number('<?php echo $faltan;?>');
            var etapasEstatus=null;
            var etapasPermisos='<?php echo $etapasPermisos; ?>';
            var pag=Number('<?php echo $pagina;?>'); // Para menu regresar muestre la página en donde estaba
            var deptotipo=Number('<?php echo $deptotipo;?>'); //Tipo de departamento
            var idperfil=Number('<?php echo $id_perfil;?>');
        </script>
    </head>

    <body class="body_class">

        <!-- --------------- ENCABEZADO --------------- -->
        <div class="top_class">
            <?php encabezado($tipo); ?>
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
                        <td>
                            <div class="viewport">
                                <div id="id_div_tabla_titulo"></div>
                            </div>
                        </td>
                        <td rowspan="2">
                            <div class="viewport">
                                <div id="chart-container-1"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="viewport">
                                <div id="id_div_tabla_fecha"></div>
                            </div>
                        </td>
                    </tr>
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
            //Menus
            $("#id_menu_todo").click(function(){seleccionarTodo();});
            $("#id_menu_des").click(function(){DesseleccionarTodo();});
            $("#id_menu_rango").click(function(){seleccionarRango();});
            $("#id_menu_exportar").click(function(){exportarCSV();});

            recarga_grafica(total,faltan);      // Carga viewport tabla
            carga_titulo(tipo,total);           // Carga viewport título
            carga_fecha(fecha);                 // Carga viewport fecha
            recarga_tabla(tipo,id);             // Carga viewport tabla
            etapasEstatus=carga_estatus(tipo);  // Carga estatus disponibles para el combo al cambiar de estado
        });

    </script>

    <!-- --------------- DIALOGOS --------------- -->

    <!-- +++++ LOADING +++++ -->

    <div id="loadingmessage" class="loader"></div>

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
            $("#id_dialog_etapas").dialog({modal:true,height:510,width:850,autoOpen:false,show:"fade",hide:"fade",open:function(){$("#id_tabla_dialog").show();}});
            $("#id_dialog_etapas").on('dialogclose',function(event){$("#id_historico_tr").html('');});
        });
    </script>

    <!-- +++++ CAMBIA ETAPA +++++ -->

    <div id="id_dialog_etapas_to" title="">

        <table width=100% id="id_tabla_dialog_to" style="display:none">
            <tr>
                <td>
                    Estatus:
                </td>
                <td>
                    <select id="id_dialog_etapas_to_estatus" style="width:23em;">
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Comentario:
                </td>
                <td>
                    <textarea id="id_dialog_etapas_to_comentario" style="width:22em;" rows="3" cols="34" maxlength="100" placeholder="Opcional, max 100 caracteres"></textarea>
                </td>
            </tr>
        </table>

    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#id_dialog_etapas_to").dialog(
            {
                modal:true,height:240,width:440,autoOpen:false,show:"fade",hide:"fade",
                open:function()
                {$("#id_tabla_dialog_to").show();$("#id_dialog_etapas_to_comentario").show();},
                buttons:
                {
                    Aceptar: function()
                    {
                        var jsonDatos=$(this).data('jsonDatos');
                        jsonDatos.comentario=sanear($("#id_dialog_etapas_to_comentario").val());
                        jsonDatos.idestatus=Number($("#id_dialog_etapas_to_estatus").val());
                        if(jsonDatos.idestatus!=0)
                        {
                            $.ajax({
                                url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,dataType:"json",
                                data:{ajx_accion:'cambiaestado',ajx_jsonDatos:JSON.stringify(jsonDatos),ajx_faltan:faltan,ajx_id:id,ajx_tipo:tipo},
                                success: function(result_json)
                                {
                                    if(result_json.ejecutado==1)
                                    {
                                        recarga_tabla(tipo,id);
                                        if(result_json.etapa==4)
                                        {
                                            faltan=result_json.faltan;
                                            recarga_grafica(total,faltan);
                                        }
                                    }
                                    else {alert(result_json.errorMSG);}
                                }
                            });
                        }
                        else {alert("Error: No se selecciono estatus");}
                        $(this).dialog("close");
                    },
                    Cancelar: function(){$(this).dialog("close");}
                }
            });
            $("#id_dialog_etapas_to").on('dialogclose',function(event)
            {
                $("#id_dialog_etapas_to_estatus").html("");
                $("#id_dialog_etapas_to_comentario").val("");
            });
            $("[name=menu_estado]").click(function()
            {
                // id_menu_1_2   (id_menu_conciliacion1_aEtapa2)
                var arr=$(this).attr('id').split("_");
                var tipo=Number(arr[2]);
                var etapaNueva=Number(arr[3]);
                var titulo="";
                switch (tipo) {
                    case 1:
                        switch (etapaNueva) {
                            case 2: titulo="Cambiar etapa a Faltante";  break;
                            case 3: titulo="Cambiar etapa a Corregido"; break;
                            case 4: titulo="Cambiar etapa a Procesado"; break;
                            case 5: titulo="Regresar etapa";            break;
                        }
                        break;
                    case 2:
                        switch (etapaNueva) {
                            case 2: titulo="Cambiar etapa a Faltante";  break;
                            case 3: titulo="Cambiar etapa a Corregido"; break;
                            case 4: titulo="Cambiar etapa a Procesado"; break;
                            case 5: titulo="Regresar a estado";         break;
                        }
                }
                jsonDatos=generaJSONtabla(tipo,etapaNueva);
                if(jsonDatos.error){alert("Error : "+jsonDatos.errormsg);return;}
                $("#id_dialog_etapas_to_estatus").html(generaSelectEstatus(jsonDatos.etapaactual,jsonDatos.etapanueva,etapasEstatus));
                $("#id_dialog_etapas_to").dialog("option","title",titulo);
                $("#id_dialog_etapas_to").data('jsonDatos',jsonDatos).dialog("open");
            });
        });
    </script>

    <!-- +++++ SEGUIMIENTO +++++ -->

    <div id="id_dialog_seguimiento" title="">

        <table width=100% id="id_tabla_dialog_seguimiento" style="display:none">
            <tr>
                <td>
                    Estatus:
                </td>
                <td>
                    <select id="id_dialog_seguimiento_estatus" style="width:23em;">
                    </select>
                </td>
            </tr>
            <tr id="id_dialog_seguimiento_tr" style="display:none">
                <td>
                    Departamento:
                </td>
                <td>
                    <select id="id_dialog_seguimiento_departamento" style="width:23em;">
                        <option value=2>SPOS</option>
                        <option value=3>FACTURACION</option>
                        <option value=4>SISACT</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Comentario:
                </td>
                <td>
                    <textarea id="id_dialog_seguimiento_comentario" style="width:22em;" rows="3" cols="34" maxlength="100" placeholder="Opcional, max 100 caracteres"></textarea>
                </td>
            </tr>
        </table>

    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#id_dialog_seguimiento").dialog(
            {
                modal:true,height:270,width:440,autoOpen:false,show:"fade",hide:"fade",
                open:function()
                {$("#id_tabla_dialog_seguimiento").show();},
                buttons:
                {
                    Aceptar: function()
                    {
                        var jsonDatos=$(this).data('jsonDatos');
                        jsonDatos.idtipodepto=Number($("#id_dialog_seguimiento_departamento").val());
                        jsonDatos.idestatus=Number($("#id_dialog_seguimiento_estatus").val());
                        jsonDatos.comentario=sanear($("#id_dialog_seguimiento_comentario").val());
                        if(jsonDatos.idestatus!=0)
                        {
                            switch(jsonDatos.seguimiento)
                            {
                                case "reasignar":
                                    $.ajax({
                                        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,dataType:"json",
                                        data:{ajx_accion:'cambiaasignacion',ajx_jsonDatos:JSON.stringify(jsonDatos),ajx_id:id,ajx_tipo:tipo},
                                        success: function(result_json)
                                        {
                                            if(result_json.ejecutado==1)
                                            {
                                                recarga_tabla(tipo,id);
                                            }
                                            else {alert(result_json.errorMSG);}
                                        }
                                    });
                                    break;
                                case "comentar":
                                    $.ajax({
                                        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,dataType:"json",
                                        data:{ajx_accion:'comentar',ajx_jsonDatos:JSON.stringify(jsonDatos),ajx_id:id,ajx_tipo:tipo},
                                        success: function(result_json)
                                        {
                                            if(result_json.ejecutado==1)
                                            {
                                                DesseleccionarTodo();
                                            }
                                            else{alert(result_json.errorMSG);}
                                        }
                                    });
                                    break;
                            }
                        }
                        else {alert("Error: No se selecciono estatus");}
                        $(this).dialog("close");
                    },
                    Cancelar: function(){$(this).dialog("close");}
                }
            });
            $("#id_dialog_seguimiento").on('dialogclose',function(event)
            {
                $("#id_dialog_seguimiento_tr").hide();
                $("#id_dialog_seguimiento_estatus").html("");
                $("#id_dialog_seguimiento_comentario").val("");
            });
            $("#id_menu_reasignar").click(function()
            {
                jsonDatos=generaJSONseguimiento(tipo);
                jsonDatos.seguimiento="reasignar";
                if(jsonDatos.error){alert("Error : "+jsonDatos.errormsg);return;}
                if(jsonDatos.etapaactual!=2){alert("Error : Reasignación solo permitida en etapa Faltante");return;}
                $("#id_dialog_seguimiento_estatus").html("<option value=3>Reasignado</option>");
                $("#id_dialog_seguimiento_tr").show();
                $("#id_dialog_seguimiento").dialog("option","title","Reasignar");
                $("#id_dialog_seguimiento").data('jsonDatos',jsonDatos).dialog("open");
            });
            $("#id_menu_comentar").click(function()
            {
                jsonDatos=generaJSONseguimiento(tipo);
                jsonDatos.seguimiento="comentar";
                if(jsonDatos.error){alert("Error : "+jsonDatos.errormsg);return;}
                $("#id_dialog_seguimiento_estatus").html("<option value=2>Comentario</option>");
                $("#id_dialog_seguimiento").dialog("option","title","Comentar");
                $("#id_dialog_seguimiento").data('jsonDatos',jsonDatos).dialog("open");
            });
        });
    </script>

    <!-- +++++ CAMBIA CONTRASEÑA +++++ -->

    <?php dialogoContraseña() // y eventos click del menu usuario ?>

</html>
