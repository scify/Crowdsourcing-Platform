@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Verhaltensregeln</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>Als Crowdsourcing-Plattform heißen wir alle willkommen und sorgen für ein freundliches und positives Umfeld.
                                    Diese Verhaltensregeln umreißen unsere Erwartungen an die Teilnehmenden, um eine erfolgreiche Teilnahme zu gewährleisten, sowie die Schritte zur Meldung von inakzeptablem Verhalten. Wir sind bestrebt, ein einladendes und inspirierendes Umfeld für alle zu schaffen und erwarten, dass unsere Verhaltensregeln beachtet werden. Wer gegen diese Verhaltensregeln verstößt, kann von der Plattform ausgeschlossen oder die Antworten können gelöscht werden.
                                    Während Ihrer Teilnahme an Crowdsourcing-Projekten:                                    
                                </p>
                                <ul>
                                    <li>
                                        <strong>Seien Sie eindeutig und auf das Thema bezogen:</strong> Versuchen Sie, präzise zu sein und Ihre Gedanken und Argumente klar zu erläutern. Alle Antworten müssen für das Thema des Fragebogens relevant sein. Dies erleichtert die Arbeit der Moderator*innen der Plattform, die alle Antworten analysieren, kategorisieren und wertvolle Erkenntnisse gewinnen müssen, die sich positiv auf die Gesellschaft auswirken können.
                                    </li>
                                    <li><strong>Seien Sie respektvoll und freundlich:</strong> Nicht alle von uns werden immer einer Meinung sein, aber Meinungsverschiedenheiten sind keine Entschuldigung für schlechtes Benehmen und schlechte Manieren. Es ist wichtig, daran zu denken, dass ein Umfeld, in dem sich Menschen unwohl oder bedroht fühlen, nicht produktiv ist, auch wenn die von Ihnen gegebenen Antworten anonym sind. Natürlich sind Belästigungen, Beleidigungen, die Veröffentlichung (oder Androhung der Veröffentlichung) von persönlichen Daten anderer Personen ("Doxing"), rassistische oder sexistische Ausdrücke und anderes ausgrenzendes Verhalten nicht akzeptabel. Wenn Sie einfach nur "respektvoll und freundlich" im Kopf behalten, können Sie nichts falsch machen.
                                    </li>
                                    <li><strong>Denken Sie daran - Ihr Beitrag ist öffentlich:</strong> Ihre E-Mail und alle persönlichen Informationen werden von der Plattform nicht veröffentlicht.  Die Antworten, die Sie in den Fragebögen geben, die Reaktionen auf offene Fragen, können jedoch öffentlich zugänglich sein. Geben Sie in Ihren Antworten keine persönlichen Informationen an, die Sie nicht öffentlich zugänglich machen möchten.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Erklärung zur Diversität
                                </h2>
                            </div>
                            <div class="col-12">
                                Wir ermutigen alle zur Teilnahme und setzen uns für den Aufbau einer Gemeinschaft für alle ein. Obwohl diese Liste nicht allumfassend sein kann, würdigen wir ausdrücklich Vielfalt in Bezug auf Alter, Geschlecht, Geschlechtsidentität oder -ausdruck, Kultur, ethnische Zugehörigkeit, Sprache, nationale Herkunft, politische Überzeugungen, Beruf, Rasse, Religion, sexuelle Orientierung, sozioökonomischen Status und technische Fähigkeiten. Wir dulden keine Diskriminierung aufgrund eines der oben genannten geschützten Merkmale, auch nicht bei Teilnehmenden mit Behinderungen.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Ausschluss unangemessener Inhalte
                                </h2>
                            </div>
                            <div class="col-12">
                                Die Moderator*innen der Plattform werden die von den Teilnehmenden eingestellten Beiträge in regelmäßigen Abständen überprüfen. Die Moderator*innen können unangemessene Inhalte von der Plattform ausschließen und den Autor*innen der ausgeschlossenen Inhalte die Gründe für den Ausschluss erklären.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Meldung von Problemen
                                </h2>
                            </div>
                            <div class="col-12">
                                Wenn Sie inakzeptables Verhalten erleben oder beobachten oder andere Bedenken haben, melden Sie dies bitte an die Organisator*innen unter info@scify.org
                                <br><br>
                                Alle Meldungen werden mit Diskretion behandelt. Bitte geben Sie in Ihrer Meldung an:<br>
                                - Ihre Kontaktinformationen.<br>
                                - Die Antwort auf den Fragebogen, die Sie melden möchten. Geben Sie den Namen des Projekts, die Frage und den Text der Antwort an, die Sie melden möchten.
                                <br><br>
                                Nach der Meldung wird sich jemand persönlich mit Ihnen in Verbindung setzen, den Vorfall prüfen, weitere Fragen stellen und eine Entscheidung über das weitere Vorgehen treffen.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Namensnennung und Danksagung</h2>
                            </div>
                            <div class="col-12">
                                In diesem Verhaltenskodex wurden Elemente des Verhaltenskodex von <a href="https://openlifesci.org/code-of-conduct"> Open Life Science </a>code-of-conduct verwendet.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i> Zurück zum Fragebogen</a>
                </div>
            @endif
        </div>
    </div>
@endsection
