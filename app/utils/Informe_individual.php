<?php
require_once 'app/dependencies/vendor/autoload.php';
require_once 'app/utils/testFunctions.php';


use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Language;
use PhpOffice\PhpWord\Settings;

function generarInformeIndividual(array $calificacionesLetas, array $calificacionesNumero, string $calificacionFinal, array $medias, array $descriptores)
{

    //$histograma = array('nota_media'=> 'B1','nota_area_1' => 'B1', 'nota_area_2'=> 'B1', 'nota_area_3'=> 'A2', 'nota_area_4'=> 'B2', 'nota_area_5'=> 'B2');
    $phpWord = new \PhpOffice\PhpWord\PhpWord(); // Creamos el documento. 
    
    $section = $phpWord->addSection();
    $lang = new Language();
    $lang->setLangId(Language::ES_ES_ID); // Definimos el idioma en español
    $phpWord->getSettings()->setThemeFontLang($lang);

    $fuente = 'Arial';
    // Define styles
    $phpWord->addTitleStyle(1, array('name' => $fuente, 'size' => 20, 'bold' => true, 'color' => '#363694'), array('keepNext' => true, 'spaceBefore' => 240));
    $phpWord->addTitleStyle(2, array('name' => $fuente, 'size' => 18, 'bold' => true, 'color' => '#363694'), array('keepNext' => true, 'spaceBefore' => 240));
    $phpWord->addTitleStyle(3, array('name' => $fuente, 'size' => 14, 'bold' => true, 'color' => '#363694'), array('keepNext' => true, 'spaceBefore' => 240));
    $phpWord->addLinkStyle('NLink', array());

    
    $estilo = [
        "name" => $fuente,
        "size" => 12,
        "color" =>'#5263cc',
        "align" => 'lowKashida'
    ];

    $blanco_p = [
        "name" => $fuente,
        "size" => 10,
        "color" =>'#ffffff'
    ];
    $blan = [
        "name" => $fuente,
        "size" => 12,
        "color" =>'#ffffff'
    ];
    $blanco = array_merge($blan,[
        "bold" => true,
    ]);
    
    $link = [
        'color' => '1156cc', 
        'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE
    ];

    $negrita = array_merge($estilo,[
        "bold" => true,
    ]);
    $subrayado = array_merge($estilo,[
        "bgColor" => '#deebef',
    ]);
    $sub_bold = array_merge($estilo,[
        "bgColor" => '#deebef',
        "bold" => true,
    ]);
   
    $encabezado = $section->addHeader();
    

    $section->addTitle('Informe del resultado del test CDD', 1);
    $section->addText('', $estilo);
    $section->addText('', $estilo);
    $section->addText('Estimado usuario,', $estilo);
    $textrun = $section->addTextRun();
    $textrun->addText('Gracias por haber realizado el ', $estilo); 
    $textrun->addText('Test de Autoevaluación de la Competencia Digital Docente ', $negrita);
    $textrun->addText('de ', $estilo);
    $textrun->addText('Aonia.', $negrita);
    $section->addText('Esperamos haberte ayudado a reflexionar acerca de tus prácticas relacionadas con la competencia digital, y que este sea el punto de partida para que sigas desarrollando tu formación en el futuro.', $estilo);
    $section->addText('', $estilo);
    $textrun = $section->addTextRun();
    $section->addText('Te recordamos cuáles son estas cinco áreas:', $estilo);
   
    $textrun = $section->addTextRun();
    $textrun->addText('1. ', $negrita);
    $textrun->addText('Información y alfabetización informacional: ', $sub_bold);
    $textrun->addText('identificar, localizar, recuperar, almacenar, organizar y analizar la información digital, evaluando su finalidad y relevancia.', $estilo);

    $textrun = $section->addTextRun();
    $textrun->addText('2. ', $negrita);
    $textrun->addText('Comunicación y colaboración: ', $sub_bold);
    $textrun->addText('comunicar en entornos digitales, compartir recursos a través de herramientas en línea, conectar y colaborar con otros a través de herramientas digitales, interactuar y participar en comunidades y redes; conciencia intercultural.', $estilo);
    
    $textrun = $section->addTextRun();
    $textrun->addText('3. ', $negrita);
    $textrun->addText('Creación de contenidos digitales: ', $sub_bold);
    $textrun->addText('crear y editar contenidos nuevos (textos, imágenes, videos…), integrar y reelaborar conocimientos y contenidos previos, realizar producciones artísticas, contenidos multimedia y programación informática, saber aplicar los derechos de propiedad intelectual y las licencias de uso.', $estilo);

    $textrun = $section->addTextRun();
    $textrun->addText('4. ', $negrita);
    $textrun->addText('Seguridad: ', $sub_bold);
    $textrun->addText('protección personal, protección de datos, protección de la identidad digital, uso seguro y sostenible.', $estilo);

    $textrun = $section->addTextRun();
    $textrun->addText('5. ', $negrita);
    $textrun->addText('Resolución de problemas: ', $sub_bold);
    $textrun->addText('identificar necesidades y recursos digitales, tomar decisiones a la hora de elegir la herramienta digital apropiada, acorde a la finalidad o necesidad, resolver problemas conceptuales a través de medios digitales, resolver problemas técnicos, uso creativo de la tecnología, actualizar la competencia propia y la de otros.', $estilo);
   
    $section->addPageBreak();

    $section->addText('', $estilo);
    $section->addText('El Marco Común Europeo de Competencia Digital Docente establece 3 niveles de Competencia para cada una de estas áreas. Dentro de cada nivel, además, encontrarás dos divisiones:', $estilo);
    $section->addText('', $estilo);
    

    $table = $section->addTable(array('width' => 60 * 80, 'unit' => 'pct', 'valign' => 'bottom', 'align' => 'center', 'borderColor'=>'ffffff', 'borderSize'=> 1, 'cellMargin' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'vAlign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::BOTTOM, 'cellSpacing' => 40));
    $ancho = 3000; 


    $table->addRow()->addCell($ancho, ['bgColor' => 'e5b8ff', 'borderColor'=>'ffffff', 'borderSize'=> 1])->addText('Nivel A1', $blanco, ['align' => 'center','valign' => 'bottom']);
    $table->addCell($ancho, ['bgColor' => 'e5b8ff', 'borderColor'=>'ffffff', 'borderSize'=> 1])->addText('Acceso', $blanco, ['align' => 'center']);

    $table->addRow()->addCell($ancho, ['bgColor' => 'db9bfe', 'borderColor'=>'ffffff', 'borderSize'=> 1])->addText('Nivel A2', $blanco, ['align' => 'center','valign' => 'bottom']);
    $table->addCell($ancho, ['bgColor' => 'db9bfe', 'borderColor'=>'ffffff', 'borderSize'=> 1])->addText('Plataforma', $blanco, ['align' => 'center']);

    $table->addRow()->addCell($ancho, ['bgColor' => '94e6fe'])->addText('Nivel B1', $blanco, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '94e6fe'])->addText('Intermedio', $blanco, ['align' => 'center']);

    $table->addRow()->addCell($ancho, ['bgColor' => '69befe'])->addText('Nivel B2', $blanco, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '69befe'])->addText('Intermedio alto', $blanco, ['align' => 'center']);

    $table->addRow()->addCell($ancho, ['bgColor' => '7171f4'])->addText('Nivel C1', $blanco, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '7171f4'])->addText('Dominio operativo eficaz', $blanco, ['align' => 'center']);

    $table->addRow()->addCell($ancho, ['bgColor' => '5133cc'])->addText('Nivel C2', $blanco, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '5133cc'])->addText('Maestría', $blanco, ['align' => 'center']);
    
    $section->addText('', $estilo);
    $section->addText('Para ayudarte a definir tu itinerario de formación, a continuación encontrarás un resumen los resultados que has obtenido en la evaluación.', $estilo);

    $section->addText('', $estilo);
    $section->addTitle('Resumen de resultados de tu evaluación. Niveles obtenidos por áreas:', 3);

    $table = $section->addTable(array('width' => 60 * 80, 'unit' => 'pct', 'valign' => 'bottom', 'align' => 'center', 'borderColor'=>'ffffff', 'borderSize'=> 1, 'cellMargin' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'vAlign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::BOTTOM, 'cellSpacing' => 40));
    $ancho = 3000;

    $table->addRow();
    $table->addCell($ancho, ['bgColor' => '8e86f7'])->addText('Global', $blanco_p, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '8e86f7'])->addText('Información', $blanco_p, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '8e86f7'])->addText('Comunicación', $blanco_p, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '8e86f7'])->addText('Creación de contenidos digitales', $blanco_p, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '8e86f7'])->addText('Seguridad', $blanco_p, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => '8e86f7'])->addText('Resolución de problemas', $blanco_p, ['align' => 'center']);

    $table->addRow();
    $table->addCell($ancho, ['bgColor' => 'ffffff'])->addText($calificacionFinal, $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'ffffff'])->addText($calificacionesLetas['area_1'],    $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'ffffff'])->addText($calificacionesLetas['area_2'],    $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'ffffff'])->addText($calificacionesLetas['area_3'],    $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'ffffff'])->addText($calificacionesLetas['area_4'],    $estilo, ['align' => 'center']);
    $table->addCell($ancho, ['bgColor' => 'ffffff'])->addText($calificacionesLetas['area_5'],    $estilo, ['align' => 'center']);

    $section->addText('Tabla resumen de los resultados por área', $estilo, ['align' => 'center']);
  
    $textrun = $section->addTextRun();
    $section->addText('Información',$negrita);
    $section->addText($descriptores['area_1'], $estilo);
    $textrun = $section->addTextRun();
    $section->addText('Comunicación',$negrita);
    $section->addText($descriptores['area_2'],$estilo);
    $textrun = $section->addTextRun();
    $section->addText('Creación de contenidos digitales',$negrita);
    $section->addText($descriptores['area_3'],$estilo);
    $textrun = $section->addTextRun();
    $section->addText('Seguridad',$negrita);
    $section->addText($descriptores['area_4'],$estilo);
    $textrun = $section->addTextRun();
    $section->addText('Resolución de problemas',$negrita);
    $section->addText($descriptores['area_5'],$estilo);
    $textrun = $section->addTextRun();

    $section = $phpWord->addSection();
    $chartType = 'radar';
    $areas = array('Información', 'Comunicación', 'Creación de contenidos digitales', 'Seguridad', 'Resolución de problemas');
    //datos de resultados por áreas
    $showGridLines = false;
    $showAxisLabels = false;
    $showLegend = false;
    $legendPosition = 'b';
    
    //gráfico radar

    $chart = $section->addChart($chartType, $areas, $calificacionesNumero);
    $chart->getStyle()->setWidth(Converter::inchToEmu(5.5))->setHeight(Converter::inchToEmu(5));
    $chart->getStyle()->setShowGridX($showGridLines);
    $chart->getStyle()->setShowGridY($showGridLines);
    $chart->getStyle()->setShowAxisLabels($showAxisLabels);
    $chart->getStyle()->setShowLegend($showLegend);
    $chart->getStyle()->setLegendPosition($legendPosition);
   

    $section->addText('', $estilo);
    $section->addTitle('Consejos para el desarrollo de tu itinerario de formación', 3);
    $section->addText('', $estilo);
    $textrun = $section->addTextRun();
    $textrun->addText('Las páginas anteriores te ayudarán a desarrollar tu ', $estilo);
    $textrun->addText('Competencia Digital ', $negrita); 
    $textrun->addText('articulando distintos aspectos de la misma. Además, te recomendamos seguir las siguientes directrices:',$estilo);
   
    $textrun = $section->addTextRun();
    $textrun->addText('1. ', $negrita);
    $textrun->addText('Consulta los ', $estilo);
    $textrun->addText('descriptores ', $negrita);
    $textrun->addText('de referencia para la Competencia Digital. Te ayudarán a conocer qué necesitas mejorar. Los encontrarás en la página del DigCom.', $estilo);
   
    $textrun = $section->addTextRun();
    $textrun->addText('2. ', $negrita);
    $textrun->addText('Diseña un itinerario ', $estilo);
    $textrun->addText('homogéneo' , $negrita);
    $textrun->addText(', en el que no destaquen unas áreas competenciales sobre otras. Consulta con tus compañeros y compañeras qué formaciones les han funcionado, así como la oferta formativa que te ofrece tu centro de trabajo.',$estilo);
   
    $textrun = $section->addTextRun();
    $textrun->addText('3. ', $negrita);
    $textrun->addText('Procura que sea también ', $estilo);
    $textrun->addText('posibilitador', $negrita);
    $textrun->addText(', esto es, que ', $estilo);
    $textrun->addText(' no esté orientado exclusivamente a aprender a manejar herramientas concretas', $negrita);
    $textrun->addText(', sino a saber lo que puedes lograr con tecnología en relación con los objetivos que quieres alcanzar', $estilo);
    
    $textrun = $section->addTextRun();
    $textrun->addText('4. ', $negrita);
    $textrun->addText('Intenta que tu ruta sea ', $estilo);
    $textrun->addText('coherente con metodologías ', $negrita);
    $textrun->addText('innovadoras, que no repliquen prácticas que no favorecen el aprendizaje.', $estilo);
    
    $textrun = $section->addTextRun();
    $textrun->addText('5. ', $negrita);
    $textrun->addText('Para terminar, sé ', $estilo);
    $textrun->addText('coherente con el nuevo rol de docente', $negrita);
    $textrun->addText(', como posibilitador del aprendizaje, y no como mero transmisor del conocimiento.', $estilo);

    // Aqui Area 6
    $textrun = $section->addTextRun();
    $textrun->addText('6. ', $negrita);
    $textrun->addText('Prueba ', $estilo);
    $textrun->addText('Prueba', $negrita);
    $textrun->addText(', Prueba', $estilo);


    /*
    header("Content-Type: application/msword");
    $phpWord->save("php://output", 'Word2007');
    // */
    header("Content-Type: 	application/pdf");
    $domPdfPath = "app/dependencies/vendor/dompdf/dompdf/";
    Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
    Settings::setPdfRendererPath($domPdfPath);
    $phpWord->save("php://output", 'PDF');
    // */
    die();

}

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