//--- Define click paginación --
function DefineClickPaginacion(maximo)
{
   $(".pagination a").on({"click": clicked});
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
         url:"ajax/ajax_conciliacion.php",type:"POST",
         //data:{accion:'refresh',ajx_pagina:pagina,ajx_buscar:$("#id_buscar_asignacion_texto").val().trim()},
         data:{accion:'refresh',ajx_pagina:pagina,ajx_buscar:''},
         success: function(result_html){$("#id_div_tabla_datos").html(result_html);}
      });
      pag=pagina; //de variable local a variable global
   }
}
//Manda a otra página con el detalle de faltantes
function muestraDetalles(obj,tipo)
{
    var row=obj.parentElement.parentElement;
    var id=row.cells.item(1).innerText;
    var fecha=row.cells.item(2).innerText;
    var ventastotal=0;
    var ventasfaltan=0;
    if(tipo==1)
    {
        ventastotal=row.cells.item(3).innerText;
        ventasfaltan=row.cells.item(4).innerText;
    }
    else if (tipo=2)
    {
        ventastotal=row.cells.item(7).innerText;
        ventasfaltan=row.cells.item(8).innerText;
    }
    var objform=document.getElementById("id_form_detalles");
    document.getElementById("id_form_detalles_tipo").value = tipo;
    document.getElementById("id_form_detalles_idventasdiarias").value = id;
    document.getElementById("id_form_detalles_fecha").value = fecha;
    document.getElementById("id_form_detalles_total").value = ventastotal;
    document.getElementById("id_form_detalles_faltan").value = ventasfaltan;
    document.getElementById("id_form_detalles_pagina").value = pag;

    if (ventastotal==0)
    {alert("¡ Sin datos !");}
    else
    {objform.submit();}
}
//Menu Exportar
function exportarCSV()
{
    var fecha=obtieneFechaActual();
    $.ajax({
       url:"ajax/ajax_conciliacion.php",type:"POST",async:false,cache:false,dataType:"json",
       data:{accion:'exportar'},
       success: function(result_json)
       {
          if(result_json.ejecutado)
          {
             result_json.datos.unshift(['Fecha','Ventas total','Ventas faltan','% Ventas faltan','Ventas enviadas a SAP','Ventas faltan SAP','% Ventas faltan SAP']);
             exportToCsv("resumen_conciliacion_"+fecha+".csv", result_json.datos);
          }
          else {alert("¡ Error !: "+result_json.errormsg);}
       }
    });
}
