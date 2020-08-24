function carga_titulo(tipo,total)
{
    $.ajax({
        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,
        data:{ajx_accion:'refreshtitulo',ajx_tipo:tipo,ajx_total:total},
        success: function(result_html)
        {
            $("#id_div_tabla_titulo").html(result_html);
        }
    });
}
function carga_fecha(fecha)
{
    $.ajax({
        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,
        data:{ajx_accion:'refreshfecha',ajx_fecha:fecha},
        success: function(result_html)
        {
            $("#id_div_tabla_fecha").html(result_html);
        }
    });
}
function recarga_grafica(total,faltan)
{
    FusionCharts.ready(function()
    {
        var myChart1 = new FusionCharts(
        {
            type: "pie2d",
            renderAt: "chart-container-1",
            width: "560",
            height: "220",
            dataFormat: "json",
            dataSource:
            {
                chart:
                {
                   showhovereffect: "1",
                   showvalues: "1",
                   showlegend: "1",
                   showpercentvalues: "1",
                   showLabels :"0",
                   showBorder :"0",
                   formatNumberScale :"0",
                   theme: "fusion",
                   showshadow:"0",
                   showHoverEffect:"1",
                   animationDuration:"2",
                   legendPosition:"RIGHT",
                   interactiveLegend:"1",
                   showToolBarButtonTooltext:"1",
                   minimiseWrappingInLegend:"1"
               },
                data:
                [
                   {
                      label: "Encontrados",
                      value: total-faltan
                   },
                   {
                      label: "No encontrados",
                      value: faltan
                   }
                ]
            }
        }).render();
    });
}
function carga_estatus(tipo) //carga estatus disponibles según tipo de conciliacion
{
    var etapasEstatus;
    $.ajax({
        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,dataType:"json",
        data:{ajx_accion:'obtieneEstatus',ajx_tipo:tipo},
        success: function(result_json)
        {
            if(result_json.ejecutado==1){etapasEstatus=result_json.estatus;}
            else {alert(result_json.errorMSG);}
        }
    });
    return etapasEstatus;
}
function recarga_tabla(tipo,id)
{
    $.ajax({
        url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,
        data:{ajx_accion:'refreshtabla',ajx_tipo:tipo,ajx_id_ventasdiarias:id,ajx_tipodepto:0},
        success: function(result_html)
        {
            $("#id_div_tabla_datos").html(result_html);
        }
    });
}
//Menú Selección
function seleccionarTodo()
{
    var tabla=document.getElementById("id_tabla_ventasfaltan");
    switch(tipo)
    {
        case 1:
            for (var i=1 ; i<tabla.rows.length; i++)
            {
                var input = tabla.rows[i].cells[17].children[0];
                if(input.disabled==false && input.checked==false){input.checked=true;}
            }
            break;
        case 2:
            for (var i=1 ; i<tabla.rows.length; i++)
            {
                var input = tabla.rows[i].cells[15].children[0];
                if(input.disabled==false && input.checked==false){input.checked=true;}
            }
            break;
    }
}
function DesseleccionarTodo()
{
    var tabla=document.getElementById("id_tabla_ventasfaltan");
    switch(tipo)
    {
        case 1:
            for (var i=1 ; i<tabla.rows.length; i++)
            {
                var input = tabla.rows[i].cells[17].children[0];
                if(input.disabled==false && input.checked==true){input.checked=false;}
            }
            break;
        case 2:
            for (var i=1 ; i<tabla.rows.length; i++)
            {
                var input = tabla.rows[i].cells[15].children[0];
                if(input.disabled==false && input.checked==true){input.checked=false;}
            }
        break;
            break;
    }
}
function seleccionarRango()
{
    var tabla=document.getElementById("id_tabla_ventasfaltan");
    switch(tipo)
    {
        case 1:
            var rowSelect=[];
            for (var i=1 ; i<tabla.rows.length; i++)    //Encuentra limites
            {
                var input = tabla.rows[i].cells[17].children[0];
                if(input.disabled==false && input.checked==true){rowSelect.push(i);}
            }
            for (var i=rowSelect[0] ; i<=rowSelect[1]; i++) // Selecciona dentro de límites
            {
                var input = tabla.rows[i].cells[17].children[0];
                if(input.disabled==false && input.checked==false){input.checked=true;}
            }
            break;
        case 2:
            var rowSelect=[];
            for (var i=1 ; i<tabla.rows.length; i++)    //Encuentra limites
            {
                var input = tabla.rows[i].cells[15].children[0];
                if(input.disabled==false && input.checked==true){rowSelect.push(i);}
            }
            for (var i=rowSelect[0] ; i<=rowSelect[1]; i++) // Selecciona dentro de límites
            {
                var input = tabla.rows[i].cells[15].children[0];
                if(input.disabled==false && input.checked==false){input.checked=true;}
            }
            break;
    }
}
//Menú Estado
function generaSelectEstatus(etapaActual,etapaNueva,jsonEtapas)
{
    var row="";
    if(etapaNueva==5) // obtenido del menu (regresar etapa)
    {
        $.ajax({
            url:"ajax/ajax_conciliacion2.php",type:"POST",async:false,cache:false,dataType:"json",
            data:{ajx_accion:'obtieneetapas',ajx_tipo:tipo,ajx_etapa_actual:etapaActual},
            success: function(result_json)
            {
                if(result_json.ejecutado)
                {
                    for(i=0;i<result_json.estados.length;i++){row += '<option value='+result_json.estados[i].id+'>'+result_json.estados[i].nombre+'</option>';}
                    $("#id_dialog_etapas_to_comentario").hide();
                }
                else {alert("¡ Error !: "+result_json.errormsg);}
            }
        });
    }
    else
    {
        for(i=0;i<jsonEtapas.length;i++)
        {
            if(etapaActual==jsonEtapas[i].id_etapa && etapaNueva==jsonEtapas[i].id_etapato)
            {row += '<option value='+jsonEtapas[i].id+'>'+jsonEtapas[i].estatus+'</option>';}
        }
    }
    return row;
}
function generaJSONtabla(tipoConciliacion,etapaNueva)  //genera JSON de datos a modificar y valida
{
    objTable=document.getElementById("id_tabla_ventasfaltan");
    var selecciontabla={};
    selecciontabla.error=0;
    selecciontabla.errormsg="";
    selecciontabla.etapaactual=0;
    selecciontabla.etapanueva=Number(etapaNueva);
    selecciontabla.tipo=Number(tipoConciliacion);
    selecciontabla.datos=new Array();
    selecciontabla.idestatus=0;
    selecciontabla.comentario="";

    switch (selecciontabla.tipo)
    {
        // Para conciliación 1
        /*
        {"error":0,"errormsg":"","etapaactual":1,"etapanueva":2,"tipo":1,"datos":[{"id_ventasfaltan":"1","tipo":"activaciones","finan":"C. finan","id_etapa":"1"}],"idestatus":0,"comentario":""}
        */
        case 1:
            // Guarda valores seleccionados de la tabla a json
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                if ( objTable.rows[i].cells[17].children[0].checked )
                {
                    selecciontabla.datos.push( {"id_ventasfaltan":Number(objTable.rows[i].cells[0].innerHTML),"tipo":objTable.rows[i].cells[2].children[0].innerHTML,"finan":objTable.rows[i].cells[3].innerHTML,"id_etapa":Number(objTable.rows[i].cells[14].innerHTML),"id_tipodepto":Number(objTable.rows[i].cells[16].innerHTML)} );
                }
            }
            break;
        // Para conciliación 2
        case 2:
            // Guarda valores seleccionados de la tabla a json
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                if ( objTable.rows[i].cells[15].children[0].checked )
                {
                    selecciontabla.datos.push( {"id_ventasfaltan":objTable.rows[i].cells[0].innerHTML,"tipo":objTable.rows[i].cells[2].innerHTML,"finan":objTable.rows[i].cells[3].innerHTML,"id_etapa":objTable.rows[i].cells[12].innerHTML,"id_tipodepto":Number(objTable.rows[i].cells[14].innerHTML)} );
                }
            }
            break;
    }
    // Error si no hay seleccionados
    if(selecciontabla.datos.length==0)
    {
        selecciontabla.error=1;
        selecciontabla.errormsg="Sin selección";
    }
    else
    {
        // Error diferentes etapas seleccionadas
        var primer=true;
        var etapaActual=null;
        var etapaAnterior=null;
        for(i=0;i<selecciontabla.datos.length;i++)
        {
            etapaActual=selecciontabla.datos[i].id_etapa;
            if(primer)
            { primer=false;}
            else {
                if(etapaActual!=etapaAnterior)
                {
                    selecciontabla.error=1;
                    selecciontabla.errormsg="Diferentes etapas seleccionadas";
                    break;
                }
            }
            etapaAnterior=etapaActual;
        }
        selecciontabla.etapaactual=Number(etapaActual);
        //alert(JSON.stringify(selecciontabla));
        // Error otro departamento asignado
        if(idperfil!=1)
        {
            for(var i=0; i<selecciontabla.datos.length; i++)
            {
                if(selecciontabla.datos[i].id_tipodepto!=deptotipo) {selecciontabla.error=1; selecciontabla.errormsg="Asignado a otro departamento";break;}
            }
        }
        // Error etapa siguiente no válida
        if(selecciontabla.error!=1)
        {
            //Crea un array con el nuero de etapa permitido del perfil (1,0,1,0) -> (1,3) : acceso a la etpa 1 y 3
            var arrPermisos=etapasPermisos.split(',');
            //alert(arrPermisos.join('\n'));
            var arr=new Array();
            for(var i=0;i<arrPermisos.length;i++)
            {
                if(Number(arrPermisos[i])==1){arr.push( i+1 )}
            }
            //alert(arr.join('\n'));
            //Revisa si la etapa actual tiene permiso
            var permiso=false;
            for(var i=0;i<arr.length;i++)
            {
                if(Number(etapaActual)==arr[i]){permiso=true;break;}
            }
            if(!permiso)
            {selecciontabla.error=1;selecciontabla.errormsg="No tiene permiso en esta etapa";}
            else
            {
                switch (Number(etapaActual)) // Revisa según el flujo
                {
                    case 5: selecciontabla.error=0;
                        break;
                    case 1:
                        if(etapaNueva!=2 && etapaNueva!=4)
                        {selecciontabla.error=1;selecciontabla.errormsg="Siguiente etapa incorrecta";}
                        break;
                    case 2:
                        if(etapaNueva!=3 && etapaNueva!=4)
                        {selecciontabla.error=1;selecciontabla.errormsg="Siguiente etapa incorrecta";}
                        break;
                    case 3:
                        if(etapaNueva!=2 && etapaNueva!=4)
                        {selecciontabla.error=1;selecciontabla.errormsg="Siguiente etapa incorrecta";}
                        break;
                }
                if(etapaNueva==5){selecciontabla.error=0;}//regreso de estado
            }
        }
    }
    return selecciontabla;
}
function generaJSONseguimiento(tipoConciliacion)  //genera JSON de datos para raesignar o comentar
{
    objTable=document.getElementById("id_tabla_ventasfaltan");
    var selecciontabla={};
    selecciontabla.error=0;
    selecciontabla.errormsg="";
    selecciontabla.etapaactual=0;
    selecciontabla.tipo=Number(tipoConciliacion);
    selecciontabla.datos=new Array();
    selecciontabla.idestatus=0;
    selecciontabla.idtipodepto=0;
    selecciontabla.comentario="";
    selecciontabla.seguimiento="";
    switch (selecciontabla.tipo)
    {
        // Para conciliación 1
        /*
        {"error":0,"errormsg":"","tipo":1,"datos":[{"id_ventasfaltan":"1","id_etapa":"1"}],"idestatus":0,"comentario":""}
        */
        case 1:
            // Guarda valores seleccionados de la tabla a json
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                if ( objTable.rows[i].cells[17].children[0].checked )
                {
                    selecciontabla.datos.push( {"id_ventasfaltan":Number(objTable.rows[i].cells[0].innerHTML),"id_etapa":Number(objTable.rows[i].cells[14].innerHTML)} );
                }
            }
            break;
        // Para conciliación 2
        case 2:
            // Guarda valores seleccionados de la tabla a json
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                if ( objTable.rows[i].cells[15].children[0].checked )
                {
                    selecciontabla.datos.push( {"id_ventasfaltan":Number(objTable.rows[i].cells[0].innerHTML),"id_etapa":Number(objTable.rows[i].cells[12].innerHTML),"id_tipodepto":Number(objTable.rows[i].cells[14].innerHTML)} );
                }
            }
            break;
    }
    // Error si no hay seleccionados
    if(selecciontabla.datos.length==0)
    {
        selecciontabla.error=1;
        selecciontabla.errormsg="Sin selección";
    }
    else
    {
        // Error diferentes etapas seleccionadas
        var primer=true;
        var etapaActual=null;
        var etapaAnterior=null;
        for(i=0;i<selecciontabla.datos.length;i++)
        {
            etapaActual=selecciontabla.datos[i].id_etapa;
            if(primer)
            { primer=false;}
            else {
                if(etapaActual!=etapaAnterior)
                {
                    selecciontabla.error=1;
                    selecciontabla.errormsg="Diferentes etapas seleccionadas";
                    break;
                }
            }
            etapaAnterior=etapaActual;
        }
        selecciontabla.etapaactual=Number(etapaActual);
    }
    // Error otro departamento asignado
    if(idperfil!=1)
    {
        for(var i=0; i<selecciontabla.datos.length; i++)
        {
            if(selecciontabla.datos[i].id_tipodepto!=deptotipo) {selecciontabla.error=1; selecciontabla.errormsg="Asignado a otro departamento";break;}
        }
    }
    return selecciontabla;
}
function verFlujo(obj)
{
    var row=obj.parentElement.parentElement;
    var id_ventasfaltan=row.cells.item(0).innerText;
    var numfaltante=row.cells.item(1).innerText;
    var etapaActual=(tipo==1)?Number(row.cells.item(14).innerText):Number(row.cells.item(12).innerText); // conciliación 1 ó conciliación 2
    var etapa=0;
    var etapahtml='';
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
                $("#id_dialog_etapas").dialog('option','title','Etapas faltante # '+numfaltante);
                $("#id_dialog_etapas").dialog("open");
            }
            else { alert(json.errorMSG); }
        }
    });
}
//Menu Exportar
function exportarCSV()
{
    document.body.style.cursor = "progress";
    var arreglo=[];
    objTable=document.getElementById("id_tabla_ventasfaltan");
    switch (tipo)
    {
        case 1:
            arreglo.push(['Tipo','Financiamiento','Fuerza de venta','Folio','IMEI','Mercado','Plazo','Linea','Fecha activación','Monto Financiado','Anticipo Negges','Etapa','Asignado']);
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                var tabla_tipo=objTable.rows[i].cells[2].children[0].innerHTML;
                var tabla_fina=objTable.rows[i].cells[3].innerHTML;
                var tabla_fzvt=objTable.rows[i].cells[4].innerHTML;
                var tabla_foli=Number(objTable.rows[i].cells[5].innerHTML);
                var tabla_imei=Number(objTable.rows[i].cells[6].innerHTML);
                var tabla_merc=objTable.rows[i].cells[7].innerHTML;
                var tabla_plaz=Number(objTable.rows[i].cells[8].innerHTML);
                var tabla_line=Number(objTable.rows[i].cells[9].innerHTML);
                var tabla_fact=objTable.rows[i].cells[10].innerHTML;
                var tabla_monfin=objTable.rows[i].cells[11].innerHTML;
                var tabla_antneg=objTable.rows[i].cells[12].innerHTML;
                var tabla_etap=objTable.rows[i].cells[13].children[0].innerHTML;
                try {var tabla_asig=objTable.rows[i].cells[15].children[0].innerHTML;} catch (e){var tabla_asig="";}
                arreglo.push([tabla_tipo,tabla_fina,tabla_fzvt,tabla_foli,tabla_imei,tabla_merc,tabla_plaz,tabla_line,tabla_fact,tabla_monfin,tabla_antneg,tabla_etap,tabla_asig]);
            }
            exportToCsv("ventasVS5archivos_"+fecha+".csv", arreglo);
            break;
        case 2:
            arreglo.push(['Tipo','Financiamiento','IMEI','Linea','Fuerza de Venta','RFC','Nombre','Fecha Activacion','Mensaje SAP','Etapa','Asignado']);
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                var tabla_tipo=objTable.rows[i].cells[2].innerHTML;
                var tabla_fina=objTable.rows[i].cells[3].innerHTML;
                var tabla_imei=Number(objTable.rows[i].cells[4].innerHTML);
                var tabla_linea=Number(objTable.rows[i].cells[5].innerHTML);
                var tabla_fzvt=objTable.rows[i].cells[6].innerHTML;
                var tabla_rfc=objTable.rows[i].cells[7].innerHTML;
                var tabla_nomb=objTable.rows[i].cells[8].innerHTML;
                var tabla_fact=objTable.rows[i].cells[9].innerHTML;
                var tabla_msap=objTable.rows[i].cells[10].innerHTML;
                var tabla_etap=objTable.rows[i].cells[11].children[0].innerHTML;
                try {var tabla_asig=objTable.rows[i].cells[13].children[0].innerHTML;} catch (e) {var tabla_asig="";}
                arreglo.push([tabla_tipo,tabla_fina,tabla_imei,tabla_linea,tabla_fzvt,tabla_rfc,tabla_nomb,tabla_fact,'"'+tabla_msap.trim()+'"',tabla_etap,tabla_asig]);
            }
            exportToCsv("5archivosVSsap_"+fecha+".csv", arreglo);
            break;
    }
    document.body.style.cursor = "default";
}
function filtrar(obj)
{
    var filtros=new Array();
    var renglon=obj.parentElement.parentElement;
    var objTable=document.getElementById("id_tabla_ventasfaltan");
    var strtmp="";
    switch (tipo)
    {
        case 1:
            filtros[0]=new RegExp( String(renglon.children[1].querySelector('input[type=text]').value) ,'i');   //filtro tipo
            filtros[1]=new RegExp( String(renglon.children[2].querySelector('input[type=text]').value) ,'i');   //filtro financiamiento
            filtros[2]=new RegExp( String(renglon.children[3].querySelector('input[type=text]').value) ,'i');   //filtro fuerza de venta
            filtros[3]=new RegExp( String(renglon.children[4].querySelector('input[type=text]').value) ,'i');   //filtro Folio
            filtros[4]=new RegExp( String(renglon.children[5].querySelector('input[type=text]').value) ,'i');   //filtro IMEI
            filtros[5]=new RegExp( String(renglon.children[8].querySelector('input[type=text]').value) ,'i');   //filtro linea
            filtros[6]=new RegExp( String(renglon.children[12].querySelector('input[type=text]').value) ,'i');  //filtro etapa
            filtros[7]=new RegExp( String(renglon.children[13].querySelector('input[type=text]').value) ,'i');  //filtro asignado
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                var mostrar=true;
                //Filtro tipo
                strtmp=objTable.rows[i].cells[2].children[0].innerHTML;
                var busqueda=strtmp.search(filtros[0]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro financiamiento
                strtmp=objTable.rows[i].cells[3].innerHTML;
                busqueda=strtmp.search(filtros[1]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro fuerza de venta
                strtmp=objTable.rows[i].cells[4].innerHTML;
                busqueda=strtmp.search(filtros[2]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro Folio
                strtmp=objTable.rows[i].cells[5].innerHTML;
                busqueda=strtmp.search(filtros[3]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro IMEI
                strtmp=objTable.rows[i].cells[6].innerHTML;
                busqueda=strtmp.search(filtros[4]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro linea
                strtmp=objTable.rows[i].cells[9].innerHTML;
                busqueda=strtmp.search(filtros[5]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro etapa
                strtmp=objTable.rows[i].cells[13].children[0].innerHTML;
                busqueda=strtmp.search(filtros[6]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro asignado
                try {strtmp=objTable.rows[i].cells[15].children[0].innerHTML;}
                catch (e) {strtmp="";}
                busqueda=strtmp.search(filtros[7]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //muestra / oculta
                objTable.rows[i].style.display=(mostrar)?'':'none';
            }
            break;
        case 2:
            filtros[0]=new RegExp( String(renglon.children[1].querySelector('input[type=text]').value) ,'i');   //filtro IMEI
            filtros[1]=new RegExp( String(renglon.children[2].querySelector('input[type=text]').value) ,'i');   //filtro linea
            filtros[2]=new RegExp( String(renglon.children[3].querySelector('input[type=text]').value) ,'i');   //filtro fuerza de venta
            filtros[3]=new RegExp( String(renglon.children[8].querySelector('input[type=text]').value) ,'i');   //filtro etapa
            filtros[4]=new RegExp( String(renglon.children[9].querySelector('input[type=text]').value) ,'i');   //filtro asignado
            for (var i=1 ; i<objTable.rows.length; i++)
            {
                var mostrar=true;
                //Filtro imei
                strtmp=objTable.rows[i].cells[4].innerHTML;
                var busqueda=strtmp.search(filtros[0]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro linea
                strtmp=objTable.rows[i].cells[5].innerHTML;
                busqueda=strtmp.search(filtros[1]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro fuerza de venta
                strtmp=objTable.rows[i].cells[6].innerHTML;
                busqueda=strtmp.search(filtros[2]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro etapa
                strtmp=objTable.rows[i].cells[11].children[0].innerHTML;
                busqueda=strtmp.search(filtros[3]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //Filtro asignado
                try {strtmp=objTable.rows[i].cells[13].children[0].innerHTML;}
                catch (e) {strtmp="";}
                busqueda=strtmp.search(filtros[4]);
                mostrar=mostrar && ((busqueda>=0)?true:false);
                //muestra / oculta
                objTable.rows[i].style.display=(mostrar)?'':'none';
            }
            break;
    }
}
