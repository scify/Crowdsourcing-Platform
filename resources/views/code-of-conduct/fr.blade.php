@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Code de conduite</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>En tant que plateforme de crowdsourcing, nous accueillons tout le monde et encourageons un environnement amical et positif.
                                    Ce code de conduite décrit ce que nous attendons des participants pour garantir une participation réussie, ainsi que les étapes à suivre pour signaler un comportement inacceptable. Nous nous engageons à fournir un environnement accueillant et stimulant pour tous et attendons que notre code de conduite soit respecté. Toute personne qui enfreint ce code de conduite peut être bannie de la plate-forme ou ses réponses peuvent être supprimées.
                                    Lors de votre participation à des projets de crowdsourcing:
                                </p>
                                <ul>
                                    <li>
                                        <strong>Soyez clair et pertinent par rapport au sujet:</strong> Essayez d'être précis et d'expliquer vos pensées et arguments avec clarté. Toutes les réponses doivent être pertinentes par rapport au sujet du questionnaire. Cela facilitera le travail des modérateurs de la plateforme, qui devront analyser toutes les réponses données, les classer et produire des informations précieuses qui peuvent avoir un impact positif sur la société.
                                    </li>
                                    <li><strong>Soyez respectueux et aimable:</strong> Nous ne serons pas tous d'accord tout le temps, mais un désaccord n'est pas une excuse pour un mauvais comportement et de mauvaises manières. Il est important de se rappeler que même si les réponses que vous donnez sont anonymes, un environnement où les gens se sentent mal à l'aise ou menacés n'est pas productif. Bien entendu, le harcèlement, les insultes, la publication (ou la menace de publication) d'informations permettant d'identifier personnellement d'autres personnes ("doxing"), les termes racistes ou sexistes et autres comportements d'exclusion sont inacceptables. Si vous gardez à l'esprit l'expression "respectueux et aimable", vous ne pouvez pas vous tromper.
                                    </li>
                                    <li><strong>N'oubliez pas que votre contribution est publique:</strong> Votre adresse électronique et toute information personnelle ne sont pas révélées par la plateforme.  Cependant, les réponses textuelles que vous fournissez dans les questionnaires, les réponses aux questions ouvertes, peuvent être accessibles au public. N'incluez pas d'informations personnelles dans vos réponses si vous ne souhaitez pas qu'elles soient accessibles au public.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Déclaration sur la diversité
                                </h2>
                            </div>
                            <div class="col-12">
                                Nous encourageons tout le monde à participer et nous nous engageons à construire une communauté pour tous. Bien que cette liste ne puisse être exhaustive, nous honorons explicitement la diversité en termes d'âge, de sexe, d'identité ou d'expression sexuelle, de culture, d'ethnicité, de langue, d'origine nationale, de convictions politiques, de profession, de race, de religion, d'orientation sexuelle, de statut socio-économique et d'aptitudes techniques. Nous ne tolérerons aucune discrimination fondée sur l'une des caractéristiques protégées ci-dessus, y compris pour les participants handicapés.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Exclusion des contenus inappropriés
                                </h2>
                            </div>
                            <div class="col-12">
                                Les animateurs de la plate-forme examineront périodiquement les contributions postées par les participants. Les animateurs peuvent exclure les contenus inappropriés de la plateforme et expliquer les raisons de cette exclusion à l'auteur du contenu exclu.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Signalement des problèmes
                                </h2>
                            </div>
                            <div class="col-12">
                                Si vous êtes témoin d'un comportement inacceptable ou si vous avez d'autres préoccupations, veuillez les signaler en contactant les organisateurs à l'adresse info@scify.org
                                <br><br>
                                Tous les rapports seront traités avec discrétion. Dans votre rapport, veuillez inclure:<br>
                                - Vos coordonnées.<br>
                                - La réponse au questionnaire que vous souhaitez signaler. Indiquez le nom du   projet, la question et le texte de la réponse que vous souhaitez signaler.
                                <br><br>
                                Après le dépôt d'un rapport, un représentant vous contactera personnellement, examinera l'incident, répondra à toute question supplémentaire et prendra une décision quant à la manière de réagir.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Attribution et remerciements</h2>
                            </div>
                            <div class="col-12">
                                Ce code de conduite a utilisé des éléments du code de conduite du site <a href="https://openlifesci.org/code-of-conduct"> Open Life Science </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i> Revenir au questionnaire</a>
                </div>
            @endif
        </div>
    </div>
@endsection
