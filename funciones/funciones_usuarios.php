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
                echo '<button class="dropbtn"><img style="top:14px;" src="img/baseline_keyboard_arrow_down_black_18dp.png">Usuarios</button>';
                echo '<div class="dropdown-content">';
                    echo '<a href="#" id="id_menu_crear">Crear</a>';
                    echo '<a href="#" id="id_menu_modificar">Modificar</a>';
                    echo '<a href="#" id="id_menu_eliminar">Eliminar</a>';
                echo '</div>';
            echo '</div>';

        echo '</div>';
    }

    function genera_tabla_datos($db)
    {
        $salida="";
        $salida .= '<p><h3 style="color:lightgrey;">Usuarios</h3></p>';
        $salida .= '<table id="id_tabla_datos" class="tablaviewport">';
        $salida .=    '<thead>';
        $salida .=        '<tr>';
        $salida .=            '<th></th>';
        $salida .=            '<th>Usuario<br><input class="input_busqueda" style="width:5em;" maxlength="8" type=text onkeyup="filtrar(this)"></th>';
        $salida .=            '<th>Perfil<br><input class="input_busqueda" style="width:8.5em;" maxlength="15" type=text onkeyup="filtrar(this)"></th>';
        $salida .=            '<th>Nombre<br><input class="input_busqueda" style="width:15em;" maxlength="60" type=text onkeyup="filtrar(this)"></th>';
        $salida .=            '<th>Departamento<br><input class="input_busqueda" style="width:25em;" maxlength="70" type=text onkeyup="filtrar(this)"></th>';
        $salida .=            '<th>Correo<br><input class="input_busqueda" style="width:19em;" maxlength="40" type=text onkeyup="filtrar(this)"></th>';
        $salida .=            '<th>Extensión<br>&nbsp</th>';
        $salida .=            '<th></th>';
        $salida .=        '</tr>';
        $salida .=    '</thead>';

        $sql= "SELECT usuarios.id,
                usuarios.usuario,
                usuarios.nombre,
                usuarios.departamento,
                usuarios.correo,
                usuarios.extension,
                usuarios.id_perfil,
                perfiles.nombre AS perfil,
                usuarios.id_deptotipo,
                usuarios.escalacion
            FROM usuarios, perfiles
            WHERE usuarios.id_perfil=perfiles.id
            AND usuarios.id>1
            ORDER BY usuario";

        $data=array();
        $salida .= '<tbody>';
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            foreach($rows as $row)
            {
                $salida .=  '<tr>';
                $salida .=      '<td style="display:none">'.$row['id'].'</td>';
                $salida .=      '<td><img src="img/baseline_account_circle_black_18dp.png"></td>';
                $salida .=      '<td>'.$row['usuario'].'</td>';
                $salida .=      '<td style="display:none">'.$row['id_perfil'].'</td>';
                $salida .=      '<td> <div class="fondocolor" style="'.set_estilo_tipo($row['id_perfil']).'">'.$row['perfil'].'</div> </td>';
                $salida .=      '<td>'.$row['nombre'].'</td>';
                $salida .=      '<td>'.$row['departamento'].'</td>';
                $salida .=      '<td>'.$row['correo'].'</td>';
                $salida .=      '<td>'.$row['extension'].'</td>';
                $salida .=      '<td style="display:none">'.$row['id_perfil'].'</td>';
                $salida .=      '<td style="display:none">'.$row['id_deptotipo'].'</td>';
                $salida .=      '<td style="display:none">'.$row['escalacion'].'</td>';
                $salida .=      '<td align="center"> <input type="radio" name="grupo1"> </td>';
                $salida .=  '</tr>'.PHP_EOL;
            }
        }
        else {
            $salida .= '<tr><td>'.$db->obtieneError().'</td></tr>';
        }
        $salida .= '</tbody>';
        $salida .= '</table>';
        #$salida .= '<script>$("[name=filtro]").keyup(function(e){if(e.keyCode==13){filtrar(this);}}); DefineMarcaRenglon("id_tabla_datos")</script>';
        $salida .= '<script>DefineMarcaRenglon("id_tabla_datos")</script>';

        return $salida;
    }

    function obtiene_perfiles($db)
    {
        $arrayResult=array();
        $arrayTMP=array();

        $sql="SELECT id,nombre FROM perfiles ORDER BY id";
        $data=array();
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            foreach($rows as $row)
            {
                array_push( $arrayTMP,array("id"=>$row['id'], "nombre"=>$row['nombre']) );
            }
            $arrayResult=array("ejecutado"=>1,"perfiles"=>$arrayTMP,"errormsg"=>"");
        }
        else {
            $arrayResult=array("ejecutado"=>0,"perfiles"=>"","errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }

    function obtiene_tipodepto($db)
    {
        $arrayResult=array();
        $arrayTMP=array();

        $sql="SELECT id,tipo FROM tipodepto ORDER BY id";
        $data=array();
        if($db->ejecutarQueryPreparado($sql,$data))
        {
            $rows=$db->obtieneResultado();
            foreach($rows as $row)
            {
                array_push( $arrayTMP,array("id"=>$row['id'], "tipo"=>$row['tipo']) );
            }
            $arrayResult=array("ejecutado"=>1,"tipos"=>$arrayTMP,"errormsg"=>"");
        }
        else {
            $arrayResult=array("ejecutado"=>0,"tipos"=>"","errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }

    function agrega_usuario($db,$jsondatos)
    {
        /*
        {
            "usuario":"universal",
            "nombre":"Nombre Apellido",
            "departamento":"TD",
            "correo":"correo@americamovil.com",
            "extension":"1234",
            "perfil":4,
            "tipodepto":0,
            "notificacion":1
            "password1":"password",
            "validado":1
        }
        */
        $arrayResult=array();
        $etapa=0;
        $lastid=0;
        try
        {
            $db->iniciaTransaccion();

            //Agrega usuario
            $sql="INSERT INTO usuarios (usuario,password,nombre,departamento,id_deptotipo,escalacion,correo,extension,id_perfil) VALUES (?,?,?,?,?,?,?,?,?)";
            $data=array($jsondatos->usuario,password_hash($jsondatos->password1,PASSWORD_BCRYPT),$jsondatos->nombre,$jsondatos->departamento,$jsondatos->tipodepto,$jsondatos->notificacion,$jsondatos->correo,$jsondatos->extension,$jsondatos->perfil);
            $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));
            $lastid=$db->obtieneLastID();

            //Agrega notificacion para perfiles validación, correccion y revisión
            if($jsondatos->perfil==3||$jsondatos->perfil==4||$jsondatos->perfil==5)
            {
                switch ($jsondatos->perfil)
                {
                    case 3: // validacion
                        $etapa=1; break;
                    case 4: // correccion
                        $etapa=2; break;
                    case 5: //Revision
                        $etapa=3; break;
                }
                $sql="INSERT INTO notificaciones (id_etapac1,id_etapac2,id_usuarios) VALUES (?,?,?)";
                $data=array($etapa,$etapa,$lastid);
                $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));
            }

            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"id"=>$lastid,"errormsg"=>"");
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayResult=array("ejecutado"=>0,"id"=>"","errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }

    function modifica_usuario($db,$jsondatos,$id)
    {
        /*
        {
            "usuario":"universal",
            "nombre":"Nombre Apellido",
            "departamento":"TD",
            "correo":"correo@americamovil.com",
            "extension":"1234",
            "perfil":4,
            "tipodepto":0,
            "notificacion":1,
            "password1":"...............",
            "validado":1
        }
        */
        try
        {
            $arrayResult=array();
            $etapa=0;
            $db->iniciaTransaccion();

            // Modifica usuario
            if($jsondatos->password1=="...............") { // No cambia contraseña
                $sql="UPDATE usuarios SET usuario=?,nombre=?,departamento=?,id_deptotipo=?,escalacion=?,correo=?,extension=?,id_perfil=? WHERE id=?";
                $data=array("$jsondatos->usuario", "$jsondatos->nombre", "$jsondatos->departamento", $jsondatos->tipodepto, $jsondatos->notificacion, "$jsondatos->correo", "$jsondatos->extension", $jsondatos->perfil, $id);
            }
            else {  // Cambia contraseña
                $sql="UPDATE usuarios SET usuario=?,password=?,nombre=?,departamento=?,id_deptotipo=?,escalacion=?,correo=?,extension=?,id_perfil=? WHERE id=?";
                $data=array($jsondatos->usuario,password_hash($jsondatos->password1,PASSWORD_BCRYPT),$jsondatos->nombre,$jsondatos->departamento,$jsondatos->tipodepto,$jsondatos->notificacion,"$jsondatos->correo",$jsondatos->extension,$jsondatos->perfil,$id);
            }
            $db->revisaExepcionTransaccion($db->ejecutarQueryPreparadoOneRow($sql,$data));

            //Modifica notificacion
            switch ($jsondatos->perfil)
            {
                case 3: // validacion
                    $etapa=1; break;
                case 4: // correccion
                    $etapa=2; break;
                case 5: //Revision
                    $etapa=3; break;
            }
            $sql="SELECT count(id_usuarios) AS cantidad FROM notificaciones WHERE id_usuarios=?";
            $data=array($id);
            $db->revisaExepcionTransaccion($db->ejecutarQueryPreparadoOneRow($sql,$data));

            if($db->obtieneResultado()[cantidad]==0) // Si no existe notificacion, la crea
            {
                if($jsondatos->perfil==3||$jsondatos->perfil==4||$jsondatos->perfil==5)
                {
                    $sql="INSERT INTO notificaciones (id_etapac1,id_etapac2,id_usuarios) VALUES (?,?,?)";
                    $data=array($etapa,$etapa,$id);
                    $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));
                }
            }
            else
            {
                if($jsondatos->perfil==3||$jsondatos->perfil==4||$jsondatos->perfil==5) // Si ya existe y el nuevo perfil es 3,4,5 se actuaiza
                {
                    $sql="UPDATE notificaciones SET id_etapac1=?, id_etapac2=? WHERE id_usuarios=?";
                    $data=array($etapa,$etapa,$id);
                    $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));
                }
                // else    // Si el cambio es diferente a los perfiles 3,4,5 se borra
                // {
                //     $sql="DELETE FROM notificaciones WHERE id_usuarios=?";
                //     $data=array($id);
                //     $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));
                // }
            }

            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"id"=>$id,"errormsg"=>"");
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayResult=array("ejecutado"=>0,"id"=>"","errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }

    function elimina_usuario($db,$id)
    {
        $arrayResult=array();
        try
        {
            $db->iniciaTransaccion();

            // Borra de notificaciones
            $sql="DELETE FROM notificaciones WHERE id_usuarios=?";
            $data=array($id);
            $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));

            // Borra usuario
            $sql="DELETE FROM usuarios WHERE id=?";
            $data=array($id);
            $db->revisaExepcionTransaccion($db->ejecutarQueryPreparado($sql,$data));

            $db->terminaTransaccion();
            $arrayResult=array("ejecutado"=>1,"id"=>$id,"errormsg"=>"");
        }
        catch (\Exception $e)
        {
            $db->rollbackTransaccion();
            $arrayResult=array("ejecutado"=>0,"id"=>$id,"errormsg"=>$db->obtieneError());
        }
        return $arrayResult;
    }
?>
