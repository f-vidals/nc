<?php
    include 'funciones/funciones.php';
    include 'funciones/funciones_notificaciones.php';
    validaSesion();
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Notas de Crédito</title>
        <script language="JavaScript" type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/funciones_notificaciones.js"></script>
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
                        <td colspan="2" align="center">
                            <div class="viewport">
                                <div id="id_div_tabla_etapa1">
                                    <p><h3 style="color:lightgrey;">Notificaciones etapa 1 : Validación</h3></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <div class="viewport">
                                <div id="id_div_tabla_etapa2">
                                    <p><h3 style="color:lightgrey;">Notificaciones etapa 2 : Faltante</h3></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <div class="viewport">
                                <div id="id_div_tabla_etapa3">
                                    <p><h3 style="color:lightgrey;">Notificaciones etapa 3 : Corregido</h3></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td colspan="2" align="center">
                            <div class="viewport">
                                <div id="id_div_tabla_etapa4">
                                    <p><h3 style="color:lightgrey;">Notificaciones sin cambio de estado</h3></p>
                                </div>
                            </div>
                        </td>
                    </tr> -->
                </table>
            </div>

        </div>
    </body>

    <script type="text/javascript">
        $(document).ready(function()
        {
            carga_tabla_etapa(1);
            carga_tabla_etapa(2);
            carga_tabla_etapa(3);
            //carga_tabla_etapa(4);
            carga_usuarios();
        });
    </script>

    <!-- --------------- DIALOGOS --------------- -->

    <!-- +++++ LOADING +++++ -->

    <div id='loadingmessage' class="loader" ></div>

    <!-- +++++ CAMBIA CONTRASEÑA +++++ -->

    <?php dialogoContraseña(); // y eventos click del menu usuario ?>

    <!-- +++++ USUARIOS +++++ -->

    <div id="id_dialog_usuarios" title="Agregar Usuario">
        <div id="id_dialog_usuarios_tabla" style="padding:5px;">
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#id_dialog_usuarios").dialog(
            {
                modal:true,height:470,width:450,autoOpen:false,show:"fade",hide:"fade",
                open:function(e,ui)
                {
                    $("#id_tabla_add_usuario").show();
                    $(this).keyup(function(e) {if (e.keyCode == 13) {$(this).parent().find(".ui-dialog-buttonpane button:eq(0)").trigger("click");}});
                },
                buttons:
                {
                    Agregar:function()
                    {
                        var JSONnotificacion=$(this).data('notificacion');
                        var id_usr=Number($('#id_tabla_add_usuario input[name="grupo_todos_usuarios"]:checked').closest('tr').find("td:nth-child(1)").text());
                        if(id_usr==0){alert("Sin selección");}
                        else {
                            var encontrado=false;for(var i=0;i<JSONnotificacion.usuarios.length;i++){if(JSONnotificacion.usuarios[i]==id_usr){encontrado=true;break;}}
                            if(encontrado){alert("El usuario ya está asignado");}
                            else {
                                $.ajax({
                                    url:"ajax/ajax_notificaciones.php",type:"POST",async:false,cache:false,dataType:"json",
                                    data:{accion:'add_usuarios',ajx_id:id_usr,ajx_etapa:JSONnotificacion.etapa},
                                    success: function(result_json)
                                    {
                                        if(result_json.ejecutado==1){carga_tabla_etapa(JSONnotificacion.etapa);}
                                        else {alert(result_json.errormsg);}
                                    }
                                });
                                $(this).dialog("close");
                            }
                        }
                    },
                    Cancelar: function(){$(this).dialog("close");}
                }
            });
            $("#id_dialog_usuarios").on('dialogclose',function(event)
            {
                try {document.getElementById('id_tabla_add_usuario').querySelector('input[type=radio]:checked').checked=false;}
                catch(error){console.error(error);}
            });
        });
    </script>

    <!-- +++++ ELIMINAR +++++ -->

    <div id="id_dialog_eliminar" title="Eliminar Usuario">

        <table id="id_tabla_eliminar" width=100% style="display:none">
            <tr>
                <td width=100% align="center">
                    <img src="img/baseline_account_circle_black_48dp.png">
                </td>
            </tr>
            <tr><td></td></tr>
            <tr><td id="id_dialog_eliminar_usuario" align="center">usuario</td></tr>
            <tr><td id="id_dialog_eliminar_nombre" align="center">Nombre</td></tr>
        </table>

    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#id_dialog_eliminar").dialog(
            {
                modal:true,height:255,width:370,autoOpen:false,show:"fade",hide:"fade",
                open:function(e,ui)
                {
                    $("#id_tabla_eliminar").show();
                    $(this).keyup(function(e) {if (e.keyCode == 13) {$(this).parent().find(".ui-dialog-buttonpane button:eq(0)").trigger("click");}});
                },
                buttons:
                {
                    Eliminar:function()
                    {
                        var id=$(this).data('id');
                        $.ajax({
                            url:"ajax/ajax_usuarios.php",type:"POST",async:false,cache:false,dataType:"json",
                            data:{accion:'eliminar',ajx_id:id},
                            success: function(result_json)
                            {
                                if(result_json.ejecutado==1){carga_tabla();alert("Usuario eliminado");}
                                else {alert(result_json.errormsg);}
                            }
                        });
                        $(this).dialog("close");
                    },
                    Cancelar: function(){$(this).dialog("close");}
                }
            });
            $("#id_menu_eliminar").click(function()
            {
                var tabla=document.getElementById('id_tabla_datos');
                var inputelement=tabla.querySelector('input[type=radio]:checked');
                if(inputelement==null){
                    alert("Debe seleccionar un usuario");
                }
                else {
                    var row=inputelement.parentElement.parentElement;
                    var id=Number(row.cells.item(0).innerText);
                    $("#id_dialog_eliminar_usuario").html('<b>'+row.cells.item(2).innerText+'</b>');
                    $("#id_dialog_eliminar_nombre").html(row.cells.item(5).innerText);
                    $("#id_dialog_eliminar").data('id',id).dialog("open");
                }
            });
        });
    </script>

</html>
