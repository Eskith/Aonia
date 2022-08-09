<?php

/*
    A1 = 1; 
    A2 = 2; 
    B1 = 3; 
    B2 = 4; 
    C1 = 5; 
    C2 = 6; 

*/

function getDescriptores(array $arr)
{
    require "app/config/descriptores.php"; 
    $result = []; 
    $i = 0; 
    foreach ($arr as $key => $value) {
        $result[$key] = $descriptores[$i][$value];
        $i++;
    }
    return $result; 
}


function getRecomendaciones(array $arr)
{
    require_once "app/config/recomendaciones.php"; 
    $result = []; 
    $i = 0; 
    foreach ($arr as $key => $value) {
        $result[$key] = $recomendaciones[$i][$value];
        $i++;
    }
    return $result; 
}

function replaceMarkNumberToString(array $arr)
{
    return array_map(function ( $n)
    {
        if($n < 1.6) return 'A1';
        elseif ($n < 2.6) return 'A2'; 
        elseif ($n < 3.6) return 'B1'; 
        elseif ($n < 4.6) return 'B2'; 
        elseif ($n < 5.6) return 'C1'; 
        elseif ($n < 6.6) return 'C2'; 
        else return '??'; 
    }, $arr);
}

function replaceMarkStringToNumber(array $arr)
{
    return array_map(function (string $s)
    {
        return str_replace(['A1', 'A2', 'B1', 'B2', 'C1', 'C2'],[1, 2, 3, 4, 5, 6], strtoupper($s)); 
    }, $arr);
}

/*
Función que genera las calificaciones

*/
function generateMarks(array $responses):array
{   

    /** Agrupamos las respuestas por áreas */ 
    $groupedResponses = [];
    foreach ($responses as $key => $value) { /* respuesta_ {area}_{numero de respuesta en ese area} */
        $aux = explode('_', $key); 
        $groupedResponses['area_'.$aux[1]][] = $value;
    }
    /*groupedResponses ==>  area_1 =>[1, 3, 2, 1], area_2, ....*/
    $mark = [];

    //var_dump($groupedResponses);
    foreach ($groupedResponses as $key => $areaResponses) {
        
        $mark[$key] = calculateMark($areaResponses);
    }
    //var_dump($mark); 
    $mark = replaceMarkStringToNumber($mark); 
    $mark["finalMark"] = array_sum($mark)/count($mark);
    return $mark; 

}

function calculateMark(Array &$areaResponses): string
{
    switch (normalizacionYNumeroDePreguntas($areaResponses)) {
        case 3:
            return preguntas3($areaResponses);
            break;
        case 4:
            return preguntas4($areaResponses);
            break;
        case 6:
            return preguntas6($areaResponses);
            break;
        
        default:
            die("No hay reglas para un área de ".count($areaResponses)." preguntas."); 
            break;
    }
}

function normalizacionYNumeroDePreguntas(array &$areaResponses)
{
    $n = count($areaResponses);
    // Calculamos la frecuencia de las respuestas
    $array =  count_chars(strtoupper(implode($areaResponses)), 1); 

    //Cambiamos el valor numérico de las letras por su valor gráfico.
    $areaResponses = array_combine(array_map(function (string $key){ return chr($key);}, array_keys($array)),$array);

    //Normalizamos a que siempre haya 4 respuestas con A-D
    foreach (['A', 'B', 'C', 'D'] as $letter) {
        $areaResponses[$letter] = isset($areaResponses[$letter]) ? $areaResponses[$letter] : 0; 
    }

    //Restamos las preguntas D
    restar($areaResponses, $areaResponses['D']);
    return $n; 
}

function restar(array &$arr, int $n = 1)
{   
    //var_dump($arr);
    for ($d=0; $d < $n; $d++) { 
        //ordenado por frecuencia >
        arsort($arr, SORT_NUMERIC);
        $letters = array_keys($arr);
        //Se recorren las letras por orden de frecuencia
        $i = 0; 
        $biggerLetter = $letters[$i] != 'D' ? $letters[$i] : $letters[++$i] ;
        while ($i < count($letters)-1 && $arr[$letters[$i]] === $arr[$letters[$i+1]]) {
            //Evitamos que se inserte la letra D
            $biggerLetter = $letters[++$i] !== 'D' && $biggerLetter < $letters[$i] ? $letters[$i] : $biggerLetter; 

        }
        --$arr[$biggerLetter];
    }

}

/* 3 preguntas */
function preguntas3(array $responses) : string
{

    if($responses['D'] === 0){ //No se restan preguntas
        if($responses['A'] === 3){return 'A1';}  // caso 1
        elseif ($responses['A'] === 2 && ( $responses['B'] === 1 || $responses['C'] === 1 )) {return 'A2';} //caso 2
        elseif ($responses['B'] === 3) {return 'B1';} //caso 3
        elseif ($responses['B'] === 2 && $responses['A'] === 1) {return 'B1';} //caso 4
        elseif ($responses['B'] === 2 && $responses['C'] === 1) {return 'B2';} //caso 5
        elseif ($responses['C'] === 2 && ( $responses['A'] === 1 || $responses['B'] === 1 )) {return 'C1';} //caso 6
        elseif ($responses['C'] === 3) {return 'C2';} //caso 7
        elseif ($responses['A'] === 1 && $responses['B'] === 1 && $responses['C'] === 1) {return 'B1';} //caso 8
    }elseif ($responses['D'] === 1) { // Se resta 1 pregunta
        if($responses['A'] === 1 || $responses['B'] === 1){return 'A1';} // Casos 1 y 2
        elseif ($responses['C'] === 1) {return 'A2';} //caso 3
    }elseif ($responses['D'] > 1) { // Se restan 2 preguntas
        return 'A1';
    }

    return '??';
}

/* 4 preguntas */
function preguntas4(array $responses) : string
{

    if($responses['D'] === 0){ //No se restan preguntas
        if($responses['A'] === 4){return 'A1';}  // caso 1
        elseif ($responses['A'] === 3 && ( $responses['B'] === 1 || $responses['C'] === 1 )) {return 'A2';} //caso 2
        elseif ($responses['A'] === 2 && $responses['B'] === 2) {return 'A2';} //caso 3
        elseif ($responses['A'] === 2 && $responses['B'] === 1 && $responses['C'] === 1) {return 'A2';} //caso 4
        elseif ($responses['A'] === 2 && $responses['C'] === 2) {return 'B1';} //caso 5

        if($responses['B'] === 4){return 'B1';}  // caso 6
        elseif ($responses['B'] === 3 && $responses['A'] === 1) {return 'B1';} //caso 7
        elseif ($responses['B'] === 3 && $responses['C'] === 1) {return 'B2';} //caso 8
        elseif ($responses['B'] === 2 && $responses['A'] === 1 && $responses['C'] === 1) {return 'B1';} //caso 9
        elseif ($responses['B'] === 2 && $responses['C'] === 2) {return 'B2';} //caso 10

        if($responses['C'] === 4){return 'C2';}  // caso 13
        elseif ($responses['C'] === 2 && $responses['A'] === 1 && $responses['B'] === 1) {return 'B2';} //caso 11
        elseif ($responses['C'] === 3 && ( $responses['A'] === 1 || $responses['B'] === 1 )) {return 'C1';} //caso 12

    }elseif ($responses['D'] === 1) { // Se resta 1 pregunta
        if($responses['A'] === 2){return 'A1';}  // caso 1
        elseif ($responses['A'] === 1 && ( $responses['B'] === 1 || $responses['C'] === 1 )) {return 'A2';} //caso 2
        elseif($responses['B'] === 2){return 'B1';}  // caso 3
        elseif ($responses['B'] === 1 && $responses['C'] === 1) {return 'B1';} //caso 4
        elseif($responses['C'] === 2){return 'B2';}  // caso 5
    }elseif ($responses['D'] > 1) { // Se restan 2 preguntas
        return 'A1';
    }

    return '??';
}

/* 6 preguntas */
function preguntas6(array $responses) : string
{

    //print_r($responses);

    if($responses['D'] === 0){ //No se restan preguntas
        if($responses['A'] === 6){return 'A1';}  // caso 1
        elseif ($responses['A'] === 5 && ( $responses['B'] === 1 || $responses['C'] === 1 )) {return 'A1';} //caso 2
        elseif ($responses['A'] === 4 && ( $responses['B'] > 0 || $responses['C'] > 0 )) {return 'A2';} //caso 3
        elseif ($responses['A'] === 3 && ($responses['B'] === 3 || ($responses['B'] === 2 && $responses['C'] === 1)) ) {return 'B1';} //caso 4
        elseif ($responses['A'] === 3 && ($responses['C'] === 3 || ($responses['C'] === 2 && $responses['B'] === 1)) ) {return 'B1';} //caso 5
        elseif ($responses['A'] === 2 && $responses['B'] === 2 && $responses['C'] === 2) {return 'B1';} //caso 6

        elseif ($responses['B'] === 6) {return 'B1';} //caso 7
        elseif ($responses['B'] === 5 && ( $responses['A'] === 1 || $responses['C'] === 1 )) {return 'B1';} //caso 8
        elseif ($responses['B'] === 4 && $responses['A'] === 2) {return 'B1';} //caso 9
        elseif ($responses['B'] === 3 && $responses['A'] === 2 && $responses['C'] === 1) {return 'B1';} //caso 10
        elseif ($responses['B'] === 4 && $responses['C'] === 2) {return 'B2';} //caso 11
        elseif ($responses['B'] === 4 && $responses['A'] === 1 && $responses['C'] === 1) {return 'B1';} //caso 12
        elseif ($responses['B'] === 3 && ( $responses['C'] === 3 || ($responses['C'] === 2 && $responses['A'] === 1) )) {return 'B2';} //caso 13
        elseif ($responses['B'] === 3 && $responses['C'] === 2 && $responses['A'] === 1) {return 'B2';} //caso 14
        elseif ($responses['B'] === 3 && $responses['A'] === 2 && $responses['C'] === 1) {return 'B1';} //caso 21

        elseif ($responses['C'] === 6) {return 'C2';} //caso 15
        elseif ($responses['C'] === 5 && ($responses['A'] === 1 || $responses['B'] === 1)) {return 'C1';} //caso 16 (ERROR)
        elseif ($responses['C'] === 4 && ( $responses['B'] === 2 || $responses['A'] === 2 )) {return 'C1';} //caso 17
        elseif ($responses['C'] === 4 && $responses['B'] === 1 && $responses['A'] === 1) {return 'C1';} //caso 18
        elseif ($responses['C'] === 3 && $responses['B'] === 2 && $responses['A'] === 1) {return 'C1';} //caso 19
        elseif ($responses['C'] === 3 && $responses['A'] === 2 && $responses['B'] === 1) {return 'B2';} //caso 20

    }elseif ($responses['D'] === 1) { // Se resta 1 pregunta (4 respuestas en total)
        if($responses['A'] === 4){return 'A1';}  // caso 1
        elseif ($responses['A'] === 3 && ( $responses['B'] === 1 || $responses['C'] === 1 )) {return 'A2';} //caso 2
        elseif ($responses['A'] === 2 && $responses['B'] === 2) {return 'A2';} //caso 3
        elseif ($responses['A'] === 2 && $responses['C'] === 2) {return 'B1';} //caso 4
        elseif ($responses['A'] === 2 && $responses['B'] === 1 && $responses['C'] === 1) {return 'A2';} //caso 5

        elseif($responses['B'] === 4){return 'B1';}  // caso 6
        elseif ($responses['B'] === 3 && $responses['A'] === 1) {return 'B1';} //caso 7
        elseif ($responses['B'] === 3 && $responses['C'] === 1) {return 'B2';} //caso 8
        elseif ($responses['B'] === 2 && $responses['A'] === 1 && $responses['C'] === 1) {return 'B1';} //caso 9
        elseif ($responses['B'] === 2 && $responses['C'] === 2) {return 'B2';} //caso 10

        elseif ($responses['C'] === 2 && $responses['A'] === 1 && $responses['B'] === 1) {return 'B2';} //caso 11
        elseif ($responses['C'] === 3 && ( $responses['A'] === 1 || $responses['B'] === 1 )) {return 'C1';} //caso 12
        elseif($responses['C'] === 4){return 'C2';}  // caso 13

    }elseif ($responses['D'] > 1) { // Se resta 2 o más preguntas
        if($responses['B'] > 0 || $responses['C'] > 0){return 'A2';}
        else{return 'A1';}
    }elseif ($responses['D'] > 2) { // Se restan 3 o 4 preguntas
        return 'A1';
    }

    return '??';
}

/*
    edad: int
    area_1: int (0-5)
         ...
    area_X: int (0-5)

*/

function generarHistograma(array $calificaciones):array
{
    $histograma = [
        'area_1' => array_fill(0, 6, 0),
        'area_2' => array_fill(0, 6, 0),
        'area_3' => array_fill(0, 6, 0),
        'area_4' => array_fill(0, 6, 0),
        'area_5' => array_fill(0, 6, 0),
        'area_6' => array_fill(0, 6, 0), // Aqui
        'final'  => array_fill(0, 6, 0),
        'edades' => [
            'Menor de 25'   => array_fill(0, 6, 0), 
            'Entre 25 y 35' => array_fill(0, 6, 0), 
            'Entre 36 y 45' => array_fill(0, 6, 0), 
            'Entre 46 y 55' => array_fill(0, 6, 0), 
            'Más de 56'     => array_fill(0, 6, 0)]
    ];
    $vuelta = 0;

    foreach ($calificaciones as $key => $userCalificacion) {
        foreach ($userCalificacion as $area => $value) {
            --$value;
           
            if (strpos($area, 'area_') !== false) {
                    if ($value == -1) { // Aqui
                        $value = 0;
                    }
                    ++$histograma[$area][$value];
            }else if(strpos($area, 'final') !== false){
                $value = round($value);
                ++$histograma['final'][$value];
                if($userCalificacion['edad'] < 25){
                    ++$histograma['edades']['Menor de 25'][$value];
                }elseif ($userCalificacion['edad'] < 36) {
                    ++$histograma['edades']['Entre 25 y 35'][$value];
                }elseif ($userCalificacion['edad'] < 46) {
                    ++$histograma['edades']['Entre 36 y 45'][$value];
                }elseif ($userCalificacion['edad'] < 56) {
                    ++$histograma['edades']['Entre 46 y 55'][$value];
                }else {
                    ++$histograma['edades']['Más de 56'][$value];
                }
                
            }
            
        }
       
    }

    return $histograma;
}