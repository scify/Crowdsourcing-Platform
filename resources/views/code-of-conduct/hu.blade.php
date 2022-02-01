@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Magatartási kódex</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>Crowdsourcing platformként mindenkit szívesen látunk, barátságos és pozitív környezetet teremtünk.
                                    Ez a magatartási kódex ismerteti a résztvevőkkel szembeni elvárásainkat a sikeres részvétel biztosítása érdekében, valamint az elfogadhatatlan viselkedés bejelentésének lépéseit. Elkötelezettek vagyunk amellett, hogy mindenki számára barátságos és inspiráló környezetet biztosítsunk, és elvárjuk, hogy magatartási kódexünket tiszteletben tartsák. Bárki, aki megsérti ezt a magatartási kódexet, kitiltható a Platformról, vagy válaszai törölhetők.
                                    A crowdsourcing projektekben való részvétel során:                                    
                                </p>
                                <ul>
                                    <li>
                                        <strong>Legyen egyértelmű és kapcsolódjon a témához:</strong> Igyekezzen pontos lenni, és gondolatait, érveit világosan kifejteni. Minden válasznak relevánsnak kell lennie a kérdőív témájához. Ez megkönnyíti a platform moderátorainak munkáját, akiknek elemezniük kell az összes adott választ, kategorizálniuk kell azokat, és értékes meglátásokat kell készíteniük, amelyek pozitív hatással lehetnek a társadalomra.
                                    </li>
                                    <li><strong>Legyen tisztelettudó és kedves:</strong> Nem mindenki fog mindig egyetérteni, de az egyet nem értés nem mentség a rossz viselkedésre és a rossz modorra. Fontos, hogy ne feledje: bár a válaszok névtelenek, az olyan környezet, ahol az emberek kényelmetlenül érzik magukat vagy fenyegetve, nem hatékony. Természetesen a zaklatás, a sértegetés, mások személyazonosító adatainak közzététele (vagy azzal való fenyegetés) ("doxing"), a rasszista vagy szexista kifejezések és más kirekesztő viselkedés nem elfogadható. Ha csak a "tisztelettudó és kedves" kifejezést tartja szem előtt, nem járhat rosszul.
                                    </li>
                                    <li><strong>Ne feledje, hogy a hozzászólása nyilvános:</strong>Az e-mail címét és bármilyen személyes adatát a platform nem hozza nyilvánosságra.  Bár a kérdőívekben megadott szöveges válaszok, a nyílt végű kérdésekre adott válaszok nyilvánosan elérhetőek lehetnek. Ne közöljön olyan személyes adatokat a válaszaiban, amelyeket nem szeretne nyilvánosan elérhetővé tenni.

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Sokszínűségi nyilatkozat
                                </h2>
                            </div>
                            <div class="col-12">
                                Mindenkit részvételre bátorítunk, és elkötelezettek vagyunk a mindenki számára elérhető közösség építése mellett. Bár ez a lista nem lehet teljes, kifejezetten tiszteletben tartjuk az életkor, a nem, a nemi identitás, a kultúra, az etnikai hovatartozás, a nyelv, a származás, a politikai meggyőződés, a foglalkozás, a faji hovatartozás, a vallás, a szexuális irányultság, a társadalmi-gazdasági helyzet és a technikai képességek sokszínűségét. Nem tűrjük a fenti védett tulajdonságok bármelyike alapján történő megkülönböztetést, beleértve a fogyatékkal élő résztvevőket is.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">A nem megfelelő tartalom kizárása
                                </h2>
                            </div>
                            <div class="col-12">
                                A platform facilitátorai rendszeresen felülvizsgálják a résztvevők által közzétett hozzászólásokat. A moderátorok kizárhatják a nem megfelelő tartalmakat a platformról, és a kizárás okait megmagyarázhatják a kizárt tartalom szerzőjének.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Problémák jelentése
                                </h2>
                            </div>
                            <div class="col-12">
                                Ha elfogadhatatlan viselkedést tapasztal, vagy annak tanúja, vagy bármilyen más aggálya van, kérjük, jelezze azt a szervezőknek a info@scify.org
                                <br><br>
                                Minden bejelentést diszkréten kezelünk. A jelentésben kérjük, tüntesse fel a következőket:<br>
                                - Az Ön elérhetőségét.<br>
                                - A kérdőívre adott választ, amelyet jelenteni kíván. Adja meg a projekt nevét, a kérdést és a válasz szövegét, amelyet jelenteni szeretne.
                                <br><br>
                                A bejelentés benyújtása után munkatársunk személyesen felveszi Önnel a kapcsolatot, megvizsgálja az esetet, további kérdéseket tesz fel, és döntést hoz a válaszadás módjáról.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Attribúció és köszönetnyilvánítás</h2>
                            </div>
                            <div class="col-12">
                                Ez a magatartási kódex a <a href="https://openlifesci.org/code-of-conduct"> Open Life Science </a>magatartási kódex elemeit használta fel.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i> Vissza a kérdőívhez</a>
                </div>
            @endif
        </div>
    </div>
@endsection
