function valida()
{
    var patt=/^([a-z0-9]{7,8})$|^(admin)$/;
    var salida=false;
    var usuario=$("#id_usuario");
    var password=$("#id_password");
    if(usuario.val().length==0 || !patt.test(usuario.val()) || password.val().length==0){salida=false;}
    else {
        $.ajax({
            url:"ajax/ajax_index.php",type:"POST",async:false,cache:false,dataType:"json",
            data:{ajx_accion:'login',ajx_usr:usuario.val(),ajx_pwd:password.val()},
            success: function(result_json) {
                if(result_json.ejecutado==1) {
                    if(result_json.coincide==1) {
                        salida=true;
                    }
                    else {
                        salida=false;
                    }
                }
                else{salida=false; alert(result_json.errormsg);}
            }
        });
    }
    usuario.val(""); password.val("");
    if(!salida){alert("¡ Usuario o nombre incorrecto !");}
    return salida;
}
function recupera()
{
    var usuario=$("#id_usuario");
    var usuariotxt=usuario.val().trim()

    if(usuariotxt.length==0){alert("¡ Debe escribir un usuario !")}
    else {
        document.body.style.cursor = "progress";
        $.ajax({
            url:"ajax/ajax_index.php",type:"POST",async:false,cache:false,dataType:"json",
            data:{ajx_accion:'recupera',ajx_usr:usuariotxt},
            success: function(result_json) {
                if(result_json.ejecutado==1) {
                    if(result_json.coincide==1) {
                        alert("Contraseña enviada por correo: "+result_json.errormsg);
                    }
                    else {
                        alert("Error de usuario");
                    }
                }
                else{alert(result_json.errormsg);}
            }
        });
        document.body.style.cursor = "default";
    }
    usuario.val("");
    return false;
}
