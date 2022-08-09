<?php

    require_once 'app/config/questions.php';
    
    $questionGroups = $questions;
    $testCDD_respuestas = "";
    $testCDD_calificaciones = "";
    $testCDD_ultima_calificacion = "";
    $testCDD_media = "";
    $areas = [];
    foreach ($questionGroups as $key => $questionGroup) {
        $group = $key + 1;
        foreach ($questionGroup["preguntas"] as $key => $questions) {
            $colunName = 'respuesta_'.$group.'_'.($key+1); 
            $testCDD_respuestas .= "ALTER TABLE testCDD ADD $colunName CHAR(1) NOT NULL DEFAULT '';\n";
        }
        $colunName = 'area_'.$group; 
        $areas[] = $colunName;
        $testCDD_ultima_calificacion .= "ALTER TABLE testCDD_media ADD $colunName SMALLINT NOT NULL DEFAULT -1;\n";
        $testCDD_calificaciones .= "ALTER TABLE testCDD ADD $colunName SMALLINT NOT NULL DEFAULT 0;\n";
        $testCDD_media .= "ALTER TABLE testCDD_media ADD $colunName DECIMAL(3,2) NOT NULL;\n";
    }
    $testCDD_ultima_calificacion .= "ALTER TABLE testCDD_ultima_calificacion ADD finalMark DECIMAL(3,2) NOT NULL DEFAULT -1;\n";
    $testCDD_calificaciones .= "ALTER TABLE testCDD ADD finalMark DECIMAL(3,2) NOT NULL DEFAULT 0;\n";
    $testCDD_media .= "ALTER TABLE testCDD_media ADD finalMark DECIMAL(3,2) NOT NULL;\n";
    $testCDD_media .= "INSERT INTO testCDD_media(count, " . implode(", ", $areas) . ", finalMark) VALUES (" . implode(', ', array_fill(0, count($areas) + 2,  '0')) . ");"; 


    /*echo $responsesSQL; 
    echo $testCDD_calificaciones; 
    echo $testCDD_ultima_calificacion; 
    echo $testCDD_media; */

    file_put_contents('app/models/sql/DataBase_docFinal_AL.sql', str_replace(['{{testCDD_respuestas}}', '{{testCDD_calificaciones}}', '{{testCDD_ultima_calificacion}}', '{{testCDD_media}}'], [$testCDD_respuestas, $testCDD_calificaciones, $testCDD_ultima_calificacion, $testCDD_media], file_get_contents('app/models/sql/DataBase_docBase_AL.sql')));