<?php

    date_default_timezone_set('America/Argentina/Buenos_Aires');

    //fuente: https://www.lawebdelprogramador.com/codigo/PHP/2483-Ejemplo-de-crear-un-simple-calendario.html
    //https://espanol.epochconverter.com/dias/2020

    $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    $diasLaborales = 2;
    $diasDeDescanso = 9;
    $mesIngreso = 9;
    $diaIngreso = 1;

    $numeroDeDiaDeIngreso = date("z", mktime(0,0,0,$mesIngreso,$diaIngreso+1,date("y")));

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Document</title>
    </head>
    <body>
        <h1>Calendario 2020</h1>

        <?php
        
        echo '<div class="caja-calendario">';

        $diaLaboral = 0;
        $diaDescanso = 0;
        $aux = 0;
        $day = -1;

        // for($p = -7; $p < 5; $p++) {
        for($p = -1; $p < 4; $p++) {

            $diasDespues = 1;
            $month = date("n") + $p;
            $mesAnterior = $month - 1;
            $year=date("Y");
            $diaAnterior = date("t",(mktime(0,0,0,$mesAnterior,1,$year))) + 1;
            $diaActual=date("j");
            
            # Obtenemos el dia de la semana del primer dia
            # Devuelve 0 para domingo, 6 para sabado
            $diaSemana=date("w",mktime(0,0,0,$month,1,$year));

            # Obtenemos el ultimo dia del mes
            $ultimoDiaMes=date("t",(mktime(0,0,0,$month+1,1,$year)-1));
                    
            $last_cell=$diaSemana+$ultimoDiaMes;

            if ($diaSemana == 0) {
                $diaAnterior = $diaAnterior - 7;
            }
            $diasAnterioresParaDescontar = $diaSemana;
            echo '<table id="calendar"><caption>'. $meses[$month] .' '. $year . '</caption><tr><th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th><th>Vie</th><th>Sab</th><th>Dom</th></tr><tr bgcolor="silver">';

            // hacemos un bucle hasta 42, que es el máximo de valores que puede
            // haber... 6 columnas de 7 dias
            for($i=1;$i<=42;$i++) {
                if($i==$diaSemana) {
                    // determinamos en que dia empieza
                    $day=1;
                }
                if($diaSemana == 0) {
                    if($diaSemana == 0 && $i == 7) {
                        $day=1;
                    }
                    if($aux == 1 || (date("z", mktime(0,0,0,$month,$day+1,$year)) == $numeroDeDiaDeIngreso)) {
                        $aux = 1;
                        if($diaLaboral < $diasLaborales && $diaLaboral >= 0) {
                            $valor = 'class="trabajo"';
                            if($i<($diaSemana+7) || $i>=($last_cell+7)) {
                                // echo "a ";
                            } else {
                                $diaLaboral++;
                                if($diaLaboral == $diasDeDescanso) {
                                    $diaDescanso = 0;
                                }
                            }
                        } elseif ($diaDescanso < $diasDeDescanso && $diaDescanso >= 0) {
                            if($i<($diaSemana+7) || $i>=($last_cell+7)) {

                            } else {
                                $valor = 'class="descanso"';    
                                $diaDescanso++;     
                                $diaLaboral = -1;
                                if ($diaDescanso == $diasDeDescanso) {
                                    $diaLaboral = 0;
                                }
                            }
                        }
                    } else {
                        $valor = '';
                    }
                    if($i<($diaSemana+7) || $i>=($last_cell+7)) {
                        // celca vacia
                        if($i<($diaSemana+7)) {
                            // echo '<td class="vacio">&nbsp</td>';
                            $diasAnterioresParaDescontar--;
                            echo '<td class="vacio">'. ($diaAnterior - $diasAnterioresParaDescontar) .'</td>';
                        } else {
                            echo '<td class="vacio">'. $diasDespues++.'</td>';
                        }                    
                    }else{
                          // mostramos el dia
                        if($day==$diaActual && $month == date("n")) {
                            echo '<td class="hoy">' . $day . '</td>';
                        } else {
                            echo '<td ' . $valor . '>' . $day . '</td>';
                        }
                        $day++;
                    }
                } else {
                    if($aux == 1 || (date("z", mktime(0,0,0,$month,$day+1,$year)) == $numeroDeDiaDeIngreso)) {
                        $aux = 1;
                        if($diaLaboral < $diasLaborales && $diaLaboral >= 0) {
                            $valor = 'class="trabajo"';
                            if($i<$diaSemana || $i>=$last_cell) {
                                // echo "a";
                            } else {
                                $diaLaboral++;
                                if($diaLaboral == $diasLaborales) {
                                    $diaDescanso = 0;
                                }
                            }
                        } elseif ($diaDescanso < $diasDeDescanso && $diaDescanso >= 0) {
                            if($i<$diaSemana || $i>=$last_cell) {

                            } else {
                                $valor = 'class="descanso"';    
                                $diaDescanso++;     
                                $diaLaboral = -1;
                                if ($diaDescanso == $diasDeDescanso) {
                                    $diaLaboral = 0;
                                }
                            }
                        }
                        
                    } else {
                        $valor = '';
                    }
                    if($i<$diaSemana || $i>=$last_cell) {
                        // celca vacia
                        if($i<$diaSemana) {
                            $diasAnterioresParaDescontar--;
                            echo '<td class="vacio">'. ($diaAnterior - $diasAnterioresParaDescontar) .'</td>';
                        } else {
                            echo '<td class="vacio">'. $diasDespues++.'</td>';
                        }
                    } else{
                        // mostramos el dia
                        if($day==$diaActual && $month == date("n")) {
                            echo '<td class="hoy">' . $day . '</td>'; 
                        } else {
                            echo '<td ' . $valor . '>' . $day . '</td>';
                        }
                        $day++;
                    }
                }
                // cuando llega al final de la semana, iniciamos una columna nueva
                if($i % 7 == 0)
                {
                    echo "</tr><tr>\n";
                }
            }
            echo '</tr></table>';
        }
        echo '<div>';
        
        ?>

    </body>
</html>
