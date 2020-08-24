<?php
    # Genera menus para conciliaciones 1 y 2
    function encabezado($tipo)
    {
        if ($tipo==1)   //Conciliación 1
        {
            $perfilopciones=explode(",",$_SESSION['perfil']['conciliacion1estadomenu']);                //(vali,falt,corr,proc,regr) -> permisos de acceso a menus
            $perfilopcionessegumiento=explode(",",$_SESSION['perfil']['conciliacion1seguimientomenu']); //(Reasig,coment) -> permisos de acceso a menus
            echo PHP_EOL;
            echo '<div class="top_left_class">';
                echo '<img src="img/Telcel_logo.png" height="40" width="170">';
            echo '</div>';
            echo '<div class="top_right_class">';

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">'.$_SESSION['usuario'].'</button>';
                    echo '<div class="dropdown-content">';
                        echo '<a href="#" id="id_menu_passw">Cambiar contraseña</a>';
                        echo '<a href="#" id="id_menu_salir">Salir</a>';
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Selección</button>';
                    echo '<div class="dropdown-content">';
                        echo '<a href="#" id="id_menu_rango">Seleccionar rango</a>';
                        echo '<a href="#" id="id_menu_todo">Seleccionar todo</a>';
                        echo '<a href="#" id="id_menu_des">Deseleccionar todo</a>';
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Etapas</button>';
                    echo '<div class="dropdown-content">';
                        if($perfilopciones[1]==1) {echo '<a href="#" id="id_menu_1_2" name="menu_estado">Cambiar a faltante</a>';} //concilicion 1 etapa 2
                        if($perfilopciones[2]==1) {echo '<a href="#" id="id_menu_1_3" name="menu_estado">Cambiar a corregido</a>';}
                        if($perfilopciones[3]==1) {echo '<a href="#" id="id_menu_1_4" name="menu_estado">Cambiar a procesado</a>';}
                        if($perfilopciones[4]==1) {echo '<a href="#" id="id_menu_1_5" name="menu_estado">Regresar etapa</a>';}
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Seguimiento</button>';
                    echo '<div class="dropdown-content">';
                        if($perfilopcionessegumiento[0]==1) {echo '<a href="#" id="id_menu_reasignar">Reasignar</a>';}
                        if($perfilopcionessegumiento[1]==1) {echo '<a href="#" id="id_menu_comentar" >Comentar</a>';}
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Datos</button>';
                    echo '<div class="dropdown-content">';
                        echo '<a href="#" id="id_menu_exportar">Exportar CSV</a>';
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button id="id_menu_regresar" class="dropbtn">Regresar</button>';
                echo '</div>';
                echo PHP_EOL;

            echo '</div>';

            echo '<script type="text/javascript">$("#id_menu_regresar").click(function(){location.href="conciliacion.php?p="+pag;});</script>';
        }
        else //Conciliación 2
        {
            $perfilopciones=explode(",",$_SESSION['perfil']['conciliacion2estadomenu']); //(vali,corr,manu,proc,regr) -> permisos de acceso a menus
            $perfilopcionessegumiento=explode(",",$_SESSION['perfil']['conciliacion2seguimientomenu']); //(Reasig,coment) -> permisos de acceso a menus
            echo PHP_EOL;
            echo '<div class="top_left_class">';
                echo '<img src="img/Telcel_logo.png" height="40" width="170">';
            echo '</div>';
            echo '<div class="top_right_class">';

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">'.$_SESSION['usuario'].'</button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="#" id="id_menu_passw">Cambiar contraseña</a>';
                    echo '<a href="#" id="id_menu_salir">Salir</a>';
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Selección</button>';
                    echo '<div class="dropdown-content">';
                        echo '<a href="#" id="id_menu_rango">Seleccionar rango</a>';
                        echo '<a href="#" id="id_menu_todo">Seleccionar todo</a>';
                        echo '<a href="#" id="id_menu_des">Deseleccionar todo</a>';
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Estado</button>';
                    echo '<div class="dropdown-content">';
                    if($perfilopciones[1]==1) {echo '<a href="#" id="id_menu_2_2" name="menu_estado">Cambiar a faltante</a>';} //concilicion 2 etapa 2
                    if($perfilopciones[2]==1) {echo '<a href="#" id="id_menu_2_3" name="menu_estado">Cambiar a corregido</a>';}
                    if($perfilopciones[3]==1) {echo '<a href="#" id="id_menu_2_4" name="menu_estado">Cambiar a procesado</a>';}
                    if($perfilopciones[4]==1) {echo '<a href="#" id="id_menu_2_5" name="menu_estado">Regresar estado</a>';}
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Seguimiento</button>';
                    echo '<div class="dropdown-content">';
                        if($perfilopcionessegumiento[0]==1) {echo '<a href="#" id="id_menu_reasignar">Reasignar</a>';}
                        if($perfilopcionessegumiento[1]==1) {echo '<a href="#" id="id_menu_comentar" >Comentar</a>';}
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Datos</button>';
                    echo '<div class="dropdown-content">';
                        echo '<a href="#" id="id_menu_exportar">Exportar CSV</a>';
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

                echo '<div class="dropdown">';
                    echo '<button id="id_menu_regresar" class="dropbtn">Regresar</button>';
                echo '</div>';
                echo PHP_EOL;

            echo '</div>';

            echo '<script type="text/javascript">$("#id_menu_regresar").click(function(){location.href="conciliacion.php?p="+pag;});</script>';
        }
    }

    function genera_tabla_titulo($tipo,$total)
    {
        $salida = "";
        $salida .=   '<table>';
        $salida .=       '<tr>';
        $salida .=           '<td rowspan="2">';
        if($tipo==1)
        {
            $salida .=           '<img src="img/icons8-fund-accounting-96.png" height="55" width="55">';
        }
        elseif ($tipo==2)
        {
            $salida .=           '<img src="img/icons8-sap-96.png" height="60" width="60">';
        }

        $salida .=           '</td>';
        $salida .=           '<td>';
        if($tipo==1)
        {
            $salida .=           '<font size="5" color="darkblue"><b>Ventas VS 5archivos</b></font>';
        }
        elseif($tipo==2)
        {
            $salida .=           '<font size="5" color="darkblue"><b>5archivos VS SAP</b></font>';
        }
        $salida .=           '</td>';
        $salida .=       '</tr>';
        $salida .=       '<tr>';
        $salida .=           '<td>';
        $salida .=               '<font size="4" color="darkgrey">'.$total.' ventas</font>';
        $salida .=           '</td>';
        $salida .=       '</tr>';
        $salida .=   '</table>'.PHP_EOL;
        return $salida;
    }

    function genera_tabla_fecha($fecha)
    {

        $salida = "";
        $salida .=  '<table>';
        $salida .=      '<tr>';
        $salida .=          '<td>';
        $salida .=              '<img src="img/icons8-calendar-96.png" height="55" width="55">';
        $salida .=          '</td>';
        $salida .=          '<td>';
        $salida .=              '<font size="5" color="#009688">'.$fecha.'</font>';
        $salida .=          '</td>';
        $salida .=      '</tr>';
        $salida .=  '</table>';
        return $salida;
    }

    # Genera tabla principal de conciliacion 1
    function genera_tabla_datos_ventasVS5archivos($db,$id_ventasdiarias)
    {
        $arrayEstadoPermiso=explode(',',$_SESSION['perfil']['conciliacion1estadomenu']);
        $salida = "";

        $salida .= '<table id="id_tabla_ventasfaltan" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th>#<br>&nbsp</th>';
        $salida .=            '<th>Tipo<br><input class="input_busqueda" style="width:6.5em;" maxlength="20" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>Finan<br><input class="input_busqueda" style="width:4em;" maxlength="8" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>FV<br><input class="input_busqueda" style="width:4em;" maxlength="10" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>Folio<br><input class="input_busqueda" style="width:4.5em;" maxlength="8" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>IMEI<br><input class="input_busqueda" style="width:9.5em;" maxlength="15" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>Merc<br>&nbsp</th>';
        $salida .=            '<th>Plazo<br>&nbsp</th>';
        $salida .=            '<th>Linea<br><input class="input_busqueda" style="width:6em;" maxlength="10" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>Fecha activ<br>&nbsp</th>';
        $salida .=            '<th>Mont Fin<br>&nbsp</th>';
        $salida .=            '<th>Ant Negges<br>&nbsp</th>';
        $salida .=            '<th>Etapa<br><input class="input_busqueda" style="width:6em;" maxlength="10" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>Asignado<br><input class="input_busqueda" style="width:6.5em;" maxlength="11" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th></th>';
        $salida .=            '<th></th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>'.PHP_EOL;

        $sql= "SELECT
                ventasfaltanc1.id,
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
                tipodepto.tipo AS asignado,
                tipodepto.id AS id_tipodepto
            FROM ventasfaltanc1, etapac1, tipodepto
            WHERE id_ventasdiarias=? AND ventasfaltanc1.id_etapac1=etapac1.id AND ventasfaltanc1.id_tipodepto=tipodepto.id
            ORDER BY 6";
        $data=array($id_ventasdiarias);

        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $count=0;
            foreach($rows as $row)
            {
                $count++;

                if($row['id_etapac1']==4)  // Deshabilitar renglón (PROCESADO)
                {
                    $salida .=  '<tr style="color:lightgrey;">';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$count.'</td>';
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
                    $salida .=      '<td> <button class="botontabla" name="name_etapa">'.$row['nombre'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac1'].'</td>';
                    $salida .=      '<td> </td>';
                    $salida .=      '<td style="display:none"> </td>';
                    if($_SESSION['perfil']['detallesseleccion'])
                    {
                        //Si tiene permiso de regresar estado muestra el checkbox aunque esté en procesado
                        $salida .= ($arrayEstadoPermiso[3])?'<td id="id_tabla_ventasfaltan_checkbox" align="center"> <input type="checkbox"> </td>':'<td align="center"> <input disabled type="checkbox"> </td>';
                    }
                    else {
                        $salida .=      '<td align="center"> </td>';
                    }
                    $salida .=  '</tr>'.PHP_EOL;
                }
                else
                {
                    $salida .=  '<tr>';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$count.'</td>';
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
                    $salida .=      '<td> <button class="botontabla" name="name_etapa">'.$row['nombre'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac1'].'</td>';
                    $salida .=      '<td> <button class="botontablaasig">'.$row['asignado'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_tipodepto'].'</td>';
                    if($_SESSION['perfil']['detallesseleccion'])
                    {
                        $salida .=      '<td id="id_tabla_ventasfaltan_checkbox" align="center"> <input type="checkbox"> </td>';
                    }
                    else {
                        $salida .=      '<td align="center"> </td>';
                    }
                    $salida .=  '</tr>'.PHP_EOL;
                }
            }
        }
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</table>';
        $salida .= '<script type="text/javascript"> $("[name=name_etapa]").click(function(){verFlujo(this);}); </script>';

        return $salida;
    }

    # Genera tabla principal de conciliacion 2
    function genera_tabla_datos_5archivosVSsap($db,$id_ventasdiarias)
    {
        $arrayEstadoPermiso=explode(',',$_SESSION['perfil']['conciliacion2estadomenu']);
        $salida="";

        $salida .= '<table id="id_tabla_ventasfaltan" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th>#</th>';
        $salida .=            '<th>IMEI<br><input class="input_busqueda" style="width:9.5em;" maxlength="15" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>linea<br><input class="input_busqueda" style="width:6em;" maxlength="10" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>FV<br><input class="input_busqueda" style="width:4em;" maxlength="10" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>RFC<br>&nbsp</th>';
        $salida .=            '<th>Nombre<br>&nbsp</th>';
        $salida .=            '<th>Fecha Activ</th>';
        $salida .=            '<th>Mensaje SAP<br>&nbsp</th>';
        $salida .=            '<th>Etapa<br><input class="input_busqueda" style="width:6em;" maxlength="10" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th>Asignado<br><input class="input_busqueda" style="width:6.5em;" maxlength="11" type=text onkeyup="filtrar(this)"</th>';
        $salida .=            '<th></th>';
        $salida .=            '<th></th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>'.PHP_EOL;

        $sql= "SELECT
                ventasfaltanc2.id,
                ventasfaltanc2.tipo,
                ventasfaltanc2.financiamiento,
                ventasfaltanc2.imei,
                ventasfaltanc2.linea,
                ventasfaltanc2.fuerzavta,
                ventasfaltanc2.rfc,
                ventasfaltanc2.nombre,
                ventasfaltanc2.fechaact,
                ventasfaltanc2.mensajesap,
                ventasfaltanc2.id_etapac2,
                etapac2.nombre AS nombreetapa,
                tipodepto.tipo AS asignado,
                tipodepto.id AS id_tipodepto
            FROM ventasfaltanc2, etapac2, tipodepto
            WHERE id_ventasdiarias=? AND ventasfaltanc2.id_etapac2=etapac2.id AND ventasfaltanc2.id_tipodepto=tipodepto.id
            ORDER BY 4";
        $data=array($id_ventasdiarias);

        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $count=0;
            foreach ($rows as $row)
            {
                $count++;
                if($row['id_etapac2']==4)  // Deshabilitar renglón
                {
                    $salida .=  '<tr style="color:lightgrey;">';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$count.'</td>';
                    $salida .=      '<td style="display:none">'.$row['tipo'].'</td>';
                    $salida .=      '<td style="display:none">'.$row['financiamiento'].'</td>';
                    $salida .=      '<td>'.$row['imei'].'</td>';
                    $salida .=      '<td>'.$row['linea'].'</td>';
                    $salida .=      '<td>'.$row['fuerzavta'].'</td>';
                    $salida .=      '<td>'.$row['rfc'].'</td>';
                    $salida .=      '<td>'.$row['nombre'].'</td>';
                    $salida .=      '<td>'.$row['fechaact'].'</td>';
                    $salida .=      '<td>'.$row['mensajesap'].'</td>';
                    $salida .=      '<td> <button class="botontabla" name="name_etapa">'.$row['nombreetapa'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac2'].'</td>';
                    $salida .=      '<td> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_tipodepto'].'</td>';
                    if($_SESSION['perfil']['detallesseleccion'])
                    {
                        $salida .= ($arrayEstadoPermiso[3])?'<td align="center"> <input type="checkbox"> </td>':'<td align="center"> <input disabled type="checkbox"> </td>';
                    }
                    else {
                        $salida .=      '<td align="center"> </td>';
                    }
                    $salida .=  '</tr>'.PHP_EOL;
                }
                else
                {
                    $salida .=  '<tr>';
                    $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                    $salida .=      '<td>'.$count.'</td>';
                    $salida .=      '<td style="display:none">'.$row['tipo'].'</td>';
                    $salida .=      '<td style="display:none">'.$row['financiamiento'].'</td>';
                    $salida .=      '<td>'.$row['imei'].'</td>';
                    $salida .=      '<td>'.$row['linea'].'</td>';
                    $salida .=      '<td>'.$row['fuerzavta'].'</td>';
                    $salida .=      '<td>'.$row['rfc'].'</td>';
                    $salida .=      '<td>'.$row['nombre'].'</td>';
                    $salida .=      '<td>'.$row['fechaact'].'</td>';
                    $salida .=      '<td>'.$row['mensajesap'].'</td>';
                    $salida .=      '<td> <button class="botontabla" name="name_etapa">'.$row['nombreetapa'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_etapac2'].'</td>';
                    $salida .=      '<td> <button class="botontablaasig">'.$row['asignado'].'</button> </td>';
                    $salida .=      '<td style="display:none">'.$row['id_tipodepto'].'</td>';
                    if($_SESSION['perfil']['detallesseleccion'])
                    {
                        $salida .=      '<td align="center"> <input type="checkbox"> </td>';
                    }
                    else {
                        $salida .=      '<td align="center"> </td>';
                    }
                    $salida .=  '</tr>'.PHP_EOL;
                }
            }
        }
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</table>';
        $salida .= '<script type="text/javascript">$("[name=name_etapa]").click(function(){verFlujo(this);});</script>';

        return $salida;
    }

    # Obtiene lista de estatus para colocar en combo cuando se pase a otra etapa en array
    function obtiene_estatus($db,$tipo)
    {
        $arrayResult=array();
        $arrayTMP=array();
        switch ($tipo)
        {
            case 1: # Conciliación 1
                $sql="SELECT id, id_etapac1, id_etapac1to, estatusc1 FROM estatusc1 WHERE habilitado=? ORDER BY id_etapac1, id_etapac1to, estatusc1";
                $data=array(1);
                if($db->ejecutarQueryPreparado($sql,$data))
                {
                    $rows=$db->obtieneResultado();
                    foreach($rows as $row)
                    {
                        array_push($arrayTMP,array("id"=>$row['id'], "id_etapa"=>$row['id_etapac1'], "id_etapato"=>$row['id_etapac1to'], "estatus"=>$row['estatusc1']));
                    }
                    $arrayResult=array("ejecutado"=>1, "estatus"=>$arrayTMP, "errormsg"=>"");
                }
                else
                {
                    $arrayResult=array("ejecutado"=>0,"estatus"=>"", "errormsg"=>$db->obtieneError());
                }
                break;
            case 2: # Conciliación 2
                $sql="SELECT id, id_etapac2, id_etapac2to, estatusc2 FROM estatusc2 WHERE habilitado=? ORDER BY id_etapac2, id_etapac2to, estatusc2";
                $data=array(1);
                if($db->ejecutarQueryPreparado($sql,$data))
                {
                    $rows=$db->obtieneResultado();
                    foreach($rows as $row)
                    {
                        array_push($arrayTMP,array("id"=>$row['id'], "id_etapa"=>$row['id_etapac2'], "id_etapato"=>$row['id_etapac2to'], "estatus"=>$row['estatusc2']));
                    }
                    $arrayResult=array("ejecutado"=>1, "estatus"=>$arrayTMP, "errormsg"=>"");
                }
                else
                {
                    $arrayResult=array("ejecutado"=>0,"estatus"=>"", "errormsg"=>$db->obtieneError());
                }
                break;
        }
        return $arrayResult;
    }

    # Obtiene listados de etapas para el regreso de etapa por el administrador
    function obtiene_etapas($db,$tipo,$etapaActual)
    {
        $arrayResult=array();
        $arrayTMP=array();
        switch ($tipo)
        {
            case 1: $sql="SELECT id, nombre FROM etapac1 WHERE id<? ORDER BY 1"; break;
            case 2: $sql="SELECT id, nombre FROM etapac2 WHERE id<? ORDER BY 1"; break;
        }
        $data=array($etapaActual);
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            foreach($rows as $row)
            {
                array_push( $arrayTMP,array("id"=>$row['id'], "nombre"=>$row['nombre']) );
            }
            $arrayResult=array("ejecutado"=>1, "estados"=>$arrayTMP, "errormsg"=>"");
        }
        else
        {
            $arrayResult=array("ejecutado"=>0,"estados"=>"", "errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
        /*
        {
            "ejecutado":1,
            "estados":
            [
                {"id":1,"nombre":"Validacion"},
                {"id":2,"nombre":"Faltante"}
            ],
            "errormsg":""
        }
        */
    }

    function cambia_estado($db,$jsonDatos,$id_usuario,$nombre,$faltan,$id_ventasdiarias,$tipo)
    {
        $fecha=strftime("%Y-%m-%d",time());
        /*
        {
            "error":0,
            "errormsg":"",
            "etapaactual":1,
            "etapanueva":2,
            "tipo":1,
            "datos":
            [
                {"id_ventasfaltan":"100","tipo":"activaciones","finan":"C. finan","id_etapa":"1"},
                {"id_ventasfaltan":"101","tipo":"activaciones","finan":"C. finan","id_etapa":"1"}
            ],
            "selecciontabla.idestatus":1,       -> estado seleccionado
            "selecciontabla.comentario":"opcional"
        }

        */
        $arrayResult=array();
        try
        {
            $db->iniciaTransaccion();

            // Isertar en tabla de seguimientoc1 o seguimientoc2
            switch ($tipo)
            {
                case 1:
                    $sql="INSERT INTO seguimientoc1 (id_ventasfaltanc1, id_etapac1, id_usuario, nombre, id_estatusc1, fecha, comentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    break;
                case 2:
                    $sql="INSERT INTO seguimientoc2 (id_ventasfaltanc2, id_etapac2, id_usuario, nombre, id_estatusc2, fecha, comentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                $data=array($value->id_ventasfaltan, $value->id_etapa, $id_usuario, "$nombre", $jsonDatos->idestatus, $fecha, $jsonDatos->comentario);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            // Actualizar tabla de ventasfaltanc1 o ventasfaltanc2
            switch ($tipo)
            {
                case 1:
                    $sql="UPDATE ventasfaltanc1 SET id_etapac1=?,enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
                    break;
                case 2:
                    $sql="UPDATE ventasfaltanc2 SET id_etapac2=?,enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                // Revisa a qué departamento se va a asignar
                $id_tipodepto_asignacion=0;                                                                                                                         //0=OTRO (tabla tipodepto)
                switch ($jsonDatos->etapanueva)
                {
                    case 2:
                        if     (($value->tipo=="cambio de equipos" || $value->tipo=="cambio de plan") && $value->finan=="S.finan") { $id_tipodepto_asignacion=2;}   //2=SPOS (tabla tipodepto)
                        elseif (($value->tipo=="cambio de equipos" || $value->tipo=="activaciones") && $value->finan=="C. finan") { $id_tipodepto_asignacion=3;}    //3=FACTURACION (tabla tipodepto)
                        elseif ($value->tipo=="activaciones" && $value->finan=="S.finan") { $id_tipodepto_asignacion=4;}                                            //4=SISACT (tabla tipodepto)
                        break;
                    case 3:
                        $id_tipodepto_asignacion=5;                                                                                                                 //5=SAP (tabla tipodepto)
                        break;
                }
                $data=array($jsonDatos->etapanueva, $fecha, $id_tipodepto_asignacion,$value->id_ventasfaltan);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
                if($jsonDatos->etapanueva==4)
                {
                    $faltan--;
                }
            }

            // Actualizar tabla de ventasdiarias cuando se pase a procesado
            if($jsonDatos->etapanueva==4)
            {
                /*
                switch ($tipo)
                {
                    case 1:
                        $sql="UPDATE ventasdiarias SET ventasfaltan=? WHERE id=?";
                        break;
                    case 2:
                        $sql="UPDATE ventasdiarias SET ventasfaltansap=? WHERE id=?";
                        break;
                }
                $data=array($faltan, $id_ventasdiarias);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
                */
                $sql="CALL actualizaventasdiarias(?,?)";
                $data=array($id_ventasdiarias, $tipo);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"etapa"=>$jsonDatos->etapanueva,"faltan"=>$faltan,"errormsg"=>"");

        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayError=explode("|",$e->getMessage());
            $arrayResult=array("ejecutado"=>0,"etapa"=>$jsonDatos->etapanueva,"faltan"=>$faltan,"errormsg"=>"$arrayError[1]");
        }
        finally
        {
            return $arrayResult;
        }
    }

    function regresa_estado($db,$jsonDatos,$id_usuario,$nombre,$faltan,$id_ventasdiarias,$tipo)
    {
        $fecha=strftime("%Y-%m-%d",time());
        /*
        {
            "error":0,
            "errormsg":"Siguiente etapa incorrecta",
            "etapaactual":2,
            "etapanueva":5,
            "tipo":2,"datos":
            [
                {"id_ventasfaltan":"1","tipo":"activaciones","finan":"S.finan","id_etapa":"2"}
            ],
            "idestatus":1,
            "comentario":"script>alert(\"hola\")</script>"
        }
        */
        $arrayResult=array();
        try
        {
            $db->iniciaTransaccion();

            // Borra registros de etapas posteriores a la seleccionada de seguimientoc1 o seguimientoc2
            // switch ($tipo)
            // {
            //     case 1:
            //         $sql="DELETE FROM seguimientoc1 WHERE id_ventasfaltanc1=? AND id_etapac1>?";
            //         break;
            //     case 2:
            //         $sql="DELETE FROM seguimientoc2 WHERE id_ventasfaltanc2=? AND id_etapac2>?";
            //         break;
            // }
            // foreach ($jsonDatos->datos as $key => $value)
            // {
            //     $data=array($value->id_ventasfaltan, $jsonDatos->idestatus);
            //     $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            // }

            //Inserta seguimiento el regreso de etapa
            switch ($tipo)
            {
                case 1:
                    $sql="INSERT INTO seguimientoc1 (id_ventasfaltanc1,id_etapac1,id_usuario,nombre,id_estatusc1,fecha,comentario) VALUES (?,?,?,?,?,?,?)";
                    break;
                case 2:
                    $sql="INSERT INTO seguimientoc2 (id_ventasfaltanc2,id_etapac2,id_usuario,nombre,id_estatusc2,fecha,comentario) VALUES (?,?,?,?,?,?,?)";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                $data=array($value->id_ventasfaltan, $jsonDatos->idestatus,$id_usuario,"$nombre",4,"$fecha","Regreso desde etapa $jsonDatos->etapaactual:".substr($jsonDatos->comentario,0,78)); // id_estatuscx = comentario
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            // Actualizar tabla de ventasfaltanc1 o ventasfaltanc2
            switch ($tipo)
            {
                case 1:
                    $sql="UPDATE ventasfaltanc1 SET id_etapac1=?,enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
                    break;
                case 2:
                    $sql="UPDATE ventasfaltanc2 SET id_etapac2=?,enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                // Revisa a qué departamento se va a asignar
                $id_tipodepto_asignacion=1;                                                                                                                         //1=FINANZAS (tabla tipodepto)
                switch ($jsonDatos->idestatus)
                {
                    case 2:
                        if     (($value->tipo=="cambio de equipos" || $value->tipo=="cambio de plan") && $value->finan=="S.finan") { $id_tipodepto_asignacion=2;}   //2=SPOS (tabla tipodepto)
                        elseif (($value->tipo=="cambio de equipos" || $value->tipo=="activaciones") && $value->finan=="C. finan") { $id_tipodepto_asignacion=3;}    //3=FACTURACION (tabla tipodepto)
                        elseif ($value->tipo=="activaciones" && $value->finan=="S.finan") { $id_tipodepto_asignacion=4;}                                            //4=SISACT (tabla tipodepto)
                        break;
                    case 3:
                        $id_tipodepto_asignacion=5;                                                                                                                 //5=SAP (tabla tipodepto)
                        break;
                }
                $data=array($jsonDatos->idestatus, $fecha, $id_tipodepto_asignacion,$value->id_ventasfaltan);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
                if($jsonDatos->etapanueva==4)
                {
                    $faltan--;
                }
            }

            // Actualizar tabla de ventasdiarias cuando se regrese de procesado
            if($jsonDatos->etapaactual==4)
            {
                /*
                switch ($tipo)
                {
                    case 1:
                        $sql="UPDATE ventasdiarias SET ventasfaltan=? WHERE id=?";
                        break;
                    case 2:
                        $sql="UPDATE ventasdiarias SET ventasfaltansap=? WHERE id=?";
                        break;
                }
                $data=array($faltan, $id_ventasdiarias);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
                */
                $sql="CALL actualizaventasdiarias(?,?)";
                $data=array($id_ventasdiarias, $tipo);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));

                $arrayResult=array("ejecutado"=>1,"etapa"=>$jsonDatos->etapaactual,"faltan"=>$faltan,"errormsg"=>"");
            }
            else {
                $arrayResult=array("ejecutado"=>1,"etapa"=>$jsonDatos->idestatus,"faltan"=>$faltan,"errormsg"=>"");
            }

            $db->terminaTransaccion();

        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayError=explode("|",$e->getMessage());
            $arrayResult=array("ejecutado"=>0,"etapa"=>$jsonDatos->idestatus,"faltan"=>$faltan,"errormsg"=>"$arrayError[1]");
        }
        finally
        {
            return $arrayResult;
        }
    }

    function obtienejson_historico($db,$id_ventasfaltan,$tipo)
    {
        $arrayResult=array();
        $arrayTMP=array();
        switch ($tipo)
        {
            case 1:
                $sql="SELECT s.id, et.nombre AS etapa, s.fecha, s.nombre, e2.estatusc1, s.comentario
                    FROM seguimientoc1 s , estatusc1 e2, etapac1 et
                    WHERE s.id_estatusc1 = e2.id
                    AND s.id_etapac1 = et.id
                    AND s.id_ventasfaltanc1 = ?
                    ORDER BY s.id DESC, s.id_etapac1";
                $data=array($id_ventasfaltan);
                if($db->ejecutarQueryPreparado($sql,$data))
                {
                    $rows=$db->obtieneResultado();
                    foreach($rows as $row)
                    {
                        array_push($arrayTMP,array("etapa"=>$row['etapa'], "fecha"=>$row['fecha'], "usuario"=>$row['nombre'], "estatus"=>$row['estatusc1'], "comentario"=>$row['comentario']));
                    }
                    $arrayResult=array("ejecutado"=>1, "etapas"=>$arrayTMP, "errormsg"=>"");
                }
                else {
                    $arrayResult=array("ejecutado"=>0,"etapas"=>"", "errormsg"=>$db->obtieneError());
                }
                break;
            case 2:
                $sql="SELECT s.id, et.nombre AS etapa, s.fecha, s.nombre, e2.estatusc2, s.comentario
                    FROM seguimientoc2 s , estatusc2 e2, etapac2 et
                    WHERE s.id_estatusc2 = e2.id
                    AND s.id_etapac2 = et.id
                    AND s.id_ventasfaltanc2 = ?
                    ORDER BY s.id DESC";
                $data=array($id_ventasfaltan);
                if($db->ejecutarQueryPreparado($sql,$data))
                {
                    $rows=$db->obtieneResultado();
                    foreach($rows as $row)
                    {
                        array_push($arrayTMP,array("etapa"=>$row['etapa'], "fecha"=>$row['fecha'], "usuario"=>$row['nombre'], "estatus"=>$row['estatusc2'], "comentario"=>$row['comentario']));
                    }
                    $arrayResult=array("ejecutado"=>1, "etapas"=>$arrayTMP, "errormsg"=>"");
                }
                else {
                    $arrayResult=array("ejecutado"=>0,"etapas"=>"", "errormsg"=>$db->obtieneError());
                }
                break;
        }
        return $arrayResult;
        /*
        {
            "ejecutado":1,
            "etapas":
            [
                {"id_etapa":1,"fecha":"2020-04-17","usuario":"vy25b23","estatus":"Faltante","comentario":"revisado"},
                {"id_etapa":2,"fecha":"2020-04-20","usuario":"vy25b23","estatus":"Financiamiento Cargado","comentario":"corregido"},
                {"id_etapa":3,"fecha":"2020-04-20","usuario":"vy25b23","estatus":"Nota de crédito corregida","comentario":"procesado"}
            ],
            "errormsg":""
        */
    }
    function cambia_asignacion ($db,$jsonDatos,$id_usuario,$nombre,$id_ventasdiarias,$tipo)
    {
        $fecha=strftime("%Y-%m-%d",time());
        /*
        {
            "error":0,
            "errormsg":"",
            "etapaactual":2,
            "tipo":1,
            "datos":
            [
                {"id_ventasfaltan":"1","id_etapa":"2"}
            ],
            "idestatus":3,
            "idtipodepto":2,
            "comentario":"eqpla"
        }
        */
        $arrayResult=array();
        try
        {
            $db->iniciaTransaccion();

            // Isertar en tabla de seguimientoc1 o seguimientoc2
            switch ($tipo)
            {
                case 1:
                    $sql="INSERT INTO seguimientoc1 (id_ventasfaltanc1, id_etapac1, id_usuario, nombre, id_estatusc1, fecha, comentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    break;
                case 2:
                    $sql="INSERT INTO seguimientoc2 (id_ventasfaltanc2, id_etapac2, id_usuario, nombre, id_estatusc2, fecha, comentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                $data=array($value->id_ventasfaltan, $value->id_etapa, $id_usuario, "$nombre", $jsonDatos->idestatus, $fecha, $jsonDatos->comentario);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            // Actualizar tabla de ventasfaltanc1 o ventasfaltanc2
            switch ($tipo)
            {
                case 1:
                    $sql="UPDATE ventasfaltanc1 SET enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
                    break;
                case 2:
                    $sql="UPDATE ventasfaltanc2 SET enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                $data=array($fecha, $jsonDatos->idtipodepto,$value->id_ventasfaltan);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"errormsg"=>"");
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayResult=array("ejecutado"=>0,"errormsg"=>$e->getMessage());
        }
        finally
        {
            return $arrayResult;
        }
    }
    function comentar ($db,$jsonDatos,$id_usuario,$nombre,$id_ventasdiarias,$tipo)
    {
        $fecha=strftime("%Y-%m-%d",time());
        /*
        {
            "error":0,
            "errormsg":"",
            "etapaactual":1,
            "tipo":1,
            "datos":
            [
                {"id_ventasfaltan":"6","id_etapa":"1"},
                {"id_ventasfaltan":"7","id_etapa":"1"},
                {"id_ventasfaltan":"8","id_etapa":"1"}
            ],
            "idestatus":2,
            "idtipodepto":2,
            "comentario":"comentar varios",
            "seguimiento":"comentar"
        }
        */
        $arrayResult=array();
        try
        {
            $db->iniciaTransaccion();

            // Isertar en tabla de seguimientoc1 o seguimientoc2
            switch ($tipo)
            {
                case 1:
                    $sql="INSERT INTO seguimientoc1 (id_ventasfaltanc1, id_etapac1, id_usuario, nombre, id_estatusc1, fecha, comentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    break;
                case 2:
                    $sql="INSERT INTO seguimientoc2 (id_ventasfaltanc2, id_etapac2, id_usuario, nombre, id_estatusc2, fecha, comentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                $data=array($value->id_ventasfaltan, $value->id_etapa, $id_usuario, "$nombre", $jsonDatos->idestatus, $fecha, $jsonDatos->comentario);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"errormsg"=>"");
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayResult=array("ejecutado"=>0,"errormsg"=>$e->getMessage());
        }
        finally
        {
            return $arrayResult;
        }
    }

?>
