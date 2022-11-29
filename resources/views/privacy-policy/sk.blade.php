@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>ZÁSADY OCHRANY OSOBNÝCH ÚDAJOV</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                Tieto zásady ochrany osobných údajov sa vzťahujú na všetkých používateľov platformy (ďalej len <b>“používatelia”</b> alebo <b>“používateľ”</b> a <b>“platforma”</b> a tvoria neoddeliteľnú súčasť zmluvných podmienok webovej stránky platformy. Tieto Zásady ochrany osobných údajov poskytujú Používateľovi všeobecné informácie o tom, ako Prevádzkovateľ používa jeho osobné údaje, a ďalšie informácie požadované právnymi predpismi o ochrane údajov. V prípade budúcej zmeny budú Používateľovi poskytnuté potrebné aktualizácie a informácie prostredníctvom aktualizácie týchto Zásad ochrany osobných údajov nahratých na Platformu.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">1. Kto je správcom údajov?</h2>
                            </div>
                            <div class="col-12">
                                <b>1.1.</b> Spoločnosť s názvom "{{ config("app.installation_company_name") }}", adresa: {{ config("app.installation_company_address") }}, Telefón: {{ config("app.installation_company_phone") }}, email: {{ config("app.installation_company_email") }}, je Prevádzkovateľom pre spracúvanie Osobných údajov Užívateľa (ďalej len <b>"Správca údajov"</b>).
                                <br><br>
                                <b>1.2. Kontaktné údaje prevádzkovateľa údajov:</b> V prípade akéhokoľvek problému alebo obáv v súvislosti s týmito zásadami ochrany osobných údajov a so spracovaním osobných údajov používateľa alebo údajov nahraných používateľom pri  používaní platformy, môže používateľ komunikovať s prevádzkovateľom údajov pomocou jednej z nasledujúcich alternatív:
                                <br><br>
                                Zavolaním na číslo {{ config("app.installation_company_phone") }}, od pondelka do piatku od 9.30 do 17.30 CET<br>
                                Zaslaním e-mailu na túto e-mailovú adresu: {{ config("app.installation_company_email") }}<br>
                                Zaslaním korešpondencie na nasledujúcu adresu: {{ config("app.installation_company_address") }}<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">2. Aký je účel a právny základ spracovania údajov používateľa?</h2>
                                <b>2.1.</b> Operačným účelom platformy je zhromažďovať názory používateľov prostredníctvom dotazníkov. Názory sa spracúvajú s cieľom získať poznatky, zhromaždiť a prezentovať cenné nápady a návrhy k témam, ktorým sa dotazníky venujú. Používatelia môžu odpovedať anonymne (bez poskytnutia akýchkoľvek osobných údajov) alebo sa môžu dobrovoľne zaregistrovať a odoslať rovnomenné odpovede poskytnutím emaiul a prezývky. Odpovede používateľov sú preložené do angličtiny a sú prezentované v prehľadoch. Pre konkrétny účel spracovania je právnym základom predchádzajúci súhlas Používateľa.
                                <br><br>
                                <b>2.2.</b> Zasielať Používateľovi informatívne e-maily s cieľom informovať ho o nových aktivitách, projektoch a iných otázkach záujmu Platformy. Na tento účel spracovania je právnym základom predchádzajúci súhlas Používateľa.
                                <br><br>
                                <b>2.3</b> Spracúvanie údajov z dôvodov súvisiacich s dodržiavaním zákonných povinností Prevádzkovateľom. V takýchto prípadoch sa údaje spracúvajú len počas nevyhnutnej doby, aby Prevádzkovateľ splnil povinnosti uložené rôznymi právnymi predpismi.
                                <br><br>
                                <b>V prípade vyššie uvedených ustanovení, kde je právnym základom predchádzajúci súhlas Používateľa, môže Používateľ svoj súhlas kedykoľvek odvolať bez toho, aby bola dotknutá oprávnenosť údajov založených na súhlase pred jeho odvolaním.</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">3. Typy zhromažďovaných údajov</h2>

                                <h3 class="mt-4 mb-4">3.1 Osobné údaje</h3>
                                <b>3.1.1 Registrácia – vytvorenie účtu:</b><br>
                                Aby si Používateľ mohol dobrovoľne vytvoriť účet na Platforme, musí vyplniť potrebné údaje: svoju prezývku, e-mailovú adresu a heslo
                                <br><br>
                                <b>3.1.2 Zaslané odpovede na dotazník</b><br>
                                Platforma zhromažďuje odpovede používateľov (t. j. názory na rôzne témy) na otázky položené prostredníctvom dotazníkov Platformy. Tieto odpovede sú analyzované a prezentované na stránke s výsledkami dotazníka. Používateľovi sa prísne odporúča dodržiavať „kódex správania pre úspešnú účasť“ platformy a vyhýbať sa zverejňovaniu akýchkoľvek osobných údajov, u ktorých si používateľ neželá, aby boli verejne dostupné na platforme.
                                <br><br>
                                <b>3.1.3. Komunikácia platformy z dôvodov súvisiacich s povoleným používaním platformy používateľom.</b>
                                <br>
                                Aby mohla Platforma komunikovať s Používateľom na vyššie uvedené účely, Správca údajov môže spracovať všetky údaje týkajúce sa účtu Používateľa, nahraného obsahu a údajov súvisiacich s používaním Platformy Používateľom.

                                <h3 class="mt-4 mb-4">3.2 Údaje o používaní</h3>
                                Môžeme tiež zhromažďovať informácie o tom, ako sa k webovej stránke pristupuje a ako sa používa („Údaje o používaní“). Tieto údaje o používaní môžu zahŕňať informácie ako je adresa internetového protokolu vášho počítača (napr. IP adresa), typ prehliadača, verzia prehliadača, stránky našej webovej stránky, ktoré navštívite, čas a dátum vašej návštevy, čas strávený na týchto stránkach, jedinečné identifikátory zariadení a iné diagnostické údaje.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4"> 4. Ako Platforma zhromažďuje údaje</h2>
                                4.1 Informácie je možné zbierať nasledujúcimi spôsobmi: <br>
                                4.1.1 Keď sa Používateľ zaregistruje a vytvorí si účet na Platforme. <br>
                                4.1.2 Keď Používateľ odošle odpovede na dotazníky Platformy <br>
                                4.1.3 Keď Používateľ navštívi Platformu a súhlasí s inštaláciou súborov cookie (podľa Zásad používania súborov cookie platformy v článku 11 nižšie) a so zhromažďovaním osobných údajov Používateľa, ako napr. IP adresa, operačný systém, typ a verzia prehliadača atď.
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">5. Ako dlho sú uložené údaje používateľa a kedy sú vymazané?</h2>
                                <b>5.1. Údaje o používateľskom účte:</b><br>
                                Bez toho, aby bolo dotknuté právo Používateľa na vymazanie uvedené nižšie, Údaje zaregistrované a uložené v účte Používateľa budú uložené dovtedy, kým si Používateľ želá využívať Platformu na vyššie uvedený účel. V prípade, že si Používateľ želá vymazať svoj účet, môže svoj účet vymazať prostredníctvom nastavení účtu alebo kontaktovať správcu údajov na vyššie uvedených kontaktných údajoch.
                                <br><br>
                                <b>5.2. Komunikácia platformy z dôvodov súvisiacich s povoleným používaním platformy používateľom.</b><br>
                                Údaje súvisiace s takouto komunikáciou budú uchovávané iba dovtedy, kým si Používateľ želá používať Platformu a bude si udržiavať svoj účet. V prípade, že si Používateľ želá vymazať svoj účet, môže svoj účet vymazať prostredníctvom nastavení účtu alebo kontaktovať správcu údajov na vyššie uvedených kontaktných údajoch.
                                <br><br>
                                <b>5.3. Štatistická analýza na optimalizáciu webovej stránky</b><br>
                                Bez ohľadu na vyššie uvedené ustanovenia článku 5 bude Prevádzkovateľ uchovávať a spracovávať iba potrebné údaje počas obdobia potrebného na splnenie svojich povinností uložených zákonom (dodržiavanie daňových povinností atď.) .
                                <br><br>
                                <b>5.4. Spracúvanie osobných údajov na účely vykonávania štatistických analýz.</b><br>
                                Pozrite si pravidlá používania súborov cookie (článok 11) nižšie.
                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">6. Aké sú práva užívateľa v súvislosti so spracovaním jeho údajov a ako môže tieto práva uplatniť?</h2>
                                <b>6.1</b> Prevádzkovateľ rešpektuje právo používateľa v súvislosti so spracovaním údajov.
                                <br><br>
                                <b>6.2</b> Používateľ môže svoje práva uplatniť kontaktovaním správcu údajov na nasledujúcich kontaktných údajoch: Telefón: +3222905845, e-mail: info(at)ecas.org
                                <br><br>
                                Práva Používateľa sú na uľahčenie uvedené v nasledujúcej tabuľke spolu s krátkym vysvetlením každého práva. (odkaz na články zodpovedá článku GDPR 2016/679):
                                <br><br>
                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Právo</th>
                                        <th>Vysvetlenie</th>
                                    </tr>
                                    <tr>
                                        <td>Prístup (článok 15)</td>
                                        <td>
                                            Používateľ môže požiadať Prevádzkovateľa, aby:
                                            <ul>
                                                <li>potvrdil, či Prevádzkovateľ spracúva osobné údaje Používateľa
                                                </li>
                                                <li>poskytol Používateľovi prístup k údajom, ktorými Používateľ nemá disponovať</li>
                                                <li>poskytnúť Používateľovi ďalšie informácie súvisiace s osobnými údajmi Používateľa, akými sú napríklad údaje, ktorými Prevádzkovateľ disponuje, aké sú účely spracovania, komu sú tieto údaje poskytované, či sú tieto údaje prenášané do zahraničia a akým spôsobom sú tieto údaje chránené, ako dlho sú údaje uchovávané, aké sú práva Užívateľa, ako je možné uplatniť reklamáciu, odkiaľ boli prevzaté údaje v rozsahu, v akom tieto informácie nie sú zahrnuté v Zásadách ochrany osobných údajov.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oprava (článok 16)</td>
                                        <td>
                                            Používateľ môže požiadať Prevádzkovateľa o opravu nepresných osobných údajov.<br><br>
                                            Správca údajov sa môže snažiť overiť presnosť údajov pred ich opravou.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vymazanie/vymazanie (článok 17)</td>
                                        <td>
                                            Užívateľ môže požiadať Prevádzkovateľa o vymazanie jeho osobných údajov:<br><br>
                                            <ul>
                                                <li>kedykoľvek, keď už osobné údaje nie sú potrebné na účely, na ktoré boli zhromaždené
                                                </li>
                                                <li>keď Užívateľ odvolá svoj súhlas</li>
                                                <li>keď osobné údaje boli spracúvané nezákonne</li>
                                            </ul>
                                            <br><br>
                                            Prevádzkovateľ nie je povinný vyhovieť žiadosti Používateľa o vymazanie jeho osobných údajov, ak je spracovanie osobných údajov Používateľa nevyhnutné:
                                            <ul>
                                                <li>pre splnenie zákonnej povinnosti</li>
                                                <li>pre splnenie iného oprávneného účelu alebo iného oprávneného právneho základu
                                                </li>
                                                <li>pre určenie, výkon alebo obhajobu právnych nárokov</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Obmedzenie (článok 18)</td>
                                        <td>Používateľ môže požiadať Prevádzkovateľa o obmedzenie (uchovávanie, ale nespracovanie) osobných údajov Používateľa, ak:<br><br>
                                            je sporná ich presnosť (pozri opravu), aby Prevádzkovateľ mohol overiť presnosť osobných údajov alebo<br><br>
                                            osobné údaje boli spracúvané nezákonne, ale Používateľ namieta proti vymazaniu osobných údajov alebo<br><br>
                                            už nie sú potrebné na účely, na ktoré boli zhromaždené, ale Používateľ ich stále potrebuje na určenie, výkon alebo obhajobu právnych nárokov alebo existuje iný legitímny účel spracovania alebo iný právny základ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Prenosnosť údajov (článok 20)
                                        </td>
                                        <td>
                                            Keď je spracovanie založené na súhlase a spracúvanie sa vykonáva automatizovanými prostriedkami, Používateľ môže požiadať Prevádzkovateľa o získanie jeho osobných údajov v štruktúrovanom bežne používanom a strojovo čitateľnom formáte alebo požiadať Prevádzkovateľa, aby ich odovzdal inému prevádzkovateľovi priamo od Prevádzkovateľa. Toto právo sa však podľa zákona vzťahuje len na tie údaje, ktoré poskytol sám Používateľ, a nie na tie údaje, ktoré prevádzkovateľ vyvodil na základe údajov, ktoré Používateľ poskytol.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Námietka (článok 21)</td>
                                        <td>
                                            Používateľ môže kedykoľvek namietať proti spracúvaniu osobných údajov, ktoré sa ho týka, ktoré je založené na oprávnenom záujme alebo plnení úlohy vykonávanej vo verejnom záujme.<br><br>
                                            Keď PouUžívateľ uplatní svoje právo namietať, Prevádzkovateľ má právo preukázať, že má závažné oprávnené dôvody na spracovanie, ktoré prevažujú nad záujmami, právami a slobodou Používateľa, alebo na určenie, výkon alebo obhajobu právnych nárokov.

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Odvolanie súhlasu (opt-out)
                                        </td>
                                        <td>
                                            Používateľ má právo svoj súhlas odvolať, ak je súhlas základom spracovania. Odstúpenie je platné do budúcnosti.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Dozorný orgán
                                        </td>
                                        <td>
                                            Používateľ má právo podať sťažnosť miestnemu dozornému orgánu v súvislosti s ochranou údajov. <br><br>
                                            V Grécku je dozorným orgánom pre ochranu údajov Úrad na ochranu údajov https://www.dpa.gr/

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identita</td>
                                        <td>Správca údajov berie vážne dôvernosť všetkých súborov, ktoré obsahujú osobné údaje, a preto je oprávnený žiadať od Používateľa dôkaz o svojej totožnosti, ak Používateľ podá žiadosť v súvislosti s týmito súbormi.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Náklady</td>
                                        <td>Používateľ nebude musieť platiť za výkon svojich práv v súvislosti s osobnými údajmi, pokiaľ nie je žiadosť o získanie prístupu k informáciám podľa zákona neopodstatnená alebo neprimeraná. V takom prípade môže Prevádzkovateľ za daných okolností účtovať Používateľovi primeraný poplatok. Správca údajov bude informovať Používateľa o prípadnom poplatku pred dokončením žiadosti.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Správca údajov</td>
                                        <td>Správca údajov je povinný odpovedať na platné žiadosti Používateľa najneskôr do jedného (1) mesiaca od ich prijatia, pokiaľ žiadosť nie je mimoriadne komplikovaná alebo Používateľ nepredložil viacero žiadostí, pričom v takom prípade sa správca údajov snaží na ne odpovedať do troch mesiacov. V prípade, že Prevádzkovateľ potrebuje z vyššie uvedených dôvodov viac ako jeden mesiac, bude o tom Používateľa informovať. Správca údajov sa môže spýtať Používateľa, či chce vysvetliť, čo presne si želá dostávať alebo čo sa ho týka. Prevádzkovateľovi údajov to pomôže rýchlejšie konať vo vzťahu k žiadosti používateľa. Používateľ by mal v každom prípade uviesť konkrétne a pravdivé údaje a/alebo skutočnosti, aby Prevádzkovateľ mohol presne odpovedať a/alebo vyhovieť žiadosti Používateľa. V opačnom prípade si Správca údajov vyhradzuje právo na akékoľvek chyby, ktoré sú mimo jeho kontroly. Okrem toho môže správca údajov odmietnuť žiadosti, ktoré sú neopodstatnené, neprimerané, urážlivé, podané v zlej viere alebo sú nezákonné v rámci zákonných ustanovení.
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">7. Ako je zaistená bezpečnosť údajov?</h2>
                                <b>7.1</b> Správca údajov implementuje všetky príslušné bezpečnostné opatrenia na zabezpečenie ochrany a dôvernosti osobných údajov, medzi ktoré patria:
                                <br>
                                <ol>
                                    <li>Silné zásady hesiel na všetkých serveroch</li>
                                    <li>Protokol HTTPS na interakciu s API a webovými klientmi</li>
                                    <li>Protokol SSH na pripojenie k serveru</li>
                                    <li>Pravidelné aktualizácie servera s najnovším zabezpečením opravy</li>
                                </ol>

                                <br><br>
                                <b>7.2</b> Upozorňujeme, že s údajmi zadanými Používateľom nakladajú iba osobitne poverení zamestnanci Prevádzkovateľa, ktorí konajú na základe poverenia Prevádzkovateľa a len na jeho pokyn, ako aj príjemcovia, ak je to potrebné. Na spracovanie si Správca údajov vyberá osoby s primeranou kvalifikáciou, ktoré majú dostatočné záruky, pokiaľ ide o technické znalosti a osobnú integritu na ochranu dôvernosti. Správca údajov prijíma všetky potrebné bezpečnostné opatrenia na ochranu a zabezpečenie utajenia, dôvernosti a integrity osobných údajov aj prostredníctvom príslušných zmluvných záväzkov svojich spolupracovníkov. V každom prípade môže dôjsť k narušeniu bezpečnosti webovej stránky z dôvodov, ktoré sa nachádzajú mimo sféry kontroly správcu údajov, ako aj z dôvodu technického alebo iného problému siete alebo vyššej moci alebo náhodných skutočností. V takom prípade nie je možné zaručiť bezpečnosť osobných údajov.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">8. Kto sú príjemcovia údajov?</h2>
                                <b>8.1</b> Príjemcami osobných údajov Používateľa sú pridružené spoločnosti, ktoré zabezpečujú technickú infraštruktúru pre prevádzku Webovej stránky, poskytovateľ hostingu ako aj spoločnosť, ktorá sa zaväzuje zasielať Používateľom elektronickú komunikáciu súvisiacu s prevádzkou Platformy. Ak je to potrebné v súlade s platnými zákonmi, prevádzkovateľ údajov podpíše s takýmito spoločnosťami zmluvy, ktoré sa týkajú implementácie a pravidelného monitorovania bezpečnostných opatrení. V prípade prenosu údajov mimo EÚ existujú všetky potrebné záruky.
                                <br><br>
                                <b>8.2.</b> V prípade, že prevádzkovateľ dostane žiadosť o oznámenie alebo prenos údajov na základe žiadosti príslušného správneho orgánu, advokáta, súdu alebo iného orgánu, môže tieto údaje oznámiť/preniesť, aby splnil svoju povinnosť vykonanú v prospech verejného záujmu voči týmto oprávneniam (s predchádzajúcim upozornením používateľa alebo bez neho) v súlade s príslušnými zákonnými ustanoveniami. Ak by mal byť používateľ vopred upozornený v súlade s právnymi ustanoveniami, používateľ má právo namietať proti tomuto spracovaniu, ako je uvedené v článku 7 vyššie.
                                <br><br>
                                <b>8.3</b> Pokiaľ ide o profesionálne údaje každého Používateľa, sú k dispozícii všetkým registrovaným Používateľom Platformy na účely uvedené vyššie.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">9. Komunikácia s prevádzkovateľom údajov</h2>
                                <b>9.1.</b> V prípade akéhokoľvek problému súvisiaceho s týmito zásadami ochrany osobných údajov, spracovaním údajov Používateľa, ako aj s výkonom práv Používateľa, môže Používateľ kontaktovať Prevádzkovateľa údajov jedným z nasledujúcich spôsobov: <br>
                                Telefón: +3222905845, <br>
                                E-mail: info(at)ecas.org
                                <br><br>
                                V prípade, že Používateľ sa dozvie o akomkoľvek incidente narušenia údajov, žiadame ho, aby o tom bezodkladne informoval správcu údajov.
                                <br><br>
                                <b>9.2.</b> Tieto podmienky sa riadia a dopĺňajú Obchodnými podmienkami a tvoria spolu s nimi jednotný text.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">10. Prepojenie s inými webovými stránkami/sociálnymi médiami</h2>
                                Táto webová stránka sa spája s inými webovými stránkami prostredníctvom hypertextových odkazov. Tieto webové stránky nesúvisia s webovou stránkou správcu údajov a ich obsah správca údajov nekontroluje ani neodporúča. Správnosť, oprávnenosť, úplnosť alebo kvalitu ich obsahu a oprávnenosť spracúvania osobných údajov Používateľa tak nie je možné kontrolovať a neposkytuje sa na ne záruka. Správca údajov nezodpovedá za ne ani za žiadnu škodu, ktorá môže byť Používateľovi spôsobená v dôsledku ich používania alebo po ich používaní. Správca údajov nemôže kontrolovať spracúvanie osobných údajov používateľa týmito prepojenými webovými stránkami, a preto nenesie žiadnu zodpovednosť. Keď Používateľ pristupuje na tieto webové stránky, mal by vziať do úvahy, že platia zmluvné podmienky každej webovej lokality. V prípade akéhokoľvek problému, ktorý sa môže vyskytnúť v súvislosti s obsahom alebo používaním prepojenej webovej stránky, by sa mal používateľ obrátiť priamo na prevádzkovateľa alebo správcu každej webovej lokality. Správca údajov neschvaľuje ani neprijíma obsah alebo služby prepojených webových stránok, ku ktorým používateľ pristupuje prostredníctvom webovej stránky.<br><br>
                                Webová stránka dáva Používateľovi možnosť pripojiť sa a interagovať so sociálnymi médiami na základe vlastnej iniciatívy a vôle. V takom prípade Správca údajov nezodpovedá za spracovanie údajov Používateľa, ktoré prebieha prostredníctvom sociálnych médií alebo prostredníctvom nich. Používateľ by sa mal priamo obrátiť na každé konkrétne sociálne médium, aby mohol uplatniť svoje legitímne práva.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">11. Súbory cookie</h2>
                                11.1. Platforma používa cookies, aby bola funkčná alebo efektívnejšia pri svojej prevádzke, aby zlepšila navigáciu Používateľa, poskytla Používateľovi plný potenciál Platformy, zabezpečila správne zobrazenie obsahu, ako aj na analytické a štatistické účely.
                                <br><br>
                                11.2. Cookies sú malé textové súbory uložené v počítači Používateľa pri návšteve digitálnej platformy, ktoré sa používajú ako prostriedok na identifikáciu jeho počítača.
                                <br><br>
                                11.3. Súbory cookie okrem absolútne nevyhnutných súborov cookie sa inštalujú iba vtedy, ak používateľ pri návšteve tejto platformy akceptuje ich inštaláciu. Akceptovaním cookies pri vstupe na túto platformu užívateľ výslovne prehlasuje, že si prečítal a porozumel špecifickým podmienkam týkajúcim sa inštalácie, funkcie a účelu cookies a že dáva súhlas s ich používaním.
                                <br><br>
                                11.4. Používateľ tiež nemusí akceptovať súbory cookie. V tomto prípade sa nainštalujú iba cookies, ktoré sú technicky a funkčne nevyhnutné pre fungovanie Platformy.
                                <br><br>
                                11.5. Používateľ môže spravovať používanie a inštaláciu cookies kedykoľvek prostredníctvom panela, kde si môže zvoliť, ktorú kategóriu cookies chce akceptovať a ktoré nie (alebo požiadať o inštaláciu len technicky nevyhnutných cookies).
                                <br><br>
                                11.6. Platforma používa najmä tieto cookies:
                                <br><br>

                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Typ cookies</th>
                                        <th>Vysvetlenie</th>
                                        <th>Príklady cookies</th>
                                        <th>Trvanie každej inštalácie cookies</th>
                                        <th>Prenos údajov tretím stranám</th>
                                    </tr>
                                    <tr>
                                        <td>Absolútne nevyhnutné Cookies</td>
                                        <td>Absolútne nevyhnutné cookies sú nevyhnutné pre správne fungovanie platformy. Tieto súbory cookie umožňujú používateľovi prehliadať a používať funkcie platformy, ako je napríklad prístup do zabezpečených oblastí. Tieto cookies nerozpoznávajú individuálnu identitu Používateľa a bez nich nie je možné bezproblémové fungovanie Platformy.
                                        </td>
                                        <td>crowdsourcing_app_cookies_consent_selection (Ukladá stav súhlasu používateľa so súbormi cookie pre aktuálnu doménu)
                                            <br><br>
                                            crowdsourcing_app_cookies_consent_targeting (Ukladá stav súhlasu používateľa so súbormi cookie pre aktuálnu doménu)
                                            <br><br>
                                            XSRF-TOKEN (Zabezpečuje bezpečnosť prehliadania návštevníka tým, že zabraňuje falšovaniu požiadaviek medzi stránkami. Tento súbor cookie je nevyhnutný pre bezpečnosť webovej lokality a návštevníka. )
                                            <br><br>
                                            ecas_lets_crowdsource_our_future_session (Keď to aplikácia potrebuje „zapamätať si“ prihláseného používateľa, kým (s) prechádza na platformu)
                                            <br><br>
                                            Crowdsourcing_anonymous_user_id (používa sa na ukladanie anonymných odpovedí na dotazníky priradením celého čísla používateľovi, ktorý odosiela odpoveď)
                                        </td>
                                        <td>1 rok
                                            <br><br>
                                            <br><br>
                                            1 deň
                                            <br><br>
                                            <br><br>
                                            Relácia
                                            <br><br>
                                            <br><br>
                                            5 rokov
                                        </td>
                                        <td>Nie
                                            <br><br>
                                            <br><br>

                                            Nie
                                            <br><br>
                                            <br><br>

                                            Nie
                                            <br><br>
                                            <br><br>

                                            Nie
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Štatistiky/analytické súbory cookie</td>
                                        <td>Ide o súbory cookie, ktoré vyhodnocujú spôsob, akým návštevníci používajú platformu (napríklad, ktoré stránky sú navštevované častejšie a či z webových stránok dostávajú chybové hlásenia). Tieto súbory cookie sa používajú na štatistické účely a na zlepšenie výkonu platformy.
                                        </td>
                                        <td>_ga_4S9N5MK4VE, _gat,_ga, _gcl_au, _gid: Súbory cookie Google Analytics sa používajú na meranie návštevnosti na platforme. Ukladá sa jedinečný textový reťazec na identifikáciu prehliadača, časovej pečiatky pre interakcie a prehliadača/zdrojovej stránky, ktorá používateľa priviedla na platformu. Neukladajú sa žiadne citlivé informácie.

                                        </td>
                                        <td>_ga_4S9N5MK4VE: 2 roky
                                            <br><br>
                                            _gat:1 minúta
                                            <br><br>
                                            _ga:2 roky
                                            <br><br>
                                            _gcl_au:3 mesiace
                                            <br><br>
                                            _gid:24 hodín
                                        </td>
                                        <td>Áno (Spoločnosť, ktorá poskytuje štatistické a analytické služby, ak je považovaná za tretiu stranu)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">12. Súkromie detí </h2>
                                Náš projekt neoslovuje nikoho mladšieho ako 18 rokov ("Deti"). Vedome nezhromažďujeme osobné údaje od nikoho mladšieho ako 18 rokov. Ak ste rodič alebo opatrovník a viete, že vaše deti nám poskytli osobné údaje, kontaktujte nás. Ak zistíme, že sme zhromaždili osobné údaje od detí bez overenia súhlasu rodičov, podnikneme kroky na odstránenie týchto informácií z našich serverov.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">13. Dodatky k týmto Zásadám ochrany osobných údajov</h2>
                                Prevádzkovateľ si vyhradzuje právo zmeniť tieto Zásady ochrany osobných údajov, napríklad ak je to potrebné na splnenie nových požiadaviek uložených platnými zákonmi, usmerneniami alebo technickými požiadavkami, alebo v priebehu revízie Procesov a postupov správcu údajov. Používateľ bude informovaný o akejkoľvek zmene Zásad ochrany osobných údajov prostredníctvom platformy. Používateľ by mal pravidelne kontrolovať Zásady ochrany osobných údajov a najmä to,či sa v nich nenachádzajú nejaké zmeny.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
