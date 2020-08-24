<?php
    include 'funciones/funciones.php';
    include 'funciones/funciones_usuarios.php';
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
        <script language="JavaScript" type="text/javascript" src="js/funciones_usuarios.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php tab_icon(); ?>
        <script type="text/javascript">
            var perfiles=null;
            var tipodepto=null;
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
                                <div id="id_div_tabla_datos">
                                    <p><h3 style="color:lightgrey;">Usuarios</h3></p>
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
            carga_tabla();
            perfiles=carga_perfiles();
            tipodepto=carga_tipodepto();
        });
    </script>

    <!-- --------------- DIALOGOS --------------- -->

    <!-- +++++ LOADING +++++ -->

    <div id='loadingmessage' class="loader" ></div>

    <!-- +++++ CAMBIA CONTRASEÑA +++++ -->

    <?php dialogoContraseña() // y eventos click del menu usuario ?>

    <!-- +++++ USUARIOS +++++ -->

    <div id="id_dialog_usuarios" title="Usuario">

        <table id="id_tabla_usuarios" width=100% style="display:none">
            <tr>
                <td width=100% align="center" colspan="2">
                    <img src="img/baseline_account_circle_black_48dp.png">
                </td>
            </tr>
            <tr>
                <td>Usuario</td><td><input id="id_dialog_usuarios_usuario" type="text" placeholder="usuario universal" style="width:16em;" maxlength="8" ></td>
            </tr>
            <tr>
                <td>Nombre</td><td><input id="id_dialog_usuarios_nombre" type="text" placeholder="nombre completo" style="width:16em;" maxlength="60"></td>
            </tr>
            <tr>
                <td>Departamento</td><td><input id="id_dialog_usuarios_departamento" type="text" placeholder="departamento" placeholder="" style="width:16em;" maxlength="70"></td>
            </tr>
            <tr>
                <td>Correo</td><td><input id="id_dialog_usuarios_correo" type="text" placeholder="correo@telcel.com" style="width:16em;" maxlength="40"></td>
            </tr>
            <tr>
                <td>Extensión</td><td><input id="id_dialog_usuarios_extension" type="text" placeholder="0000" style="width:16em;" maxlength="4"></td>
            </tr>
            <tr>
                <td>Perfil</td><td><select id="id_dialog_usuarios_perfil" style="width:17em;"></select></td>
            </tr>
            <tr>
                <td>Tipo depto</td><td><select id="id_dialog_usuarios_tipodepto" style="width:17em;"></select></td>
            </tr>
            <tr>
                <td>Nivel notificación</td><td><select id="id_dialog_usuarios_notificacion" style="width:17em;" ><option value=1>1</option><option value=2>2</option><option value=3>3</option></select></td>
            </tr>
            <tr>
                <td>Contraseña</td><td><input id="id_dialog_usuarios_password_1" type="password" placeholder="8 a 15 caracteres" style="width:16em;" maxlength="15"></td>
            </tr>
            <tr>
                <td>Contraseña</td><td><input id="id_dialog_usuarios_password_2" type="password" placeholder="8 a 15 caracteres" style="width:16em;" maxlength="15"></td>
            </tr>
        </table>

    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#id_dialog_usuarios_perfil").html(genera_select_perfiles());
            //$("#id_dialog_usuarios_tipodepto").html(genera_select_tipodepto());
            $("#id_dialog_usuarios_tipodepto").html('<option value=0>OTRO</option><option value=1>FINANZAS</option><option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option><option value=5>SAP</option>');
            $("#id_dialog_usuarios_perfil").on('change',function(){
                var opciones='';
                switch(Number($("#id_dialog_usuarios_perfil").val()))
                {
                    case 1: opciones='<option value=0>OTRO</option><option value=1>FINANZAS</option><option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option><option value=5>SAP</option>'; break;
                    case 2: opciones='<option value=0>OTRO</option><option value=1>FINANZAS</option><option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option><option value=5>SAP</option>'; break;
                    case 3: opciones='<option value=1>FINANZAS</option>'; break;
                    case 4: opciones='<option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option>'; break;
                    case 5: opciones='<option value=5>SAP</option>'; break;
                }
                $("#id_dialog_usuarios_tipodepto").html(opciones);
            });
            $("#id_dialog_usuarios").dialog(
            {
                modal:true,height:535,width:370,autoOpen:false,show:"fade",hide:"fade",
                open:function(e,ui)
                {
                    $("#id_tabla_usuarios").show();
                    $(this).keyup(function(e) {if (e.keyCode == 13) {$(this).parent().find(".ui-dialog-buttonpane button:eq(0)").trigger("click");}});
                },
                buttons:
                {
                    Aceptar:function()
                    {
                        var id=$(this).data('id');
                        var usuario=generajson(id);
                        if(usuario.validado)
                        {
                            switch (id)
                            {
                                case 0: //Sin selección(agregar)
                                    $.ajax({
                                        url:"ajax/ajax_usuarios.php",type:"POST",async:false,cache:false,dataType:"json",
                                        data:{accion:'agregar',ajx_datos:JSON.stringify(usuario)},
                                        success: function(result_json)
                                        {
                                            if(result_json.ejecutado==1){carga_tabla();alert("Usuario agregado");}
                                            else {alert(result_json.errormsg);}
                                        }
                                    });
                                    break;
                                default: // Modificar
                                    $.ajax({
                                        url:"ajax/ajax_usuarios.php",type:"POST",async:false,cache:false,dataType:"json",
                                        data:{accion:'modificar',ajx_datos:JSON.stringify(usuario),ajx_id:id},
                                        success: function(result_json)
                                        {
                                            if(result_json.ejecutado==1){carga_tabla();alert("Usuario modificado");}
                                            else {alert(result_json.errormsg);}
                                        }
                                    });
                                    break;
                            }
                            $(this).dialog("close");
                        }
                    },
                    Cancelar: function(){$(this).dialog("close");}
                }
            });
            $("#id_dialog_usuarios").on('dialogclose',function(event)
            {
                var valor=document.getElementById('id_dialog_usuarios_usuario'); valor.value=""; valor.style.backgroundColor="#F2F2F2";
                valor=document.getElementById('id_dialog_usuarios_nombre'); valor.value=""; valor.style.backgroundColor="#F2F2F2";
                valor=document.getElementById('id_dialog_usuarios_departamento'); valor.value=""; valor.style.backgroundColor="#F2F2F2";
                valor=document.getElementById('id_dialog_usuarios_correo'); valor.value=""; valor.style.backgroundColor="#F2F2F2";
                valor=document.getElementById('id_dialog_usuarios_extension'); valor.value=""; valor.style.backgroundColor="#F2F2F2";
                document.getElementById('id_dialog_usuarios_perfil').value=1;
                var tipodepto=document.getElementById('id_dialog_usuarios_tipodepto');tipodepto.innerHTML='<option value=0>OTRO</option><option value=1>FINANZAS</option><option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option><option value=5>SAP</option>';
                var notificacion=document.getElementById('id_dialog_usuarios_notificacion');notificacion.value=1;
                valor=document.getElementById('id_dialog_usuarios_password_1'); valor.value=""; valor.style.backgroundColor="#F2F2F2";
                valor=document.getElementById('id_dialog_usuarios_password_2'); valor.value=""; valor.style.backgroundColor="#F2F2F2";
            });
            $("#id_menu_crear").click(function()
            {
                $("#id_dialog_usuarios").dialog("option","title","Agregar usuario");
                $("#id_dialog_usuarios").data('id',0).dialog("open");
            });
            $("#id_menu_modificar").click(function()
            {
                var id=obtiene_datos_usuario();
                if(id){
                    $("#id_dialog_usuarios").dialog("option","title","Modificar usuario");
                    $("#id_dialog_usuarios").data('id',id).dialog("open");
                }
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
