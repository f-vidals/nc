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

            echo '<input id="id_busqueda_txt" type="text" maxlength="15" placeholder="buscar imei o linea" style="background-image:url(img/baseline_search_black_18dp.png);background-position:7px 7px;background-repeat:no-repeat;padding-left:2.3em;width:10em;" onFocus=this.value="">';

            /*
            echo '<div class="dropdown">';
                echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Datos</button>';
                echo '<div class="dropdown-content">';
                    echo '<a href="#">Exportar CSV</a>';
                echo '</div>';
            echo '</div>';
            */

            #echo '<img src="img/NC.png" height="55" width="55" align="right">';

        echo '</div>';
    }


    function genera_tabla_datos_1($db,$pagina,$busqueda) //(bd,pagina,cadena)
    {
        $salida="";

        //Calcula paginación
        $rowsCount=0;
        $total=0;
        list($page,$limit,$offset)=calculaPaginacion($pagina);

        $salida .= '<p><h3 style="color:lightgrey;">Resultado de la búsqueda Ventas VS 5archivos</h3></p>';
        $salida .= '<table id="id_tabla_ventasdiarias" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th>Fecha</th>';
        $salida .=            '<th>Tipo</th>';
        $salida .=            '<th>Finan</th>';
        $salida .=            '<th>FV</th>';
        $salida .=            '<th>Folio</th>';
        $salida .=            '<th>IMEI</th>';
        $salida .=            '<th>Mercado</th>';
        $salida .=            '<th>Plazo</th>';
        $salida .=            '<th>Linea</th>';
        $salida .=            '<th>Fecha activ</th>';
        $salida .=            '<th>Mont Fin</th>';
        $salida .=            '<th>Ant Negges</th>';
        $salida .=            '<th>Etapa</th>';
        $salida .=            '<th>Asignado</th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>';

        $sql= "SELECT SQL_CALC_FOUND_ROWS
                ventasfaltanc1.id,
                ventasdiarias.fecha,
                ventasfaltanc1.tipo,
                ventasfaltanc1.financiamiento,
                ventasfaltanc1.fuerzavta,
                ventasfaltanc1.folio,
                ventasfaltanc1.imei,
                ventasfaltanc1.mercado,
                ventasfaltanc1.plazo,
                ventasfaltanc1.linea,
                ventasfaltanc1.fechaact,
                ventasfaltanc1.montofinanciado,
                ventasfaltanc1.anticiponegges,
                ventasfaltanc1.id_etapac1,
                etapac1.nombre,
                tipodepto.tipo AS asignado
            FROM ventasdiarias, ventasfaltanc1, etapac1, tipodepto
            WHERE ventasfaltanc1.id_ventasdiarias = ventasdiarias.id
            AND ventasfaltanc1.id_tipodepto=tipodepto.id
            AND ventasfaltanc1.id_etapac1=etapac1.id
            AND (ventasfaltanc1.imei=? OR ventasfaltanc1.linea=?)
            ORDER BY 2 DESC,1 DESC LIMIT ?,?";

        $data=array($busqueda,$busqueda,$offset,$limit);

        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $sql = "SELECT FOUND_ROWS() as total";
            $data=array();
            $db->ejecutarQueryPreparadoOneRow($sql,$data);
            $total=$db->obtieneResultado()['total'];

            foreach($rows as $row)
            {
                if($row['id_etapac1']==4)  // Deshabilitar renglón
                {
                    $salida .=  '<tr style="color:lightgrey;">';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$row['fecha'].'</td>';
                    $salida .=      '<td> <div class="fondocolor" style="'.set_estilo_tipo('nada').'">'.$row['tipo'].'</div> </td>';
                    $salida .=      '<td>'.$row['financiamiento'].'</td>';
                    $salida .=      '<td>'.$row['fuerzavta'].'</td>';
                    $salida .=      '<td>'.$row['folio'].'</td>';
                    $salida .=      '<td>'.$row['imei'].'</td>';
                    $salida .=      '<td>'.$row['mercado'].'</td>';
                    $salida .=      '<td>'.$row['plazo'].'</td>';
                    $salida .=      '<td>'.$row['linea'].'</td>';
                    $salida .=      '<td>'.$row['fechaact'].'</td>';
                    $salida .=      '<td>'.round($row['montofinanciado'],2).'</td>';
                    $salida .=      '<td>'.round($row['anticiponegges'],2).'</td>';
                    $salida .=      '<td> <button class="botontabla" name="name_etapa_1">'.$row['nombre'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac1'].'</td>';
                    $salida .=      '<td> </td>';
                    $salida .=  '</tr>'.PHP_EOL;
                }
                else
                {
                    $salida .=  '<tr>';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$row['fecha'].'</td>';
                    $salida .=      '<td> <div class="fondocolor" style="'.set_estilo_tipo($row['tipo']).'">'.$row['tipo'].'</div> </td>';
                    $salida .=      '<td>'.$row['financiamiento'].'</td>';
                    $salida .=      '<td>'.$row['fuerzavta'].'</td>';
                    $salida .=      '<td>'.$row['folio'].'</td>';
                    $salida .=      '<td>'.$row['imei'].'</td>';
                    $salida .=      '<td>'.$row['mercado'].'</td>';
                    $salida .=      '<td>'.$row['plazo'].'</td>';
                    $salida .=      '<td>'.$row['linea'].'</td>';
                    $salida .=      '<td>'.$row['fechaact'].'</td>';
                    $salida .=      '<td>'.round($row['montofinanciado'],2).'</td>';
                    $salida .=      '<td>'.round($row['anticiponegges'],2).'</td>';
                    $salida .=      '<td> <button class="botontabla" name="name_etapa_1">'.$row['nombre'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac1'].'</td>';
                    $salida .=      '<td> <button class="botontablaasig">'.$row['asignado'].'</button> </td>';
                    $salida .=  '</tr>'.PHP_EOL;
                }
            }
        }
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</table>';
        $salida .= '<script type="text/javascript">$("[name=name_etapa_1]").click(function(){verFlujo(this,1);});</script>';

        //Barra de Paginación
        list($totalPag,$paginacion)=barraDePaginacion($total,$limit,$page);
        $salida .= '<br>'.$paginacion;
        $salida .= '<script type="text/javascript">DefineClickPaginacion('.$totalPag.','.$busqueda.',1);</script>';

        return $salida;
    }

    function genera_tabla_datos_2($db,$pagina,$busqueda) //(bd,pagina,cadena)
    {
        $salida="";

        //Calcula paginación
        $rowsCount=0;
        $total=0;
        list($page,$limit,$offset)=calculaPaginacion($pagina);

        $salida .= '<p><h3 style="color:lightgrey;">Resultado de la búsqueda 5archivos VS SAP</h3></p>';
        $salida .= '<table id="id_tabla_ventasdiarias" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th>Fecha</th>';
        $salida .=            '<th>IMEI</th>';
        $salida .=            '<th>linea</th>';
        $salida .=            '<th>FV</th>';
        $salida .=            '<th>RFC</th>';
        $salida .=            '<th>Nombre</th>';
        $salida .=            '<th>Fecha activación</th>';
        $salida .=            '<th>Mensaje SAP</th>';
        $salida .=            '<th>Etapa</th>';
        $salida .=            '<th>Asignado</th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>';

        $sql= "SELECT SQL_CALC_FOUND_ROWS
                ventasfaltanc2.id,
                ventasdiarias.fecha,
                ventasfaltanc2.imei,
                ventasfaltanc2.linea,
                ventasfaltanc2.fuerzavta,
                ventasfaltanc2.rfc,
                ventasfaltanc2.nombre,
                ventasfaltanc2.fechaact,
                ventasfaltanc2.mensajesap,
                ventasfaltanc2.id_etapac2,
                etapac2.nombre as nombreetapa,
                tipodepto.tipo AS asignado
            FROM ventasdiarias, ventasfaltanc2, etapac2, tipodepto
            WHERE ventasfaltanc2.id_ventasdiarias = ventasdiarias.id
            AND ventasfaltanc2.id_tipodepto=tipodepto.id
            AND ventasfaltanc2.id_etapac2=etapac2.id
            AND (ventasfaltanc2.imei=? OR ventasfaltanc2.linea=?)
            ORDER BY 2 DESC,1 DESC LIMIT ?,?";
        $data=array($busqueda,$busqueda,$offset,$limit);

        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $sql = "SELECT FOUND_ROWS() as total";
            $data=array();
            $db->ejecutarQueryPreparadoOneRow($sql,$data);
            $total=$db->obtieneResultado()['total'];

            foreach($rows as $row)
            {
                if($row['id_etapac2']==4)  // Deshabilitar renglón
                {
                    $salida .=  '<tr style="color:lightgrey;">';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$row['fecha'].'</td>';
                    $salida .=      '<td>'.$row['imei'].'</td>';
                    $salida .=      '<td>'.$row['linea'].'</td>';
                    $salida .=      '<td>'.$row['fuerzavta'].'</td>';
                    $salida .=      '<td>'.$row['rfc'].'</td>';
                    $salida .=      '<td>'.$row['nombre'].'</td>';
                    $salida .=      '<td>'.$row['fechaact'].'</td>';
                    $salida .=      '<td>'.$row['mensajesap'].'</td>';
                    $salida .=      '<td> <button class="botontabla" name="name_etapa_2">'.$row['nombreetapa'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac2'].'</td>';
                    $salida .=      '<td> </td>';
                    $salida .=  '</tr>'.PHP_EOL;
                }
                else
                {
                    $salida .=  '<tr>';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$row['fecha'].'</td>';
                    $salida .=      '<td>'.$row['imei'].'</td>';
                    $salida .=      '<td>'.$row['linea'].'</td>';
                    $salida .=      '<td>'.$row['fuerzavta'].'</td>';
                    $salida .=      '<td>'.$row['rfc'].'</td>';
                    $salida .=      '<td>'.$row['nombre'].'</td>';
                    $salida .=      '<td>'.$row['fechaact'].'</td>';
                    $salida .=      '<td>'.$row['mensajesap'].'</td>';
                    $salida .=      '<td> <button class="botontabla" name="name_etapa_2">'.$row['nombreetapa'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac2'].'</td>';
                    $salida .=      '<td> <button class="botontablaasig">'.$row['asignado'].'</button> </td>';
                    $salida .=  '</tr>'.PHP_EOL;
                }
            }
        }
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</table>';
        $salida .= '<script type="text/javascript">$("[name=name_etapa_2]").click(function(){verFlujo(this,2);});</script>';

        //Barra de Paginación
        list($totalPag,$paginacion)=barraDePaginacion($total,$limit,$page);
        $salida .= '<br>'.$paginacion;
        $salida .= '<script type="text/javascript">DefineClickPaginacion('.$totalPag.','.$busqueda.',2);</script>';

        return $salida;
    }

?>
