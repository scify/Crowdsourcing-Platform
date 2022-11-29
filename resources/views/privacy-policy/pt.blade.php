@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Política de privacidade</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                A presente Política de Privacidade aplica-se a todos os Utilizadores da Plataforma (doravante designados por <b>“Utilizadores”</b> ou <b>“Utilizador”</b> e <b>“Plataforma”</b> respetivamente) e faz parte integrante dos Termos e Condições do Site da Plataforma. A presente Política de Privacidade fornece ao utilizador informações gerais sobre como o Controlador de Dados usa seus dados pessoais e outras informações exigidas pela legislação de proteção de dados. Em caso de alteração futura, o utilizador receberá as atualizações e informações necessárias através da atualização da presente Política de Privacidade, carregada na Plataforma.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">1. Quem é o Controlador de Dados?</h2>
                            </div>
                            <div class="col-12">
                                <b>1.1.</b> A empresa com o nome de empresa “{{ config("app.installation_company_name") }}”, endereço: {{ config("app.installation_company_address") }}, Telefone: {{ config("app.installation_company_phone") }}, email:
                                {{ config("app.installation_company_email") }}, é o Controlador de Dados para o processamento dos Dados Pessoais do utilizador (doravante denominado <b>"Controlador de Dados"</b>).
                                <br><br>
                                <b>1.2. Detalhes de contato do controlador de dados:</b> Para qualquer problema ou preocupação com relação à presente Política de Privacidade e ao processamento de dados pessoais do utilizador ou dados carregados pelo utilizador para usar a plataforma, o utilizador pode comunicar com o controlador de dados, usando um dos seguintes alternativas:
                                <br><br>
                                Através do telefone {{ config("app.installation_company_phone") }}, de segunda a sexta das 10h00 às 18h00. EET (Hora do Leste Europeu)<br>
                                Ao enviar um e-mail para o seguinte endereço de e-mail: {{ config("app.installation_company_email") }}<br>
                                Enviando correspondência para o seguinte endereço: {{ config("app.installation_company_address") }}<br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">2. Qual é a finalidade e a base legal do tratamento dos dados do Utilizador?</h2>
                                <b>2.1.</b> O objetivo operacional da plataforma é recolher opiniões dos utilizadores através de questionários. As opiniões são processadas para obter insights, reunir e apresentar ideias e sugestões valiosas sobre os temas abordados nos questionários. Os utilizadores podem responder anonimamente (sem fornecer qualquer informação pessoal) ou podem registrar -se voluntariamente para enviar respostas e-mail e um apelido. As respostas do utilizador são traduzidas para inglês e apresentadas em relatórios. Para fins específicos de processamento, a base legal é o consentimento prévio do Utilizador.
                                <br><br>
                                <b>2.2.</b> Enviar e-mails informativos ao Utilizador com o objetivo de informá-lo sobre novas atividades, projetos e outros assuntos de interesse da Plataforma. Para este efeito de tratamento a base legal é o consentimento prévio do Utilizador.
                                <br><br>
                                <b>2.3</b> Processamento de dados por motivos relacionados com o cumprimento das obrigações legais do Controlador de Dados. Nesses casos, o processamento de dados ocorre apenas pelo período de tempo necessário para que o Controlador de Dados cumpra as obrigações impostas por várias disposições legais.
                                <br><br>
                                <b>No caso das disposições acima em que a base legal é o consentimento prévio do Utilizador, o Utilizador pode sempre retirar seu consentimento a qualquer momento sem afetar a legitimidade dos dados com base no consentimento prévio à sua retirada.</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">3. Tipos de dados recolhidos</h2>

                                <h3 class="mt-4 mb-4">3.1 Dados pessoais</h3>
                                <b>3.1.1 Registro - criação de conta:</b><br>
                                Para que um Utilizador crie voluntariamente uma conta na Plataforma, o Utilizador deverá preencher os dados necessários: apelido, endereço de e-mail e uma palavra passe.
                                <br><br>
                                <b>3.1.2 Respostas do questionário enviado</b><br>
                                A Plataforma recolhe as respostas dos utilizadores (ou seja, opiniões sobre vários assuntos) em perguntas feitas através de questionários da Plataforma. Essas respostas são analisadas e apresentadas numa página de resultados do questionário. O Utilizador é estritamente aconselhado a cumprir o "código de conduta para uma participação bem-sucedida" da plataforma e evitar publicar publicamente quaisquer dados pessoais que não desejem estar disponíveis publicamente na Plataforma.
                                <br><br>
                                <b>3.1.3. A comunicação da Plataforma por motivos relacionados ao uso permitido da Plataforma pelo Utilizador.</b>
                                <br>
                                Para que a Plataforma se comunique com o Utilizador para os fins acima, o Controlador de Dados pode processar todos os dados relacionados à conta do Utilizador, conteúdo carregado e dados relacionados ao uso da Plataforma pelo Utilizador.

                                <h3 class="mt-4 mb-4">3.2 Dados de uso</h3>
                                Também podemos recolher informações sobre como a página da Web é acedida e usada ("Dados de uso"). Esses Dados de Uso podem incluir informações como o endereço do protocolo de Internet do seu computador (por exemplo, endereço IP), tipo de navegador, versão do navegador, as páginas da nossa página da Web que você visita, a hora e a data de sua visita, o tempo passado nessas páginas, identificadores de dispositivos e outros dados de diagnóstico.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4"> 4. Como a Plataforma coleta dados</h2>
                                4.1 As informações podem ser recolhidas das seguintes formas: <br>
                                4.1.1 Quando o Utilizador se regista e cria uma conta na Plataforma. <br>
                                4.1.2 Quando o Utilizador envia respostas nos questionários da Plataforma <br>
                                4.1.3 Quando o Utilizador visita a Plataforma e concorda com a instalação de cookies (conforme a Política de Cookies da Plataforma no artigo 11 abaixo) e a recolha de dados pessoais do Utilizador, como endereço IP, sistema operacional, tipo e edição do navegador etc.
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">5. Por quanto tempo os dados do utilizador são armazenados e quando são excluídos?</h2>
                                <b>5.1. Dados da conta do utilizador:</b><br>
                                Sem prejuízo do direito de exclusão/exclusão do Utilizador mencionado abaixo, os Dados registrados e armazenados na conta do Utilizador serão armazenados enquanto o Utilizador desejar fazer uso da Plataforma para os fins mencionados acima. Caso um Utilizador deseje remover sua conta, ele pode remover sua conta através das configurações da conta ou entrar em contato com o Controlador de Dados nos detalhes de contato mencionados acima.
                                <br><br>
                                <b>5.2. A comunicação da Plataforma por motivos relacionados ao uso permitido da Plataforma pelo Utilizador.</b><br>
                                Os dados relacionados a tal comunicação serão armazenados apenas enquanto o Utilizador desejar utilizar a Plataforma e manter sua conta. Caso um Utilizador deseje excluir sua conta, ele pode excluir sua conta através das configurações da conta ou entrar em contato com o Controlador de Dados nos detalhes de contato mencionados acima.
                                <br><br>
                                <b>5.3. Análise estatística para a otimização do Website</b><br>
                                Independentemente das disposições acima mencionadas do artigo 5, o Controlador de Dados armazenará e processará apenas os dados necessários pelo período necessário para cumprir suas obrigações impostas por lei (cumprimento de obrigações fiscais etc.).
                                <br><br>
                                <b>5.4. Tratamento de dados pessoais para fins de análise estatística.</b><br>
                                Consulte a política de cookies (artigo 11) abaixo.
                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">6. Quais são os direitos do Utilizador em relação ao tratamento dos seus dados e como pode exercer esses direitos?</h2>
                                <b>6.1</b> O Controlador de Dados respeita o direito do Utilizador em relação ao processamento de dados.
                                <br><br>
                                <b>6.2</b> O Utilizador pode exercer os seus direitos contactando o Controlador de Dados através dos seguintes contactos: Telefone: {{ config("app.installation_company_phone") }}, email: {{ config("app.installation_company_email") }}
                                <br><br>
                                Para ajudar o utilizador, os direitos do utilizador estão incluídos na tabela a seguir, juntamente com uma breve explicação de cada direito (referência aos artigos corresponde ao artigo do GDPR 2016/679):
                                <br><br>
                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Direito</th>
                                        <th>Explicação</th>
                                    </tr>
                                    <tr>
                                        <td>Acesso (artigo 15)</td>
                                        <td>
                                            O Utilizador pode solicitar ao Controlador de Dados que:
                                            <ul>
                                                <li>confirmar se o Controlador de Dados processa os dados pessoais do Utilizador dar ao Utilizador acesso a dados que o Utilizador não dispõe</li>
                                                <li>fornecer ao Utilizador outras informações relacionadas aos dados pessoais do Utilizador, como quais são os dados que o Controlador de Dados dispõe, quais são as finalidades do processamento, a quem são divulgados esses dados, se esses dados são transferidos em países estrangeiros e como são esses dados protegidos, por quanto tempo são armazenados os dados, quais são os direitos do Utilizador, como pode ser apresentada uma reclamação, de onde foram retirados os dados na medida em que esta informação não está incluída na presente Política de Privacidade.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Retificação (artigo 16)</td>
                                        <td>
                                            O Utilizador pode solicitar ao Controlador de Dados que retifique dados pessoais imprecisos.<br><br>
                                            O Controlador de Dados pode procurar verificar a exatidão dos dados antes de retificá-los.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Eliminar/remover (artigo 17)</td>
                                        <td>
                                            O Utilizador pode solicitar ao Controlador de Dados que apague seus dados pessoais:<br><br>
                                            <ul>
                                                <li>sempre que, quando os dados pessoais não forem mais necessários para os fins para os quais foram coletados
                                                </li>
                                                <li>quando o Utilizador retira seu consentimento</li>
                                                <li>os dados pessoais foram processados ilegalmente</li>
                                            </ul>
                                            <br><br>
                                            O Controlador de Dados não é obrigado a cumprir a solicitação do Utilizador para apagar seus dados pessoais, se o processamento dos dados pessoais do Utilizador for necessário:
                                            <ul>
                                                <li>para cumprimento de uma obrigação legal</li>
                                                <li>para o cumprimento de outra finalidade legítima ou outra base legal legítima
                                                </li>
                                                <li>para o estabelecimento, exercício ou defesa de ações judiciais</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Restrição (artigo 18)</td>
                                        <td>

                                            O Utilizador pode solicitar ao Controlador de Dados que restrinja (armazene, mas não processe) os dados pessoais do Utilizador quando:<br><br>
                                            a sua exatidão é contestada (ver retificação), para que o Controlador de Dados possa verificar a exatidão dos dados pessoais ou<br><br>
                                            os dados pessoais foram tratados de forma ilícita, mas o Utilizador opõe-se ao apagamento dos dados pessoais ou<br><br>
                                            já não são necessários para os fins para os quais foram recolhidos, mas o Utilizador continua a precisar deles para o estabelecimento, exercício ou defesa de ações judiciais ou existe outra finalidade legítima de tratamento ou outra base legal

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Portabilidade de dados (artigo 20)
                                        </td>
                                        <td>
                                            Quando o processamento é baseado no consentimento e o processamento é realizado por meios automatizados, o utilizador pode solicitar ao controlador de dados que receba seus dados pessoais em um formato estruturado comumente usado e legível por máquina ou solicitar ao controlador de dados que os transmita a outro controlador diretamente de o Controlador de Dados. No entanto, de acordo com a lei, este direito refere-se apenas aos dados que foram fornecidos pelo próprio Utilizador e não aos dados que são inferidos pelo Controlador de Dados com base nos dados que o Utilizador forneceu.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Objeção (artigo 21)</td>
                                        <td>
                                            O Utilizador pode, a qualquer momento, opor-se ao tratamento de dados pessoais que lhe digam respeito, que se baseie em interesse legítimo ou no desempenho de uma tarefa de interesse público.<br><br>
                                            Quando o Utilizador exerce o seu direito de objeção, o Controlador de Dados tem o direito de demonstrar motivos legítimos imperiosos para o tratamento que se sobreponham ao interesse, direitos e liberdade do Utilizador ou para o estabelecimento, exercício ou defesa de ações judiciais.

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Remoção de consentimento (optar por sair)
                                        </td>
                                        <td>
                                            O Utilizador tem o direito de retirar seu consentimento quando o consentimento for a base do processamento. A retirada é válida para o futuro.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Autoridade Supervisora
                                        </td>
                                        <td>
                                            O Utilizador tem o direito de apresentar uma reclamação à autoridade supervisora local relacionada à proteção de dados. <br><br>
                                            Em Portugal, a autoridade supervisora da Proteção de Dados é a Comissão Nacional de Proteção de Dados (CNPD) https://www.cnpd.pt/cnpd

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identidade</td>
                                        <td>O Controlador de Dados leva a sério a confidencialidade de todos os arquivos que incluam dados pessoais, portanto, ele tem o direito de solicitar ao Utilizador prova de sua identidade se o Utilizador enviar uma solicitação em relação a esses arquivos.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Custo</td>
                                        <td>O Utilizador não terá que pagar pelo exercício dos seus direitos em relação aos dados pessoais, a menos que, conforme previsto em lei, o pedido de acesso à informação seja infundado ou excessivo. Nesse caso, o Controlador de Dados pode cobrar ao Utilizador uma taxa razoável sob as circunstâncias específicas. O Controlador de Dados informará o Utilizador de qualquer possível cobrança antes de concluir a solicitação.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Calendário</td>
                                        <td>O Controlador de Dados visa responder às solicitações válidas do Utilizador no prazo máximo de 1 (um) mês a partir do recebimento, a menos que a solicitação seja extremamente complicada ou o Utilizador tenha enviado várias solicitações, caso em que o Controlador de dados visa respondê-las em três meses. Caso o Controlador de Dados precise de mais de um mês pelos motivos mencionados acima, ele informará o Utilizador. O Controlador de Dados pode perguntar ao Utilizador se ele deseja explicar o que exatamente deseja receber ou qual é sua preocupação. Isso ajudará o Controlador de Dados a agir mais rapidamente em relação à solicitação do Utilizador. Em qualquer caso, o Utilizador deve mencionar dados e/ou fatos específicos e verdadeiros para que o Controlador de Dados possa responder e/ou satisfazer com precisão a solicitação do Utilizador. Caso contrário, o Controlador de Dados se reserva o direito de quaisquer falhas que estejam fora de seu controle. Adicionalmente, o Responsável pelo Tratamento pode rejeitar pedidos infundados, excessivos, abusivos, feitos de má fé ou ilegítimos no quadro das disposições legais.
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">7. Como a segurança dos dados é protegida?</h2>
                                <b>7.1</b> O Controlador de Dados implementa todas as medidas de segurança apropriadas para garantir a proteção e confidencialidade dos dados pessoais, entre os quais estão incluídos:
                                <br>
                                <ol>
                                    <li>Políticas de senha forte em todos os servidores</li>
                                    <li>Protocolo HTTPS para interagir com APIs e clientes Web</li>
                                    <li>Protocolo SSH para conexão do servidor</li>
                                    <li>Atualizações periódicas do servidor com as correções de segurança mais recentes</li>
                                </ol>

                                <br><br>
                                <b>7.2</b> Observe que apenas funcionários especificamente autorizados do Controlador de Dados, agindo sob a autoridade do Controlador de Dados e apenas sob suas instruções, bem como destinatários, quando necessário, lidam com os dados enviados pelo Utilizador. Para o processamento, o Controlador de Dados escolhe pessoas com qualificações apropriadas que tenham garantias suficientes quanto ao conhecimento técnico e integridade pessoal para proteger a confidencialidade. O Controlador de Dados toma todas as medidas de segurança necessárias para a proteção e salvaguarda do sigilo, confidencialidade e integridade dos dados pessoais também por meio de compromissos contratuais relevantes de seus associados. Em qualquer caso, a segurança do Site pode ser violada por motivos que residem fora da esfera de controle do Controlador de Dados, bem como por problemas técnicos ou outros de rede ou força maior ou fatos acidentais. Nesse caso, a segurança dos dados pessoais não pode ser garantida.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">8. Quem são os destinatários dos dados?</h2>
                                <b>8.1</b> Os destinatários dos dados pessoais do Utilizador são empresas associadas que fornecem infraestrutura técnica para o funcionamento do Site, fornecedor de alojamento, bem como a empresa que se compromete a enviar comunicação eletrónica relacionada com o funcionamento da Plataforma aos Utilizadores. Sempre que necessário, de acordo com as leis aplicáveis, o Controlador de Dados assinará acordos com essas empresas, que se referem à implementação e monitorização regular de medidas de segurança. Caso os dados sejam transferidos para fora da ΕU, todas as garantias necessárias estão em vigor.
                                <br><br>
                                <b>8.2.</b> Caso o Controlador de Dados receba uma solicitação para notificar ou transferir dados após solicitação da Autoridade Administrativa, Procurador, Tribunal ou outra Autoridade competente, ele poderá notificar / transferir esses dados para cumprir seu dever executado em favor do interesse público para essas autoridades (com ou sem notificação prévia do Utilizador) de acordo com as disposições legais pertinentes. Se o Utilizador for previamente notificado de acordo com as disposições legais, então o Utilizador tem o direito de se opor a esse processamento conforme previsto no artigo 7 acima.
                                <br><br>
                                <b>8.3.</b> Quanto aos dados profissionais de cada Utilizador, estão à disposição de todos os Utilizadores registados da Plataforma para os fins acima referidos.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">9. Comunicação com o Controlador de Dados</h2>
                                <b>9.1.</b> Para qualquer questão relacionada com a presente política de privacidade, tratamento de dados do Utilizador, bem como exercício dos direitos do Utilizador, o Utilizador pode contactar o Controlador de Dados através de uma das seguintes formas:
                                Telefone: {{ config("app.installation_company_phone") }}, <br>
                                Email: {{ config("app.installation_company_email") }}
                                <br><br>
                                Caso o Utilizador tome conhecimento de qualquer incidente de violação de dados, ele é cordialmente solicitado a notificar o Controlador de Dados imediatamente.
                                <br><br>
                                <b>9.2.</b> Os presentes termos são regidos e complementados pelos Termos e Condições e consistem juntamente com eles um texto uniforme.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">10. Conexão com outros sites/mídias sociais</h2>
                                O Website dá ao Utilizador a possibilidade de se conectar e interagir com as redes sociais por iniciativa e vontade própria. Nesse caso, o Controlador de Dados não é responsável pelo processamento de dados do Utilizador que ocorra através ou pela mídia social. O Utilizador deve dirigir-se diretamente a cada mídia social específica para exercer seus direitos legítimos.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">11. Cookies</h2>
                                11.1. A Plataforma utiliza cookies para ser operacional ou mais eficiente no seu funcionamento, para melhorar a navegação do Utilizador, para proporcionar ao Utilizador todo o potencial da Plataforma, para garantir a correta visualização dos conteúdos, bem como para fins analíticos e estatísticos.
                                <br><br>
                                11.2. Cookies são pequenos arquivos de texto armazenados no computador do Utilizador quando este visita uma plataforma digital, que são utilizados como meio de identificação do seu computador.
                                <br><br>
                                11.3. Os cookies para além dos cookies absolutamente necessários só são instalados se o Utilizador aceitar a sua instalação ao visitar esta Plataforma. Ao aceitar cookies ao entrar nesta Plataforma, o Utilizador declara expressamente que leu e compreendeu os termos e condições específicos relativos à instalação, função e finalidade dos cookies e que dá o seu consentimento para a sua utilização.
                                <br><br>
                                11.4. Alternativamente, o Utilizador pode não aceitar cookies. Neste caso, serão instalados apenas os cookies que sejam técnica e funcionalmente necessários para o funcionamento da Plataforma.
                                <br><br>
                                11.5. O Utilizador pode gerir a utilização e instalação de cookies a qualquer momento através de um painel, onde pode escolher que categoria de cookies quer aceitar e quais não (ou solicitar a instalação apenas dos cookies tecnicamente necessários).
                                <br><br>
                                11.6. Em particular, os cookies utilizados pela Plataforma são os seguintes:
                                <br><br>

                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Tipos de cookies</th>
                                        <th>Explicação</th>
                                        <th>Exemplos de cookies</th>
                                        <th>Duração da instalação de cada cookie</th>
                                        <th>Transferência de dados para terceiros</th>
                                    </tr>
                                    <tr>
                                        <td>Cookies absolutamente necessários</td>
                                        <td>Os cookies absolutamente necessários são essenciais para o bom funcionamento da Plataforma. Esses cookies permitem que o Utilizador navegue e use recursos da Plataforma, como acesso a áreas seguras. Esses cookies não reconhecem a identidade individual do Utilizador e sem eles não é possível o bom funcionamento da Plataforma.
                                        </td>
                                        <td>crowdsourcing_app_cookies_consent_selection (armazena o estado de consentimento do cookie do utilizador para o domínio atual)
                                            <br><br>
                                            crowdsourcing_app_cookies_consent_targeting (armazena o estado de consentimento do cookie do utilizador para o domínio atual)
                                            <br><br>
                                            XSRF-TOKEN (garante a segurança da navegação do visitante, evitando a falsificação de solicitações entre sites. Este cookie é essencial para a segurança do site e do visitante. )
                                            <br><br>
                                            ecas_lets_crowdsource_our_future_session (Quando o aplicativo precisa “lembrar” o utilizador logado enquanto ele navega para a Plataforma)
                                            <br><br>
                                            Crowdsourcing_anonymous_user_id (usado para armazenar respostas anônimas nos questionários, atribuindo um número inteiro ao utilizador que está enviando a resposta)
                                        </td>
                                        <td>1 ano
                                            <br><br>
                                            <br><br>
                                            1 ano
                                            <br><br>
                                            <br><br>
                                            Sessão
                                            <br><br>
                                            <br><br>
                                            5 anos
                                        </td>
                                        <td>Não
                                            <br><br>
                                            <br><br>

                                            Não
                                            <br><br>
                                            <br><br>

                                            Não
                                            <br><br>
                                            <br><br>

                                            Não
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cookies estatísticos/analíticos</td>
                                        <td>São cookies que avaliam a forma como os visitantes usam a Plataforma (por exemplo, quais páginas são visitadas com mais frequência e se recebem mensagens de erro de páginas da web). Esses cookies são usados para fins estatísticos e para melhorar o desempenho de uma Plataforma.
                                        </td>
                                        <td>_ga_4S9N5MK4VE, _gat,_ga, _gcl_au, _gid: os cookies do Google Analytics são usados para medir o tráfego na Plataforma. Uma string de texto exclusiva é salva para identificar o navegador, o carimbo de data/hora das interações e o navegador/página de origem que levou o utilizador à Plataforma. Nenhuma informação sensível é salva.

                                        </td>
                                        <td>_ga_4S9N5MK4VE: 2 anos
                                            <br><br>
                                            _gat:1 minutos
                                            <br><br>
                                            _ga:2 anos
                                            <br><br>
                                            _gcl_au:3 meses
                                            <br><br>
                                            _gid:24 horas
                                        </td>
                                        <td>Sim (Empresa que presta serviços estatísticos e analíticos se considerada como terceira)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">12. Privacidade das Crianças</h2>
                                O nosso projeto não se dirige a menores de 18 anos ("Crianças"). Não recolhemos intencionalmente informações de identificação pessoal de menores de 18 anos. Se você é pai ou responsável e está ciente de que seus filhos nos forneceram Dados Pessoais, entre em contato connosco. Se tomarmos conhecimento de que recolhemos Dados Pessoais de crianças sem verificação do consentimento dos pais, tomamos medidas para remover essas informações dos nossos servidores.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">13. Alterações a esta Política de Privacidade</h2>
                                O Controlador de Dados reserva-se o direito de alterar esta presente Política de Privacidade, por exemplo, quando isso for necessário para cumprir novos requisitos impostos por leis, diretrizes ou requisitos técnicos aplicáveis, ou durante uma revisão dos processos e práticas do Controlador de Dados. O Utilizador será notificado de qualquer alteração a esta Política de Privacidade através da Plataforma. O Utilizador deve verificar regularmente esta Política de Privacidade para quaisquer alterações.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
