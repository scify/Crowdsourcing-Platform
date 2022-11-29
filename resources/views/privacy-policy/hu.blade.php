@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>ADATVÉDELMI POLITIKA</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                A jelen Adatvédelmi szabályzat a Platform valamennyi Felhasználójára (a továbbiakban: <b>“Felhasználók”</b> vagy <b>“Felhasználó”</b> illetve <b>“Platform”</b>) vonatkozik, és a Platform Honlap Általános Szerződési Feltételeinek szerves részét képezi. A jelen Adatvédelmi szabályzat általános tájékoztatást nyújt a Felhasználónak arról, hogy az Adatkezelő hogyan használja fel az Ön személyes adatait, valamint az adatvédelmi jogszabályok által előírt egyéb információkról. A jövőbeni módosítások esetén a Felhasználó a szükséges frissítéseket és információkat a jelen Adatvédelmi Szabályzatnak a Platformra feltöltött frissítésén keresztül kapja meg.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">1. Ki az adatkezelő?</h2>
                            </div>
                            <div class="col-12">
                                <b>1.1.</b> A "{{ config("app.installation_company_name") }}" cégnévvel rendelkező társaság, cím: {{ config("app.installation_company_address") }} , Telefon: {{ config("app.installation_company_phone") }}, email:
                                {{ config("app.installation_company_email") }}, Felhasználó személyes adatainak feldolgozásáért felelős adatkezelő (a továbbiakban <b>"Adatkezelő"</b>).
                                <br><br>
                                <b>1.2. Az adatkezelő elérhetőségei:</b> A jelen Adatvédelmi Szabályzattal és a Felhasználó személyes adatainak vagy a Felhasználó által a Platform használatához feltöltött adatoknak a feldolgozásával kapcsolatos bármilyen kérdés vagy aggály esetén a Felhasználó az alábbi alternatívák egyikén keresztül léphet kapcsolatba az Adatkezelővel:
                                <br><br>
                                Telefonon a {{ config("app.installation_company_phone") }}-es telefonszámon, hétfőtől péntekig 10.00 és 18.00 óra között (Kelet-európai idő szerint)<br>
                                E-mailben a következő e-mail címen: {{ config("app.installation_company_email") }}<br>
                                {{ config("app.installation_company_address") }}<br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">2. Mi a célja és jogalapja az adatfeldolgozásnak?</h2>
                                <b>2.1.</b> A platform működési célja a felhasználók véleményének összegyűjtése kérdőívek segítségével. A véleményeket feldolgozzuk, hogy betekintést nyerjünk, értékes ötleteket és javaslatokat gyűjtsünk és nyújtsunk be a kérdőívekben tárgyalt témákkal kapcsolatban. A felhasználók névtelenül (személyes adatok megadása nélkül) válaszolhatnak, vagy önkéntesen regisztrálhatnak, hogy névre szóló válaszokat adhassanak, egy e-mail cím és egy becenév megadásával. A felhasználók válaszait angolra fordítjuk, és jelentésekben mutatjuk be. Az adatkezelés konkrét céljára a jogalap a Felhasználó előzetes hozzájárulása.
                                <br><br>
                                <b>2.2.</b> Információs e-mailek küldése a Felhasználónak, hogy tájékoztassa őt a Platform új tevékenységeiről, projektjeiről és egyéb, a Platformot érintő kérdésekről. Az adatkezelés e céljának jogalapja a Felhasználó előzetes hozzájárulása.
                                <br><br>
                                <b>2.3</b> Adatkezelés az Adatkezelő jogi kötelezettségeinek teljesítésével kapcsolatos okokból. Ilyen esetekben az adatkezelés csak annyi ideig történik, amennyi ahhoz szükséges, hogy az Adatkezelő eleget tegyen a különböző jogi rendelkezések által előírt kötelezettségeknek.
                                <br><br>
                                <b>A fenti rendelkezések esetében, ahol a jogalap a Felhasználó előzetes hozzájárulása, a Felhasználó bármikor visszavonhatja hozzájárulását anélkül, hogy a visszavonás előtti hozzájáruláson alapuló adatok jogszerűségét befolyásolná.</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">3. Az összegyűjtött adatok típusai</h2>

                                <h3 class="mt-4 mb-4">3.1 Személyes adatok</h3>
                                <b>3.1.1 Regisztráció - fiók létrehozása:</b><br>
                                Ahhoz, hogy a Felhasználó önkéntesen fiókot hozzon létre a Platformon, a Felhasználónak ki kell töltenie a szükséges adatokat: becenevét, e-mail címét és jelszavát.
                                <br><br>
                                <b>3.1.2 Beküldött kérdőíves válaszok</b><br>
                                Platform összegyűjti a felhasználók válaszait (azaz véleményét különböző témákról) a Platform kérdőívein keresztül feltett kérdésekre. Ezeket a válaszokat elemzik és egy kérdőív eredményoldalon mutatják be. A Felhasználónak szigorúan be kell tartania a Platformon "a sikeres részvételre vonatkozó magatartási kódex" tartalmát, továbbá el kell kerülniük olyan személyes adatok nyilvános közzétételét, amelyeket nem kíván nyilvánosan elérhetővé tenni a Platformon.
                                <br><br>
                                <b>3.1.3. A Platform kommunikációja a Felhasználónak a Platform engedélyezett használatával kapcsolatos okai miatt.</b>
                                <br>
                                Annak érdekében, hogy a Platform a fenti célokból kommunikálhasson a Felhasználóval, az Adatkezelő feldolgozhat minden, a Felhasználó fiókjával, feltöltött tartalmával és a Felhasználó Platform használatával kapcsolatos adatot.

                                <h3 class="mt-4 mb-4">3.2 Felhasználási adatok</h3>
                                A weboldal elérésére és használatára vonatkozó információkat is gyűjthetünk ("Használati adatok"). Ezek a használatra vonatkozó adatok olyan információkat tartalmazhatnak, mint az Ön számítógépének Internet Protocol címe (IP-cím), a böngésző típusa, a böngésző verziója, a weboldalunk meglátogatott oldalai, a látogatás időpontja és dátuma, az oldalakon töltött idő, egyedi eszközazonosítók és egyéb diagnosztikai adatok.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4"> 4. Hogyan gyűjti a platform az adatokat</h2>
                                4.1 Az információk a következő módokon gyűjthetők: <br>
                                4.1.1 Amikor a Felhasználó regisztrál és fiókot hoz létre a Platformon. <br>
                                4.1.2 Amikor a Felhasználó a Platform kérdőíveire <br>
                                4.1.3 Amikor a Felhasználó meglátogatja a Platformot és hozzájárul a cookie-k telepítéséhez (a Platform cookie-irányelvei szerint a 11. cikkben foglaltak szerint) és a Felhasználó személyes adatainak, mint például az IP-cím, az operációs rendszer, a böngésző típusa és kiadása stb. gyűjtéséhez
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">5. Mennyi ideig tárolják a Felhasználó adatait, és mikor törlik azokat?</h2>
                                <b>5.1. Felhasználó fiókjának adatai:</b><br>
                                Felhasználó alábbiakban említett törlési/törlési jogának sérelme nélkül, a Felhasználó fiókjában regisztrált és tárolt adatok mindaddig tárolásra kerülnek, amíg a Felhasználó a fent említett célokra kívánja használni a Platformot. Amennyiben a Felhasználó törölni kívánja a fiókját, a fiók beállításain keresztül törölheti a fiókját, vagy kapcsolatba léphet az Adatkezelővel a fent említett elérhetőségeken.
                                <br><br>
                                <b>5.2. A Platform kommunikációja a Platform Felhasználó által engedélyezett használatával kapcsolatos okokból.</b><br>
                                Az ilyen kommunikációval kapcsolatos adatokat csak addig tároljuk, amíg a Felhasználó használni kívánja a Platformot és fenntartja fiókját. Amennyiben a Felhasználó törölni kívánja a fiókját, a fiók beállításain keresztül törölheti a fiókját, vagy kapcsolatba léphet az Adatkezelővel a fent említett elérhetőségeken.
                                <br><br>
                                <b>5.3. Statisztikai elemzés a Weboldal optimalizálása érdekében</b><br>
                                Az 5. cikk fent említett rendelkezéseitől függetlenül az Adatkezelő csak a törvény által előírt kötelezettségeinek (pl. adókötelezettségek teljesítése, stb.) mindenkori teljesítéséhez szükséges ideig tárolja és kezeli a szükséges adatokat.
                                <br><br>
                                <b>5.4. Személyes adatok feldolgozása statisztikai elemzés elvégzése céljából.</b><br>
                                Lásd a cookie-kra vonatkozó politikát (11. cikk ) alább.
                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">6. Milyen jogai vannak a Felhasználónak az adatai feldolgozásával kapcsolatban, és hogyan gyakorolhatja ezeket a jogokat?</h2>
                                <b>6.1</b> Az Adatkezelő tiszteletben tartja a Felhasználónak az adatkezeléssel kapcsolatos jogait.
                                <br><br>
                                <b>6.2</b> A Felhasználó a jogait az Adatkezelővel való kapcsolatfelvétel útján gyakorolhatja az alábbi elérhetőségeken: Telefon: {{ config("app.installation_company_phone") }}, e-mail: {{ config("app.installation_company_email") }}
                                <br><br>
                                Felhasználó tájékozódását támogatandó, a Felhasználó jogait az alábbi táblázat tartalmazza az egyes jogok rövid magyarázatával együtt (a cikkekre való hivatkozás megfelel a GDPR 2016/679 cikkének):
                                <br><br>
                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Jog</th>
                                        <th>Magyarázat</th>
                                    </tr>
                                    <tr>
                                        <td>Hozzáférés (15. cikk)</td>
                                        <td>
                                            A Felhasználó kérheti az Adatkezelőt, hogy:
                                            <ul>
                                                <li>megerősítse, hogy az Adatkezelő kezeli-e a Felhasználó személyes adatait                                                </li>
                                                <li>a felhasználó számára hozzáférést biztosítson olyan adatokhoz, amelyekkel a felhasználó nem rendelkezik</li>
                                                <li>a Felhasználónak a Felhasználó személyes adataival kapcsolatos egyéb információkat adjon, például, hogy milyen adatokkal rendelkezik az Adatkezelő, melyek az adatkezelés céljai, kinek adják át ezeket az adatokat, továbbítják-e ezeket az adatokat külföldre és hogyan védik ezeket az adatokat, mennyi ideig tárolják az adatokat, milyen jogai vannak a Felhasználónak, hogyan lehet panaszt tenni, honnan származnak az adatok, amennyiben ezeket az információkat a jelen Adatvédelmi szabályzat nem tartalmazza.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Helyesbítés (16. cikk)</td>
                                        <td>
                                            A Felhasználó kérheti az Adatkezelőtől a pontatlan személyes adatok helyesbítését.<br><br>
                                            Az Adatkezelő az adatok helyesbítése előtt kérheti az adatok pontosságának ellenőrzését.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Törlés/törlés (17. cikk)</td>
                                        <td>
                                            A Felhasználó kérheti az Adatkezelőtől személyes adatainak törlését:<br><br>
                                            <ul>
                                                <li>bármikor, amikor a személyes adatokra már nincs szükség azokhoz a célokhoz, amelyekhez azokat gyűjtötték
                                                </li>
                                                <li>amikor a felhasználó visszavonja hozzájárulását</li>
                                                <li>a személyes adatokat jogellenesen kezelték</li>
                                            </ul>
                                            <br><br>
                                            Adatkezelő nem köteles eleget tenni a Felhasználó személyes adatainak törlésére irányuló kérésének, ha a Felhasználó személyes adatainak kezelése szükséges:
                                            <ul>
                                                <li>jogi kötelezettség</li>
                                                <li>egyéb jogos cél vagy egyéb jogos jogalap
                                                </li>
                                                <li>jogi igények előterjesztéséhez, érvényesítéséhez vagy védelméhez.</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Korlátozás (18. cikk)</td>
                                        <td>

                                            A Felhasználó kérheti az Adatkezelőt, hogy korlátozza (tárolja, de ne kezelje) a Felhasználó személyes adatait, ha:<br><br>
                                            azok pontosságát vitatják (lásd helyesbítés), hogy az Adatkezelő ellenőrizhesse a személyes adatok pontosságát, vagy<br><br>
                                            a személyes adatokat jogellenesen kezelték, de a Felhasználó tiltakozik a személyes adatok törlése ellen, vagy<br><br>
                                            azok már nem szükségesek ahhoz a célhoz, amelyhez azokat gyűjtötték, de a Felhasználónak továbbra is szüksége van rájuk jogi igények előterjesztéséhez, érvényesítéséhez vagy védelméhez, vagy az adatkezelésnek más jogszerű célja vagy egyéb jogalapja van
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Adathordozhatóság (20. cikk)
                                        </td>
                                        <td>
                                            Ha az adatkezelés hozzájáruláson alapul, és az adatkezelés automatizált módon történik, a Felhasználó kérheti az Adatkezelőtől, hogy személyes adatait strukturált, általánosan használt és géppel olvasható formátumban kapja meg, vagy kérheti az Adatkezelőtől, hogy azokat közvetlenül az Adatkezelőtől továbbítsa egy másik adatkezelőnek. Mindazonáltal a törvény szerint ez a jog csak azokra az adatokra vonatkozik, amelyeket maga a Felhasználó adott meg, és nem vonatkozik azokra az adatokra, amelyeket az Adatkezelő a Felhasználó által megadott adatok alapján következtet.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tiltakozás (21. cikk)</td>
                                        <td>
                                            A Felhasználó bármikor kifogásolhatja a rá vonatkozó személyes adatok jogos érdeken vagy közérdekű feladat végrehajtásán alapuló kezelését.<br><br>
                                            Ha a Felhasználó él a kifogással való jogával, az Adatkezelő jogosult bizonyítani, hogy az adatkezelést olyan kényszerítő erejű jogos okok indokolják, amelyek elsőbbséget élveznek a Felhasználó érdekeivel, jogaival és szabadságával szemben, vagy jogi igények előterjesztéséhez, érvényesítéséhez vagy védelméhez szükségesek.

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            A hozzájárulás visszavonása (opt-out)
                                        </td>
                                        <td>
                                            A Felhasználónak joga van a hozzájárulásának visszavonására, amennyiben a hozzájárulás az adatkezelés alapja. A visszavonás a jövőre nézve érvényes.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Felügyeleti hatóság
                                        </td>
                                        <td>
                                            A Felhasználónak joga van panaszt tenni a helyi adatvédelmi felügyeleti hatóságnál. <br><br>
                                            Magyarországon az adatvédelmi felügyeleti hatóság a Nemzeti Adatvédelmi és Információszabadság Hatóság (https://www.naih.hu/).


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identitás</td>
                                        <td>Az Adatkezelő komolyan veszi a személyes adatokat tartalmazó valamennyi fájl bizalmas kezelését, ezért jogosult a Felhasználótól személyazonosságának igazolását kérni, ha a Felhasználó az említett fájlokkal kapcsolatban kérelmet nyújt be.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Költségek</td>
                                        <td>A Felhasználónak nem kell fizetnie a személyes adatokkal kapcsolatos jogainak gyakorlásáért, kivéve, ha a törvényben előírtak szerint az információkhoz való hozzáférés iránti kérelem megalapozatlan vagy túlzott mértékű. Ebben az esetben az Adatkezelő az adott körülmények között ésszerű díjat számíthat fel a Felhasználónak. Az Adatkezelő a kérelem teljesítése előtt tájékoztatja a Felhasználót az esetleges díjról.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Menetrend</td>
                                        <td>Az Adatkezelő a Felhasználó érvényes kéréseit legkésőbb a beérkezéstől számított egy (1) hónapon belül igyekszik megválaszolni, kivéve, ha a kérés rendkívül bonyolult, vagy a Felhasználó több kérelmet nyújtott be, amely esetben az Adatkezelő három hónapon belül igyekszik válaszolni. Amennyiben az Adatkezelőnek a fent említett okok miatt egy hónapnál hosszabb időre van szüksége, erről tájékoztatja a Felhasználót. Az Adatkezelő megkérheti a Felhasználót, hogy ha meg akarja magyarázni, hogy pontosan mit szeretne kapni, vagy mi a problémája. Ez segít az Adatkezelőnek abban, hogy gyorsabban tudjon eljárni a Felhasználó kérésével kapcsolatban. A Felhasználónak minden esetben konkrét és valós adatokat és/vagy tényeket kell megemlítenie, hogy az Adatkezelő pontosan tudjon válaszolni és/vagy eleget tudjon tenni a Felhasználó kérésének. Ellenkező esetben az Adatkezelő fenntartja magának a jogot az ellenőrzési körén kívül eső hibák esetén. Az Adatkezelő továbbá elutasíthatja az alaptalan, túlzó, visszaélésszerű, rosszhiszemű vagy a jogi rendelkezések értelmében jogellenes kérelmeket.
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">7. Hogyan biztosított az adatbiztonság?</h2>
                                <b>7.1</b> Az Adatkezelő minden megfelelő biztonsági intézkedést megtesz a személyes adatok védelme és bizalmas kezelése érdekében, amelyek között a következők szerepelnek:
                                <br>
                                <ol>
                                    <li>Erős jelszószabályok minden kiszolgálón</li>
                                    <li>HTTPS protokoll az API-kkal és webes ügyfelekkel való interakcióhoz</li>
                                    <li>SSH protokoll a kiszolgálóhoz való csatlakozáshoz</li>
                                    <li>Rendszeres szerverfrissítések a legújabb biztonsági javításokkal</li>
                                </ol>

                                <br><br>
                                <b>7.2</b> Felhívjuk figyelmét, hogy a Felhasználó által megadott adatokat kizárólag az Adatkezelő kifejezetten erre felhatalmazott alkalmazottai kezelik, akik az Adatkezelő felhatalmazása alapján és kizárólag az ő utasításai szerint járnak el, valamint szükség esetén a címzettek. Az adatkezeléshez az Adatkezelő megfelelő képesítéssel rendelkező személyeket választ, akik a technikai ismeretek és a személyes integritás tekintetében megfelelő garanciákkal rendelkeznek a titoktartás védelme érdekében. Az Adatkezelő minden szükséges biztonsági intézkedést megtesz a személyes adatok titkosságának, bizalmas jellegének és sértetlenségének védelme és megőrzése érdekében, a munkatársai vonatkozó szerződéses kötelezettségvállalásai révén is. A Weboldal biztonsága minden esetben sérülhet az Adatkezelő ellenőrzési körén kívül eső okok, valamint a hálózat technikai vagy egyéb problémája, vis maior vagy véletlenszerű események miatt. Ebben az esetben a személyes adatok biztonsága nem garantálható.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">8. Kik az adatok címzettjei?</h2>
                                <b>8.1</b> A Felhasználó személyes adatainak címzettjei a Honlap működéséhez szükséges technikai infrastruktúrát biztosító társult vállalatok, a tárhelyszolgáltató, valamint az a vállalat, amely vállalja, hogy a Platform működésével kapcsolatos elektronikus kommunikációt küld a Felhasználóknak. Amennyiben a vonatkozó jogszabályok szerint szükséges, az Adatkezelő az ilyen cégekkel olyan megállapodásokat köt, amelyek a biztonsági intézkedések végrehajtására és rendszeres ellenőrzésére vonatkoznak. Az adatok EU-n kívülre történő továbbítása esetén minden szükséges garancia rendelkezésre áll.
                                <br><br>
                                <b>8.2.</b> Amennyiben az Adatkezelő az illetékes közigazgatási hatóság, ügyvéd, bíróság vagy más hatóság megkeresése nyomán adatközlésre vagy adattovábbításra vonatkozó megkeresést kap, a megfelelő jogszabályi rendelkezésekkel összhangban (a Felhasználó előzetes értesítése mellett vagy anélkül) közérdekből e hatóságok felé teljesített kötelezettsége teljesítése érdekében az adatokat közölheti/továbbíthatja. Ha a Felhasználót a jogszabályi rendelkezésekkel összhangban előzetesen értesíteni kell, akkor a Felhasználónak joga van tiltakozni a fenti 7. cikkben foglaltak szerint az adatkezelés ellen.
                                <br><br>
                                <b>8.3.</b> Αs az egyes Felhasználók szakmai adatai a fent említett célokból a Platform minden regisztrált Felhasználója számára elérhetőek.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">9. Kommunikáció az adatkezelővel</h2>
                                <b>9.1.</b> jelen adatvédelmi irányelvekkel, a Felhasználó adatkezelésével, valamint a Felhasználó jogainak gyakorlásával kapcsolatos bármely kérdésben a Felhasználó az alábbi módok valamelyikén léphet kapcsolatba az Adatkezelővel: <br>
                                Telefon: {{ config("app.installation_company_phone") }}, <br>
                                Email: {{ config("app.installation_company_email") }}
                                <br><br>
                                Amennyiben a Felhasználó tudomást szerez bármilyen adatvédelmi incidensről, kérjük, hogy haladéktalanul értesítse az Adatkezelőt.
                                <br><br>
                                <b>9.2.</b> A jelen feltételeket az Általános Szerződési Feltételek szabályozzák és egészítik ki, és azokkal együtt egységes szöveget alkotnak.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">10. Kapcsolódás más weboldalakhoz/közösségi médiához</h2>
                                Ez a weboldal hiperhivatkozásokon keresztül kapcsolódik más weboldalakhoz. Ezek a weboldalak nem kapcsolódnak az Adatkezelő weboldalához, és tartalmukat az Adatkezelő nem ellenőrzi és nem ajánlja. Így azok tartalmának pontossága, jogszerűsége, teljessége vagy minősége, valamint a Felhasználó személyes adatainak feldolgozásának jogszerűsége nem ellenőrizhető, és nem vállalható rájuk garancia. Az Adatkezelő nem tehető felelőssé értük, illetve a használatuk miatt vagy azt követően a Felhasználónak esetlegesen okozott károkért. Az Adatkezelő nem tudja ellenőrizni a Felhasználó személyes adatainak a hivatkozott weboldalak általi feldolgozását, és ezért nem vállal felelősséget. Amikor a Felhasználó belép ezekre a weboldalakra, figyelembe kell vennie, hogy az egyes weboldalakra az adott weboldal feltételei vonatkoznak. Bármilyen, a hivatkozott weboldal tartalmával vagy használatával kapcsolatban felmerülő kérdésben a Felhasználónak közvetlenül az egyes weboldalak üzemeltetőjéhez vagy adminisztrátorához kell fordulnia. Az Adatkezelő nem hagyja jóvá és nem fogadja el a hivatkozott weboldalak tartalmát vagy szolgáltatásait, amelyekhez a Felhasználó a Weboldalon keresztül hozzáfér.<br><br>
                                A Weboldal lehetőséget biztosít a Felhasználónak arra, hogy saját kezdeményezésére és akaratát követve csatlakozzon és kapcsolatba lépjen a közösségi médiával. Ebben az esetben az Adatkezelő nem felel a Felhasználó adatainak a közösségi médián keresztül vagy a közösségi média által történő feldolgozásáért. A Felhasználónak közvetlenül az egyes közösségi médiumokhoz kell fordulnia jogos jogainak gyakorlása érdekében.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">11. Sütik</h2>
                                11.1. A Platform sütiket használ a működés vagy a hatékonyabb működés érdekében, a Felhasználó navigációjának javítása, a Platformban rejlő lehetőségek teljes körű kihasználása, a tartalom helyes megjelenítésének biztosítása, valamint elemzési és statisztikai célokra.
                                <br><br>
                                11.2. A sütik olyan kis szöveges fájlok, amelyeket a Felhasználó számítógépén tárolnak, amikor a Felhasználó egy digitális platformot látogat, és amelyek a számítógépének azonosítására szolgálnak.
                                <br><br>
                                11.3. A cookie-k a feltétlenül szükséges cookie-kon kívül csak akkor kerülnek telepítésre, ha a Felhasználó a Platform meglátogatásakor elfogadja a telepítésüket. A cookie-k elfogadásával a Platformra való belépéskor a Felhasználó kifejezetten kijelenti, hogy elolvasta és megértette a cookie-k telepítésére, működésére és céljára vonatkozó konkrét feltételeket, és hozzájárulását adja azok használatához.
                                <br><br>
                                11.4. Alternatívaként a Felhasználó nem fogadhatja el a cookie-kat. Ebben az esetben csak a Platform működéséhez technikailag és funkcionálisan szükséges cookie-k kerülnek telepítésre.
                                <br><br>
                                11.5. A Felhasználó bármikor kezelheti a cookie-k használatát és telepítését egy panelen keresztül, ahol kiválaszthatja, hogy melyik kategóriájú cookie-kat szeretné elfogadni és melyeket nem (vagy kérheti, hogy csak a technikailag szükséges cookie-kat telepítsék).
                                <br><br>
                                11.6. A Platform által használt cookie-k különösen a következők:
                                <br><br>

                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>A sütik típusa</th>
                                        <th>Magyarázat</th>
                                        <th>Példák a sütikre</th>
                                        <th>Az egyes sütik telepítésének időtartama</th>
                                        <th>Adattovábbítás harmadik félnek</th>
                                    </tr>
                                    <tr>
                                        <td>Feltétlenül szükséges cookie-k</td>
                                        <td>A feltétlenül szükséges cookie-k engedhetetlenek a Platform megfelelő működéséhez. Ezek a cookie-k lehetővé teszik a Felhasználó számára a Platform funkcióinak böngészését és használatát, például a biztonságos területekhez való hozzáférést. Ezek a cookie-k nem ismerik fel a Felhasználó egyéni személyazonosságát, és nélkülük a Platform zavartalan működése nem lehetséges.
                                        </td>
                                        <td>crowdsourcing_app_cookies_consent_selection (Tárolja a felhasználó süti hozzájárulásának állapotát az aktuális tartományhoz )
                                            <br><br>
                                            crowdsourcing_app_cookies_consent_targeting (Tárolja a felhasználó süti hozzájárulásának állapotát az aktuális tartományhoz )
                                            <br><br>
                                            XSRF-TOKEN (Biztosítja a látogatók böngészésének biztonságát a webhelyközi kérés meghamisításának megakadályozásával. Ez a cookie elengedhetetlen a weboldal és a látogató biztonsága szempontjából. )
                                            <br><br>
                                            ecas_lets_crowdsource_our_future_session (Amikor az alkalmazásnak "emlékeznie" kell a bejelentkezett felhasználóra, miközben a platformon navigál)
                                            <br><br>
                                            Crowdsourcing_anonymous_user_id (a kérdőívekre adott anonim válaszok tárolására szolgál a választ beküldő felhasználóhoz rendelt egész számmal)
                                        </td>
                                        <td>1 év
                                            <br><br>
                                            <br><br>
                                            1 nap
                                            <br><br>
                                            <br><br>
                                            Munkamenet
                                            <br><br>
                                            <br><br>
                                            5 év
                                        </td>
                                        <td>Nem
                                            <br><br>
                                            <br><br>

                                            Nem
                                            <br><br>
                                            <br><br>

                                            Nem
                                            <br><br>
                                            <br><br>

                                            Nem
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Statisztikai/analitikai sütik</td>
                                        <td>Ezek olyan cookie-k, amelyek kiértékelik, hogy a látogatók hogyan használják a Platformot (például, hogy mely oldalakat látogatják gyakrabban, és hogy kapnak-e hibaüzeneteket a weboldalakról). Ezeket a sütiket statisztikai célokra és a Platform teljesítményének javítására használják.
                                        </td>
                                        <td>_ga_4S9N5MK4VE, _gat,_ga, _gcl_au, _gid: Google Analytics cookie-k: A Google Analytics sütiket a Platform forgalmának mérésére használják. Egy egyedi szövegrészletet tárolnak a böngésző azonosítására, az interakciók időbélyegét és a böngészőt/forrásoldalt, amely a felhasználót a Platformra vezette. Érzékeny információk nem kerülnek elmentésre.

                                        </td>
                                        <td>_ga_4S9N5MK4VE: 2 év
                                            <br><br>
                                            _gat:1 perc
                                            <br><br>
                                            _ga:2 év
                                            <br><br>
                                            _gcl_au:3 hónap
                                            <br><br>
                                            _gid:24 óra
                                        </td>
                                        <td>Igen (statisztikai és elemzési szolgáltatásokat nyújtó vállalat, ha harmadik félnek minősül)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">12. Gyermekek magánélete  </h2>
                                Projektünk nem szól 18 év alattiakhoz ("Gyermekek"). Tudatosan nem gyűjtünk személyazonosításra alkalmas adatokat 18 év alattiaktól. Ha Ön szülő vagy gyám, és tudomása van arról, hogy Gyermekei személyes adatokat adtak meg nekünk, kérjük, lépjen kapcsolatba velünk. Ha tudomást szerzünk arról, hogy a szülői beleegyezés ellenőrzése nélkül gyűjtöttünk személyes adatokat gyermekektől, lépéseket teszünk annak érdekében, hogy eltávolítsuk ezeket az adatokat a szervereinkről.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">13. A jelen Adatvédelmi szabályzat módosításai </h2>
                                Az Adatkezelő fenntartja magának a jogot a jelen Adatvédelmi szabályzat módosítására, például ha ez szükséges az alkalmazandó jogszabályok, irányelvek vagy technikai követelmények által előírt új követelményeknek való megfeleléshez, vagy az Adatkezelő folyamatainak és gyakorlatának felülvizsgálata során. A Felhasználó a Platformon keresztül értesítést kap a jelen Adatvédelmi szabályzat bármely módosításáról. A Felhasználónak rendszeresen ellenőriznie kell a jelen Adatvédelmi szabályzatot a módosítások tekintetében.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
