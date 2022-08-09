<?php

    require_once 'app/config/questions.php';
    
    $questionGroups = $questions;
    $responsesSQL = "";
    $marksSQL = "";
    $userMarksSQL = "";
    $mediasSQL = "";
    $areas = [];
    foreach ($questionGroups as $key => $questionGroup) {
        $group = $key + 1;
        foreach ($questionGroup["preguntas"] as $key => $questions) {
            $colunName = 'respuesta_'.$group.'_'.($key+1); 
            $responsesSQL .= "ALTER TABLE testCDD_responses ADD $colunName CHAR(1) NOT NULL DEFAULT '';\n";
        }
        $colunName = 'area_'.$group; 
        $areas[] = $colunName;
        $userMarksSQL .= "ALTER TABLE user ADD $colunName SMALLINT NOT NULL DEFAULT -1;\n";
        $marksSQL .= "ALTER TABLE testCDD_marks ADD $colunName SMALLINT NOT NULL DEFAULT 0;\n";
        $mediasSQL .= "ALTER TABLE testCDD_media ADD $colunName DECIMAL(3,2) NOT NULL;\n";
    }
    $userMarksSQL .= "ALTER TABLE user ADD finalMark DECIMAL(3,2) NOT NULL DEFAULT -1;\n";
    $marksSQL .= "ALTER TABLE testCDD_marks ADD finalMark DECIMAL(3,2) NOT NULL DEFAULT 0;\n";
    $mediasSQL .= "ALTER TABLE testCDD_media ADD finalMark DECIMAL(3,2) NOT NULL;\n";
    $mediasSQL .= "INSERT INTO testCDD_media(count, " . implode(", ", $areas) . ", finalMark) VALUES (" . implode(', ', array_fill(0, count($areas) + 2,  '0')) . ");"; 


    /*echo $responsesSQL; 
    echo $marksSQL; 
    echo $userMarksSQL; 
    echo $mediasSQL; */

    file_put_contents('app/models/sql/DataBase_docFinal.sql', str_replace(['{{responsesSQL}}', '{{marksSQL}}', '{{userMarksSQL}}', '{{mediasSQL}}'], [$responsesSQL, $marksSQL, $userMarksSQL, $mediasSQL], file_get_contents('app/models/sql/DataBase_docBase.sql')));