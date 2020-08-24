function carga_tabla()
{
    $.ajax({
        url:"ajax/ajax_usuarios.php",type:"POST",async:false,cache:false,
        data:{accion:'refresh'},
        success: function(result_html){$("#id_div_tabla_datos").html(result_html);}
    });
}
function carga_perfiles() //carga pefiles para el combo
{
    var pefiles;
    $.ajax({
        url:"ajax/ajax_usuarios.php",type:"POST",async:false,cache:false,dataType:"json",
        data:{accion:'obtienePerfiles'},
        success: function(result_json)
        {
            if(result_json.ejecutado==1){perfiles=result_json.perfiles;}
            else {alert(result_json.errormsg);}
        }
    });
    return perfiles;
    /*
    [{"id":1,"nombre":"administrador"},{"id":2,"nombre":"vista"},{"id":3,"nombre":"validacion"},{"id":4,"nombre":"corrección"},{"id":5,"nombre":"revision"}]
    */
}
function carga_tipodepto() //carga tipo de departamento para el combo (se utiliza para clasificar las notificaciones)
{
    var tipos;
    $.ajax({
        url:"ajax/ajax_usuarios.php",type:"POST",async:false,cache:false,dataType:"json",
        data:{accion:'obtieneTipoDepto'},
        success: function(result_json)
        {
            if(result_json.ejecutado==1){tipos=result_json.tipos;}
            else {alert(result_json.errormsg);}
        }
    });
    return tipos;
    /*
    [{"id":0,"tipo":"OTRO"},{"id":1,"tipo":"SPOS"},{"id":2,"tipo":"FACTURACION"},{"id":3,"tipo":"SISACT"}]
    */
}
function genera_select_perfiles()
{
    var row="";
    for(var i=0; i<perfiles.length; i++)
    {
        row += '<option value='+perfiles[i].id+'>'+perfiles[i].nombre+'</option>';
    }
    return row;
}
function genera_select_tipodepto()
{
    var row="";
    for(var i=0; i<tipodepto.length; i++)
    {
        row += '<option value='+tipodepto[i].id+'>'+tipodepto[i].tipo+'</option>';
    }
    return row;
}
function validar_usuario(valor)
{
    var patt=/^([a-z0-9]){7,8}$/;
    if(!patt.test( valor.value.trim().toLowerCase() ) )
    {valor.style.backgroundColor="#FF6600";return false;}
    else{valor.style.backgroundColor="#F2F2F2";return true;}
}
function validar_nombre(valor)
{
    var patt=/^[a-zA-Z\sñÑáéíóú]{3,60}$/;
    if(!patt.test(valor.value.trim().toLowerCase()))
    {valor.style.backgroundColor="#FF6600";return false;}
    else{valor.style.backgroundColor="#F2F2F2";return true;}
}
function validar_departamento(valor)
{
    var patt=/^([a-zA-Z\sñÑáéíóú&\._\-\(\)0-9])*$/;
    if(!patt.test(valor.value.trim().toLowerCase()))
    {valor.style.backgroundColor="#FF6600";return false;}
    else{valor.style.backgroundColor="#F2F2F2";return true;}
}
function validar_correo(valor)
{
    var patt=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,4})$/;
    if(!patt.test(valor.value.trim().toLowerCase()))
    {valor.style.backgroundColor="#FF6600";return false;}
    else{valor.style.backgroundColor="#F2F2F2";return true;}
}
function validar_extension(valor)
{
    var patt=/^([0-9]){4}$/;
    if(!patt.test(valor.value) && valor.value.length>0)
    {valor.style.backgroundColor="#FF6600";return false;}
    else{valor.style.backgroundColor="#F2F2F2";return true;}
}
function validar_password(valor1,valor2)
{
    var patt=/^(?=.*\d)(?=.*[A-Z])(?!.*(.)\1)\S{8,15}$/;
    if(valor1.value!=valor2.value || !patt.test(valor1.value))
    {valor1.style.backgroundColor="#FF6600";valor2.style.backgroundColor="#FF6600";return false;}
    else{valor1.style.backgroundColor="#F2F2F2";valor2.style.backgroundColor="#F2F2F2";return true;}
}
function generajson(id)
{
    var valida=true;
    var usuario={};
    usuario.usuario=document.getElementById('id_dialog_usuarios_usuario');
    usuario.nombre=document.getElementById('id_dialog_usuarios_nombre');
    usuario.departamento=document.getElementById('id_dialog_usuarios_departamento');
    usuario.correo=document.getElementById('id_dialog_usuarios_correo');
    usuario.extension=document.getElementById('id_dialog_usuarios_extension');
    usuario.perfil=Number(document.getElementById('id_dialog_usuarios_perfil').value);
    usuario.tipodepto=Number(document.getElementById('id_dialog_usuarios_tipodepto').value);
    usuario.notificacion=Number(document.getElementById('id_dialog_usuarios_notificacion').value);
    usuario.password1=document.getElementById('id_dialog_usuarios_password_1');
    usuario.password2=document.getElementById('id_dialog_usuarios_password_2');
    usuario.validado=false;
    valida=valida & validar_usuario(usuario.usuario);
    valida=valida & validar_nombre(usuario.nombre);
    valida=valida & validar_departamento(usuario.departamento);
    valida=valida & validar_correo(usuario.correo);
    valida=valida & validar_extension(usuario.extension);
    if(id==0 || usuario.password1.value !="..............." || usuario.password2.value !="..............."){valida=valida & validar_password(usuario.password1,usuario.password2);}
    if(valida)
    {
        usuario.usuario=usuario.usuario.value.trim().toLowerCase();
        usuario.nombre=capital_letter(usuario.nombre.value.trim().toLowerCase());
        usuario.departamento=usuario.departamento.value.trim().toUpperCase();
        usuario.correo=usuario.correo.value.trim().toLowerCase();
        usuario.extension=usuario.extension.value;
        usuario.password1=usuario.password1.value;
        usuario.password2=usuario.password1.value;
    }
    usuario.validado=valida;
    return usuario;
}
function obtiene_datos_usuario()
{
    var id=0;
    var tabla=document.getElementById('id_tabla_datos');
    var inputelement=tabla.querySelector('input[type=radio]:checked');
    if(inputelement==null){
        alert("Debe seleccionar un usuario");
    }
    else {
        var row=inputelement.parentElement.parentElement;
        id=Number(row.cells.item(0).innerText);
        document.getElementById('id_dialog_usuarios_usuario').value=row.cells.item(2).innerText;
        document.getElementById('id_dialog_usuarios_nombre').value=row.cells.item(5).innerText;
        document.getElementById('id_dialog_usuarios_departamento').value=row.cells.item(6).innerText;
        document.getElementById('id_dialog_usuarios_correo').value=row.cells.item(7).innerText;
        document.getElementById('id_dialog_usuarios_extension').value=row.cells.item(8).innerText;
        var perfil=Number(row.cells.item(3).innerText);
        document.getElementById('id_dialog_usuarios_perfil').value=perfil;
        var opciones="";
        switch(perfil)
        {
            case 1: opciones='<option value=0>OTRO</option><option value=1>FINANZAS</option><option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option><option value=5>SAP</option>'; break;
            case 2: opciones='<option value=0>OTRO</option><option value=1>FINANZAS</option><option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option><option value=5>SAP</option>'; break;
            case 3: opciones='<option value=1>FINANZAS</option>'; break;
            case 4: opciones='<option value=2>SPOS</option><option value=3>FACTURACION</option><option value=4>SISACT</option>'; break;
            case 5: opciones='<option value=5>SAP</option>'; break;
        }
        var select_tipo=document.getElementById('id_dialog_usuarios_tipodepto');
        select_tipo.innerHTML=opciones;
        select_tipo.value=Number(row.cells.item(10).innerText);
        document.getElementById('id_dialog_usuarios_notificacion').value=Number(row.cells.item(11).innerText);
        document.getElementById('id_dialog_usuarios_password_1').value="...............";
        document.getElementById('id_dialog_usuarios_password_2').value="...............";
    }
    return id;
}
function filtrar(obj)
{
    var filtros=new Array();
    var renglon=obj.parentElement.parentElement;
    filtros[0]=new RegExp( String(renglon.children[1].querySelector('input[type=text]').value) ,'i');   //filtroUsuario
    filtros[1]=new RegExp( String(renglon.children[2].querySelector('input[type=text]').value) ,'i');   //filtroPerfil
    filtros[2]=new RegExp( String(renglon.children[3].querySelector('input[type=text]').value) ,'i');   //filtroNombre
    filtros[3]=new RegExp( String(renglon.children[4].querySelector('input[type=text]').value) ,'i');   //filtroDepartamento
    filtros[4]=new RegExp( String(renglon.children[5].querySelector('input[type=text]').value) ,'i');   //filtroCorreo
    var objTable=document.getElementById("id_tabla_datos");
    var strtmp="";

    for (var i=1 ; i<objTable.rows.length; i++)
    {
        var mostrar=true;
        //Filtro usuario
        strtmp=objTable.rows[i].cells[2].innerHTML;
        var busqueda=strtmp.search(filtros[0]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro perfil
        strtmp=objTable.rows[i].cells[4].children[0].innerHTML;
        busqueda=strtmp.search(filtros[1]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro Nombre
        strtmp=objTable.rows[i].cells[5].innerHTML;
        busqueda=strtmp.search(filtros[2]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro Departamento
        strtmp=objTable.rows[i].cells[6].innerHTML;
        busqueda=strtmp.search(filtros[3]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //Filtro Correo
        strtmp=objTable.rows[i].cells[7].innerHTML;
        busqueda=strtmp.search(filtros[4]);
        mostrar=mostrar && ((busqueda>=0)?true:false);
        //muestra / oculta
        objTable.rows[i].style.display=(mostrar)?'':'none';
    }
}
