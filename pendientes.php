<?php
    include 'funciones/funciones.php';
    include 'funciones/funciones_pendientes.php';
    validaSesion();
    $etapasPermisos1=$_SESSION['perfil']['conciliacion1etapapermiso'];
    $etapasPermisos2=$_SESSION['perfil']['conciliacion2etapapermiso']; // Permiso del perfil en cada etapa
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Notas de Crédito</title>
        <script language="JavaScript" type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones_pendientes.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php tab_icon(); ?>
        <script type="text/javascript">
            var etapasEstatus=[];
            var etapasPermisos=[];
            etapasPermisos[1]='<?php echo $etapasPermisos1; ?>';
            etapasPermisos[2]='<?php echo $etapasPermisos2; ?>';
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
                <table>
                    <tr>
                        <td colspan="2">
                            <div class="viewport">
                                <div id="id_div_tabla_datos_1">
                                    <p><h3 style="color:lightgrey;">Pendientes Ventas VS 5archivos</h3></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="viewport">
                                <div id="id_div_tabla_datos_2">
                                    <p><h3 style="color:lightgrey;">Pendientes 5archivos VS SAP</h3></p>
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
                //Menus
                $("#id_menu_todo_1").click(function(){seleccionarTodo(1);});
                $("#id_menu_todo_2").click(function(){seleccionarTodo(2);});
                $("#id_menu_des_1").click(function(){DesseleccionarTodo(1);});
                $("#id_menu_des_2").click(function(){DesseleccionarTodo(2);});
                $("#id_menu_rango_1").click(function(){seleccionarRango(1);});
                $("#id_menu_rango_2").click(function(){seleccionarRango(2);});
                $("#id_menu_exportar_1").click(function(){exportarCSV(1);});
                $("#id_menu_exportar_2").click(function(){exportarCSV(2);});
                recarga_tabla(2,1);             // Carga viewport tabla (conciliacion2,pagina1)
                recarga_tabla(1,1);             // Carga viewport tabla (conciliacion1,pagina1)
                etapasEstatus[1]=carga_estatus(1);  // Carga estatus disponibles para el combo al cambiar de estado
                etapasEstatus[2]=carga_estatus(2);  // Carga estatus disponibles para el combo al cambiar de estado
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
        $("#id_dialog_etapas").dialog(
        {
            modal:true,height:510,width:850,autoOpen:false,show:"fade",hide:"fade",
            open:function(){$("#id_tabla_dialog").show();}
        });
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
                                url:"ajax/ajax_pendientes.php",type:"POST",async:false,cache:false,dataType:"json",
                                data:{ajx_accion:'cambiaestado',ajx_jsonDatos:JSON.stringify(jsonDatos)},
                                success: function(result_json)
                                {
                                    if(result_json.ejecutado==1)
                                    {
                                        recarga_tabla(jsonDatos.tipo,1);
                                        alert("Movido a etapa "+ ((jsonDatos.etapanueva==5)?jsonDatos.idestatus:jsonDatos.etapanueva) );
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
                tipo=Number(arr[2]);
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
                        break;
                }
                jsonDatos=generaJSONtabla(tipo,etapaNueva);
                if(jsonDatos.error){alert("Error : "+jsonDatos.errormsg);return;}
                $("#id_dialog_etapas_to_estatus").html(generaSelectEstatus(jsonDatos.etapaactual,jsonDatos.etapanueva,etapasEstatus[tipo]));
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
                                        data:{ajx_accion:'cambiaasignacion',ajx_jsonDatos:JSON.stringify(jsonDatos),ajx_id:0,ajx_tipo:jsonDatos.tipo},
                                        success: function(result_json)
                                        {
                                            if(result_json.ejecutado==1){recarga_tabla(jsonDatos.tipo,1);alert("Reasignado");}
                                            else {alert(result_json.errorMSG);}
                                        }
                                    });
                                    break;
                                case "comentar":
                                    $.ajax({
                                        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,dataType:"json",
                                        data:{ajx_accion:'comentar',ajx_jsonDatos:JSON.stringify(jsonDatos),ajx_id:0,ajx_tipo:jsonDatos.tipo},
                                        success: function(result_json)
                                        {
                                            if(result_json.ejecutado==1){DesseleccionarTodo(jsonDatos.tipo);}
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
            $("[name=menu_seguimiento]").click(function()
            {
                // id_menu_reasignar_1   (reasignar,conciliacion1)
                var arr=$(this).attr('id').split("_");
                var menu=arr[2];
                var tipo=Number(arr[3]);
                jsonDatos=generaJSONseguimiento(tipo);
                switch (menu) {
                    case "reasignar":
                        jsonDatos.seguimiento="reasignar";
                        if(jsonDatos.error){alert("Error : "+jsonDatos.errormsg);return;}
                        if(jsonDatos.etapaactual!=2){alert("Error : Reasignación solo permitida en etapa Faltante");return;}
                        $("#id_dialog_seguimiento_estatus").html("<option value=3>Reasignado</option>");
                        $("#id_dialog_seguimiento").dialog("option","title","Reasignar");
                        $("#id_dialog_seguimiento_tr").show();
                        break;
                    case "comentar":
                        jsonDatos.seguimiento="comentar";
                        if(jsonDatos.error){alert("Error : "+jsonDatos.errormsg);return;}
                        $("#id_dialog_seguimiento_estatus").html("<option value=2>Comentario</option>");
                        $("#id_dialog_seguimiento").dialog("option","title","Comentar");
                        break;
                }
                $("#id_dialog_seguimiento").data('jsonDatos',jsonDatos).dialog("open");
            });
        });
    </script>

</html>
