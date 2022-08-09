<?php
require_once 'app/dependencies/vendor/autoload.php';

use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Language;

function generarInformeCentro(array $histograma, string $centro, int $nUsuarios)
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord(); // Creamos el documento

    $lang = new Language();
    $lang->setLangId(Language::ES_ES_ID); // Definimos el idioma en español
    $phpWord->getSettings()->setThemeFontLang($lang);

    $fuente = 'Rubik';
    // Define styles
    $phpWord->addTitleStyle(1, array('name' => $fuente, 'size' => 18, 'bold' => true, 'color' => '#363694'), array('keepNext' => true, 'spaceBefore' => 240));
    $phpWord->addTitleStyle(2, array('name' => $fuente, 'size' => 16, 'bold' => true, 'color' => '#363694'), array('keepNext' => true, 'spaceBefore' => 240));
    $phpWord->addTitleStyle(3, array('name' => $fuente, 'size' => 12, 'bold' => true), array('keepNext' => true, 'spaceBefore' => 240));
    $phpWord->addLinkStyle('NLink', array());

    $estilo = [
        "name" => $fuente,
        "size" => 11,
    ];

    $link = [
        'color' => '1156cc', 
        'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE
    ];

    $negrita = array_merge($estilo,[
        "bold" => true,
    ]);

    /** Sección 1: ¿Qué hemos evaluado? */
    $section = $phpWord->addSection();
    $section->addTitle('1. ¿Qué hemos evaluado?', 1);
    $section->addTitle('Evaluación de la Competencia Digital Docente.', 2);
    $section->addText('El Plan de Acción de Educación Digital (2021-2027) es una iniciativa de la Unión Europea para apoyar una adaptación sostenible y eficaz de los sistemas de educación y formación de los Estados miembros. Entre las recomendaciones de este plan se encuentra el desarrollo y mejora de las competencias digitales para la transformación digital, fomentando el desarrollo de un ecosistema educativo digital de alto rendimiento, en el que profesorado y personal de educación cuenten con las competencias y confianza suficientes para trabajar en los nuevos entornos digitales.', $estilo);
    $section->addText('La transformación digital progresiva de nuestra sociedad, impulsada por la pandemia de COVID-19, han impactado especialmente en el sector educativo en los últimos años poniendo de relieve, más si cabe, la importancia de la competencia digital en el conjunto de las competencias clave:', $estilo);
    
    $textrun = $section->addTextRun(['bgColor' => 'efefef']);

    /*$table = $section->addTable($tableStyle);
    $table->addRow();
    $table->addCell(5000, ['bgColor' => 'd9ead3', 'vMerge' => 'restart', 'valign' => 'center'])->addText('Nivel A', $estilo, ['align' => 'center']);*/

    $textrun->addText('La competencia digital es una de las 8 competencias clave que cualquier joven debe haber desarrollado al finalizar la enseñanza obligatoria para poder incorporarse a la vida adulta de manera satisfactoria y ser capaz de desarrollar un aprendizaje permanente a lo largo de la vida.', array_merge(['bgColor' => 'efefef'], $estilo), ['pageBreakBefore' => true]);
    $textrun->addTextBreak();
    $textrun = $section->addTextRun();
    $textrun->addText('(Recomendación 2006/962/CE del Parlamento Europeo y del Consejo, de 18 de diciembre de 2006, sobre las competencias clave para el aprendizaje permanente, Diario Oficial L 394 de 30.12.2006', array_merge($estilo, ['size' => 9, 'bgColor' => 'efefef']), ['align' => 'right','pageBreakBefore' => true]);
    $textrun->addFootnote()->addText('"EUR-Lex - 32006H0962 - EN - EUR-Lex - europa.eu." https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=celex%3A32006H0962. Se consultó el 27 mar.. 2019.');

    $textrun = $section->addTextRun();
    $textrun->addText('En este contexto no debemos perder de vista el ', $estilo);
    $textrun->addText('Marco Común de Competencia Digital Docente', $negrita);
    $textrun->addText('. Éste ha servido a Aonia para desarrollar su ', $estilo);
    $textrun->addText(', que ha puesto a disposición de la Comunidad Educativa  para ayudar a recoger y definir el perfil de competencia digital de los y las docentes evaluados, al tiempo que proporciona una visión global del centro que os permitirá:', $negrita);
    
    $listItemRun = $section->addListItemRun();
    $listItemRun->addText('Que la ', $estilo);
    $listItemRun->addText('comunidad educativa', $negrita);
    $listItemRun->addText('  conozca, pueda evaluar y ayude a desarrollar la competencia digital de sus miembros.', $estilo);

    $listItemRun = $section->addListItemRun();
    $listItemRun->addText('Difundir', $negrita);
    $listItemRun->addText(' una referencia común, con descriptores, de la competencia digital, que ayude a enmarcar las competencias digitales individuales.', $estilo);

    $listItemRun = $section->addListItemRun();
    $listItemRun->addText('Trabajar', $negrita);
    $listItemRun->addText(' en la concienciación de la importancia de la competencia digital en el contexto educativo actual y futuro.', $estilo);

    $listItemRun = $section->addListItemRun();
    $listItemRun->addText('Influir', $negrita);
    $listItemRun->addText(' en la comunidad educativa para, con ayuda de la transformación tecnológica, provocar una transformación profunda de la metodología desarrollada en el centro.', $estilo);

    $section->addText('Os animamos a revisar los datos que recogemos a continuación y reflexionar sobre ellos para apoyar acciones concretas en vuestro centro que impulsen la transformación digital del mismo.', $estilo);


    $section->addTitle('¿Qué evaluamos en relación a la Competencia Digital?', 2);

    $textrun = $section->addTextRun();
    $textrun->addText('Según está definida en el ', $estilo);
    $textrun->addText('Acuerdo de la Conferencia Sectorial de Educación sobre el marco de referencia de la competencia digital docente', $negrita);
    $textrun->addText(' (', $estilo);
    $textrun->addLink('https://www.boe.es/boe/dias/2020/07/13/pdfs/BOE-A-2020-7775.pdf', 'Disposición 7775 BOE 191/2020', array_merge($negrita,$link));
    $textrun->addText('), ésta se organiza en cinco áreas:', $estilo);

    $listStyle = ['listType' =>\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER];
    $listItemRun = $section->addListItemRun(0, $listStyle);
    $listItemRun->addText('Información y alfabetización informacional: ', $negrita);
    $listItemRun->addText('relacionada con identificar, localizar, recuperar, almacenar, organizar y analizar la información digital, evaluando su finalidad y relevancia.', $estilo);

    $listItemRun = $section->addListItemRun(0, $listStyle);
    $listItemRun->addText('Comunicación y colaboración: ', $negrita);
    $listItemRun->addText('relacionada con comunicar en entornos digitales, compartir recursos a través de herramientas en línea, conectar y colaborar con otros a través de herramientas digitales, interactuar y participar en comunidades y redes; conciencia intercultural.', $estilo);

    $listItemRun = $section->addListItemRun(0, $listStyle);
    $listItemRun->addText('Creación de contenidos digitales: ', $negrita);
    $listItemRun->addText('crear y editar contenidos nuevos (textos, imágenes,  vídeos…), integrar y reelaborar conocimientos y contenidos previos, realizar producciones artísticas, contenidos multimedia y programación informática, saber aplicar los derechos de propiedad intelectual y las licencias de uso.', $estilo);

    $listItemRun = $section->addListItemRun(0, $listStyle);
    $listItemRun->addText('Seguridad: ', $negrita);
    $listItemRun->addText('protección personal, protección de datos, protección de la identidad digital, uso seguro y sostenible.', $estilo);

    $listItemRun = $section->addListItemRun(0, $listStyle);
    $listItemRun->addText('Resolución de problemas: ', $negrita);
    $listItemRun->addText('identificar necesidades y recursos digitales, tomar decisiones a la hora de elegir la herramienta digital apropiada, acorde a la finalidad o necesidad, resolver problemas conceptuales a través de medios digitales, resolver problemas técnicos, uso creativo de la tecnología, actualizar la competencia propia y la de otros.', $estilo);


    $textrun = $section->addTextRun();
    $textrun->addText('En estas cinco áreas se incluyen los elementos relacionados con la Competencia Digital Docente que todo profesor y profesora debe dominar en el contexto digital presente. El desarrollo de los mismos, articulado de forma progresiva, ', $estilo);
    $textrun->addText('facilitará el cambio metodológico del centro.', $negrita);
    $section->addText('A continuación te mostramos el perfil de Competencia Digital de vuestro centro, organizados en las distintas áreas, a partir de las evaluaciones realizadas por los y las docentes participantes.', $estilo);


    /** Sección 2: Perfil de Competencia Digital del Centro */
    $section = $phpWord->addSection();
    $section->addTitle('2. Perfil de Competencia Digital del Centro.', 1);
    $textrun = $section->addTextRun();
    $textrun->addText('Fruto de la autoevaluación personal de cada uno de los y las docentes, presentamos a continuación el ', $estilo);
    $textrun->addText('perfil del centro', $negrita);
    $textrun->addText('. Comenzamos recordando cuáles son las 5 áreas de evaluación en las que se divide la Competencia Digital Docente, en las que se concreta esta evaluación:', $estilo);

    $section->addListItem('Área 1. Información.',0, $negrita);
    $section->addListItem('Área 2. Comunicación.',0, $negrita);
    $section->addListItem('Área 3. Creación de contenido.',0, $negrita);
    $section->addListItem('Área 4. Seguridad.',0, $negrita);
    $section->addListItem('Área 5. Resolución de problemas.',0, $negrita);

    $section->addText('Para cada una de estas áreas se han establecido tres niveles competenciales, que se subdividen a su vez en dos:', $estilo);
    $section->addText('En el caso de la autoevaluación del profesorado de vuestro centro, encontramos que los niveles que han presentado se encuentran distribuidos de la siguiente forma: ', $estilo);

    $tableStyle = [
        'borderColor' => '006699',
        'borderSize'  => 6,
        'cellMargin'  => 50,
        'align' => 'center',
    ];
    $ancho = 3000;
    $table = $section->addTable($tableStyle);
    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'd9ead3', 'vMerge' => 'restart', 'valign' => 'center'])->addText('Nivel A', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'd9ead3', 'align' => 'center'])->addText('A1 - Acceso', $estilo, ['align' => 'center']);
    $table->addRow();
    $table->addCell(null, ['vMerge' => 'continue']);
    $table->addCell($ancho, ['bgColor' => 'd9ead3', 'align' => 'center'])->addText('A2 - Plataforma', $estilo, ['align' => 'center']);

    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'ead1dc', 'vMerge' => 'restart', 'valign' => 'center', 'align' => 'center'])->addText('Nivel B', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'ead1dc', 'align' => 'center'])->addText('B1 - Intermedio', $estilo, ['align' => 'center']);
    $table->addRow();
    $table->addCell(null, ['vMerge' => 'continue']);
    $table->addCell($ancho, ['bgColor' => 'ead1dc', 'align' => 'center'])->addText('B2 - Intermedio alto', $estilo, ['align' => 'center']);

    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'fce5cd', 'vMerge' => 'restart', 'valign' => 'center', 'align' => 'center'])->addText('Nivel C', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'fce5cd', 'align' => 'center'])->addText('C1 - Dominio operativo eficaz', $estilo, ['align' => 'center']);
    $table->addRow();
    $table->addCell(null, ['vMerge' => 'continue']);
    $table->addCell($ancho, ['bgColor' => 'fce5cd', 'align' => 'center'])->addText('C2 - Maestría', $estilo, ['align' => 'center']);

    $section->addText("En el caso de la autoevaluación del profesorado de vuestro centro, encontramos que los niveles que han presentado se encuentran distribuidos de la siguiente forma: ", $estilo);

    $table = $section->addTable($tableStyle);

    $niveles[] = ['text' => 'A1 - Acceso',                   'color' => 'd9ead3'];
    $niveles[] = ['text' => 'A2 - Plataforma',               'color' => 'd9ead3'];
    $niveles[] = ['text' => 'B1 - Intermedio',               'color' => 'ead1dc'];
    $niveles[] = ['text' => 'B2 - Intermedio alto',          'color' => 'ead1dc'];
    $niveles[] = ['text' => 'C1 - Dominio operativo eficaz', 'color' => 'fce5cd'];
    $niveles[] = ['text' => 'C2 - Maestría',                 'color' => 'fce5cd'];
    
    $ancho = 5000; 
    $index = max(array_keys($histograma['area_1'], max($histograma['area_1'])));
    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'd9d9d9'])->addText('Área 1. Información', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => $niveles[$index]['color']])->addText($niveles[$index]['text'], $estilo, ['align' => 'center']);

    $index = max(array_keys($histograma['area_2'], max($histograma['area_2'])));
    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'd9d9d9'])->addText('Área 2. Comunicación', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => $niveles[$index]['color']])->addText($niveles[$index]['text'], $estilo, ['align' => 'center']);

    $index = max(array_keys($histograma['area_3'], max($histograma['area_3'])));
    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'd9d9d9'])->addText('Área 3. Creación de contenido', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => $niveles[$index]['color']])->addText($niveles[$index]['text'], $estilo, ['align' => 'center']);

    $index = max(array_keys($histograma['area_4'], max($histograma['area_4'])));
    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'd9d9d9'])->addText('Área 4. Seguridad', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => $niveles[$index]['color']])->addText($niveles[$index]['text'], $estilo, ['align' => 'center']);

    $index = max(array_keys($histograma['area_5'], max($histograma['area_5'])));
    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'd9d9d9'])->addText('Área 5. Resolución de problemas', $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => $niveles[$index]['color']])->addText($niveles[$index]['text'], $estilo, ['align' => 'center']);

    $section->addTitle('Distribución general de los datos', 2);
    $section->addText("En primer lugar, el número de docentes del colegio $centro que han respondido es de $nUsuarios. Muchas gracias a todos ellos por su participación.", $estilo);
    $section->addText('En el siguiente gráfico encontrarás el detalle del número de docentes del centro distribuidos en columnas que nos indican el nivel medio en CDD obtenido. ', $estilo);
    
    addChart($section, 'Nivel de competencia Digital docente', $histograma['final']);
    $section->addText('Te invitamos también a analizar la distribución de niveles por edades.', $estilo);

    // Ajustamos el formato para el gráfico por edades.
    $aux = [];
    foreach ($histograma['edades'] as $edad => $values) {
        foreach ($values as $key => $value) {
            $aux[$key][] = $value;
        }
    }
    addChart($section, 'Nivel de competencia Digital docente por edades', $aux, array_keys($histograma['edades']));
    $section->addTitle('Niveles por Área competencial', 2);

    $section->addText('Un análisis que suele resultar interesante es el que hacemos por área de la competencia digital, ya que generalmente se muestra una distribución irregular de resultados. Revisa esta información comprueba en qué áreas tu claustro posee mejores habilidades. ¿Qué se les da mejor? ¿La creación de contenidos o la gestión del aula virtual?', $estilo);
    $section->addText('A continuación mostramos la distribución del número de docentes en función del resultado obtenido en cada una de  las áreas evaluadas. Te ayudará a reflexionar sobre el perfil digital del profesorado.', $estilo);

    // Area 1
    $section->addTitle('Información y alfabetización informacional', 3);
    $section->addText('En este área analizamos las habilidades del profesorado para buscar, gestionar y compartir información digital. ¿Realizan búsquedas eficaces? ¿Almacenan la información de forma adecuada? ¿Son capaces de compartir sus búsquedas? ¿Enseñan a otros a realizar búsquedas mejores y más seguras? Analiza el gráfico para ver el nivel de competencia del claustro en este área.', $estilo);
    addChart($section, 'Nivel en el area de Información', $histograma['area_1']);
    $section->addPageBreak();

    // Area 2
    $section->addTitle('Comunicación y colaboración', 3);
    $section->addText('Las competencias digitales relacionadas con la comunicación y la colaboración permiten a tu claustro realizar acciones seguras como comunicarse de forma eficaz con las familias, recibir y gestionar las comunicaciones digitales del aula, y colaborar con otros compañeros y compañeras online. Además, en los niveles más avanzados de este área, los y las docentes apoyan y promueven la comunicación y colaboración digitales.', $estilo);
    addChart($section, 'Nivel en el area de Comunicación', $histograma['area_2']);

    // Area 3
    $section->addTitle('Creación de contenidos digitales', 3);
    $section->addText('La creación de contenidos digitales es una de las competencias digitales más importantes. En los primeros niveles, los y las docentes son capaces de crear contenidos sencillos y reutilizar contenidos de otros de forma simple. En los niveles más avanzados, podrán modificar código, crear animaciones complejas,...', $estilo);
    addChart($section, 'Nivel en el area de Creación de contenidos', $histograma['area_3']);

    // Area 4
    $section->addTitle('Seguridad', 3);
    $section->addText('Mantener la seguridad en entornos digitales es esencial. Comenzando con la generación de claves seguras y el reconocimiento de potenciales amenazas, en los niveles más altos los y las docentes diseñan estrategias para promover la seguridad de su alumnado.', $estilo);
    addChart($section, 'Nivel en el area de Seguridad', $histograma['area_4']);

    // Area 5
    $section->addTitle('Resolución de problemas', 3);
    $section->addText('No siempre sabemos identificar nuestros problemas en el mundo digital. Cuando no tenemos nuestras habilidades muy desarrolladas, solemos acudir a otras personas para recibir ayuda. Cuando tenemos la experiencia suficiente, somos capaces de ayudar a otras personas a identificar sus necesidades educativas relacionadas con lo digital y resolverlas. Analiza el perfil de tus docentes para saber dónde está su fuerte.', $estilo);
    addChart($section, 'Nivel en el area de Resolución de problemas', $histograma['area_5']);

    //$section = $phpWord->addSection();
    //$section->addTitle('3. Recomendaciones para la interpretación de los resultados.', 1);


    //$phpWord->save($temp_file);

    // Your browser will name the file "myFile.docx"
    // regardless of what it's named on the server 
    header("Content-Disposition: attachment; filename='Informe Centro.docx'");
    header("Content-Type: application/msword");
    header("Cache-Control: must-revalidate,post-check=0, pre-check=0");
    header("Expires: 0");
    //$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
    //readfile($temp_file); // or echo file_get_contents($temp_file);
    //unlink($temp_file);  // remove temp file
    $phpWord->save("php://output", 'Word2007');

    //$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007', true);
    //$objWriter->save("php://output");
    die();
    //$phpWord->save('prueba2.docx', 'Word2007');
    
}


function addChart(\PhpOffice\PhpWord\Element\Section &$section, string $titulo, array $datos, array $niveles = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])
{
    /* Primera gráfica */
    if(is_array($datos[0])){
        $datosAux = array_splice($datos, 1);
        $datos = $datos[0];
        $chart = $section->addChart('column', $niveles, $datos, null, 'A1');
        $chart->getStyle()->setShowLegend(true); // Para que muestre la leyenda debajo
    }else{
        $datosAux = [];
        $chart = $section->addChart('column', $niveles, $datos);
    }

    
    $chart->getStyle()->setWidth(Converter::inchToEmu(5.3))->setHeight(Converter::inchToEmu(3.25)); // Fijamos el tamaño
    $chart->getStyle()->setTitle($titulo);
    $chart->getStyle()->is3d(true);
    $chart->getStyle()->setShowGridY(true); // Que se muestren lineas horizontales
    $chart->getStyle()->setShowAxisLabels(true); // HAcemos que se muestre el nivel correspondiente debajo
    $chart->getStyle()->setLegendPosition('b'); // Indicamos que la posición sea abajo (r = right, l = left, t = top, b = bottom, tr = top right)
    $chart->getStyle()->setDataLabelOptions([
        'showVal'          => false, // value
        'showCatName'      => false, // category name
        'showLegendKey'    => true, //show the cart legend
        'showSerName'      => false, // series name
        'showPercent'      => true,
        'showLeaderLines'  => false,
        'showBubbleSize'   => false,
    ]);
    $niveles = ['A2', 'B1', 'B2', 'C1', 'C2']; 
    //$chart->addSeries($niveles, $histograma['area_1']);
    foreach ($datosAux as $key => $datos) {
        $chart->addSeries($niveles, $datos, $niveles[$key]);
    }
    $chart->getStyle()->setValueAxisTitle("Número de docentes");
    $section->addTextBreak();
}


// Save file
//echo write($phpWord, basename(__FILE__, '.php'), $writers);



function write($phpWord, $filename, $writers)
{
    $result = '';

    // Write documents
    foreach ($writers as $format => $extension) {
        $result .= date('H:i:s') . " Write to {$format} format";
        if (null !== $extension) {
            $targetFile = __DIR__ . "/results/{$filename}.{$extension}";
            $phpWord->save($targetFile, $format);
        } else {
            $result .= ' ... NOT DONE!';
        }
        $result .= "\n";
    }

    //$result .= getEndingNotes($writers, $filename);

    return $result;
}