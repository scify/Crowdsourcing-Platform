@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Código de conduta</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>Como plataforma de crowdsourcing, damos as boas-vindas a todos e incentivamos um ambiente amigável e positivo.
                                    Este código de conduta descreve as nossas expectativas dos participantes para garantir uma participação bem-sucedida, bem como as etapas para relatar comportamentos inaceitáveis. Estamos comprometidos em proporcionar um ambiente acolhedor e inspirador para todos e esperamos que nosso código de conduta seja honrado. Qualquer pessoa que viole este código de conduta poderá ser banida da Plataforma ou suas respostas poderão ser deletadas.
                                    Durante sua participação em projetos de crowdsourcing:                                    
                                </p>
                                <ul>
                                    <li>
                                        <strong>Seja claro e relevante para o tópico:</strong> Tente ser preciso e explique os seus pensamentos e argumentos com clareza. Todas as respostas devem ser relevantes para o tópico do questionário. Isso facilitará o trabalho dos moderadores da plataforma, onde eles terão que analisar todas as respostas dadas, categorizá-las e produzir insights valiosos que podem ter um impacto positivo na sociedade.
                                    </li>
                                    <li><strong>Seja respeitoso e gentil:</strong> nem sempre iremos concordar, mas discordar não é desculpa para mau comportamento e maus modos. É importante lembrar que, embora as respostas fornecidas sejam anónimas, um ambiente em que as pessoas se sintam desconfortáveis ou ameaçadas não é produtivo. É claro que assédio, insultos, publicações (ou ameaça de publicação) de informações de identificação pessoal de outras pessoas (“doxing”), termos racistas ou sexistas e outros comportamentos de exclusão não são aceitáveis. Se se mantiver “respeitador e amável” não há como errar.
                                    </li>
                                    <li><strong>Lembre-se que sua contribuição é pública:</strong> Seu e-mail e quaisquer informações pessoais não são revelados pela plataforma. Embora as respostas textuais que você fornece nos questionários, as respostas às perguntas abertas podem estar disponíveis publicamente. Não inclua nenhuma informação pessoal em suas respostas que você não deseja que esteja disponível publicamente.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Declaração de diversidade
                                </h2>
                            </div>
                            <div class="col-12">
                                Incentivamos todos a participar e estamos comprometidos em construir uma comunidade para todos. Embora esta lista não possa ser exaustiva, honramos explicitamente a diversidade de idade, gênero, identidade ou expressão de gênero, cultura, etnia, idioma, nacionalidade, crenças políticas, profissão, raça, religião, orientação sexual, status socioeconómico e capacidade técnica. Não toleraremos discriminação com base em nenhuma das características protegidas acima, incluindo participantes com deficiência.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Excluindo conteúdo impróprio
                                </h2>
                            </div>
                            <div class="col-12">
                                Os facilitadores da plataforma irão rever periodicamente as contribuições publicadas pelos participantes. Os facilitadores podem excluir conteúdo impróprio da plataforma e explicar os motivos da exclusão ao autor do conteúdo excluído.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Reporting Issues
                                </h2>
                            </div>
                            <div class="col-12">
                                Se experienciar ou testemunhar um comportamento inaceitável, ou tiver outras preocupações, denuncie entrando em contato com os organizadores em info@scify.org
                                <br><br>
                                Todos os problemas serão tratados com discrição. No relatório, inclua:<br>
                                - A sua informação de contato.<br>
                                - A resposta do questionário que você deseja relatar. Forneça o nome do projeto, a pergunta e o texto da resposta que você deseja relatar.
                                <br><br>
                                Depois de registrar uma denúncia, um representante entrará em contato consigo pessoalmente, analisará o incidente, fará o acompanhamento com perguntas adicionais e tomará uma decisão sobre como responder.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Atribuições e Agradecimentos</h2>
                            </div>
                            <div class="col-12">
                                Este código de conduta usou elementos do Código de Conduta do <a href="https://openlifesci.org/code-of-conduct"> Open Life Science </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i> Voltar ao questionário</a>
                </div>
            @endif
        </div>
    </div>
@endsection
