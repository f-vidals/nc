// FECHA ACTUAL
function obtieneFechaActual()
{
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth()+1;  //enero=0
    var year = currentDate.getFullYear();
    if(day<10) {day='0'+day;}
    if(month<10) {month='0'+month;}
    var my_date = year+'-'+month+'-'+day;
    return my_date;
}
// LOADING
$(document).ajaxStart(function() {
  $("#loadingmessage").show();
});
$(document).ajaxComplete(function() {
  $("#loadingmessage").hide();
});
function logout()
{
    $.ajax({
        url:"ajax/ajax_index.php",type:"POST",async:false,cache:false,timeout:5000,
        data:{ajx_accion:'logout'},success: function() {},
        error: function(jqXHR, textStatus, errorThrown) {
            if(textStatus==="timeout") {alert("Call has timed out");}
            else {alert(textStatus);}
        }
    });
    location.href='./';
}
// TRIM
if (!String.prototype.trim)
{
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g,'');
    }
}
//convierte primer letra en mayuscula
function capital_letter(str)
{
    str = str.split(" ");
    for (var i = 0, x = str.length; i < x; i++) {
        str[i] = str[i][0].toUpperCase() + str[i].substr(1);
    }
    return str.join(" ");
}
// Marca renglon al dar click
function DefineMarcaRenglon(id_tabla)
{
   $("#"+id_tabla+" tbody tr").on({"click":clicked,"mouseover":hovered,"mouseout":mouseout});
   function hovered(){$(this).css("background","#ECF0F5");}
   function mouseout()
   {
      if($(this).find('input[type=radio]').is(':checked')){$(this).css("background","#ddd");}
      else{$(this).css("background", "#ffffff");}
   }
   function clicked()
   {
      $("#"+id_tabla+" tbody tr").css('background-color', 'white');
      $(this).css("background","#ddd");
      $(this).find('input[type=radio]').prop('checked', true);
   }
}
// SLEEP
function sleep(milliseconds)
{
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
// SANEAR STRING
function sanear(cadena)
{
    //var re = new RegExp(/[;<>\{\}"']/, 'g');
    //var re = new RegExp(/</, 'g');
    //var str = cadena.replace(re,'');
    var str=cadena.replace("\<","");
    return str;
}
//EXPORTAR CSV
function exportToCsv(filename, rows)
{
    var processRow = function (row)
    {
        var finalVal = '';
        for (var j = 0; j < row.length; j++)
        {
            var innerValue = row[j] === null ? '' : row[j].toString();
            if (row[j] instanceof Date){innerValue = row[j].toLocaleString();};
            var result = innerValue.replace(/"/g, '""');
            if (result.search(/("|,|\n)/g) >= 0) result = '"' + result + '"';
            if (j > 0) finalVal += ',';
            finalVal += result;
        }
        return finalVal + '\n';
    };
    var csvFile = '';
    for (var i = 0; i < rows.length; i++) {csvFile += processRow(rows[i]);}
    var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) { navigator.msSaveBlob(blob, filename);} // IE 10+
    else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}
