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


?>
