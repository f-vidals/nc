<?php
    function encabezado()
    {
        $perfilopciones1=explode(",",$_SESSION['perfil']['conciliacion1estadomenu']);               //(vali,falt,corr,proc,regr) -> permisos de acceso a menus
        $perfilopcionessegumiento1=explode(",",$_SESSION['perfil']['conciliacion1seguimientomenu']);//(Reasig,coment) -> permisos de acceso a menus
        $perfilopciones2=explode(",",$_SESSION['perfil']['conciliacion2estadomenu']);               //(vali,falt,corr,proc,regr) -> permisos de acceso a menus
        $perfilopcionessegumiento2=explode(",",$_SESSION['perfil']['conciliacion2seguimientomenu']);//(Reasig,coment) -> permisos de acceso a menus

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
                    echo '<a href="#" >------ Conciliación 1 ------</a>';
                    echo '<a href="#" id="id_menu_rango_1">Seleccionar rango</a>';
                    echo '<a href="#" id="id_menu_todo_1">Seleccionar todo</a>';
                    echo '<a href="#" id="id_menu_des_1">Deseleccionar todo</a>';
                    echo '<a href="#" >------ Conciliación 2 ------</a>';
                    echo '<a href="#" id="id_menu_rango_2">Seleccionar rango</a>';
                    echo '<a href="#" id="id_menu_todo_2">Seleccionar todo</a>';
                    echo '<a href="#" id="id_menu_des_2">Deseleccionar todo</a>';
                echo '</div>';
            echo '</div>';
            echo PHP_EOL;

            echo '<div class="dropdown">';
                echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Etapas</button>';
                echo '<div class="dropdown-content">';
                    echo '<a href="#" >------ Conciliación 1 ------</a>';
                    if($perfilopciones1[1]==1) {echo '<a href="#" id="id_menu_1_2" name="menu_estado">Cambiar a faltante</a>';} //concilicion 1 etapa 2
                    if($perfilopciones1[2]==1) {echo '<a href="#" id="id_menu_1_3" name="menu_estado">Cambiar a corregido</a>';}
                    if($perfilopciones1[3]==1) {echo '<a href="#" id="id_menu_1_4" name="menu_estado">Cambiar a procesado</a>';}
                    if($perfilopciones1[4]==1) {echo '<a href="#" id="id_menu_1_5" name="menu_estado">Regresar etapa</a>';}
                    echo '<a href="#" >------ Conciliación 2 ------</a>';
                    if($perfilopciones2[1]==1) {echo '<a href="#" id="id_menu_2_2" name="menu_estado">Cambiar a faltante</a>';} //concilicion 2 etapa 2
                    if($perfilopciones2[2]==1) {echo '<a href="#" id="id_menu_2_3" name="menu_estado">Cambiar a corregido</a>';}
                    if($perfilopciones2[3]==1) {echo '<a href="#" id="id_menu_2_4" name="menu_estado">Cambiar a procesado</a>';}
                    if($perfilopciones2[4]==1) {echo '<a href="#" id="id_menu_2_5" name="menu_estado">Regresar etapa</a>';}
                echo '</div>';
            echo '</div>';
            echo PHP_EOL;

            echo '<div class="dropdown">';
                echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Seguimiento</button>';
                echo '<div class="dropdown-content">';
                    echo '<a href="#" >------ Conciliación 1 ------</a>';
                    if($perfilopcionessegumiento1[0]==1) {echo '<a href="#" id="id_menu_reasignar_1" name="menu_seguimiento">Reasignar</a>';}
                    if($perfilopcionessegumiento1[1]==1) {echo '<a href="#" id="id_menu_comentar_1"  name="menu_seguimiento">Comentar</a>';}
                    echo '<a href="#" >------ Conciliación 2 ------</a>';
                    if($perfilopcionessegumiento2[0]==1) {echo '<a href="#" id="id_menu_reasignar_2" name="menu_seguimiento">Reasignar</a>';}
                    if($perfilopcionessegumiento2[1]==1) {echo '<a href="#" id="id_menu_comentar_2"  name="menu_seguimiento">Comentar</a>';}
                echo '</div>';
            echo '</div>';
            echo PHP_EOL;

            echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Datos</button>';
                    echo '<div class="dropdown-content">';
                        echo '<a href="#" >------ Conciliación 1 ------</a>';
                        echo '<a href="#" id="id_menu_exportar_1">Exportar CSV</a>';
                        echo '<a href="#" >------ Conciliación 2 ------</a>';
                        echo '<a href="#" id="id_menu_exportar_2">Exportar CSV</a>';
                    echo '</div>';
                echo '</div>';
                echo PHP_EOL;

        echo '</div>';
    }

    # Genera tabla principal de conciliacion 1
    function genera_tabla_datos_ventasVS5archivos($db,$pagina,$id_tipodepto)
    {
        $arrayEstadoPermiso=explode(',',$_SESSION['perfil']['conciliacion1estadomenu']);
        $salida = "";

        //Calcula paginación
        $rowsCount=0;
        $total=0;
        list($page,$limit,$offset)=calculaPaginacion($pagina);
        $salida .= '<p><h3 style="color:lightgrey;">Pendientes Ventas VS 5archivos</h3></p>';

        $salida .= '<table id="id_tabla_ventasfaltan_1" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th>Conciliac<br>&nbsp</th>';
        $salida .=            '<th>Tipo<br><input class="input_busqueda" style="width:6em;" maxlength="20" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th>Finan<br><input class="input_busqueda" style="width:3.4em;" maxlength="8" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th>FV<br><input class="input_busqueda" style="width:3.5em;" maxlength="10" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th>Folio<br><input class="input_busqueda" style="width:3.5em;" maxlength="8" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th>IMEI<br><input class="input_busqueda" style="width:8.5em;" maxlength="15" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th>Merc<br>&nbsp</th>';
        $salida .=            '<th>Plaz<br>&nbsp</th>';
        $salida .=            '<th>Linea<br><input class="input_busqueda" style="width:5.5em;" maxlength="10" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th>Fecha Activ</th>';
        $salida .=            '<th>Mont Fin</th>';
        $salida .=            '<th>Ant Negg</th>';
        $salida .=            '<th>Etapa<br><input class="input_busqueda" style="width:5.5em;" maxlength="10" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th>Asignado<br><input class="input_busqueda" style="width:6em;" maxlength="11" type=text onkeyup="filtrar(this,1)"</th>';
        $salida .=            '<th></th>';
        $salida .=            '<th></th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>'.PHP_EOL;

        if ($id_tipodepto==0)   // Si el tipo es OTRO, muestra el de todos los departamentos
        {
            $sql= "SELECT SQL_CALC_FOUND_ROWS
                    ventasfaltanc1.id,
                    ventasdiarias.fecha,
                    ventasfaltanc1.id_ventasdiarias,
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
                FROM ventasfaltanc1, etapac1, tipodepto, ventasdiarias
                WHERE ventasfaltanc1.id_etapac1=etapac1.id AND ventasfaltanc1.id_tipodepto=tipodepto.id
                AND ventasdiarias.id = ventasfaltanc1.id_ventasdiarias
                AND id_etapac1 <4
                ORDER BY fecha DESC, imei ASC LIMIT ?,?";
            $data=array($offset,$limit);
        }
        else
        {
            $sql= "SELECT SQL_CALC_FOUND_ROWS
                    ventasfaltanc1.id,
                    ventasdiarias.fecha,
                    ventasfaltanc1.id_ventasdiarias,
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
                FROM ventasfaltanc1, etapac1, tipodepto, ventasdiarias
                WHERE ventasfaltanc1.id_etapac1=etapac1.id AND ventasfaltanc1.id_tipodepto=tipodepto.id
                AND ventasdiarias.id = ventasfaltanc1.id_ventasdiarias
                AND tipodepto.id =? AND id_etapac1 <4
                ORDER BY fecha DESC, imei ASC LIMIT ?,?";
            $data=array($id_tipodepto,$offset,$limit);
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
                $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                $salida .=      '<td>'.$row['fecha'].'</td>';
                $salida .=      '<td style="display:none">'.$row['id_ventasdiarias'].'</td>';
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
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</table>';
        $salida .= '<script type="text/javascript">$("[name=name_etapa_1]").click(function(){verFlujo(this,1);});</script>';

        //Barra de Paginación
        list($totalPag,$paginacion)=barraDePaginacion($total,$limit,$page);
        $salida .= '<br>'.$paginacion;
        $salida .= '<script type="text/javascript">DefineClickPaginacion('.$totalPag.',1);</script>';

        return $salida;
    }

    # Genera datos para exportar de conciliacion 1
    function genera_datos_exportar_ventasVS5archivos($db,$id_tipodepto)
    {
        $arrayTMP=array();
        $arrayResult=array();
        if ($id_tipodepto==0)   // Si el tipo es OTRO, muestra el de todos los departamentos
        {
            $sql= "SELECT p.fecha,p.tipo,p.financiamiento,p.fuerzavta,p.folio,p.imei,p.mercado,p.plazo,p.linea,p.fechaact,p.montofinanciado,p.anticiponegges,p.nombre,p.asignado,p.id_vtasfaltan,s.comentario,s.id
                FROM
                (
	                SELECT ventasdiarias.fecha,
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
	                etapac1.nombre,
	                tipodepto.tipo AS asignado,
	                ventasfaltanc1.id AS id_vtasfaltan
                    FROM ventasfaltanc1, etapac1, tipodepto, ventasdiarias
	                WHERE ventasfaltanc1.id_etapac1=etapac1.id AND ventasfaltanc1.id_tipodepto=tipodepto.id
	                AND ventasdiarias.id = ventasfaltanc1.id_ventasdiarias
	                AND ventasfaltanc1.id_etapac1 <4
                ) AS p
                LEFT JOIN seguimientoc1 AS s
                ON p.id_vtasfaltan = s.id_ventasfaltanc1
                ORDER BY fecha DESC, imei ASC, id_vtasfaltan, id DESC";
            $data=array();
        }
        else
        {
            $sql= "SELECT p.fecha,p.tipo,p.financiamiento,p.fuerzavta,p.folio,p.imei,p.mercado,p.plazo,p.linea,p.fechaact,p.montofinanciado,p.anticiponegges,p.nombre,p.asignado,p.id_vtasfaltan,s.comentario,s.id
                FROM
                (
	                SELECT ventasdiarias.fecha,
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
	                etapac1.nombre,
	                tipodepto.tipo AS asignado,
	                ventasfaltanc1.id AS id_vtasfaltan
                    FROM ventasfaltanc1, etapac1, tipodepto, ventasdiarias
	                WHERE ventasfaltanc1.id_etapac1=etapac1.id AND ventasfaltanc1.id_tipodepto=tipodepto.id
	                AND ventasdiarias.id = ventasfaltanc1.id_ventasdiarias
	                AND ventasfaltanc1.id_tipodepto=? AND ventasfaltanc1.id_etapac1 <4
                ) AS p
                LEFT JOIN seguimientoc1 AS s
                ON p.id_vtasfaltan = s.id_ventasfaltanc1
                ORDER BY fecha DESC, imei ASC, id_vtasfaltan, id DESC";
            $data=array($id_tipodepto);
        }
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $id_vtasfaltan_anterior=0;

            foreach($rows as $row)
            {
                if ($row['id_vtasfaltan']!=$id_vtasfaltan_anterior)  # Solo agrega el último comentario
                {
                    array_push($arrayTMP,array($row['fecha'],$row['tipo'],$row['financiamiento'],$row['fuerzavta'],$row['folio'],$row['imei'],$row['mercado'],$row['plazo'],$row['linea'],$row['fechaact'],$row['montofinanciado'],$row['anticiponegges'],$row['nombre'],$row['asignado'],$row['comentario']));
                }
                $id_vtasfaltan_anterior=$row['id_vtasfaltan'];
            }
            $arrayResult=array("ejecutado"=>1,"tipo"=>1,"datos"=>$arrayTMP,"errormsg"=>"");
        }
        else {$arrayResult=array("ejecutado"=>0,"tipo"=>1,"datos"=>"","errormsg"=>$db->obtieneError());}

        return $arrayResult;
    }

    # Genera tabla principal de conciliacion 2
    function genera_tabla_datos_5archivosVSsap($db,$pagina,$id_tipodepto)
    {
        $arrayEstadoPermiso=explode(',',$_SESSION['perfil']['conciliacion2estadomenu']);
        $salida="";

        //Calcula paginación
        $rowsCount=0;
        $total=0;
        list($page,$limit,$offset)=calculaPaginacion($pagina);
        $salida .= '<p><h3 style="color:lightgrey;">Pendientes 5archivos VS SAP</h3></p>';

        $salida .= '<table id="id_tabla_ventasfaltan_2" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th>Conciliac<br>&nbsp</th>';
        $salida .=            '<th>IMEI<br><input class="input_busqueda" style="width:8.5em;" maxlength="15" type=text onkeyup="filtrar(this,2)"</th>';
        $salida .=            '<th>Linea<br><input class="input_busqueda" style="width:5.5em;" maxlength="10" type=text onkeyup="filtrar(this,2)"</th>';
        $salida .=            '<th>FV<br><input class="input_busqueda" style="width:3em;" maxlength="10" type=text onkeyup="filtrar(this,2)"</th>';
        $salida .=            '<th>RFC<br>&nbsp</th>';
        $salida .=            '<th>Nombre<br>&nbsp</th>';
        $salida .=            '<th>Fecha Activ</th>';
        $salida .=            '<th>Mensaje SAP<br>&nbsp</th>';
        $salida .=            '<th>Etapa<br><input class="input_busqueda" style="width:5.5em;" maxlength="10" type=text onkeyup="filtrar(this,2)"</th>';
        $salida .=            '<th>Asignado<br><input class="input_busqueda" style="width:5.5em;" maxlength="11" type=text onkeyup="filtrar(this,2)"</th>';
        $salida .=            '<th></th>';
        $salida .=            '<th></th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>'.PHP_EOL;

        if ($id_tipodepto==0)   // Si el tipo es OTRO, muestra el de todos los departamentos
        {
            $sql= "SELECT SQL_CALC_FOUND_ROWS
                    ventasfaltanc2.id,
                    ventasdiarias.fecha,
                    ventasfaltanc2.id_ventasdiarias,
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
                    tipodepto.tipo AS asignado
                FROM ventasfaltanc2, etapac2, tipodepto, ventasdiarias
                WHERE ventasfaltanc2.id_etapac2=etapac2.id AND ventasfaltanc2.id_tipodepto=tipodepto.id
                AND ventasdiarias.id = ventasfaltanc2.id_ventasdiarias
                AND id_etapac2 <4
                ORDER BY fecha desc, imei asc LIMIT ?,?";
            $data=array($offset,$limit);
        }
        else
        {
            $sql= "SELECT SQL_CALC_FOUND_ROWS
                    ventasfaltanc2.id,
                    ventasdiarias.fecha,
                    ventasfaltanc2.id_ventasdiarias,
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
                    tipodepto.tipo AS asignado
                FROM ventasfaltanc2, etapac2, tipodepto, ventasdiarias
                WHERE ventasfaltanc2.id_etapac2=etapac2.id AND ventasfaltanc2.id_tipodepto=tipodepto.id
                AND ventasdiarias.id = ventasfaltanc2.id_ventasdiarias
                AND tipodepto.id =? AND id_etapac2 <4
                ORDER BY fecha desc, imei asc LIMIT ?,?";
            $data=array($id_tipodepto,$offset,$limit);
        }

        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $sql = "SELECT FOUND_ROWS() as total";
            $data=array();
            $db->ejecutarQueryPreparadoOneRow($sql,$data);
            $total=$db->obtieneResultado()['total'];

            foreach ($rows as $row)
            {
                $salida .=  '<tr>';
                $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                $salida .=      '<td>'.$row['fecha'].'</td>';
                $salida .=      '<td style="display:none">'.$row['id_ventasdiarias'].'</td>';
                $salida .=      '<td style="display:none">'.$row['tipo'].'</td>';
                $salida .=      '<td style="display:none">'.$row['financiamiento'].'</td>';
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
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</table>';
        $salida .= '<script type="text/javascript">$("[name=name_etapa_2]").click(function(){verFlujo(this,2);});</script>';

        //Barra de Paginación
        list($totalPag,$paginacion)=barraDePaginacion($total,$limit,$page);
        $salida .= '<br>'.$paginacion;
        $salida .= '<script type="text/javascript">DefineClickPaginacion('.$totalPag.',2);</script>';

        return $salida;
    }

    # Genera datos para exportar de conciliacion 2
    function genera_datos_exportar_5archivosVSsap($db,$id_tipodepto)
    {
        $arrayTMP=array();
        $arrayResult=array();
        if ($id_tipodepto==0)   // Si el tipo es OTRO, muestra el de todos los departamentos
        {
            $sql= "SELECT p.fecha,p.tipo,p.folio,p.financiamiento,p.imei,p.linea,p.fuerzavta,p.rfc,p.nombre,p.fechaact,p.mensajesap,p.nombreetapa,p.asignado,p.asignado,p.id_vtasfaltan,s.comentario,s.id
                FROM
                (
	                SELECT
	                ventasdiarias.fecha,
	                ventasfaltanc2.tipo,
	                ventasfaltanc2.folio,
	                ventasfaltanc2.financiamiento,
	                ventasfaltanc2.imei,
	                ventasfaltanc2.linea,
	                ventasfaltanc2.fuerzavta,
	                ventasfaltanc2.rfc,
	                ventasfaltanc2.nombre,
	                ventasfaltanc2.fechaact,
	                ventasfaltanc2.mensajesap,
	                etapac2.nombre AS nombreetapa,
	                tipodepto.tipo AS asignado,
	                ventasfaltanc2.id AS id_vtasfaltan
	                FROM ventasfaltanc2, etapac2, tipodepto, ventasdiarias
	                WHERE ventasfaltanc2.id_etapac2=etapac2.id AND ventasfaltanc2.id_tipodepto=tipodepto.id
	                AND ventasdiarias.id = ventasfaltanc2.id_ventasdiarias
	                AND ventasfaltanc2.id_etapac2 <4
                ) AS p
                LEFT JOIN seguimientoc2 AS s
                ON p.id_vtasfaltan = s.id_ventasfaltanc2
                ORDER BY fecha DESC, imei ASC, id_vtasfaltan, id DESC";
                $data=array();
        }
        else
        {
            $sql= "SELECT p.fecha,p.tipo,p.folio,p.financiamiento,p.imei,p.linea,p.fuerzavta,p.rfc,p.nombre,p.fechaact,p.mensajesap,p.nombreetapa,p.asignado,p.asignado,p.id_vtasfaltan,s.comentario,s.id
                FROM
                (
	                SELECT
	                ventasdiarias.fecha,
	                ventasfaltanc2.tipo,
	                ventasfaltanc2.folio,
	                ventasfaltanc2.financiamiento,
	                ventasfaltanc2.imei,
	                ventasfaltanc2.linea,
	                ventasfaltanc2.fuerzavta,
	                ventasfaltanc2.rfc,
	                ventasfaltanc2.nombre,
	                ventasfaltanc2.fechaact,
	                ventasfaltanc2.mensajesap,
	                etapac2.nombre AS nombreetapa,
	                tipodepto.tipo AS asignado,
	                ventasfaltanc2.id AS id_vtasfaltan
	                FROM ventasfaltanc2, etapac2, tipodepto, ventasdiarias
	                WHERE ventasfaltanc2.id_etapac2=etapac2.id AND ventasfaltanc2.id_tipodepto=tipodepto.id
	                AND ventasdiarias.id = ventasfaltanc2.id_ventasdiarias
                    AND ventasfaltanc2.id_tipodepto=? AND ventasfaltanc2.id_etapac2 <4
                ) AS p
                LEFT JOIN seguimientoc2 AS s
                ON p.id_vtasfaltan = s.id_ventasfaltanc2
                ORDER BY fecha DESC, imei ASC, id_vtasfaltan, id DESC";
            $data=array($id_tipodepto);
        }
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            $id_vtasfaltan_anterior=0;

            foreach($rows as $row)
            {
                if ($row['id_vtasfaltan']!=$id_vtasfaltan_anterior)  # Solo agrega el último comentario
                {
                    array_push($arrayTMP,array($row['fecha'],$row['folio'],$row['imei'],$row['linea'],$row['fuerzavta'],$row['rfc'],$row['nombre'],$row['fechaact'],$row['mensajesap'],$row['nombreetapa'],$row['asignado'],$row['comentario']));
                }
                $id_vtasfaltan_anterior=$row['id_vtasfaltan'];
            }
            $arrayResult=array("ejecutado"=>1,"tipo"=>1,"datos"=>$arrayTMP,"errormsg"=>"");
        }
        else {$arrayResult=array("ejecutado"=>0,"tipo"=>1,"datos"=>"","errormsg"=>$db->obtieneError());}

        return $arrayResult;
    }

    function cambia_estado($db,$jsonDatos,$id_usuario,$nombre)
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
                {"id_ventasfaltan":"100","id_vtasdiarias":"2","tipo":"activaciones","finan":"C. finan","id_etapa":"1"},
                {"id_ventasfaltan":"101","id_vtasdiarias":"2","tipo":"activaciones","finan":"C. finan","id_etapa":"1"}
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
            switch ($jsonDatos->tipo)
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
            switch ($jsonDatos->tipo)
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
            }

            // Actualizar tabla de ventasdiarias cuando se pase a procesado
            if($jsonDatos->etapanueva==4)
            {
                $sql="CALL actualizaventasdiarias(?,?)";

                $primer=True;
                $id_ventas_diarias_anterior=0;
                $id_ventas_diarias_actual=0;
                foreach ($jsonDatos->datos as $key => $value)
                {
                    $id_ventas_diarias_actual=$value->id_vtasdiarias;
                    if($primer) { $primer=False;}
                    else
                    {
                        if($id_ventas_diarias_anterior!=$id_ventas_diarias_actual)
                        {
                            $data=array($id_ventas_diarias_anterior, $jsonDatos->tipo);
                            $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
                        }
                    }
                    $id_ventas_diarias_anterior=$id_ventas_diarias_actual;
                }
                $data=array($id_ventas_diarias_actual, $jsonDatos->tipo);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"etapa"=>$jsonDatos->etapanueva,"errormsg"=>"");
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayResult=array("ejecutado"=>0,"etapa"=>$jsonDatos->etapanueva,"errormsg"=>$e->getMessage());
        }
        finally
        {
            return $arrayResult;
        }
    }

    function regresa_estado($db,$jsonDatos,$id_usuario,$nombre)
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
                {"id_ventasfaltan":"100","id_vtasdiarias":"2","tipo":"activaciones","finan":"C. finan","id_etapa":"1"},
            ],
            "idestatus":1,
            "comentario":"script>alert(\"hola\")</script>"
        }
        */
        $arrayResult=array();
        try
        {
            $db->iniciaTransaccion();

            //Inserta seguimiento el regreso de etapa
            switch ($jsonDatos->tipo)
            {
                case 1:
                    $sql="INSERT INTO seguimientoc1 (id_ventasfaltanc1, id_etapac1, id_usuario, nombre, id_estatusc1, fecha, comentario) VALUES (?,?,?,?,?,?,?)";
                    break;
                case 2:
                    $sql="INSERT INTO seguimientoc2 (id_ventasfaltanc2, id_etapac2, id_usuario, nombre, id_estatusc2, fecha, comentario) VALUES (?,?,?,?,?,?,?)";
                    break;
            }
            foreach ($jsonDatos->datos as $key => $value)
            {
                $data=array($value->id_ventasfaltan, $jsonDatos->idestatus,$id_usuario,"$nombre",4,"$fecha","Regreso desde etapa $jsonDatos->etapaactual:".substr($jsonDatos->comentario,0,78)); // id_estatuscx = comentario
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }

            // Actualizar tabla de ventasfaltanc1 o ventasfaltanc2
            switch ($jsonDatos->tipo)
            {
                case 1:
                    $sql="UPDATE ventasfaltanc1 SET id_etapac1=?, enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
                    break;
                case 2:
                    $sql="UPDATE ventasfaltanc2 SET id_etapac2=?, enviado=0, etapafecha=?, id_tipodepto=? WHERE id=?";
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
            }

            // Actualizar tabla de ventasdiarias cuando se regrese de procesado
            if($jsonDatos->etapanueva==4)
            {
                $sql="CALL actualizaventasdiarias(?,?)";

                $primer=True;
                $id_ventas_diarias_anterior=0;
                $id_ventas_diarias_actual=0;
                foreach ($jsonDatos->datos as $key => $value)
                {
                    $id_ventas_diarias_actual=$value->id_vtasdiarias;
                    if($primer) { $primer=False;}
                    else
                    {
                        if($id_ventas_diarias_anterior!=$id_ventas_diarias_actual)
                        {
                            $data=array($id_ventas_diarias_anterior, $jsonDatos->tipo);
                            $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
                        }
                    }
                    $id_ventas_diarias_anterior=$id_ventas_diarias_actual;
                }
                $data=array($id_ventas_diarias_actual, $jsonDatos->tipo);
                $db->revisaExepcionTransaccionProcedure($db->ejecutarQueryPreparadoOneRow($sql,$data));
            }
            else {
                $arrayResult=array("ejecutado"=>1,"etapa"=>$jsonDatos->idestatus,"errormsg"=>"");
            }
            $db->terminaTransaccion();
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayError=explode("|",$e->getMessage());
            $arrayResult=array("ejecutado"=>0,"etapa"=>$jsonDatos->idestatus,"errormsg"=>"$arrayError[1]");
        }
        finally
        {
            return $arrayResult;
        }
    }
?>
