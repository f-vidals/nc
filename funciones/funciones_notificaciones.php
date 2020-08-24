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


        echo '</div>';
    }

    function genera_tabla_datos($db,$etapa)
    {
        $salida="";
        switch ($etapa)
        {
            case 1:
                $salida .= '<table width="100%"><tr><td style="text-align:left"><h3 style="color:lightgrey;">Notificaciones etapa 1: Validación</h3></td><td style="text-align:right"><button class="botonbloque" onclick="agregar(1);">Agregar</button> <button class="botonbloque" onclick="quitar(1);">Quitar</button></td></table>';
                break;
            case 2:
                $salida .= '<table width="100%"><tr><td style="text-align:left"><h3 style="color:lightgrey;">Notificaciones etapa 2: Faltante</h3></td><td style="text-align:right"><button class="botonbloque" onclick="agregar(2);">Agregar</button> <button class="botonbloque" onclick="quitar(2);">Quitar</button></td></table>';
                break;
            case 3:
                $salida .= '<table width="100%"><tr><td style="text-align:left"><h3 style="color:lightgrey;">Notificaciones etapa 3: Corregido</h3></td><td style="text-align:right"><button class="botonbloque" onclick="agregar(3);">Agregar</button> <button class="botonbloque" onclick="quitar(3);">Quitar</button></td></table>';
                break;
            case 4:
                $salida .= '<table width="100%"><tr><td style="text-align:left"><h3 style="color:lightgrey;">Notificaciones sin cambio de estado</h3></td><td style="text-align:right"><button class="botonbloque" onclick="agregar(4);">Agregar</button> <button class="botonbloque" onclick="quitar(4);">Quitar</button></td></table>';
                break;
        }
        $salida .= '<div style="width:90%;height:25em;overflow:auto;align:center;">';
        $salida .= '<table id="id_tabla_datos_etapa'.$etapa.'" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th>Usuario<br><input class="input_busqueda" style="width:5em;" maxlength="8" type=text onkeyup="filtrar(this,'.$etapa.')"</th>';
        $salida .=            '<th>Nombre<br><input class="input_busqueda" style="width:15em;" maxlength="60" type=text onkeyup="filtrar(this,'.$etapa.')"</th>';
        $salida .=            '<th>Perfil<br><input class="input_busqueda" style="width:8.5em;" maxlength="15" type=text onkeyup="filtrar(this,'.$etapa.')"</th>';
        $salida .=            '<th>Correo<br><input class="input_busqueda" style="width:19em;" maxlength="40" type=text onkeyup="filtrar(this,'.$etapa.')"</th>';
        $salida .=            '<th>Nivel<br><input class="input_busqueda" style="width:1em;" maxlength="1" type=text onkeyup="filtrar(this,'.$etapa.')"</th>';
        $salida .=            '<th></th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>';

        $sql= "SELECT usuarios.id,
                usuarios.usuario,
                usuarios.nombre,
                usuarios.id_perfil,
                perfiles.nombre AS perfil,
                usuarios.correo,
                usuarios.escalacion
            FROM usuarios,notificaciones,perfiles
            WHERE notificaciones.id_usuarios=usuarios.id
            AND usuarios.id_perfil=perfiles.id
            AND notificaciones.id_etapac1=?
            AND notificaciones.id_etapac2=?
            AND usuarios.id>1
            ORDER BY usuario";

        $data=array($etapa,$etapa);

        $salida .= '<tbody>';
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            foreach($rows as $row)
            {
                $salida .=  '<tr>';
                $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                $salida .=      '<td>'.$row['usuario'].'</td>';
                $salida .=      '<td>'.$row['nombre'].'</td>';
                $salida .=      '<td> <div class="fondocolor" style="'.set_estilo_tipo($row['id_perfil']).'">'.$row['perfil'].'</div> </td>';
                $salida .=      '<td>'.$row['correo'].'</td>';
                $salida .=      '<td>'.$row['escalacion'].'</td>';
                $salida .=      '<td align="center"> <input type="radio" name="grupo1"> </td>';
                $salida .=  '</tr>'.PHP_EOL;
            }
        }
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</tbody>';
        $salida .= '</table></div><br>';
        $salida .= '<script>DefineMarcaRenglon("id_tabla_datos_etapa'.$etapa.'")</script>';

        return $salida;
    }

    function obtiene_usuarios($db)
    {
        $salida="";
        $sql="SELECT id,usuario,nombre,escalacion FROM usuarios WHERE id>1 ORDER BY usuario";
        $data=array();
        $salida .= '<table id="id_tabla_add_usuario" class="tablaviewport" style="display:none">';
        $salida .= '<thead><tr>';
        $salida .= '<th>Usuario<br><input class="input_busqueda" style="width:5em;" maxlength="8" type=text onkeyup="filtraradd(this)"</th>';
        $salida .= '<th>Nombre<br><input class="input_busqueda" style="width:15em;" maxlength="60" type=text onkeyup="filtraradd(this)"</th>';
        $salida .= '<th>Nivel<br><input class="input_busqueda" style="width:1em;" maxlength="1" type=text onkeyup="filtraradd(this)"</th>';
        $salida .= '</tr></thead>';
        $salida .= '<tbody>';
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            foreach($rows as $row)
            {
                $salida .=  '<tr>';
                $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                $salida .=      '<td>'.$row['usuario'].'</td>';
                $salida .=      '<td>'.$row['nombre'].'</td>';
                $salida .=      '<td>'.$row['escalacion'].'</td>';
                $salida .=      '<td style="display:none;align:center;"> <input type="radio" name="grupo_todos_usuarios"> </td>';
                $salida .=  '</tr>'.PHP_EOL;
            }
        }
        else {
            $salida .= '<tr><td colspan="2">'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</tbody>';
        $salida .= '</table>';
        $salida .= '<script>DefineMarcaRenglon("id_tabla_add_usuario");</script>';
        return $salida;
    }

    function agrega_usuarios($db,$id_usuario,$etapa)
    {
        $arrayResult=array();
        $sql="INSERT INTO notificaciones (id_etapac1,id_etapac2,id_usuarios) VALUES (?,?,?)";
        $data=array($etapa,$etapa,$id_usuario);
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $arrayResult=array("ejecutado"=>1,"errormsg"=>"");
        }
        else {
            $arrayResult=array("ejecutado"=>0,"errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }

    function quita_usuarios($db,$id_usuario,$etapa)
    {
        $arrayResult=array();
        $sql="DELETE FROM notificaciones WHERE id_etapac1=? AND id_etapac2=? AND id_usuarios=?";
        $data=array($etapa,$etapa,$id_usuario);
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $arrayResult=array("ejecutado"=>1,"errormsg"=>"");
        }
        else {
            $arrayResult=array("ejecutado"=>0,"errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }
?>
