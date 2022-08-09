<?php


$questions = 
[
    //Area 1
    [	
        "title" => "Área 1: Información",
        "subTitle" => "En esta sección queremos conocer tus estrategias y hábitos para obtener información de la red. Señala la opción con la que te sientas más identificado o identificada.", 
        "preguntas" =>
        [
            [
                "tipo" => "radio",
                "pregunta" => "Navegación, búsqueda y filtrado de información.",
                "respuestas" => [
                    ["texto" => "Utilizo el navegador web de forma avanzada y soy capaz de manejar fuentes dinámicas de información (blogs, wikis, foros, redes sociales).",
                     "valor" => "B"],
                    ["texto" => "Soy capaz de localizar información utilizando palabras clave en buscadores (por ejemplo, Google).",
                     "valor" => "A"],
                    ["texto" => "Me cuesta encontrar recursos en la red.",
                     "valor" => "D"],
                    ["texto" => "Tengo una estrategia propia de búsqueda y acceso a la información y utilizo herramientas  que me permiten la actualización continua de recursos, buenas prácticas, tendencias educativas, etc.",
                     "valor" => "C"],
                ], 
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Evaluación de la información.",
                "respuestas" => [
                    ["texto" => "No evalúo la información que encuentro en la red.",
                     "valor" => "D"],
                    ["texto" => "Soy crítico/a con la información que encuentro y sé contrastar su validez y credibilidad.",
                     "valor" => "C"],
                    ["texto" => "Sé que no toda la información que se encuentra en Internet es fiable.",
                     "valor" => "A"],
                    ["texto" => "Sé comparar diferentes fuentes de información en red.",
                     "valor" => "B"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Almacenamiento y recuperación de la información.",
                "respuestas" => [
                    ["texto" => "Sé aplicar diferentes métodos y herramientas para organizar los archivos, contenidos e información, incluyendo recursos \"en la nube\". Sé implementar un conjunto de estrategias para recuperar los contenidos que yo u otras personas hemos organizado y guardado.",
                     "valor" => "C"],
                    ["texto" => "Sé cómo guardar archivos y contenidos en local (textos, imágenes, música, vídeos, páginas web). Sé como recuperar los contenidos que he guardado.",
                     "valor" => "A"],
                    ["texto" => "Sé guardar y etiquetar archivos, contenidos e información, y tengo mi propia estrategia de almacenamiento. Sé recuperar y gestionar la información y los contenidos que he guardado usando herramientas de búsqueda local.",
                     "valor" => "B"],
                    ["texto" => "No almaceno información en dispositivos digitales.",
                     "valor" => "D"],
                ],
                
            ],
        ],

    ],
    //Area 2
    [	
        "title" => "Área 2: Comunicación",
        "subTitle" => "En esta sección te preguntamos por tus hábitos de comunicación digital, cómo compartes contenido y participas en comunidades y redes. Señala la opción con la que te sientas más identificado o identificada.",
        "preguntas" =>
        [
            [
                "tipo" => "radio",
                "pregunta" => "Interacción mediante nuevas tecnologías.",
                "respuestas" => [
                    ["texto" => "Soy capaz de utilizar varias herramientas digitales para interactuar con los y las demás, incluso utilizando características avanzadas de las herramientas de comunicación más habituales (móvil, videoconferencias, chat, correo electrónico).",
                     "valor" => "B"],
                    ["texto" => "Soy capaz de interactuar con otras personas y otras utilizando las características básicas de las herramientas de comunicación más habituales (móvil, voz por IP, chat, correo electrónico).",
                     "valor" => "A"],
                    ["texto" => "No utilizo medios digitales para comunicarme.",
                     "valor" => "D"],
                    ["texto" => "Utilizo una amplia gama de herramientas para la comunicación en línea. Sé seleccionar las modalidades y formas de comunicación digital que mejor se ajustan a mis propósitos. Soy capaz de adaptar las formas y modalidades de comunicación según las personas destinatarios. Soy capaz de gestionar los distintos tipos de comunicación que recibo.",
                     "valor" => "C"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Compartir información y contenidos.",
                "respuestas" => [
                    ["texto" => "No comparto información ni contenidos a través de medios digitales.",
                     "valor" => "D"],
                    ["texto" => "Soy capaz de compartir de forma activa información, contenidos y recursos a través de comunidades en línea, redes y plataformas de comunicación.",
                     "valor" => "C"],
                    ["texto" => "Sé cómo compartir archivos y contenidos a través de medios tecnológicos sencillos (enviar y recibir archivos adjuntos a mensajes de correo electrónico, etc.).",
                     "valor" => "A"],
                    ["texto" => "Sé cómo participar en redes sociales y comunidades en línea, en las que transmito o comparto conocimientos, contenidos e información creados por otras personas.",
                     "valor" => "B"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Participación ciudadana en línea.",
                "respuestas" => [
                    ["texto" => "Participo activamente en espacios en línea como los anteriores. Sé de qué manera me puedo implicar activamente en línea.",
                     "valor" => "C"],
                    ["texto" => "Sé que la tecnología se puede utilizar para interactuar con distintos servicios y hago uso pasivo de algunos (leo información  y recibo información básica de comunidades en línea, gobierno, hospitales y centros médicos, bancos, etc).",
                     "valor" => "A"],
                    ["texto" => "No soy consciente de que existan medios de participación ciudadana en línea, ni los empleo en mi día a día.",
                     "valor" => "D"],
                    ["texto" => "Soy capaz de utilizar activamente algunos aspectos básicos de los servicios en línea anteriores (pedir cita, realizar operaciones bancarias, participar en votaciones, etc.).",
                     "valor" => "B"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Colaboración mediante canales digitales.",
                "respuestas" => [
                    ["texto" => "Soy capaz de debatir y elaborar productos en colaboración, utilizando herramientas digitales sencillas.",
                     "valor" => "B"],
                    ["texto" => "Soy capaz de colaborar mediante algunas tecnologías tradicionales (por ejemplo, el correo electrónico)",
                     "valor" => "A"],
                    ["texto" => "No colaboro con otras personas utilizando canales digitales.",
                     "valor" => "D"],
                    ["texto" => "Soy capaz de utilizar con frecuencia y confianza varias herramientas digitales y diferentes medios con el fin de colaborar con otras personas en la producción y puesta a disposición de recursos, conocimientos y contenidos.",
                     "valor" => "C"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Netiqueta (normas básicas de conducta en la red).",
                "respuestas" => [
                    ["texto" => "No conozco el término, ni soy consciente de que existan normas básicas de conducta en la red.",
                     "valor" => "D"],
                    ["texto" => "Conozco las normas básicas de conducta que rigen la comunicación con otras personas mediante herramientas digitales.",
                     "valor" => "A"],
                    ["texto" => "Soy capaz de aplicar varios aspectos de la Netiqueta en la red a distintos espacios y contextos de comunicación. Fomento el buen uso de la Netiqueta en la red.",
                     "valor" => "C"],
                    ["texto" => "Entiendo las reglas de la Netiqueta en la red y soy capaz de aplicarlas a mi contexto personal y profesional.",
                     "valor" => "B"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Gestión de la identidad digital.",
                "respuestas" => [
                    ["texto" => "Soy capaz de crear mi identidad digital y de rastrear mi huella digital.",
                     "valor" => "B"],
                    ["texto" => "Conozco los beneficios y los riesgos relacionados con la identidad digital.",
                     "valor" => "A"],
                    ["texto" => "No sé a qué refiere el término, ni soy consciente de que exista una \"identidad digital\" que gestionar.",
                     "valor" => "D"],
                    ["texto" => "Soy capaz de gestionar diferentes identidades digitales en función del contexto y de su finalidad. Soy capaz de supervisar la información y los datos que produzco a través de mi interacción en línea, y sé cómo proteger mi reputación digital.",
                     "valor" => "C"],
                ],

            ],
        ],

    ],
    // Area 3
    [	
        "title" => "Área 3: Creación de contenidos",
        "subTitle" => "¿Creas contenidos digitales para tus clases? Cuéntanos cómo lo haces y qué elementos tienes en cuenta en su diseño.",
        "preguntas" =>
        [
            [
                "tipo" => "radio",
                "pregunta" => "Desarrollo de contenidos.",
                "respuestas" => [
                    ["texto" => "Soy capaz de producir contenidos digitales en distintos formatos, incluidos multimedia.",
                     "valor" => "B"],
                    ["texto" => "Soy capaz de producir contenidos digitales en formatos, plataformas y entornos diferentes. Utilizo diversas herramientas para crear productos multimedia originales.",
                     "valor" => "C"],
                    ["texto" => "Soy capaz de crear contenidos digitales sencillos (por ejemplo, texto, tablas, imágenes, audio, etc.).",
                     "valor" => "A"],
                    ["texto" => "No desarrollo contenidos en formato digital.",
                     "valor" => "D"],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Integración y reelaboración de contenidos.",
                "respuestas" => [
                    ["texto" => "Soy capaz de hacer cambios sencillos en el contenido que otras personas han producido.",
                     "valor" => "A"],
                    ["texto" => "Nunca integro ni reelaboro otros contenidos. Si utilizo algún material, lo tomo tal cual ha sido creado.",
                     "valor" => "D"],
                    ["texto" => "Soy capaz de editar, modificar y mejorar el contenido que otras personas o yo mismo hemos producido.",
                     "valor" => "B"],
                    ["texto" => "Soy capaz de combinar elementos de contenido de distintas fuentes y crear contenido nuevo, en distintos formatos.",
                     "valor" => "C"],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Derechos de autor y licencias.",
                "respuestas" => [
                    ["texto" => "Nunca me ha preocupado el tema de los derechos de autor. No lo tengo en cuenta.",
                     "valor" => "D"],
                    ["texto" => "Soy consciente de que alguno de los contenidos que utilizo puede tener derechos de autor.",
                     "valor" => "A"],
                    ["texto" => "Conozco las diferencias básicas entre las distintas licencias (copyright, copyleft, creative commons, etc.).",
                     "valor" => "B"],
                    ["texto" => "Conozco cómo se aplican los diferentes tipos de licencia a la información y los recursos que uso y creo.",
                     "valor" => "C"],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Programación y configuración de herramientas y dispositivos.",
                "respuestas" => [
                    ["texto" => "Soy capaz de modificar funciones sencillas de software y aplicaciones (configuración básica): conectarme a una wifi, cambiar la resolución de pantalla, etc.",
                     "valor" => "A"],
                    ["texto" => "Suelo apoyarme en familiares, amistades o compañeros y compañeras de trabajo para estas cuestiones.",
                     "valor" => "D"],
                    ["texto" => "Soy capaz de realizar varias modificaciones a programas y aplicaciones (configuración avanzada, modificaciones básicas de programación html, etc.).",
                     "valor" => "B"],
                    ["texto" => "Soy capaz de modificar programas de código abierto, cambiar o escribir el código fuente, programar, etc., y entiendo los sistemas y funciones que hay detrás de los programas.",
                     "valor" => "C"],
                ],

            ],
        ],
    ],
    [	
        "title" => "Área 4: Seguridad",
        "subTitle" => "En este apartado queremos saber qué medidas de protección personal y de datos utilizas cuando empleas la web.",
        "preguntas" =>
        [
            [
                "tipo" => "radio",
                "pregunta" => "Protección de dispositivos.",
                "respuestas" => [
                    ["texto" => "Soy capaz de realizar acciones básicas para proteger mis dispositivos (por ejemplo, uso de antivirus, contraseñas, etc.).",
                     "valor" => "A"],
                    ["texto" => "Sé cómo proteger mis dispositivos digitales y actualizo mis estrategias de seguridad periódicamente.",
                     "valor" => "B"],
                    ["texto" => "No sé proteger mis dispositivos. Siempre recurro a familiares, amistades, etc.",
                     "valor" => "D"],
                    ["texto" => "Actualizo frecuentemente mis estrategias de seguridad y sé cómo actuar cuando el dispositivo está amenazado.",
                     "valor" => "C"],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Protección de datos personales.",
                "respuestas" => [
                    ["texto" => "Vigilo la configuración de privacidad predeterminada de los servicios en línea en los que participo. Tengo conocimiento amplio acerca de los problemas de privacidad que pueden darse y sé cómo se recogen y utilizan mis datos.",
                     "valor" => "C"],
                    ["texto" => "Soy consciente de que en entornos en línea puedo compartir solo ciertos tipos de información sobre mí y sobre otras personas.",
                     "valor" => "A"],
                    ["texto" => "No tengo estrategias para proteger mis datos personales.",
                     "valor" => "D"],
                    ["texto" => "Sé cómo proteger mi propia privacidad en línea y la de las demás personas. Entiendo de forma general las cuestiones relacionadas con la privacidad y tengo un conocimiento básico sobre cómo se recogen y utilizan mis datos.",
                     "valor" => "B"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Protección de la salud.",
                "respuestas" => [
                    ["texto" => "No considero que el uso de dispositivos o herramientas digitales sea peligroso en ningún aspecto.",
                     "valor" => "D"],
                    ["texto" => "Sé cómo usar correctamente las tecnologías para evitar problemas de salud.",
                     "valor" => "C"],
                    ["texto" => "Sé que la tecnología puede afectar a la salud si se utiliza mal.",
                     "valor" => "A"],
                    ["texto" => "Entiendo los riesgos para la salud asociados al uso de nuevas tecnologías (desde los aspectos ergonómicos hasta la adicción a las tecnologías).",
                     "valor" => "B"],
                ],
            ],
            [
                "tipo" => "radio",
                "pregunta" => "Protección del entorno.",
                "respuestas" => [
                    ["texto" => "Entiendo los aspectos positivos y negativos del uso de tecnología en relación con el medio ambiente.",
                     "valor" => "B"],
                    ["texto" => "No tengo en cuenta el impacto que el uso de tecnología puede tener sobre el entorno que me rodea.",
                     "valor" => "D"],
                    ["texto" => "Tomo medidas básicas de ahorro energético.",
                     "valor" => "A"],
                    ["texto" => "Adopto una postura informada sobre el impacto de las tecnologías en la vida diaria, el consumo, etc.",
                     "valor" => "C"],
                ],
            ],

        ],
    ],
    [	
        "title" => "Área 5: Resolución de problemas",
        "subTitle" => "Finalmente, te preguntamos acerca de tus estrategias para identificar necesidades y tomar decisiones respecto al uso de la tecnología en el aula.",
        "preguntas" =>
        [
            [
                "tipo" => "radio",
                "pregunta" => "Resolución de problemas técnicos.",
                "respuestas" => [
                    ["texto" => "Soy capaz de resolver una amplia gama de problemas que surgen de la utilización de la tecnología.",
                     "valor" => "C"],
                    ["texto" => "Me cuesta distinguir cuando tengo un problema con mi dispositivo.",
                     "valor" => "D"],
                    ["texto" => "Soy capaz de resolver problemas sencillos que surgen cuando las tecnologías no funcionan.",
                     "valor" => "B"],
                    ["texto" => "Soy capaz de pedir apoyo y asistencia específica cuando las tecnologías no funcionan o cuando utilizo un dispositivo, programa o aplicación nuevos.",
                     "valor" => "A"],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Identificación de necesidades y respuestas tecnológicas.",
                "respuestas" => [
                    ["texto" => "Suelo utilizar lo que usan las demás personas, sin hacer una valoración crítica de mis necesidades.",
                     "valor" => "D"],
                    ["texto" => "Entiendo las posibilidades y los límites de la tecnología. Soy capaz de resolver tareas no rutinarias explicando las posibilidades tecnológicas. Soy capaz de elegir la herramienta adecuada según la finalidad y soy capaz de evaluar la efectividad de la misma.",
                     "valor" => "B"],
                    ["texto" => "Tomo decisiones informadas a la hora de elegir una herramienta, dispositivo, aplicación, programa o servicio para una tarea con la que no estoy familiarizado/a. Mantengo información actualizada sobre los nuevos desarrollos tecnológicos. Comprendo cómo funcionan las nuevas herramientas y soy capaz de evaluar de forma crítica qué herramienta encaja mejor con mis objetivos.",
                     "valor" => "C"],
                    ["texto" => "Soy capaz de utilizar algunas tecnologías para resolver problemas, pero solo para un número limitado de tareas. Soy capaz de tomar decisiones a la hora de escoger una herramienta digital para una actividad rutinaria",
                     "valor" => "A"],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Innovar y utilizar la tecnología de forma creativa.",
                "respuestas" => [
                    ["texto" => "Soy capaz de utilizar las tecnologías para dar forma a productos creativos y de utilizar las tecnologías para resolver problemas. Colaboro con otras personas en la elaboración de productos innovadores y creativos, pero no tomo la iniciativa.",
                     "valor" => "B"],
                    ["texto" => "Soy consciente de que puedo utilizar las tecnologías y las herramientas digitales con propósitos creativos y soy capaz de utilizar las tecnologías de forma creativa en algunos casos.",
                     "valor" => "A"],
                    ["texto" => "Soy capaz de resolver problemas conceptuales aprovechando las tecnologías y las herramientas digitales. Soy capaz de contribuir a la generación de conocimiento a través de medios tecnológicos. Soy capaz de participar en acciones innovadoras a través del uso de las tecnologías. Colaboro de forma proactiva con otras personas para crear productos creativos e innovadores.",
                     "valor" => "C"],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Identificación de lagunas en la competencia digital.",
                "respuestas" => [
                    ["texto" => "Utilizo las mismas herramientas desde hace años.",
                     "valor" => "D"],
                    ["texto" => "Actualizo frecuentemente mis necesidades en lo referente a la competencia digital docente.",
                     "valor" => "C"],
                    ["texto" => "Tengo ciertos conocimientos básicos, pero soy consciente de mis limitaciones en el uso de las tecnologías.",
                     "valor" => "A"],
                    ["texto" => "Soy capaz de aprender a hacer algo con las nuevas tecnologías.",
                     "valor" => "B"],
                ],

            ],
            
        ],

    ],
     //Area 6 Aqui Preguntas
     [
        "title" => "Área 6: Titulo Provisional",
        "subTitle" => "Subtitulo",
        "preguntas" =>
        [
            [
                "tipo" => "radio",
                "pregunta" => "Pregunta 1",
                "respuestas" => [
                    [
                        "texto" => "Respuesta con valor B",
                        "valor" => "B"
                    ],
                    [
                        "texto" => "Respuesta con valor C",
                        "valor" => "C"
                    ],
                    [
                        "texto" => "Respuesta con valor A",
                        "valor" => "A"
                    ],
                    [
                        "texto" => "Respuesta con valor D",
                        "valor" => "D"
                    ],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Pregunta 2",
                "respuestas" => [
                    [
                        "texto" => "Respuesta con valor A",
                        "valor" => "A"
                    ],
                    [
                        "texto" => "Respuesta con valor D",
                        "valor" => "D"
                    ],
                    [
                        "texto" => "Respuesta con valor B",
                        "valor" => "B"
                    ],
                    [
                        "texto" => "Respuesta con valor C",
                        "valor" => "C"
                    ],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Pregunta 3",
                "respuestas" => [
                    [
                        "texto" => "Respuesta con valor D",
                        "valor" => "D"
                    ],
                    [
                        "texto" => "Respuesta con valor A",
                        "valor" => "A"
                    ],
                    [
                        "texto" => "Respuesta con valor B",
                        "valor" => "B"
                    ],
                    [
                        "texto" => "Respuesta con valor C",
                        "valor" => "C"
                    ],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "Pregunta 4",
                "respuestas" => [
                    [
                        "texto" => "Respuesta con valor A",
                        "valor" => "A"
                    ],
                    [
                        "texto" => "Respuesta con valor D",
                        "valor" => "D"
                    ],
                    [
                        "texto" => "Respuesta con valor B",
                        "valor" => "B"
                    ],
                    [
                        "texto" => "Respuesta con valor C",
                        "valor" => "C"
                    ],
                ],

            ],
        ],
    ],

];


/*

    Sección de preguntas de ejemplo

    [	
        "title" => "title",
        "subTitle" => "subTitle",
        "preguntas" =>
        [
            [
                "tipo" => "radio",
                "pregunta" => "pregunta",
                "respuestas" => [
                    ["texto" => "Respuesta",
                     "valor" => ""],
                    ["texto" => "Respuesta",
                     "valor" => ""],
                    ["texto" => "Respuesta",
                     "valor" => ""],
                    ["texto" => "Respuesta",
                     "valor" => ""],
                ],

            ],
            [
                "tipo" => "radio",
                "pregunta" => "pregunta",
                "respuestas" => [
                    ["texto" => "Respuesta",
                     "valor" => ""],
                    ["texto" => "Respuesta",
                     "valor" => ""],
                    ["texto" => "Respuesta",
                     "valor" => ""],
                    ["texto" => "Respuesta",
                     "valor" => ""],
                ],

            ],

        ],

    ],

 */