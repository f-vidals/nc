function carga_tabla_etapa(etapa)
{
    $.ajax({
        url:"ajax/ajax_notificaciones.php",type:"POST",async:false,cache:false,
        data:{accion:'refresh',ajx_etapa:etapa},
        success: function(result_html){$("#id_div_tabla_etapa"+etapa).html(result_html);}
    });
}
function carga_usuarios()
{
    $.ajax({
        url:"ajax/ajax_notificaciones.php",type:"POST",async:false,cache:false,
        data:{accion:'get_usuarios'},
        success: function(result_html){$("#id_dialog_usuarios_tabla").html(result_html);}
    });
}
function agregar(etapa)
{
    // {"etapa":1,"usuarios":[1,2,3]}
    var notificacion={};
    notificacion.etapa=etapa;
    notificacion.usuarios=new Array();
    var tabla=document.getElementById('id_tabla_datos_etapa'+etapa);
    for (var i=1 ; i<tabla.rows.length; i++)
    {
        var tabla_id=Number(tabla.rows[i].cells[0].innerHTML);
        notificacion.usuarios.push(tabla_id)
    }
    $("#id_dialog_usuarios").data("notificacion",notificacion).dialog("open");
}
function quitar(etapa)
{
    var id_usr=Number($('#id_tabla_datos_etapa'+etapa+' input[name="grupo1"]:checked').closest('tr').find("td:nth-child(1)").text());
    if(id_usr!=0)
    {
        $.ajax({
            url:"ajax/ajax_notificaciones.php",type:"POST",async:false,cache:false,dataType:"json",
            data:{accion:'del_usuarios',ajx_id:id_usr,ajx_etapa:etapa},
            success: function(result_json)
            {
                if(result_json.ejecutado==1){carga_tabla_etapa(etapa);}
                else {alert(result_json.errormsg);}
            }
        });
    }
}
function filtrar(obj,etapa)
{
    var filtros=new Array();
    var renglon=obj.parentElement.parentElement;
    filtros[0]=new RegExp( String(renglon.children[0].querySelector('input[type=text]').value) ,'i');   //filtroUsuario
    filtros[1]=new RegExp( String(renglon.children[1].querySelector('input[type=text]').value) ,'i');   //filtroNombre
    filtros[2]=new RegExp( String(renglon.children[2].querySelector('input[type=text]').value) ,'i');   //filtroPerfil
    filtros[3]=new RegExp( String(renglon.children[3].querySelector('input[type=text]').value) ,'i');   //filtroCorreo
    filtros[4]=new RegExp( String(renglon.children[4].querySelector('input[type=text]').value) ,'i');   //filtroNivel

    var objTable=document.getElementById("id_tabla_datos_etapa"+etapa);
    var strtmp="";

    for (var i=1 ; i<objTable.rows.length; i++)
    {
        var mostrar=true;
        //Filtro usuario
        strtmp=objTable.rows[i].cells[1].innerHTML;
        var busqueda=strtmp.search(filtros[0]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro nombre
        strtmp=objTable.rows[i].cells[2].innerHTML;
        busqueda=strtmp.search(filtros[1]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro perfil
        strtmp=objTable.rows[i].cells[3].children[0].innerHTML;
        busqueda=strtmp.search(filtros[2]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro Correo
        strtmp=objTable.rows[i].cells[4].innerHTML;
        busqueda=strtmp.search(filtros[3]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro Nivel
        strtmp=objTable.rows[i].cells[5].innerHTML;
        busqueda=strtmp.search(filtros[4]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //muestra / oculta
        objTable.rows[i].style.display=(mostrar)?'':'none';
    }
}
function filtraradd(obj)
{
    var filtros=new Array();
    var renglon=obj.parentElement.parentElement;
    filtros[0]=new RegExp( String(renglon.children[0].querySelector('input[type=text]').value) ,'i');   //filtroUsuario
    filtros[1]=new RegExp( String(renglon.children[1].querySelector('input[type=text]').value) ,'i');   //filtroNombre
    filtros[2]=new RegExp( String(renglon.children[2].querySelector('input[type=text]').value) ,'i');   //filtroNivel

    var objTable=document.getElementById("id_tabla_add_usuario");
    var strtmp="";

    for (var i=1 ; i<objTable.rows.length; i++)
    {
        var mostrar=true;
        //Filtro usuario
        strtmp=objTable.rows[i].cells[1].innerHTML;
        var busqueda=strtmp.search(filtros[0]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro nombre
        strtmp=objTable.rows[i].cells[2].innerHTML;
        busqueda=strtmp.search(filtros[1]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro Nivel
        strtmp=objTable.rows[i].cells[3].innerHTML;
        busqueda=strtmp.search(filtros[2]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //muestra / oculta
        objTable.rows[i].style.display=(mostrar)?'':'none';
    }
}
