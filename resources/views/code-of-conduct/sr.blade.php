@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Kodeks ponašanja</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>Kao platforma za crowdsourcing, pozdravljamo sve i podstičemo prijateljsko i pozitivno okruženje.
                                    Ovaj kodeks ponašanja opisuje naša očekivanja od učesnika kako bi se osiguralo uspješno učešće, kao i korake za prijavljivanje neprihvatljivog ponašanja. Posvećeni smo pružanju prijatnog i inspirativnog okruženja za sve i očekujemo da se poštuje naš kodeks ponašanja. Svakom ko prekrši ovaj kodeks ponašanja može biti zabranjen pristup Platformi ili njihovi odgovori mogu biti izbrisani.
                                    Tokom Vašeg učešća u crowdsourcing projektima:                                    
                                </p>
                                <ul>
                                    <li>
                                        <strong>Budite jasni i relevantni u vezi teme:</strong> Pokušajte da budete precizni i jasno objasnite svoje misli i argumente. Svi odgovori moraju biti relevantni za temu upitnika. Ovo će olakšati rad moderatora platforme, gdje će morati da analiziraju sve date odgovore, kategorišu ih i proizvedu vrijedne zaključke koji mogu imati pozitivan uticaj na društvo.
                                    </li>
                                    <li><strong>Budite učtivi i ljubazni:</strong> Nećemo se svi složiti stalno, ali neslaganje nije izgovor za loše ponašanje i loše manire. Važno je zapamtiti da iako su odgovori koje dajete anonimni, okruženje u kojem se ljudi osećaju neprijatno ili ugroženo nije produktivno. Naravno, uznemiravanje, uvrede, objavljivanje (ili pretnje objavljivanjem) ličnih informacija drugih ljudi („doxing“), rasistički ili seksistički izrazi i drugo isključivo ponašanje nijesu prihvatljivi. Ako samo imate na umu „poštovanje i ljubaznost“, ne možete pogriješiti.
                                    </li>
                                    <li><strong>Zapamtite da je Vaš doprinos javan:</strong> Platforma ne otkriva Vaš imejl niti bilo koje lične podatke. Sa druge strane, tekstualni odgovori koje dajete u upitnicima, odgovori na otvorena pitanja mogu biti javno dostupni. Nemojte uključivati nikakve lične podatke u svoje odgovore za koje ne želite da budu javno dostupni.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Izjava o različitosti
                                </h2>
                            </div>
                            <div class="col-12">
                                Podstičemo sve da učestvuju i budu posvećeni izgradnji zajednice za sve. Iako ovaj spisak ne može biti potpun, mi izričito poštujemo različitost u godinama, polu, rodnom identitetu ili izražavanju, kulturi, etničkoj pripadnosti, jeziku, nacionalnom porijeklu, političkim uvjerenjima, profesiji, rasi, religiji, seksualnoj orijentaciji, socioekonomskom statusu i tehničkim sposobnostima. Nećemo tolerisati diskriminaciju na osnovu bilo koje od gore navedenih zaštićenih karakteristika, uključujući učesnike sa invaliditetom.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Uklanjanje neprikladnog sadržaja
                                </h2>
                            </div>
                            <div class="col-12">
                                Fasilitatori platforme će periodično pregledati unose koje su unijeli učesnici. Fasilitatori mogu ukloniti neprikladan sadržaj sa platforme i objasniti razloge za uklanjanje autoru uklonjenog sadržaja.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Prijava
                                </h2>
                            </div>
                            <div class="col-12">
                                Ako iskusite ili ste svjedoci neprihvatljivog ponašanja, ili imate bilo kakve druge zabrinutosti, prijavite to kontaktiranjem organizatora na info@scifi.org.
                                <br><br>
                                Sa svim prijavama će se postupati diskretno. Molimo Vas da u prijavu uključite:<br>
                                - Vaše kontakt informacije.<br>
                                - Odgovor na upitnik koji želite da prijavite. Navedite naziv projekta, pitanje i tekst odgovora koji želite da prijavite.
                                <br><br>
                                Nakon podnošenja prijave, predstavnik će Vas lično kontaktirati, pregledati slučaj, postaviti dodatna pitanja i donijeti odluku o tome kako da odgovori.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Atribucija & Priznanja</h2>
                            </div>
                            <div class="col-12">
                                Ovaj kodeks ponašanja koristi elemente Kodeksa ponašanja sa <a href="https://openlifesci.org/code-of-conduct"> Open Life Science. </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i> Nazad na upitnik</a>
                </div>
            @endif
        </div>
    </div>
@endsection
