@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>POLÍTICA DE PRIVACIDAD</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                La presente Política de Privacidad se aplica a todos los Usuarios de la Plataforma (en adelante, los <b>“Usuarios”</b> o el <b>“Usuario”</b> y <b>“Plataforma”</b> respectivamente) y forma parte integrante de los Términos y Condiciones del Sitio Web de la Plataforma. La presente Política de Privacidad proporciona al Usuario información general sobre cómo el Controlador de datos utiliza sus datos personales y otra información requerida por la legislación de protección de datos. En caso de modificación futura, se proporcionará al Usuario las actualizaciones e información necesarias a través de la actualización de la presente Política de Privacidad, cargada en la Plataforma.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">1. ¿Quién es el Responsable del Tratamiento?</h2>
                            </div>
                            <div class="col-12">
                                <b>1.1.</b> La empresa con el nombre de empresa “{{ config("app.installation_company_name") }}”, dirección:
                                {{ config("app.installation_company_address") }} ,
                                Teléfono: {{ config("app.installation_company_phone") }}, correo electrónico:
                                {{ config("app.installation_company_email") }}, es el Controlador de datos para el procesamiento de los Datos personales del Usuario (en lo sucesivo, <b>"Controlador de datos"</b>).
                                <br><br>
                                <b>1.2. Datos de contacto del Controlador de datos:</b> para cualquier problema o inquietud con respecto a la presente Política de privacidad y al procesamiento de los datos personales del Usuario o los datos cargados por el Usuario para usar la Plataforma, el Usuario puede comunicarse con el Controlador de datos, utilizando uno de los siguientes alternativas
                                <br><br>
                                Llamando al {{ config("app.installation_company_phone") }}, de lunes a viernes de 9.30 a 17.30 horas EET (Central European Time)<br>
                                Enviando un correo electrónico a la siguiente dirección de correo electrónico: {{ config("app.installation_company_email") }}<br>
                                Enviando correspondencia postal a la siguiente dirección: {{ config("app.installation_company_address") }}<br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">2. ¿Cuál es el propósito y la base legal para el procesamiento de datos del Usuario?</h2>
                                <b>2.1.</b>  El propósito operativo de la plataforma es recopilar opiniones de los usuarios a través de cuestionarios. Las opiniones se procesan para obtener información, recopilar y presentar ideas y sugerencias valiosas sobre los temas abordados en los cuestionarios. Los usuarios pueden responder de forma anónima (sin proporcionar ninguna información personal) o pueden registrarse voluntariamente para enviar respuestas homónimas, proporcionando un correo electrónico y un alias. Las respuestas de los usuarios se traducen al inglés y se presentan en Informes. Para la finalidad específica del tratamiento, la base legal es el consentimiento previo del Usuario.
                                <br><br>
                                <b>2.2.</b> Enviar correos electrónicos informativos al Usuario con la finalidad de informarle sobre nuevas actividades, proyectos y otros temas de interés de la Plataforma. Para esta finalidad de tratamiento la base legal es el consentimiento previo del Usuario.
                                <br><br>
                                <b>2.3</b> Tratamiento de datos por motivos relacionados con el cumplimiento de obligaciones legales por parte del Responsable. En tales casos, el procesamiento de datos se lleva a cabo solo durante el período de tiempo necesario para que el Controlador de datos cumpla con las obligaciones impuestas por diversas disposiciones legales.
                                <br><br>
                                <b>En el caso de las disposiciones anteriores donde la base legal sea el consentimiento previo del Usuario, el Usuario siempre podrá retirar su consentimiento en cualquier momento sin que ello afecte a la legitimidad de los datos basados ​​en el consentimiento previo a su retirada.</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">3. Tipos de datos recopilados</h2>

                                <h3 class="mt-4 mb-4">3.1 Datos personales</h3>
                                <b>3.1.1 Registro-creación de cuenta:</b><br>
                                Para que un Usuario pueda crear voluntariamente una cuenta en la Plataforma, el Usuario deberá completar los datos necesarios: su alias, dirección de correo electrónico y una contraseña.
                                <br><br>
                                <b>3.1.2 Respuestas enviadas al cuestionario</b><br>
                                La Plataforma recopila las respuestas de los usuarios (es decir, opiniones sobre diversos temas) sobre las preguntas realizadas a través de los cuestionarios de la Plataforma. Estas respuestas se analizan y presentan en una página de resultados del cuestionario. Se recomienda estrictamente al Usuario que cumpla con el "código de conducta para una participación exitosa" de la plataforma y evite publicar cualquier dato personal que no desee que esté disponible públicamente en la Plataforma.
                                <br><br>
                                <b>3.1.3. Comunicación de la Plataforma por motivos relacionados con el uso permitido de la Plataforma por parte del Usuario.</b>
                                <br>
                                Para que la Plataforma se comunique con el Usuario con los fines anteriores, el Controlador de datos puede procesar todos los datos relacionados con la cuenta del Usuario, el contenido cargado y los datos relacionados con el uso de la Plataforma por parte del Usuario.

                                <h3 class="mt-4 mb-4">3.2 Datos de uso</h3>
                                También podemos recopilar información sobre cómo se accede y utiliza la página web ("Datos de uso"). Estos Datos de uso pueden incluir información como la dirección del Protocolo de Internet de su computadora (por ejemplo, la dirección IP), el tipo de navegador, la versión del navegador, las páginas de nuestra página web que visita, la hora y la fecha de su visita, el tiempo dedicado a esas páginas, único identificadores de dispositivos y otros datos de diagnóstico.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4"> 4. Cómo la Plataforma recopila datos</h2>
                                4.1 La información puede recopilarse de las siguientes maneras: <br>
                                4.1.1 Cuando el Usuario se registra y crea una cuenta en la Plataforma. <br>
                                4.1.2 Cuando el Usuario envía respuestas a los cuestionarios de la Plataforma <br>
                                4.1.3 Cuando el Usuario visita la Plataforma y acepta la instalación de cookies (según la Política de cookies de la Plataforma en el artículo 11 a continuación) y la recopilación de datos personales del Usuario, como la dirección IP, sistema operativo, tipo y edición del navegador, etc.
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">5. ¿Cuánto tiempo se almacenan los datos del Usuario y cuándo se eliminan?</h2>
                                <b>5.1. Datos de la cuenta del Usuario:</b><br>
                                Sin perjuicio del derecho de supresión/supresión del Usuario mencionado a continuación, los Datos registrados y almacenados en la cuenta del Usuario se conservarán mientras el Usuario desee hacer uso de la Plataforma para la finalidad mencionada anteriormente. En caso de que un Usuario desee eliminar su cuenta, puede eliminarla a través de la configuración de la cuenta o comunicarse con el Controlador de datos en los detalles de contacto mencionados anteriormente.
                                <br><br>
                                <b>5.2. Comunicación de la Plataforma por motivos relacionados con el uso permitido de la Plataforma por parte del Usuario.</b><br>
                                Los datos relacionados con dicha comunicación se almacenarán sólo mientras el Usuario desee utilizar la Plataforma y mantenga su cuenta. En caso de que un Usuario desee eliminar su cuenta, puede eliminar su cuenta a través de la configuración de la cuenta o comunicarse con el Controlador de datos en los detalles de contacto mencionados anteriormente
                                <br><br>
                                <b>5.3. Análisis estadístico para la optimización del sitio web
                                </b><br>
                                Independientemente de las disposiciones del artículo 5 antes mencionadas, el controlador de datos almacenará y procesará sólo los datos necesarios durante el período requerido para cumplir con sus obligaciones impuestas por la ley cada vez (cumplimiento de obligaciones fiscales, etc.).
                                <br><br>
                                <b>5.4. Procesamiento de datos personales con el fin de realizar análisis estadísticos.</b><br>
                                Consulte la política de cookies (artículo 11) a continuación.

                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">6. ¿Cuáles son los derechos del Usuario en relación con el tratamiento de sus datos y cómo puede ejercer estos derechos?</h2>
                                <b>6.1</b> El Controlador de datos respeta el derecho del Usuario en relación con el procesamiento de datos.
                                <br><br>
                                <b>6.2</b> El Usuario puede ejercer sus derechos poniéndose en contacto con el Responsable del Tratamiento a través de los siguientes datos de contacto: Teléfono: +3222905845, correo electrónico: info(at)ecas.org. 
                                <br><br>
                                Para facilitar al Usuario, los derechos del Usuario se incluyen en la siguiente tabla junto con una breve explicación de cada derecho (la referencia a los artículos corresponde al artículo del RGPD 2016/679):
                                <br><br>
                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Derecho</th>
                                        <th>Explicación</th>
                                    </tr>
                                    <tr>
                                        <td>Acceso (artículo 15)</td>
                                        <td>
                                            El Usuario puede solicitar al Controlador de datos que:
                                            <ul>
                                                <li>confirme si el Controlador de datos procesa los datos personales                                                </li>
                                                <li>Otorgue al Usuario acceso a datos que el Usuario no tiene. disponer</li>
                                                <li>dar al Usuario otra información relacionada con los datos personales del Usuario, como cuáles son los datos que el Controlador de datos dispone, cuáles son los propósitos del procesamiento, a quién se divulgan estos datos, si estos datos se transfieren en países extranjeros y cómo se transfieren estos datos protegidos, cuánto tiempo se almacenan los datos, cuáles son los derechos del usuario, cómo se puede presentar una queja, de dónde se tomaron los datos en la medida en que esta información no está incluida en la presente Política de Privacidad.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rectificación (artículo 16)</td>
                                        <td>
                                            El Usuario puede solicitar al Responsable del Tratamiento la rectificación de los datos personales inexactos.<br><br>
                                            El Controlador de datos puede tratar de verificar la exactitud de los datos antes de rectificarlos.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Borrado/eliminación (artículo 17)</td>
                                        <td>
                                            El Usuario puede solicitar al Controlador de datos que borre sus datos personales:<br><br>
                                            <ul>
                                                <li>siempre que,  los datos personales ya no sean necesarios para los fines para los que fueron recopilados
                                                </li>
                                                <li>cuando el Usuario retire su consentimiento</li>
                                                <li>los datos personales hayan sido procesados ​​ilegalmente</li>
                                            </ul>
                                            <br><br>
                                            El Controlador de datos no está obligado a cumplir con la solicitud del Usuario de borrar sus datos personales, si el procesamiento de los datos personales del Usuario es necesario:
                                            <ul>
                                                <li>para el cumplimiento de una obligación legal</li>
                                                <li>para el cumplimiento de otro propósito legítimo u otra base legal legítima
                                                </li>
                                                <li>para el establecimiento, ejercicio o defensa de reclamaciones legales</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Restricción (artículo 18)</td>
                                        <td>

                                            El Usuario puede solicitar al Controlador de datos que restrinja (almacene pero no procese) los datos personales del Usuario cuando:<br><br>
                                            se cuestione su exactitud (ver rectificación), para que el Controlador de datos pueda verificar la veracidad de los datos personales o<br><br>
                                            los datos personales han sido tratados ilícitamente pero el Usuario se opone a la supresión de los datos personales o<br><br>
                                            ya no son necesarios y para los fines para los que fueron recopilados pero el Usuario aún los necesita para el establecimiento, ejercicio o defensa de reclamaciones legales o existe otro propósito legítimo de procesamiento u otra base legal
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Portabilidad de datos (artículo 20)
                                        </td>
                                        <td>
                                            Cuando el procesamiento se basa en el consentimiento y el procesamiento se lleva a cabo por medios automatizados, el Usuario puede solicitar al Controlador de datos que reciba sus datos personales en un formato estructurado de uso común y lectura mecánica o solicitar al Controlador de datos que los transmita a otro controlador directamente desde el Controlador de datos. No obstante, conforme a la ley, este derecho se refiere únicamente a aquellos datos que hayan sido facilitados por el propio Usuario y no a aquellos datos que sean inferidos por el Responsable del Tratamiento a partir de los datos que el Usuario haya facilitado.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oposición (artículo 21)</td>
                                        <td>
                                            El Usuario puede oponerse en cualquier momento al tratamiento de los datos personales que le conciernen que se base en un interés legítimo o en la realización de una tarea realizada en interés público.<br><br>
                                            Cuando el Usuario ejerce su derecho de oposición, el Responsable del tratamiento tiene derecho a demostrar que existen motivos legítimos imperiosos para el tratamiento que prevalecen sobre los intereses, derechos y libertades del Usuario o para el establecimiento, ejercicio o defensa de reclamaciones.

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Retiro del consentimiento (opt-out)
                                        </td>
                                        <td>
                                            El Usuario tiene derecho a retirar su consentimiento cuando el consentimiento sea la base del procesamiento. El retiro es válido para el futuro.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Autoridad de control
                                        </td>
                                        <td>
                                            El Usuario tiene derecho a presentar una reclamación ante la autoridad de control local en materia de protección de datos. <br><br>
                                            En Grecia, la autoridad supervisora ​​de Protección de datos es la Autoridad de protección de datos https://www.dpa.gr/

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identidad</td>
                                        <td>El Controlador de datos se toma muy en serio la confidencialidad de todos los archivos que incluyen datos personales, por lo que tiene derecho a solicitar al Usuario una prueba de su identidad si el Usuario presenta una solicitud en relación con dichos archivos.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Costo</td>
                                        <td>El Usuario no tendrá que pagar por el ejercicio de sus derechos en relación con los datos personales, salvo que, por disposición legal, la solicitud para adquirir acceso a la información sea infundada o excesiva. En ese caso, el Controlador de datos puede cobrarle al Usuario una tarifa razonable según las circunstancias específicas. El Responsable del tratamiento informará al Usuario de cualquier posible cargo antes de que complete la solicitud.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gestión de tiempos.</td>
                                        <td>El Controlador de Datos tiene como objetivo responder a las solicitudes válidas del Usuario a más tardar dentro de un (1) mes a partir de su recepción, a menos que la solicitud sea extremadamente complicada o el Usuario haya presentado varias solicitudes, en cuyo caso el Controlador de datos tiene como objetivo responderlas dentro de los tres meses siguientes. . En caso de que el Controlador de datos necesite más de un mes por los motivos mencionados anteriormente, informará al Usuario. El Controlador de datos puede preguntarle al Usuario si desea explicar qué es exactamente lo que desea recibir o cuál es su preocupación. Esto ayudará al Controlador de datos a actuar más rápidamente en relación con la solicitud del Usuario. En todo caso el Usuario deberá mencionar datos y/o hechos específicos y veraces a fin de que el Responsable del Tratamiento pueda responder y/o satisfacer con exactitud la solicitud del Usuario. En caso contrario, el Responsable del tratamiento se reserva el derecho a las faltas que estén fuera de su control. Asimismo, el Responsable del tratamiento puede rechazar solicitudes infundadas, excesivas, abusivas, realizadas de mala fe o ilegítimas en el marco de las disposiciones legales.
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">7. ¿Cómo se protege la seguridad de los datos?</h2>
                                <b>7.1</b> El Controlador de datos implementa todas las medidas de seguridad apropiadas para garantizar la protección y confidencialidad de los datos personales, entre las que se incluyen las siguientes:
                                <br>
                                <ol>
                                    <li>Políticas de contraseñas seguras en todos los servidores</li>
                                    <li>Protocolo HTTPS para interactuar con las API y los clientes web</li>
                                    <li>Protocolo SSH para la conexión al servidor</li>
                                    <li>Actualizaciones periódicas del servidor con la última seguridad correcciones</li>
                                </ol>

                                <br><br>
                                <b>7.2</b> Tenga en cuenta que solo los empleados específicamente autorizados del Controlador de datos, que actúan bajo la autoridad del Controlador de datos y solo bajo sus instrucciones, así como los destinatarios, cuando sea necesario, manejan los datos enviados por el Usuario. Para el procesamiento, el Controlador de datos elige a personas con las calificaciones adecuadas que tienen garantías suficientes en cuanto a conocimientos técnicos e integridad personal para proteger la confidencialidad. El Controlador de datos toma todas las medidas de seguridad necesarias para la protección y salvaguarda del secreto, la confidencialidad y la integridad de los datos personales también a través de los compromisos contractuales pertinentes de sus asociados. En cualquier caso, la seguridad de la página  Web puede verse vulnerada por causas ajenas a la esfera de control del Responsable del tratamiento, así como por problemas técnicos o de otro tipo de la red o de fuerza mayor o hechos fortuitos. En ese caso, no se puede garantizar la seguridad de los datos personales.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">8. ¿Quiénes son los destinatarios de los datos?</h2>
                                <b>8.1</b> Los destinatarios de los datos personales del Usuario son las empresas asociadas que proporcionan la infraestructura técnica para el funcionamiento de lal página Web, el proveedor de alojamiento, así como la empresa que se compromete a enviar comunicaciones electrónicas relacionadas con el funcionamiento de la Plataforma a los Usuarios. Cuando sea necesario según las leyes aplicables, el Controlador de datos firmará acuerdos con dichas empresas, que se refieren a la implementación y el control regular de las medidas de seguridad. En caso de que los datos se transfieran fuera de la UE, existen todas las garantías necesarias.
                                <br><br>
                                <b>8.2.</b> En caso de que el Controlador de datos reciba una solicitud de notificación o transferencia de datos luego de una solicitud de la Autoridad Administrativa, Abogado, Tribunal u otra Autoridad correspondiente, puede notificar / transferir esos datos para cumplir con su deber ejecutado en favor del interés público hacia estas autoridades (con o sin notificación previa del Usuario) de conformidad con las disposiciones legales correspondientes. Si el Usuario debe ser notificado previamente de acuerdo con las disposiciones legales, entonces el Usuario tiene derecho a oponerse a este procesamiento según lo dispuesto en el artículo 7 anterior.
                                <br><br>
                                <b>8.3.</b> En cuanto a los datos profesionales de cada Usuario, se encuentran a disposición de todos los Usuarios registrados en la Plataforma para las finalidades antes mencionadas.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">9. Comunicación con el Responsable del Tratamiento</h2>
                                <b>9.1.</b> Para cualquier cuestión relacionada con la presente política de privacidad, el procesamiento de datos del Usuario, así como el ejercicio de los derechos del Usuario, el Usuario puede comunicarse con el Controlador de datos a través de una de las siguientes formas: <br>
                                Teléfono: +3222905845,<br>
                                Correo electrónico: info(at)ecas.org
                                <br><br>
                                En caso de que el El usuario tenga conocimiento de cualquier incidente de violación de datos, se le ruega que lo notifique al Controlador de datos de inmediato.
                                <br><br>
                                <b>9.2.</b> Los presentes términos se rigen y complementan por los Términos y Condiciones y constituyen junto con ellos un texto uniforme.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">10. Conexión a otros sitios web/redes sociales</h2>
                                Esta página web se conecta con otras páginas web sitios web a través de hipervínculos. Estas páginas web no están relacionados con la página web del controlador de datos y el controlador de datos no verifica ni recomienda su contenido. Por tanto, no se puede comprobar la exactitud, legitimidad, exhaustividad o calidad de su contenido y la legitimidad del tratamiento de los datos personales del Usuario, ni se otorga garantía alguna sobre los mismos. El Responsable del Tratamiento no se hace responsable de los mismos ni de los daños que puedan causarse al Usuario a causa o como consecuencia de su uso. El Controlador de datos no puede verificar el procesamiento de los datos personales del Usuario por parte de esas páginas webs sitios web vinculadas y, por lo tanto, no asume ninguna responsabilidad. Cuando el Usuario acceda a dichas páginas web deberá tener en cuenta que se aplican los términos y condiciones de cada página web. Para cualquier cuestión que pudiera ocurrir sobre el contenido o el uso de la página web enlazada, el Usuario deberá contactar directamente con el operador o administrador de cada página web. El Responsable del Tratamiento no aprueba el Contenido o los servicios de las páginas web enlazadas, a los que el Usuario accede a través de la página Web.<br><br>
                                La página Web brinda al Usuario la posibilidad de conectarse e interactuar con las redes sociales siguiendo su propia iniciativa y voluntad. En ese caso, el Controlador de datos no es responsable del procesamiento de los datos del Usuario que se realice a través o por las redes sociales. El Usuario deberá dirigirse directamente a cada red social en concreto para el ejercicio de sus legítimos derechos.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">11. Cookies</h2>
                                11.1. La Plataforma utiliza cookies para ser operativa o más eficiente en su funcionamiento, para mejorar la navegación del Usuario, para proporcionar al Usuario todo el potencial de la Plataforma, para asegurar la correcta visualización de los contenidos así como para fines analíticos y estadísticos.

                                <br><br>
                                11.2. Las cookies son pequeños archivos de texto que se almacenan en la computadora del Usuario cuando visita una plataforma digital, que se utilizan como medio para identificar su computadora.
                                <br><br>
                                11.3. Las cookies, además de las cookies absolutamente necesarias, solo se instalan si el Usuario acepta su instalación cuando visita esta Plataforma. Al aceptar las cookies al entrar en esta Plataforma, el Usuario declara expresamente que ha leído y entendido los términos y condiciones particulares sobre la instalación, función y finalidad de las cookies y que presta su consentimiento para su uso.

                                <br><br>
                                11.4. Alternativamente, el Usuario puede no aceptar las cookies. En este caso, solo se instalarán las cookies que sean técnica y funcionalmente necesarias para el funcionamiento de la Plataforma.

                                <br><br>
                                11.5. El Usuario puede gestionar el uso e instalación de cookies en cualquier momento a través de un panel, donde puede elegir qué categoría de cookies quiere aceptar y cuáles no (o solicitar que se instalen solo las cookies técnicamente necesarias).
                                <br><br>
                                11.6. En concreto, las cookies utilizadas por la Plataforma son las siguientes:
                                <br><br>

                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Tipo de cookies</th>
                                        <th>Explicación</th>
                                        <th>Ejemplos de cookies</th>
                                        <th>Duración de la instalación de cada cookie</th>
                                        <th>Cesión de datos a terceros</th>
                                    </tr>
                                    <tr>
                                        <td>Cookies</td>
                                        <td>absolutamente necesarias Las cookies absolutamente necesarias son imprescindibles para el correcto funcionamiento de la Plataforma. Estas cookies permiten al Usuario navegar y utilizar funciones de la Plataforma como el acceso a áreas seguras. Estas cookies no reconocen la identidad individual del Usuario y sin ellas no es posible el buen funcionamiento de la Plataforma.
                                        </td>
                                        <td>crowdsourcing_app_cookies_consent_selection (Almacena el estado de consentimiento de cookies del usuario para el dominio actual)
                                            <br><br>
                                            crowdsourcing_app_cookies_consent_targeting (Almacena el estado de consentimiento de cookies del usuario para el dominio actual)
                                            <br><br>
                                            XSRF-TOKEN (Garantiza la seguridad de navegación del visitante al evitar la falsificación de solicitudes entre sitios. Esta cookie es esencial para la seguridad de la página web y del visitante).
                                            <br><br>
                                            ecas_lets_crowdsource_our_future_session (Cuando la aplicación necesita para “recordar” al usuario conectado mientras navega a la Plataforma)
                                            <br><br>
                                            Crowdsourcing_anonymous_user_id (utilizado para almacenar respuestas anónimas en los cuestionarios asignando un número entero al usuario que envía la respuesta)
                                        </td>
                                        <td>1 año
                                            <br><br>
                                            <br><br>
                                            1 día
                                            <br><br>
                                            <br><br>
                                            Sesión
                                            <br><br>
                                            <br><br>
                                            5 años
                                        </td>
                                        <td>No
                                            <br><br>
                                            <br><br>

                                            No
                                            <br><br>
                                            <br><br>

                                            No
                                            <br><br>
                                            <br><br>

                                            No
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cookies estadísticas/analíticas</td>
                                        <td>Estas son cookies que evalúan la forma en que los visitantes usan la Plataforma (por ejemplo, qué páginas se visitan con más frecuencia y si reciben mensajes de error de las páginas web). Estas cookies se utilizan con fines estadísticos y para mejorar el rendimiento de una Plataforma.
                                        </td>
                                        <td>_ga_4S9N5MK4VE, _gat,_ga, _gcl_au, _gid: Las cookies de Google Analytics se utilizan para medir el tráfico en la Plataforma. Se guarda una cadena de texto única para identificar el navegador, la marca de tiempo para las interacciones y el navegador/página de origen que condujo al usuario a la Plataforma. No se guarda información sensible.

                                        </td>
                                        <td>_ga_4S9N5MK4VE: 2 años
                                            <br><br>
                                            _gat:1 minuto
                                            <br><br>
                                            _ga:2 años
                                            <br><br>
                                            _gcl_au:3 meses
                                            <br><br>
                                            _gid:24 horas
                                        </td>
                                        <td>Sí (Empresa que brinda servicios estadísticos y analíticos si se considera como un tercero)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">12. Privacidad de los niños</h2>
                                Nuestro proyecto no se dirige a ninguna persona menor de 18 años ("Niños"). No recopilamos a sabiendas información de identificación personal de ninguna persona menor de 18 años. Si es padre o tutor y sabe que sus hijos nos han proporcionado datos personales, comuníquese con nosotros. Si nos damos cuenta de que hemos recopilado Datos personales de niños sin verificación del consentimiento de los padres, tomaremos  las medidas necesarias para eliminar esa información de nuestros servidores.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">13. Modificaciones a esta Política de privacidad</h2>
                                El Controlador de datos se reserva el derecho de modificar la presente Política de privacidad, por ejemplo, cuando sea necesario para cumplir con los nuevos requisitos impuestos por las leyes, directrices o requisitos técnicos aplicables, o en el curso de una revisión de los Procesos y prácticas del Controlador de datos. El Usuario será notificado de cualquier modificación a esta Política de Privacidad a través de la Plataforma. El Usuario debe revisar periódicamente esta Política de Privacidad para ver si ha habido modificaciones.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
