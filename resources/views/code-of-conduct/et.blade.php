@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>Käitumiskoodeks</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p>Koosloome platvormina oleme avatud kõigile ning toetame sõbralikku ja positiivset koostööõhustikku.
                                    See käitumisjuhend kirjeldab meie ootusi osalejatele, et nende kaasalöömine kujuneks edukaks, samuti määratleb see lubamatust käitumisest teatamise korra. Meie eesmärk on pakkuda kõigile avatud ja inspireerivat keskkonda ning me eeldame, et seda käitumisjuhendit järgitakse. Käitumisjuhendi eiraja võidakse platvormilt blokeerida või tema vastused kustutada.
                                    Koosloomeprojektides osalemise ajal palume sul järgida neid põhimõtteid:
                                </p>
                                <ul>
                                    <li>
                                        <strong>Ole selgesõnaline ja püsi teemas:</strong> Püüa olla täpne ning selgitada oma mõtteid ja argumente lihtsalt ja arusaadavalt. Kõik vastused peavad vastama küsimustiku teemale. See hõlbustab platvormi moderaatorite tööd, kui nad peavad analüüsima kõiki antud vastuseid, neid kategoriseerima ja koostama väärtuslikke analüüse, millel võib olla ühiskonnale positiivne mõju.
                                    </li>
                                    <li><strong>Ole lugupidav ja viisakas:</strong> Me ei ole alati kõigiga ja kõiges ühel meelel, kuid lahkarvamused ei ole vabandus halvale käitumisele ja ebaviisakusele. Oluline on meeles pidada, et kuigi sinu antud vastused on anonüümsed, ei ole keskkond, kus inimesed tunnevad end ebamugavalt või ohustatuna, produktiivne. Iseenesestmõistetavalt ei ole vastuvõetav kellegi ahistamine, solvamine, teise inimese isikut tuvastada võimaldava teabe postitamine (või postitamisega ähvardamine), rassistlikud või seksistlikud väljendused ja muul viisil tõrjuv käitumine.
                                        Kui oled alati lugupidav ja viisakas, ei saa midagi valesti minna.
                                    </li>
                                    <li><strong>Pea meeles, et sinu kaastöö on avalik:</strong>Platvorm ei avalikusta sinu meiliaadressi ega isiklikku teavet. Siiski, küsimustike avatud küsimustele antud vastuste tekstid võivad olla avalikult kättesaadavad. Ära lisa oma vastustesse isikuandmeid, mida sa ei soovi avalikustada.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Mitmekesisuse kinnitus
                                </h2>
                            </div>
                            <div class="col-12">
                                Julgustame kõiki osalema ja oleme pühendunud kõigile avatud kogukonna loomisele. Kuigi see loetelu ei saa olla ammendav, peame lugu mitmekesisusest vanuse, soo, soolise identiteedi või väljenduse, kultuuri, etnilise päritolu, keele, rahvusliku päritolu, poliitiliste veendumuste, elukutse, rassi, usutunnistuse, seksuaalse sättumuse, sotsiaalmajandusliku staatuse ja tehniliste võimete vallas. Me ei salli diskrimineerimist ühegi ülaltoodud tunnuse alusel, sealhulgas puuetega osalejate diskrimineerimist
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Sobimatu sisu välistamine
                                </h2>
                            </div>
                            <div class="col-12">
                                Platvormi moderaatorid vaatavad osalejate postitatud kaastööd regulaarselt üle. Moderaatorid saavad sobimatu sisu platvormilt eemaldada ning selgitada sisu autorile selle eemaldamise põhjusi.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Probleemidest teatamine
                                </h2>
                            </div>
                            <div class="col-12">
                                Kui koged või märkad vastuvõetamatut käitumist või sul on mingeid muid muresid, anna sellest teada aadressile info@scify.org.
                                <br><br>
                                Kõiki teateid käsitletakse diskreetselt. Lisa oma teatesse:<br>
                                - oma kontaktandmed.<br>
                                - küsimustiku vastus, mille kohta soovid teate esitada; projekti nimi, küsimus ja vastuse tekst, mille kohta soovid teate esitada.
                                <br><br>
                                Pärast teate esitamist võtab platvormi esindaja sinuga isiklikult ühendust, vaatab juhtumi üle, esitab täiendavaid küsimusi ja otsustab, kuidas reageerida.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">Kasutatud allikas</h2>
                            </div>
                            <div class="col-12">
                                Selles käitumisjuhendis on kasutatud elemente antud käitumisjuhendist <a href="https://openlifesci.org/code-of-conduct"> Open Life Science </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($goBackUrl)
                <div class=" mt-5 col-md-4 col-sm-12 mx-auto">
                    <a href="{{$goBackUrl}}" class="btn call-to-action go-back"><i
                                class="fas fa-long-arrow-alt-left"></i>  Tagasi küsimustiku juurde</a>
                </div>
            @endif
        </div>
    </div>
@endsection
