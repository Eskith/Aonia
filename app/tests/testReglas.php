<?php

$stringResponsesPath = 'app/tests/stringResponses.php';
require_once 'app/utils/testFunctions.php';
require_once $stringResponsesPath;

$r = array_map(function (string $s)
{
    $res = explode(' ', trim($s));
    $resutado = array_splice($res, -1)[0];
    
    sort($res);
    $res[] = $resutado;
    //print_r(implode(' ', $res)."\n"); 
    return implode(' ', $res); 
} ,explode("\n", preg_replace('/[^\n\S]+/i',' ', $stringResponses)));

$r3 = [];
$r4 = [];
$r6 = [];
foreach ($r as $value) {
    //print_r($value); 
    switch (count(explode(' ', trim($value)))) {
        case 4:
            $r3[] = $value;
            break;
        case 5:
            $r4[] = $value;
            break;
        case 7:
            $r6[] = $value;
            break;
        case 1:
            break; 
        default:
            die("Respuesta no valida ".$value); 
            break;
    }
}
sort($r3);
sort($r4);
sort($r6);
$r = array_merge($r3, $r4, $r6);
$stringResponses = implode("\n", array_unique($r, SORT_STRING));
//print_r($stringResponses);

//clean Responses
file_put_contents($stringResponsesPath, "<?php \n\n".'$stringResponses = "'."\n".$stringResponses."\n\";");

//print_r($stringResponses); 

//$stringResponses =  explode("\n",preg_replace('/[^\n\S]+/i',' ', $stringResponses));
//print_r($stringResponses); 

$responsesTest = [];
if(isset($stringResponses))
foreach (explode("\n",preg_replace('/[^\n\S]+/i',' ', $stringResponses)) as $value) {
    if($value && $value != "" && $value != " "){
        $value = explode(' ', trim($value));
        if(is_array($value) && count($value) > 3){
            $responsesTest[] = ["resultado" => array_splice($value, -1)[0], "respuestas" => $value]; 
        }
    }
}


//$responsesTest = [[ "respuestas" => ["A", "C", "C", "C", "C", "C"], "resultado" => "C1"]];

//print_r($responsesTest); 
$i = 0; 
$errores = []; 
foreach ($responsesTest as $value) {
    $respuestas = $value["respuestas"];
    $resultadoPrevisto = $value["resultado"];
    $resultadoReal = calculateMark($respuestas);

    if($resultadoReal != $resultadoPrevisto){
        sort($value["respuestas"]);
        $error = ["respuestas" => $value["respuestas"], "resultadoReal" => $resultadoReal, "resultadoPrevisto" => $resultadoPrevisto];
        if(!in_array($error, $errores)) $errores[] = $error;
        //print_r($respuestas);
    }
}

//$errores = array_unique($errores);
foreach ($errores as $error) {
    print("Error ".++$i.", el resultado para el array [\"".implode('", "', $error["respuestas"])."\"] es ".$error["resultadoReal"]." pero se indicó que debía ser ".$error["resultadoPrevisto"]."\n");
}
