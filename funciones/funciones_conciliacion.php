<?php
    function encabezado()
    {
        echo '<div class="top_left_class">';
            echo '<img src="img/Telcel_logo.png" height="40" width="170">';
        echo '</div>';
        echo '<div class="top_right_class">';

            echo '<div class="dropdown">';
                echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">'.$_SESSION['usuario'].'</button>';
                echo '<div class="dropdown-content">';
                    echo '<a href="#" id="id_menu_passw">Cambiar contraseña</a>';
                    echo '<a href="#" id="id_menu_salir" href="#">Salir</a>';
                echo '</div>';
            echo '</div>';


            echo '<div class="dropdown">';
                echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Datos</button>';
                echo '<div class="dropdown-content">';
                    echo '<a href="#" id="id_menu_exportar">Exportar CSV</a>';
                echo '</div>';
            echo '</div>';

        echo '</div>'.PHP_EOL;
    }

    function genera_tabla_datos() //(bd,pagina,cadena)
    {
        $salida="";
        $argumentos = func_get_args();
        $numeroArgs = count($argumentos);
        $db=$argumentos[0];
        $pagina=$argumentos[1];

        //Calcula paginación
        $rowsCount=0;
        $total=0;
        list($page,$limit,$offset)=calculaPaginacion($pagina);

        $salida .= '<table id="id_tabla_ventasdiarias" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th width=10%>Fecha</th>';
        $salida .=            '<th width=10%>Ventas total</th>';
        $salida .=            '<th width=10%>Ventas faltan</th>';
        $salida .=            '<th width=25% colspan=2>% ventas faltan</th>';
        $salida .=            '<th width=10%>Ventas enviadas a SAP</th>';
        $salida .=            '<th width=10%>Ventas faltan SAP</th>';
        $salida .=            '<th width=25% colspan=2>% ventas faltan SAP</th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>';

        if ($numeroArgs==2)  // (bd, pagina)
        {
            $sql= "SELECT SQL_CALC_FOUND_ROWS
                    id,
                    fecha,
                    ventastotal,
                    ventasfaltan,
                    ROUND(ventasfaltan*100/ventastotal,2) AS ventasfaltanpor,
                    ventasenviadassap,
                    ventasfaltansap,
                    ROUND(ventasfaltansap*100/ventasenviadassap,2) AS ventasfaltansappor
                FROM ventasdiarias
                ORDER BY 2 DESC LIMIT ?,?";
            $data=array($offset,$limit);
        }
        else // (bd, pagina,cadena de busqueda)
        {
            $cadena=$argumentos[2];
            $sql= "SELECT SQL_CALC_FOUND_ROWS p.id,
                    p.id_curso,
                    c.curso,
                    p.version,
                    p.horas,
                    p.fechainicio,
                    p.fechafin,
                    p.instructor,
                    p.lugar
                FROM programado AS p, cursos as c
                WHERE p.id_curso=c.id
                AND (c.curso LIKE ? OR p.fechainicio LIKE ? OR p.fechafin LIKE ? OR p.instructor LIKE ? OR p.lugar LIKE ?)
                ORDER BY 1 DESC LIMIT ?,?";
            $data=array("%$cadena%","%$cadena%","%$cadena%","%$cadena%","%$cadena%",$offset,$limit);
        }
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $sql = "SELECT FOUND_ROWS() as total";
            $data=array();
            $db->ejecutarQueryPreparadoOneRow($sql,$data);
            $total=$db->obtieneResultado()['total'];

            foreach($rows as $row)
            {
                $salida .=  '<tr>';
                $salida .=      '<td style="display:none"><input type="radio" name="radio_tabla_conciliacion"></td>';
                $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                $salida .=      '<td>'.$row['fecha'].'</td>';
                $salida .=      '<td align="center">'.$row['ventastotal'].'</td>';
                if($row['ventasfaltan']>0)
                {
                    $salida .=      '<td align="center"><b style="color:red;">'.$row['ventasfaltan'].'</b></td>';
                }
                else
                {
                    $salida .=      '<td align="center">'.$row['ventasfaltan'].'</td>';
                }
                #$salida .=      '<td align="center"> <div class="barra_porcentaje_class"> <div style="'.set_barra($row['ventasfaltanpor'],'5archivos').'">'.$row['ventasfaltanpor'].'%</div> </div> </td>';
                $salida .=      '<td align="center">'.$row['ventasfaltanpor'].'%</td>';
                if($_SESSION['perfil']['conciliaciondetalles'])
                {
                    $salida .=      '<td align="center"> <a href="#" onclick="muestraDetalles(this,1);"> <img src="img/icons8-fund-accounting-96.png" height="27" width="27" title="ventas vs 5archivos"> </a> </td>';
                }
                else
                {
                    $salida .=      '<td align="center"> <img src="img/icons8-fund-accounting-96.png" height="27" width="27" title="ventas vs 5archivos"> </td>';
                }
                $salida .=      '<td align="center">'.$row['ventasenviadassap'].'</td>';
                if($row['ventasfaltansap']>0)
                {
                    $salida .=      '<td align="center"><b style="color:red;">'.$row['ventasfaltansap'].'</td>';
                }
                else
                {
                    $salida .=      '<td align="center">'.$row['ventasfaltansap'].'</td>';
                }
                $salida .=      '<td align="center">'.$row['ventasfaltansappor'].'%</td>';
                #$salida .=      '<td align="center"> <div class="barra_porcentaje_class"> <div style="'.set_barra($row['ventasfaltansappor'],'sap').'">'.$row['ventasfaltansappor'].'%</div> </div> </td>';
                if($_SESSION['perfil']['conciliaciondetalles'])
                {
                    $salida .=      '<td align="center"> <a href="#" onclick="muestraDetalles(this,2);"> <img src="img/icons8-sap-96.png" height="27" width="27" title="5archivos vs SAP"> </a> </td>';
                }
                else
                {
                    $salida .=      '<td align="center"> <img src="img/icons8-sap-96.png" height="27" width="27" title="5archivos vs SAP"> </td>';
                }

                $salida .=  '</tr>'.PHP_EOL;
            }
        }
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</table>';

        //Barra de Paginación
        list($totalPag,$paginacion)=barraDePaginacion($total,$limit,$page);
        $salida .= '<br>'.$paginacion;
        $salida .= '<script type="text/javascript">DefineClickPaginacion('.$totalPag.');</script>';

        return $salida;
    }

    # Genera datos para exportar
    function genera_datos_exportar($db)
    {
        $arrayTMP=array();
        $arrayResult=array();
        $sql= "SELECT fecha,
	               ventastotal,
	               ventasfaltan,
                   ROUND(ventasfaltan*100/ventastotal,2) AS ventasfaltanpor,
                   ventasenviadassap,
                   ventasfaltansap,
                   ROUND(ventasfaltansap*100/ventasenviadassap,2) AS ventasfaltansappor
               FROM ventasdiarias
               WHERE fecha > ADDDATE(CURDATE(),INTERVAL -1 YEAR)
               ORDER BY 1 DESC";
        $data=array();
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            foreach($rows as $row)
            {
                array_push($arrayTMP,array($row['fecha'],$row['ventastotal'],$row['ventasfaltan'],$row['ventasfaltanpor'],$row['ventasenviadassap'],$row['ventasfaltansap'],$row['ventasfaltansappor']));
            }
            $arrayResult=array("ejecutado"=>1,"datos"=>$arrayTMP,"errormsg"=>"");
        }
        else {$arrayResult=array("ejecutado"=>0,"datos"=>"","errormsg"=>$db->obtieneError());}
        return $arrayResult;
    }
?>
