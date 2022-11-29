@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Rīcības kodeksā</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>Projekta "CODE Europe" komanda laipni aicina piedalīties ikvienu, veicinot draudzīgu un pozitīvu vidi! 
                                    Šajā rīcības kodeksā ir izklāstīti mūsu lūgumi pret platformas lietotājiem, lai nodrošinātu veiksmīgu dalību, kā arī pasākumi, kā ziņot par citu lietotāju nepieņemamu uzvedību. Mēs esam apņēmušies nodrošināt visiem draudzīgu un iedvesmojošu vidi. Sagaidām, ka mūsu rīcības kodekss tiks ievērots. Ikvienam, kas pārkāpj šo rīcības kodeksu, var tikt liegta piekļuve platformai vai iesniegtās atbildes var tikt dzēstas. 
                                    Piedaloties ideju vākšanas projektā:                                    
                                </p>
                                <ul>
                                    <li>
                                        <strong>Izsakieties skaidri un pieturieties pie tēmas:</strong> Centieties būt precīzs un skaidri izsakiet savas domas un argumentus. Visām atbildēm jāatbilst anketas tēmai. Tas atvieglos platformas moderatoru darbu, analizējot visas sniegtās atbildes, kategorizējot tās un sniedzot vērtīgas atziņas, kas var pozitīvi ietekmēt sabiedrību.
                                    </li>
                                    <li><strong>Esiet cieņpilns un laipns:</strong> ne visiem vienmēr būs tāds pats viedoklis, bet domstarpības nav attaisnojums sliktai uzvedībai un nepienācīgai rīcībai. Ir svarīgi atcerēties, ka, lai gan Jūsu sniegtās atbildes ir anonīmas, vide, kurā cilvēki jūtas neērti vai apdraudēti, nav produktīva. Protams, uzmākšanās, apvainojumi, citu cilvēku personu identificējošas informācijas publicēšana (vai draudi publicēt) (“doksings”), rasistiski un seksistiski termini, un cita izslēdzoša rīcība, ir nepieņemama. Jūs nekļūdīsieties, ja atcerēsieties principu - izturēties "cieņpilni un pieklājīgi". 
                                    </li>
                                    <li><strong>Atcerieties, ka Jūsu ieguldījums ir publisks:</strong> platforma neatklāj Jūsu e-pastu un personisko informāciju. Savukārt no anketās sniegtajām rakstiskajām atbildēm, atbildes uz atvērtajiem jautājumiem var būt publiski pieejamas. Neiekļaujiet savās atbildēs nekādu personisku informāciju, kuru nevēlaties, lai tā būtu publiski pieejama.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Paziņojums par dažādību
                                </h2>
                            </div>
                            <div class="col-12">
                                Mēs mudinām piedalīties ikvienu un apņemamies veidot kopienu visiem. Lai gan šis saraksts nevar būt pilnīgs, mēs nepārprotami ņemam vērā dažādību vecuma, dzimuma, dzimuma identitātes vai izpausmes, kultūras, etniskās piederības, valodas, nacionālās izcelsmes, politiskās pārliecības, profesijas, rases, reliģijas, seksuālās orientācijas, sociālekonomiskā statusa un tehnisko spēju dažādību. Mēs nepieļausim diskrimināciju pret kādu no iepriekš minētajām aizsargātajām īpašībām, tostarp dalībniekiem ar invaliditāti.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Nepiemērota satura izņemšana
                                </h2>
                            </div>
                            <div class="col-12">
                                Platformas koordinatori periodiski pārskatīs dalībnieku publicēto saturu. Koordinatori var izņemt no platformas nepiemērotu saturu un izskaidrot izņemtā satura autoram izņemšanas iemeslus.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Ziņošana par problēmām
                                </h2>
                            </div>
                            <div class="col-12">
                                Ja novērojat nepieņemamu uzvedību , vai Jums ir kādas citas bažas, lūdzu, ziņojiet par to, sazinoties ar organizatoriem, rakstot e-pastu uz {{ config("app.installation_company_email") }}.
                                <br><br>
                                Visi ziņojumi tiks apstrādāti diskrēti. Savā ziņojumā, lūdzu, iekļaujiet:<br>
                                - savu kontaktinformāciju;<br>
                                - anketas atbildi, par kuru vēlaties ziņot. Projekta nosaukumu, jautājumu un atbildes tekstu, par kuru vēlaties ziņot.
                                <br><br>
                                Pēc ziņojuma iesniegšanas, organizācijas pārstāvis sazināsies ar Jums personīgi, izskatīs incidentu, uzdos papildu jautājumus un pieņems lēmumu, kā reaģēt.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Attiecinājumi un pateicības</h2>
                            </div>
                            <div class="col-12">
                                Šajā rīcības kodeksā ir izmantoti Rīcības kodeksa elementi no <a href="https://openlifesci.org/code-of-conduct"> Open Life Science. </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i> Doties atpakaļ uz anketu</a>
                </div>
            @endif
        </div>
    </div>
@endsection
