function validar_campo(valor)
{
    var patt=/^[0-9]{10,15}$/;
    if(!patt.test(valor)){alert("Error: solo de 10 a 15 digitos");return false;}
    else {return true;}
}
//--- Define click paginación --
function DefineClickPaginacion(maximo,busqueda,tipo)
{
    switch (tipo)
    {
        case 1: $("#id_div_tabla_datos_1 .pagination a").on({"click": clicked}); break;
        case 2: $("#id_div_tabla_datos_2 .pagination a").on({"click": clicked}); break;
    }
    function clicked()
    {
        var pagina=1;
        if($(this).text()=="«")
            pagina=1;
        else if($(this).text()=="»")
            pagina=maximo;
        else
            pagina=$(this).text();
        $.ajax(
        {
            url:"ajax/ajax_busqueda.php",type:"POST",async:false,cache:false,
            data:{accion:'buscar',ajx_pagina:pagina,ajx_buscar:busqueda,ajx_tipo:tipo},
            success: function(result_html){
            if(tipo==1){$("#id_div_tabla_datos_1").html(result_html)};
            if(tipo==2){$("#id_div_tabla_datos_2").html(result_html)};
            }
        });
    }
}
function verFlujo(obj,tipo)
{
    $("#id_tabla_dialog").show();
    var row=obj.parentElement.parentElement;
    var id_ventasfaltan=row.cells.item(0).innerText;
    var etapaActual=0;
    var etapahtml='';
    switch (tipo)
    {
        case 1:etapaActual=Number(row.cells.item(14).innerText);break;
        case 2:etapaActual=Number(row.cells.item(10).innerText);break;
    }
    $.ajax({
        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,dataType:"json",
        data:{ajx_accion:'obtieneEtapasHistorico',ajx_id_ventasfaltan:id_ventasfaltan,ajx_tipo:tipo},
        success: function(result_json)
        {
            if(result_json.ejecutado==1)
            {
                for(i=0;i<result_json.etapas.length;i++)
                {
                    etapahtml += ('<tr><td>'+result_json.etapas[i].fecha+'</td><td>'+result_json.etapas[i].etapa+'</td><td>'+result_json.etapas[i].usuario+'</td><td>'+result_json.etapas[i].estatus+'</td><td>'+result_json.etapas[i].comentario+'</td></tr>\n');
                }
                $("#id_historico_tr").html(etapahtml);
                switch (etapaActual)
                {
                    case 1: $("#id_etapas_img").attr("src","img/Diagrama"+tipo+"_1.png"); break;
                    case 2: $("#id_etapas_img").attr("src","img/Diagrama"+tipo+"_2.png"); break;
                    case 3: $("#id_etapas_img").attr("src","img/Diagrama"+tipo+"_3.png"); break;
                    case 4: $("#id_etapas_img").attr("src","img/Diagrama"+tipo+"_4.png"); break;
                }
                $("#id_dialog_etapas").dialog('option','title','Etapas faltante');
                $("#id_dialog_etapas").dialog("open");
            }
            else { alert(json.errorMSG); }
        }
    });
}
