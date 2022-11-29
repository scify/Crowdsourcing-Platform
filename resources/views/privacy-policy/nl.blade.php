@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Privacybeleid</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                Dit Privacybeleid is van toepassing op alle Gebruikers van het Platform (hierna respectievelijk <b>“Gebruikers”</b> of <b>“Gebruiker”</b> en <b>“Platform”</b> genoemd) en vormt een integraal onderdeel van de Algemene Voorwaarden van de Website van het Platform. Dit Privacybeleid biedt de Gebruiker algemene informatie over hoe de Gegevensbeheerder uw persoonsgegevens gebruikt en andere informatie die vereist is door de wetgeving inzake gegevensbescherming. In het geval van toekomstige wijzigingen, zal de Gebruiker worden voorzien van de nodige updates en informatie via de update van het huidige Privacybeleid, geüpload op het Platform.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">1. Wie is de verantwoordelijke voor de verwerking van de gegevens?</h2>
                            </div>
                            <div class="col-12">
                                <b>1.1.</b> Het bedrijf met de bedrijfsnaam "{{ config("app.installation_company_name") }}", adres: {{ config("app.installation_company_address") }} , Telefoon: {{ config("app.installation_company_phone") }}, e-mail: {{ config("app.installation_company_email") }}, is de Gegevensbeheerder voor de verwerking van de Persoonsgegevens van de Gebruiker (hierna te noemen <b>"Gegevensbeheerder"</b>).
                                <br><br>
                                <b>1.2. Contactgegevens van de Gegevensbeheerder:</b> Voor elke kwestie of bezorgdheid met betrekking tot het huidige Privacybeleid en tot de verwerking van de persoonsgegevens van de Gebruiker of gegevens die door de Gebruiker zijn geüpload om het Platform te gebruiken, kan de Gebruiker communiceren met de Gegevensbeheerder, door gebruik te maken van een van de volgende mogelijkheden:
                                <br><br>
                                Door te bellen naar {{ config("app.installation_company_phone") }}, van maandag tot en met vrijdag van 10.00 uur tot 18.00 uur EET (Oost-Europese Tijd)<br>
                                Door een e-mail te sturen naar het volgende e-mailadres: {{ config("app.installation_company_email") }}<br>
                                Door correspondentie te sturen naar het volgende adres {{ config("app.installation_company_address") }}<br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">2. Wat is het doel en de rechtsgrondslag van de verwerking van Gebruiker's gegevens?</h2>
                                <b>2.1.</b> Het operationele doel van het platform is het verzamelen van meningen van gebruikers via vragenlijsten. De meningen worden verwerkt om inzichten te verkrijgen, waardevolle ideeën en suggesties te verzamelen en te presenteren over de onderwerpen die in de vragenlijsten aan bod komen. Gebruikers kunnen anoniem antwoorden (zonder enige persoonlijke informatie te verstrekken) of kunnen zich vrijwillig registreren om gelijknamige antwoorden in te dienen, door een e-mail en een bijnaam op te geven. De antwoorden van de gebruikers worden in het Engels vertaald en in rapporten gepresenteerd. Voor het specifieke doel van de verwerking is de voorafgaande toestemming van de Gebruiker de rechtsgrondslag.
                                <br><br>
                                <b>2.2.</b> Om de Gebruiker informatieve e-mails te sturen met als doel haar te informeren over nieuwe activiteiten, projecten en andere zaken die van belang zijn voor het Platform. Voor dit doel van verwerking is de rechtsgrondslag de voorafgaande toestemming van de Gebruiker.
                                <br><br>
                                <b>2.3</b> Verwerking van gegevens om redenen die verband houden met de naleving van wettelijke verplichtingen door de Gegevensbeheerder. In dergelijke gevallen vindt verwerking van gegevens alleen plaats voor de periode die nodig is voor Gegevensbeheerder om te voldoen aan verplichtingen die worden opgelegd door verschillende wettelijke bepalingen.
                                <br><br>
                                <b>In het geval van bovenstaande bepalingen waarbij de rechtsgrondslag de voorafgaande toestemming van de Gebruiker is, kan de Gebruiker te allen tijde zijn toestemming intrekken zonder dat dit gevolgen heeft voor de rechtmatigheid van de gegevens op basis van de toestemming voorafgaand aan de intrekking daarvan.</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">3. Soorten verzamelde gegevens</h2>

                                <h3 class="mt-4 mb-4">3.1 Persoonlijke gegevens</h3>
                                <b>3.1.1 Registratie - account aanmaken:</b><br>
                                Om een Gebruiker vrijwillig een account te laten aanmaken in het Platform, dient de Gebruiker de nodige gegevens in te vullen: zijn bijnaam, e-mailadres, en een wachtwoord
                                <br><br>
                                <b>3.1.2 Ingezonden antwoorden op vragenlijsten</b><br>
                                Het Platform verzamelt antwoorden van gebruikers (dat zijn meningen over verschillende onderwerpen) op vragen die via vragenlijsten van het Platform worden gesteld. Deze antwoorden worden geanalyseerd en gepresenteerd in een vragenlijst resultaten pagina. De gebruiker wordt ten strengste aangeraden zich te conformeren aan de "gedragscode voor succesvolle deelname" van het Platform en te vermijden persoonlijke gegevens openbaar te maken die hij niet publiekelijk beschikbaar wil maken op het Platform.
                                <br><br>
                                <b>3.1.3. Communicatie van het Platform om redenen die verband houden met het toegestane gebruik van het Platform door de Gebruiker.</b>
                                <br>
                                Om het Platform in staat te stellen met de Gebruiker te communiceren voor de bovenstaande doeleinden, kan Gegevensverwerker alle gegevens verwerken met betrekking tot de account van de Gebruiker, geüploade inhoud en gegevens met betrekking tot het gebruik van het Platform door de Gebruiker.
                                <h3 class="mt-4 mb-4">3.2 Gebruiksgegevens</h3>
                                Wij kunnen ook informatie verzamelen over hoe de webpagina wordt bezocht en gebruikt ("Gebruiksgegevens"). Deze Gebruiksgegevens kunnen informatie bevatten zoals het Internet Protocol-adres van uw computer (bijv. IP-adres), het type browser, browserversie, de pagina's van onze webpagina die u bezoekt, de tijd en datum van uw bezoek, de tijd die u op deze pagina's doorbrengt, unieke apparaat-id's en andere diagnostische gegevens.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4"> 4. Hoe het Platform gegevens verzamelt</h2>
                                4.1 De informatie kan worden verzameld op de volgende manieren: <br>
                                4.1.1 Wanneer de Gebruiker zich registreert en een account aanmaakt op het Platform. <br>
                                4.1.2 Wanneer de Gebruiker antwoorden indient op de vragenlijsten van het Platform <br>
                                4.1.3 Wanneer de gebruiker het Platform bezoekt en instemt met de installatie van cookies (volgens het Cookiebeleid van het Platform in artikel 11 hieronder) en het verzamelen van persoonlijke gegevens van de gebruiker, zoals het IP-adres, het besturingssysteem, het type en de browser-editie, enz.
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">5. Hoe lang worden de gegevens van de gebruiker bewaard en wanneer worden ze gewist?</h2>
                                <b>5.1. Accountgegevens van de Gebruiker:</b><br>
                                Onverminderd het hieronder vermelde recht van de Gebruiker op verwijdering/verwijdering, worden de in het account van de Gebruiker geregistreerde en opgeslagen Gegevens bewaard zolang de Gebruiker gebruik wenst te maken van het Platform voor het hierboven vermelde doel. Indien een Gebruiker zijn account wenst te verwijderen, kan hij zijn account verwijderen via de instellingen van zijn account of contact opnemen met Gegevensverwerker via de hierboven vermelde contactgegevens.
                                <br><br>
                                <b>5.2. Communicatie van het Platform om redenen die verband houden met het toegestane gebruik van het Platform door de Gebruiker.</b><br>
                                Gegevens met betrekking tot dergelijke communicatie zullen alleen worden opgeslagen zolang de Gebruiker het Platform wenst te gebruiken en zijn account onderhoudt. In het geval dat een Gebruiker zijn account wenst te verwijderen, kan hij zijn account verwijderen via de instellingen van zijn account of contact opnemen met Databeheerder via de hierboven vermelde contactgegevens.
                                <br><br>
                                <b>5.3. Statistische analyse voor de optimalisatie van de Website</b><br>
                                Ongeacht de hierboven vermelde bepalingen van artikel 5, zal de Databeheerder alleen noodzakelijke gegevens opslaan en verwerken voor de periode die nodig is om te voldoen aan zijn verplichtingen die telkens door de wet worden opgelegd (voldoen aan fiscale verplichtingen doeleinden enz.).
                                <br><br>
                                <b>5.4. Verwerking van persoonsgegevens ten behoeve van het uitvoeren van statistische analyses.</b><br>
                                Zie het cookiebeleid (artikel 11 ) hieronder.
                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">6. Wat zijn de rechten van Gebruiker ι met betrekking tot de verwerking van zijn gegevens en hoe kan hij deze rechten uitoefenen?</h2>
                                <b>6.1</b> De Gegevensbeheerder respecteert het recht van de Gebruiker met betrekking tot de gegevensverwerking.
                                <br><br>
                                <b>6.2</b> De Gebruiker kan zijn rechten uitoefenen door contact op te nemen met de Gegevensbeheerder via de volgende contactgegevens: Telefoon: {{ config("app.installation_company_phone") }}, e-mail: {{ config("app.installation_company_email") }}
                                <br><br>
                                Om het de Gebruiker gemakkelijker te maken, zijn de rechten van de Gebruiker opgenomen in de volgende tabel, samen met een korte uitleg van elk recht (verwijzing naar artikelen komt overeen met artikel van GDPR 2016/679):
                                <br><br>
                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Recht</th>
                                        <th>Uitleg</th>
                                    </tr>
                                    <tr>
                                        <td>Toegang (artikel 15)</td>
                                        <td>
                                            De Gebruiker kan de Gegevensbeheerder vragen om:
                                            <ul>
                                                <li>te bevestigen of de Gegevensbeheerder de persoonsgegevens van de Gebruiker verwerkt
                                                </li>
                                                <li>de Gebruiker toegang te geven tot gegevens waarover de Gebruiker niet beschikt</li>
                                                <li>de Gebruiker andere informatie te verstrekken met betrekking tot de persoonsgegevens van de Gebruiker, zoals over welke gegevens de Gegevensbeheerder beschikt, wat de doeleinden van de verwerking zijn, aan wie deze gegevens worden verstrekt, of deze gegevens in het buitenland worden doorgegeven en hoe deze gegevens worden beschermd, hoe lang de gegevens worden bewaard, wat de rechten van de Gebruiker zijn, hoe een klacht kan worden ingediend, waar de gegevens vandaan komen, voor zover deze informatie niet in dit Privacybeleid is opgenomen.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rectificatie (artikel 16)</td>
                                        <td>
                                            De gebruiker kan de Gegevensbeheerder verzoeken onjuiste persoonsgegevens te rectificeren.<br><br>
                                            De Gegevensbeheerder kan trachten de juistheid van de gegevens te verifiëren alvorens deze te rectificeren.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Wissen/verwijderen (artikel17)</td>
                                        <td>
                                            De gebruiker kan de Gegevensbeheerder verzoeken om zijn persoonsgegevens te wissen:<br><br>
                                            <ul>
                                                <li>telkens wanneer de persoonsgegevens niet langer nodig zijn voor de doeleinden waarvoor zij werden verzameld
                                                </li>
                                                <li>wanneer de Gebruiker zijn toestemming intrekt</li>
                                                <li>de persoonsgegevens op onwettige wijze zijn verwerkt</li>
                                            </ul>
                                            <br><br>
                                            De Gegevensbeheerder is niet verplicht in te gaan op het verzoek van de Gebruiker om zijn persoonsgegevens te wissen, indien de verwerking van de persoonsgegevens van de Gebruiker noodzakelijk is:
                                            <ul>
                                                <li>voor het nakomen van een wettelijke verplichting</li>
                                                <li>voor de verwezenlijking van een ander legitiem doel of een andere legitieme rechtsgrondslag
                                                </li>
                                                <li>voor de vaststelling, uitoefening of verdediging van rechtsvorderingen</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Beperking (artikel 18)</td>
                                        <td>

                                            De Gebruiker kan de Gegevensbeheerder verzoeken de persoonsgegevens van de Gebruiker te beperken (op te slaan maar niet te verwerken) wanneer:<br><br>
                                            de juistheid ervan wordt betwist (zie rectificatie), zodat de Gegevensbeheerder de juistheid van de persoonsgegevens kan verifiëren of<br><br>
                                            de persoonsgegevens onrechtmatig zijn verwerkt, maar de Gebruiker zich verzet tegen het wissen van de persoonsgegevens of<br><br>
                                            zij niet langer noodzakelijk zijn voor de doeleinden waarvoor zij zijn verzameld, maar de Gebruiker ze nog nodig heeft voor de vaststelling, uitoefening of verdediging van rechtsvorderingen of wanneer er een ander legitiem doel van de verwerking of een andere rechtsgrondslag is
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Gegevensoverdraagbaarheid (artikel 20)
                                        </td>
                                        <td>
                                            Wanneer de verwerking op toestemming is gebaseerd en de verwerking met geautomatiseerde middelen wordt uitgevoerd, kan de Gebruiker de Gegevensbeheerder verzoeken zijn persoonsgegevens te ontvangen in een gestructureerd, algemeen gebruikt en machineleesbaar formaat of de verantwoordelijke voor de verwerking verzoeken deze rechtstreeks van de Gegevensbeheerder aan een andere verantwoordelijke voor de verwerking door te geven. Volgens de wet heeft dit recht echter alleen betrekking op de gegevens die door de Gebruiker zelf zijn verstrekt en niet op de gegevens die door de Gegevensbeheerder worden afgeleid op basis van de gegevens die de Gebruiker heeft verstrekt.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bezwaar (artikel 21)</td>
                                        <td>
                                            De Gebruiker kan te allen tijde bezwaar maken tegen de verwerking van hem betreffende persoonsgegevens die is gebaseerd op een gerechtvaardigd belang of de uitvoering van een taak van algemeen belang.<br><br>
                                            Wanneer de Gebruiker gebruik maakt van zijn recht om bezwaar te maken, heeft de Gegevensbeheerder het recht aan te tonen dat er dwingende legitieme gronden voor de verwerking zijn die zwaarder wegen dan het belang, de rechten en de vrijheid van de Gebruiker of voor de vaststelling, uitoefening of verdediging van rechtsvorderingen.

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Intrekking van toestemming (opt-out)
                                        </td>
                                        <td>
                                            De gebruiker heeft het recht zijn toestemming in te trekken wanneer toestemming de grondslag van de verwerking is. De intrekking geldt voor de toekomst.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Toezichthoudende Autoriteit
                                        </td>
                                        <td>
                                            De gebruiker heeft het recht om een klacht in te dienen bij de lokale toezichthoudende autoriteit voor gegevensbescherming. <br><br>
                                            In Griekenland is de toezichthoudende autoriteit voor gegevensbescherming de Gegevensbeschermingsautoriteit https://www.dpa.gr/

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identiteit</td>
                                        <td>De Gegevensbeheerder neemt de vertrouwelijkheid van alle bestanden waarin persoonsgegevens zijn opgenomen ernstig op, en is derhalve gerechtigd de gebruiker om bewijs van zijn identiteit te vragen indien de gebruiker een verzoek indient met betrekking tot die bestanden.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kosten</td>
                                        <td>De gebruiker hoeft niet te betalen voor de uitoefening van zijn rechten met betrekking tot persoonsgegevens, tenzij het verzoek om toegang tot informatie volgens de wet ongegrond of buitensporig is. In dat geval kan de Gegevensbeheerder de gebruiker een in de specifieke omstandigheden redelijke vergoeding vragen. De Gegevensbeheerder zal de Gebruiker op de hoogte brengen van eventuele kosten voordat hij het verzoek afrondt.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tijdschema</td>
                                        <td>De Gegevensbeheerder streeft ernaar geldige verzoeken van de Gebruiker uiterlijk binnen één (1) maand na ontvangst te beantwoorden, tenzij het verzoek zeer gecompliceerd is of de Gebruiker meerdere verzoeken heeft ingediend, in welk geval de Gegevensbeheerder ernaar streeft deze binnen drie maanden te beantwoorden. Indien de Gegevensbeheerder om bovengenoemde redenen meer dan een maand nodig heeft, zal hij de Gebruiker hiervan op de hoogte stellen. De Gegevensbeheerder kan de Gebruiker vragen uit te leggen wat hij precies wenst te ontvangen of wat zijn bezorgdheid is. Dit zal de Gegevensbeheerder helpen om sneller op het verzoek van de Gebruiker te reageren. In ieder geval dient de Gebruiker specifieke en waarheidsgetrouwe gegevens en/of feiten te vermelden, zodat de Gegevensbeheerder het verzoek van de Gebruiker accuraat kan beantwoorden en/of eraan kan voldoen. Anders behoudt de Gegevensbeheerder zich het recht voor om fouten te herstellen die buiten zijn controle vallen. Bovendien kan de verantwoordelijke verzoeken afwijzen die ongegrond, buitensporig, onrechtmatig, te kwader trouw of onwettig zijn in het kader van de wettelijke bepalingen.
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">7. Hoe wordt de gegevensbeveiliging gewaarborgd?</h2>
                                <b>7.1</b> De Gegevensbeheerder treft alle passende beveiligingsmaatregelen om de bescherming en vertrouwelijkheid van persoonsgegevens te waarborgen, waaronder de volgende:
                                <br>
                                <ol>
                                    <li>Sterk wachtwoordbeleid op alle servers</li>
                                    <li>HTTPS-protocol voor interactie met API's en webclients</li>
                                    <li>SSH-protocol voor serververbinding</li>
                                    <li>Periodieke serverupdates met de laatste beveiligingsfixes</li>
                                </ol>

                                <br><br>
                                <b>7.2</b> Wij wijzen u erop dat alleen specifiek geautoriseerde medewerkers van de Gegevensbeheerder, handelend onder het gezag van de Gegevensbeheerder en uitsluitend op zijn aanwijzingen, alsmede ontvangers, waar nodig, de door de Gebruiker verstrekte gegevens verwerken. Voor de verwerking kiest de Gegevensbeheerder personen met passende kwalificaties die voldoende waarborgen bieden inzake technische kennis en persoonlijke integriteit om de vertrouwelijkheid te beschermen. De Gegevensbeheerder neemt alle nodige veiligheidsmaatregelen voor de bescherming en vrijwaring van de geheimhouding, vertrouwelijkheid en integriteit van persoonsgegevens, ook door middel van relevante contractuele verbintenissen van zijn medewerkers. In elk geval kan de veiligheid van de Website worden geschonden door redenen die buiten de controle van de Gegevensbeheerder liggen, door technische of andere problemen van het net of door overmacht of toevallige feiten. In dat geval kan de veiligheid van persoonsgegevens niet worden gegarandeerd.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">8. Wie zijn de ontvangers van de gegevens?</h2>
                                <b>8.1</b> De ontvangers van de persoonsgegevens van de Gebruiker zijn geassocieerde bedrijven die de technische infrastructuur leveren voor de werking van de Website, hosting provider evenals het bedrijf dat zich verbindt tot het verzenden van elektronische communicatie met betrekking tot de werking van het platform aan Gebruikers. Waar nodig volgens de toepasselijke wetgeving, zal de Gegevensbeheerder overeenkomsten ondertekenen met dergelijke bedrijven, die verwijzen naar de uitvoering en regelmatige controle van veiligheidsmaatregelen. In het geval gegevens worden overgedragen buiten de EU zijn alle nodige garanties aanwezig.
                                <br><br>
                                <b>8.2.</b> Indien de Gegevensbeheerder een verzoek tot kennisgeving of overdracht van gegevens ontvangt van een bevoegde administratieve autoriteit, een advocaat, een rechtbank of een andere autoriteit, kan hij deze gegevens kennisgeving of overdracht doen om te voldoen aan zijn plicht ten behoeve van het algemeen belang tegenover deze autoriteiten (met of zonder voorafgaande kennisgeving van de gebruiker) overeenkomstig de toepasselijke wettelijke bepalingen. Indien de Gebruiker vooraf op de hoogte moet worden gebracht overeenkomstig de wettelijke bepalingen, dan heeft de Gebruiker het recht om bezwaar te maken tegen deze verwerking zoals bepaald in artikel 7 hierboven.
                                <br><br>
                                <b>8.3.</b> Αs de professionele gegevens van elke Gebruiker, zijn deze beschikbaar voor alle geregistreerde Gebruikers van het Platform voor de hierboven vermelde doeleinden.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">9. Communicatie met de Gegevensbeheerder</h2>
                                <b>9.1.</b> Voor elke kwestie met betrekking tot dit privacybeleid, de verwerking van gegevens door de Gebruiker en de uitoefening van rechten van de Gebruiker, kan de Gebruiker op een van de volgende manieren contact opnemen met de Gegevensbeheerder: <br>
                                Telefoon: {{ config("app.installation_company_phone") }}, <br>
                                Email: {{ config("app.installation_company_email") }}
                                <br><br>
                                Indien de Gebruiker zich bewust wordt van een incident met betrekking tot een datalek, wordt hij vriendelijk verzocht de Gegevensbeheerder hiervan onmiddellijk op de hoogte te stellen.
                                <br><br>
                                <b>9.2.</b> De onderhavige voorwaarden worden beheerst en aangevuld door de Algemene Voorwaarden en vormen samen met deze een uniforme tekst.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">10. Verbinding met andere websites/sociale media</h2>
                                Deze Website maakt verbinding met andere websites door middel van hyperlinks. Deze websites zijn niet gerelateerd aan de Website van de Gegevensbeheerder en hun inhoud wordt niet gecontroleerd of aanbevolen door de Gegevensbeheerder. De juistheid, rechtmatigheid, volledigheid of kwaliteit van hun inhoud en de rechtmatigheid van de verwerking van de persoonsgegevens van de Gebruiker kunnen dus niet worden gecontroleerd en er wordt geen garantie voor gegeven. De Gegevensbeheerder kan niet aansprakelijk worden gesteld voor de inhoud ervan of voor de schade die de Gebruiker zou kunnen lijden door of ten gevolge van het gebruik ervan. De verantwoordelijke voor de verwerking kan de verwerking van de persoonsgegevens van de Gebruiker door deze gelinkte websites niet controleren en draagt bijgevolg geen enkele verantwoordelijkheid. Wanneer de Gebruiker deze websites bezoekt, dient hij er rekening mee te houden dat de voorwaarden en bepalingen van elke website van toepassing zijn. Voor elk probleem dat zich met betrekking tot de inhoud of het gebruik van de gelinkte website voordoet, dient de Gebruiker rechtstreeks contact op te nemen met de exploitant of de beheerder van elke website. De Gegevensbeheerder keurt de inhoud of de diensten van de gelinkte websites, waartoe de Gebruiker via de Website toegang heeft, niet goed en omvat deze niet.<br><br>
                                De Website biedt de Gebruiker de mogelijkheid om op eigen initiatief en naar eigen goeddunken verbinding te maken en te interageren met sociale media. In dat geval is de Gegevensbeheerder niet aansprakelijk voor de verwerking van de gegevens van de Gebruiker die plaatsvindt via of door de sociale media. De Gebruiker dient zich rechtstreeks tot elk specifiek sociaal medium te wenden om zijn legitieme rechten uit te oefenen.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">11. Cookies</h2>
                                11.1. Het Platform gebruikt cookies om operationeel of efficiënter te kunnen werken, om de navigatie van de Gebruiker te verbeteren, om de Gebruiker het volledige potentieel van het Platform te bieden, om de correcte weergave van de inhoud te verzekeren, evenals voor analytische en statistische doeleinden.
                                <br><br>
                                11.2. Cookies zijn kleine tekstbestanden die op de computer van Gebruiker worden opgeslagen wanneer hij een digitaal platform bezoekt, en die worden gebruikt als middel om zijn computer te identificeren.
                                <br><br>
                                11.3. Cookies, behalve absoluut noodzakelijke cookies, worden alleen geïnstalleerd indien de Gebruiker de installatie ervan aanvaardt wanneer hij dit Platform bezoekt. Door cookies te accepteren bij het betreden van dit Platform, verklaart de Gebruiker uitdrukkelijk dat hij de specifieke voorwaarden met betrekking tot de installatie, de functie en het doel van de cookies heeft gelezen en begrepen en dat hij zijn toestemming verleent voor het gebruik ervan.
                                <br><br>
                                11.4. Als alternatief kan de Gebruiker geen cookies accepteren. In dat geval zullen alleen cookies worden geïnstalleerd die technisch en functioneel noodzakelijk zijn voor de werking van het Platform.
                                <br><br>
                                11.5. De Gebruiker kan het gebruik en de installatie van cookies op elk moment beheren via een paneel, waar hij kan kiezen welke categorie cookies hij wil accepteren en welke niet (of verzoeken om alleen de technisch noodzakelijke cookies te installeren).
                                <br><br>
                                11.6. In het bijzonder worden door het Platform de volgende cookies gebruikt:
                                <br><br>

                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Soort cookies</th>
                                        <th>Uitleg</th>
                                        <th>Voorbeelden van cookies</th>
                                        <th>Duur van elke cookie-installatie</th>
                                        <th>Doorgifte van gegevens aan derden</th>
                                    </tr>
                                    <tr>
                                        <td>Absoluut noodzakelijk cookies</td>
                                        <td>De absoluut noodzakelijke cookies zijn essentieel voor de goede werking van het Platform. Deze cookies stellen de Gebruiker in staat te browsen en gebruik te maken van Platform functies zoals toegang tot beveiligde gebieden. Deze cookies herkennen niet de individuele identiteit van de Gebruiker en zonder hen, is de goede werking van het Platform niet mogelijk.
                                        </td>
                                        <td>crowdsourcing_app_cookies_consent_selection (Slaat de cookie-toestemmingsstatus van de gebruiker op voor het huidige domein)
                                            <br><br>
                                            crowdsourcing_app_cookies_consent_targeting (Slaat de cookie-toestemmingsstatus van de gebruiker op voor het huidige domein)
                                            <br><br>
                                            XSRF-TOKEN (Zorgt voor de veiligheid van de bezoeker door het voorkomen van cross-site request forgery. Deze cookie is essentieel voor de veiligheid van de website en de bezoeker. )
                                            <br><br>
                                            ecas_lets_crowdsource_our_future_session (Wanneer de app de ingelogde gebruiker moet "onthouden" terwijl (en) hij naar het platform navigeert)
                                            <br><br>
                                            Crowdsourcing_anonymous_user_id (gebruikt om anonieme antwoorden op de vragenlijsten op te slaan door een geheel getal toe te kennen aan de gebruiker die het antwoord indient)
                                        </td>
                                        <td>1 jaar
                                            <br><br>
                                            <br><br>
                                            1 dag
                                            <br><br>
                                            <br><br>
                                            Sessie
                                            <br><br>
                                            <br><br>
                                            5 jaar
                                        </td>
                                        <td>Nee
                                            <br><br>
                                            <br><br>

                                            Nee
                                            <br><br>
                                            <br><br>

                                            Nee
                                            <br><br>
                                            <br><br>

                                            Nee
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Statistieken/analytische cookies</td>
                                        <td>Dit zijn cookies die evalueren hoe bezoekers het Platform gebruiken (bijvoorbeeld welke pagina's vaker worden bezocht en of ze foutmeldingen van webpagina's ontvangen). Deze cookies worden gebruikt voor statistische doeleinden en om de prestaties van een Platform te verbeteren.
                                        </td>
                                        <td>_ga_4S9N5MK4VE, _gat,_ga, _gcl_au, _gid: Google Analytics-cookies worden gebruikt om het verkeer op het Platform te meten. Een unieke tekststring wordt opgeslagen om de browser te identificeren, de tijdstempel voor interacties en de browser / bronpagina die de gebruiker naar het Platform heeft geleid. Er wordt geen gevoelige informatie opgeslagen.
                                        </td>
                                        <td>_ga_4S9N5MK4VE: 2 jaar
                                            <br><br>
                                            _gat:1 minuut
                                            <br><br>
                                            _ga:2 jaar
                                            <br><br>
                                            _gcl_au:3 maanden
                                            <br><br>
                                            _gid:24 uur
                                        </td>
                                        <td>Ja (Onderneming die statistische en analytische diensten levert, indien beschouwd als derde partij)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">12. Privacy van kinderen  </h2>
                                Ons project is niet gericht op personen onder de leeftijd van 18 jaar ("Kinderen"). Wij verzamelen niet bewust persoonlijk identificeerbare informatie van personen onder de leeftijd van 18 jaar. Als u een ouder of voogd bent en u weet dat uw Kinderen Persoonsgegevens aan ons hebben verstrekt, neem dan contact met ons op. Als wij ons ervan bewust worden dat wij Persoonsgegevens van kinderen hebben verzameld zonder verificatie van ouderlijke toestemming, nemen wij stappen om die informatie van onze servers te verwijderen.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">13. Wijzigingen in dit Privacybeleid </h2>
                                De Gegevensbeheerder behoudt zich het recht voor om dit Privacybeleid te wijzigen, bijvoorbeeld wanneer dit noodzakelijk is om te voldoen aan nieuwe vereisten die worden opgelegd door toepasselijke wetten, richtlijnen of technische vereisten, of in de loop van een herziening van de processen en praktijken van de Gegevensbeheerder. De Gebruiker zal via het Platform op de hoogte worden gebracht van elke wijziging van dit Privacybeleid. De Gebruiker dient dit Privacybeleid regelmatig te controleren op eventuele wijzigingen.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
