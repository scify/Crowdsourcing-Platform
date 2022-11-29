@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Gedragscode</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>We heten iedereen welkom op dit crowdsource platform en moedigen een vriendelijk en positieve omgeving aan.
                                    In deze gedragscode geven we aan wat we verwachten van deelnemers om een succesvolle deelname te bevorderen. Ook geven we de stappen aan hoe je onacceptabel gedrag kunt melden. We zetten ons in om iedereen een welkome en inspirerende omgeving te bieden en we verwachten dat onze gedragscode zal worden nageleefd. Mensen die zich niet aan de gedragscode houden kunnen van het platform verbannen worden en hun reacties kunnen worden verwijderd.
                                    Denk aan het volgende bij jouw deelname aan de crowdsource projecten:
                                </p>
                                <ul>
                                    <li>
                                        <strong>Wees helder en richt je op het onderwerp:</strong> Probeer precies te zijn en leg je gedachten en argumenten helder uit. Zorg dat je antwoorden gaan over het onderwerp van de vragenlijst. Dit draagt bij aan de uitvoering van het werk van de moderatoren. Zij zullen alle antwoorden analyseren en categoriseren om tot waardevolle inzichten te komen.
                                    </li>
                                    <li><strong>Wees vriendelijk en respectvol:</strong> We zijn het niet altijd met elkaar eens maar dit is geen excuus om onvriendelijk te worden. Wees je ervan bewust dat een omgeving waarin mensen zich ongemakkelijk of bedreigd voelen, vaak niet tot goede resultaten leidt. Ook al zijn de antwoorden anoniem. Beledigingen, intimidatie, racistische of seksistische termen en ander uitsluitend gedrag worden niet geaccepteerd. Ook het plaatsen van persoonlijke gegevens van anderen (doxing), of daarmee dreigen zijn niet toegestaan. Blijf gewoon vriendelijk en respectvol en dan gaat het altijd goed.
                                    </li>
                                    <li><strong>Denk er aan dat je bijdrage openbaar is:</strong> Je persoonlijke gegevens zoals je emailadres worden niet op het platform getoont. Maar de tekstuele antwoorden die je geeft in de vragenlijsten, kunnen wel openbaar inzichtelijk zijn. Zet daarom geen persoonlijke gegevens in je antwoorden waarvan je niet wilt dat deze publiekelijk zichtbaar zijn.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Diversiteitsverklaring
                                </h2>
                            </div>
                            <div class="col-12">
                                We moedigen iedereen aan om deel te nemen. En wij zetten ons in om een community te creëren waarin iedereen zich thuis voelt. Hoewel deze lijst niet volledig kan zijn, zijn wij expliciet voor diversiteit in leeftijd, gender, gender identiteit of uiting, cultuur, etniciteit, taal, nationaliteit, politieke overtuigingen, professie, ras, religie, seksuele oriëntatie, socioeconomische status en technische capaciteiten. We accepteren geen discriminatie op een van de beschermde karakteristieken die hierboven genoemd zijn, inclusief deelnemers met een fysieke beperking.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Uitsluiting van ongepaste bijdragen
                                </h2>
                            </div>
                            <div class="col-12">
                                De beheerders van het platform zullen regelmatig de bijdragen van deelnemers bekijken. Beheerders kunnen ongepaste bijdragen verwijderen van het platform. Ze zullen de reden voor de verwijdering uitleggen aan de schrijver van de verwijderde content.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Melden van problemen
                                </h2>
                            </div>
                            <div class="col-12">
                                Als je onacceptabel gedrag ervaart of waarneemt of als je andere zorgen hebt, meldt deze dan alsjeblieft bij de organisatoren via {{ config("app.installation_company_email") }}.
                                <br><br>
                                Alle meldingen zullen met tact worden behandeld. Als je een melding maakt voeg daar dan de volgende zaken aan toe:<br>
                                - Jouw 	contactgegevens.<br>
                                - Het inhoudelijke deel van de vragenlijst waarover je een melding wilt maken. Geef daarbij aan de naam van het project, de vraag en het antwoord waarvan je melding wilt maken.
                                <br><br>
                                Nadat je een melding hebt gemaakt zal een vertegenwoordiger van het platform contact met je opnemen. De vertegenwoordiger zal zal de melding beoordelen en als dit nodig is nog extra vragen stellen. Vervolgens wordt een besluit genomen over hoe er mee zal worden omgegaan.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Naamsvermelding en dankbetuiging</h2>
                            </div>
                            <div class="col-12">
                                Deze gedragscode heeft elementen gebruikt van de Gedragscode van de <a href="https://openlifesci.org/code-of-conduct"> Open Life Science </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i> Terug naar de vragenlijst</a>
                </div>
            @endif
        </div>
    </div>
@endsection
