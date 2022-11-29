@extends('home.layout')

@section('content')

    <div class="container pt-4 mb-2" style="margin-top: 100px">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>PRIVĀTUMA POLITIKA</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                Šī Privātuma politika attiecas uz visiem Platformas lietotājiem (turpmāk tekstā
                                <b>“Lietotāji”</b> vai <b>“Lietotājs”</b> un <b>“Platforma”</b>) un ir Platformas Vietnes
                                noteikumu un nosacījumu neatņemama sastāvdaļa. Šī Privātuma politika sniedz Lietotājam
                                vispārīgu informāciju par to, kā Datu pārzinis izmanto jūsu personas datus, un citu
                                informāciju, ko pieprasa datu aizsardzības tiesību akti. Nākotnes grozījumu gadījumā
                                Lietotājam tiks nodrošināti nepieciešamie atjauninājumi un informācija, izmantojot šīs
                                Privātuma politikas atjauninājumu, kas augšupielādēts Platformā.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">1. Kas ir Datu pārzinis?</h2>
                            </div>
                            <div class="col-12">
                                <b>1.1.</b> Uzņēmums ar uzņēmuma nosaukumu “{{ config("app.installation_company_name") }}”, adrese: {{ config("app.installation_company_address") }}, Tālrunis: {{ config("app.installation_company_phone") }}, e-pasts:
                                {{ config("app.installation_company_email") }}, ir Datu pārzinis Lietotāja personas datu apstrādei (turpmāk tekstā <b>"Datu
                                    pārzinis"</b>).
                                <br><br>
                                <b>1.2. Datu pārziņa kontaktinformācija:</b> Ja rodas problēmas vai bažas saistībā ar šo
                                Privātuma politiku un Lietotāja personas datu apstrādi vai Lietotāja augšupielādētajiem
                                datiem, lai izmantotu Platformu, Lietotājs var sazināties ar Datu pārzini, izmantojot kādu
                                no šīm alternatīvām:
                                <br><br>
                                Zvanot pa tālruni {{ config("app.installation_company_phone") }}, no pirmdienas līdz piektdienai no 10.00 līdz 18.00 EET
                                (Austrumeiropas laiks)
                                <br>
                                Nosūtot e-pastu uz šādu e-pasta adresi: {{ config("app.installation_company_email") }}<br>
                                Nosūtot korespondenci uz šādu adresi: {{ config("app.installation_company_address") }}<br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">2. Kāds ir Lietotāja datu apstrādes mērķis un tiesiskais pamats?</h2>
                                <b>2.1.</b> Platformas darbības mērķis ir apkopot lietotāju viedokļus, izmantojot anketas. Viedokļi tiek apstrādāti, lai gūtu ieskatu, apkopotu un prezentētu vērtīgas idejas un ieteikumus par anketās apskatītajiem tematiem. Lietotāji var atbildēt anonīmi (nesniedzot nekādu personisko informāciju) vai arī brīvprātīgi reģistrēties, lai iesniegtu eponīmiskas atbildes, norādot e-pastu un lietotāja vārdu. Lietotāju atbildes tiek tulkotas angļu valodā un tiek parādītas pārskatos. Konkrētajam apstrādes mērķim tiesiskais pamats ir Lietotāja iepriekšēja piekrišana.
                                <br><br>
                                <b>2.2.</b> Sūtīt Lietotājam informatīvus e-pastus ar mērķi informēt viņu par jaunām aktivitātēm, projektiem un citiem Platformas interesējošiem jautājumiem. Šim apstrādes mērķim tiesiskais pamats ir Lietotāja iepriekšēja piekrišana.
                                <br><br>
                                <b>2.3</b> Datu apstrāde saistībā ar Datu pārziņa juridisko pienākumu izpildi. Šādos gadījumos datu apstrāde notiek tikai tik ilgi, cik nepieciešams, lai Datu pārzinis ievērotu dažādu tiesību normu uzliktos pienākumus.
                                <br><br>
                                <b>Iepriekšminēto noteikumu gadījumā, ja tiesiskais pamats ir Lietotāja iepriekšēja piekrišana, Lietotājs vienmēr var atsaukt savu piekrišanu jebkurā laikā, neietekmējot pirms piekrišanas atsaukšanas apstrādāto datu likumību.</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">3. Iegūstamo datu veidi</h2>

                                <h3 class="mt-4 mb-4">3.1 Personas dati</h3>
                                <b>3.1.1 Reģistrācija — konta izveide:</b><br>
                                Lai Lietotājs brīvprātīgi varētu izveidot kontu Platformā, Lietotājam ir jāievada nepieciešamie dati: savs lietotāja vārds, e-pasta adrese un parole.
                                <br><br>
                                <b>3.1.2 Iesniegtās atbildes uz anketas jautājumiem</b><br>
                                Platforma apkopo Lietotāja atbildes (proti, viedokļus par dažādiem tematiem) uz jautājumiem, kas uzdoti, izmantojot Platformas anketas. Šīs atbildes tiek analizētas un parādītas anketas rezultātu lapā. Lietotājam tiek stingri ieteikts ievērot platformas “uzvedības kodeksu veiksmīgai dalībai” un izvairīties no jebkādu personas datu publiskošanas, kuru publisku pieejamību Platformā tas nevēlas.
                                <br><br>
                                <b>3.1.3. Platformas komunikācija tādu iemeslu dēļ, kas saistīti ar Lietotāja atļauto Platformas lietošanu.</b>
                                <br>
                                Lai Platforma varētu sazināties ar Lietotāju iepriekšminētajiem nolūkiem, Datu pārzinis var apstrādāt visus datus, kas attiecas uz Lietotāja kontu, augšupielādēto saturu un datus, kas saistīti ar Lietotāja Platformas lietošanu.
                                <h3 class="mt-4 mb-4">3.2 Lietojuma dati</h3>
                                Mēs varam iegūt informāciju arī par to, kā tīmekļa vietnei tiek piekļūts un kā tā tiek lietota (turpmāk tekstā “Lietojuma dati”). Šie Lietojuma dati var ietvert tādu informāciju kā Jūsu datora interneta protokola adrese (piemēram, IP adrese), pārlūkprogrammas veids, pārlūkprogrammas versija, Jūsu apmeklētās tīmekļa vietnes lapas, Jūsu apmeklējuma laiks un datums, lapās pavadītais laiks, unikālie ierīču identifikatori un citi diagnostikas dati.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4"> 4. Kā Platforma apkopo datus</h2>
                                4.1 Informāciju var apkopot šādos veidos: <br>
                                4.1.1 Kad Lietotājs reģistrējas un izveido kontu Platformā. <br>
                                4.1.2 Kad Lietotājs iesniedz atbildes Platformas anketās <br>
                                4.1.3 Kad Lietotājs apmeklē Platformu un piekrīt sīkdatņu instalēšanai (saskaņā ar Platformas sīkdatņu politiku 11. punktā turpmāk tekstā) un Lietotāja personas datu, piemēram, IP adreses, operētājsistēmas, pārlūkprogrammas sērijas un veida utt., apkopošanai.
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">5. Cik ilgi Lietotāja dati tiek glabāti un kad tie tiek dzēsti?
                                </h2>
                                <b>5.1. Lietotāja konta dati:</b><br>
                                Neskarot turpmāk minētās Lietotāja dzēšanas tiesības/tiesības tikt aizmirstam, Lietotāja kontā reģistrētie un glabātie Dati tiks glabāti tik ilgi, kamēr Lietotājs vēlēsies izmantot Platformu iepriekšminētajam mērķim. Ja Lietotājs vēlas dzēst savu kontu, viņš var to izdarīt, izmantojot konta iestatījumus vai sazinoties ar Datu pārzini, izmantojot iepriekšminēto kontaktinformāciju.
                                <br><br>
                                <b>5.2. Platformas komunikācija tādu iemeslu dēļ, kas saistīti ar Lietotāja atļauto Platformas lietošanu.</b><br>
                                Ar šādu saziņu saistītie dati tiks glabāti tikai tik ilgi, kamēr Lietotājs vēlēsies izmantot Platformu un saglabās savu kontu. Ja Lietotājs vēlas dzēst savu kontu, viņš var to izdarīt, izmantojot konta iestatījumus vai sazinoties ar Datu pārzini, izmantojot iepriekšminēto kontaktinformāciju.
                                <b>5.3. Statistiskā analīze Vietnes optimizācijai</b><br>
                                Neatkarīgi no iepriekšminētajiem 5. punkta noteikumiem, Datu pārzinis uzglabās un apstrādās tikai nepieciešamos datus tik ilgi, cik nepieciešams, lai katru reizi izpildītu likumā noteiktās saistības (fiskālo saistību izpilde utt.).
                                <br><br>
                                <b>5.4. Personas datu apstrāde statistiskās analīzes veikšanas nolūkos.</b><br>
                                Lūdzu, skatiet sīkdatņu politiku (11. punktā) turpmāk tekstā.
                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">6. Kādas ir Lietotāja tiesības attiecībā uz viņa datu apstrādi un kā viņš var šīs tiesības izmantot?</h2>
                                <b>6.1</b> Datu pārzinis ievēro Lietotāja tiesības attiecībā uz datu apstrādi.
                                <br><br>
                                <b>6.2</b> Lietotājs var īstenot savas tiesības, sazinoties ar Datu pārzini, izmantojot šādu kontaktinformāciju: Tālrunis: {{ config("app.installation_company_phone") }}, e-pasts: {{ config("app.installation_company_email") }}
                                <br><br>
                                Lietotāja ērtībai Lietotāja tiesības ir iekļautas šajā tabulā kopā ar īsu skaidrojumu par katru no tiesībām (atsauce uz punktiem atbilst VDAR 2016/679 pantam):
                                <br><br>
                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Tiesības</th>
                                        <th>Paskaidrojums</th>
                                    </tr>
                                    <tr>
                                        <td>Piekļuve (15. pants)</td>
                                        <td>
                                            Lietotājs var lūgt Datu pārzinim:
                                            <ul>
                                                <li>apstiprināt, vai Datu pārzinis apstrādā Lietotāja personas datus
                                                </li>
                                                <li>dot Lietotājam piekļuvi datiem, no kuriem Lietotājs neatbrīvojas</li>
                                                <li>sniegt Lietotājam citu ar Lietotāja personas datiem saistītu informāciju, piemēram, kādi ir dati, kurus Datu pārzinis apstrādā, kādi ir apstrādes mērķi, kam šie dati tiek izpausti, vai šie dati tiek nodoti ārvalstīs un kā šie dati tiek aizsargāti, cik ilgi dati tiek glabāti, kādas ir Lietotāja tiesības, kā var iesniegt sūdzību, no kurienes ir ņemti dati, ciktāl šī informācija nav iekļauta šajā Privātuma politikā.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Labošana un dzēšana (16. pants)</td>
                                        <td>
                                            Lietotājs var lūgt Datu pārzinim izlabot neprecīzos personas datus.<br><br>
                                            Datu pārzinis var censties pārbaudīt datu pareizību pirms to labošanas.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tiesības uz dzēšanu (tiesības “tikt aizmirstam”) (17. pants)</td>
                                        <td>
                                            Lietotājs var lūgt Datu pārzinim dzēst viņa personas datus:<br><br>
                                            <ul>
                                                <li>kad personas dati vairs nav nepieciešami saistībā ar nolūkiem, kādiem tie tika vākti
                                                </li>
                                                <li>kad Lietotājs atsauc savu piekrišanu</li>
                                                <li>personas dati tika apstrādāti nelikumīgi</li>
                                            </ul>
                                            <br><br>
                                            Datu pārzinim nav pienākuma izpildīt Lietotāja lūgumu dzēst viņa personas datus, ja Lietotāja personas datu apstrāde ir nepieciešama:
                                            <ul>
                                                <li>lai izpildītu juridisku pienākumu</li>
                                                <li>cita likumīgā mērķa vai cita likumīgā tiesiska pamata izpildei
                                                </li>
                                                <li>lai celtu, īstenotu vai aizstāvētu likumīgas prasības</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tiesības ierobežot apstrādi (18. pants)</td>
                                        <td>

                                            Lietotājs var lūgt Datu pārzinim ierobežot (uzglabāt, bet neapstrādāt) Lietotāja personas datus, ja:<br><br>
                                            to pareizība tiek apstrīdēta (skatīt labojumu), lai Datu pārzinis varētu pārbaudīt personas datu pareizību vai<br><br>
                                            personas dati ir apstrādāti nelikumīgi, bet Lietotājs iebilst pret personas datu dzēšanu vai<br><br>
                                            tie vairs nav nepieciešami mērķiem, kādiem tie tika apkopoti, bet Lietotājam tie joprojām ir nepieciešami juridisku prasību izvirzīšanai, īstenošanai vai aizstāvēšanai, vai arī pastāv cits likumīgs apstrādes mērķis vai cits juridisks pamats
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Tiesības uz datu pārnesamību (20. pants)
                                        </td>
                                        <td>
                                            Kad apstrāde ir balstīta uz piekrišanu un apstrāde tiek veikta ar automatizētiem līdzekļiem, Lietotājs var lūgt Datu pārzinim saņemt savus personas datus strukturētā, bieži izmantotā un mašīnlasāmā formātā vai lūgt Datu pārzinim tos pārsūtīt citam pārzinim tieši no Datu pārziņa. Tomēr saskaņā ar likumu šīs tiesības attiecas tikai uz tiem datiem, kurus ir sniedzis pats Lietotājs, nevis uz tiem datiem, kurus Datu pārzinis izsecina, pamatojoties uz Lietotāja sniegtajiem datiem.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tiesības iebilst (21. pants)</td>
                                        <td>
                                            Lietotājs jebkurā laikā var iebilst pret viņu personas datu apstrādi, kuras pamatā ir leģitīmas intereses vai sabiedrības interesēs veikta uzdevuma izpilde.<br><br>
                                            Kad Lietotājs izmanto savas tiesības iebilst, Datu pārzinim ir tiesības pierādīt, ka apstrādei ir pārliecinoši leģitīmi iemesli, kas ir svarīgāki par Lietotāja interesēm, tiesībām un brīvībām, vai lai celtu, īstenotu vai aizstāvētu likumīgas prasības.

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Piekrišanas atsaukšana (atteikšanās)
                                        </td>
                                        <td>
                                            Lietotājam ir tiesības atsaukt savu piekrišanu, ja piekrišana ir apstrādes pamatā. Atsaukšana ir derīga nākotnē.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Uzraudzības iestāde
                                        </td>
                                        <td>
                                            Lietotājam ir tiesības iesniegt sūdzību vietējai uzraudzības iestādei saistībā ar datu aizsardzību. <br><br>
                                            Grieķijā datu aizsardzības uzraudzības iestāde ir datu aizsardzības iestāde https://www.dpa.gr/

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identitāte</td>
                                        <td>Datu pārzinis nopietni izturas pret visu datņu, kas satur personas datus, konfidencialitāti, tāpēc viņam ir tiesības lūgt Lietotājam pierādīt viņa identitāti, ja Lietotājs iesniedz pieprasījumu saistībā ar šīm datnēm.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Izmaksas</td>
                                        <td>Lietotājam nebūs jāmaksā par savu tiesību izmantošanu attiecībā uz personas datiem, ja vien likumā noteiktajā kārtībā pieprasījums iegūt piekļuvi informācijai ir nepamatots vai pārmērīgs. Tādā gadījumā Datu pārzinis var iekasēt no Lietotāja saprātīgu samaksu konkrētajos apstākļos. Datu pārzinis informēs Lietotāju par jebkuru iespējamo maksu, pirms viņš izpilda pieprasījumu.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Grafiks</td>
                                        <td>Datu pārzinis uz Lietotāja pamatotiem pieprasījumiem cenšas atbildēt ne vēlāk kā viena (1) mēneša laikā no to saņemšanas, ja vien pieprasījums nav īpaši sarežģīts vai Lietotājs ir iesniedzis vairākus pieprasījumus, tādā gadījumā Datu pārzinis cenšas uz tiem atbildēt trīs mēnešu laikā. Gadījumā, ja Datu pārzinim iepriekšminēto iemeslu dēļ nepieciešams vairāk nekā viens mēnesis, viņš informēs Lietotāju. Datu pārzinis var jautāt Lietotājam, vai viņš vēlas paskaidrot, ko tieši viņš vēlas saņemt vai kādas ir viņa bažas. Tas palīdzēs Datu pārzinim ātrāk rīkoties saistībā ar Lietotāja pieprasījumu. Jebkurā gadījumā Lietotājam ir jānorāda konkrēti un patiesi dati un/vai fakti, lai Datu pārzinis varētu atbildēt un/vai precīzi apmierināt Lietotāja pieprasījumu. Pretējā gadījumā Datu pārzinis patur tiesības uz jebkādām kļūmēm, kas ir ārpus viņa kontroles. Turklāt Datu pārzinis var noraidīt pieprasījumus, kas ir nepamatoti, pārmērīgi, aizskaroši, negodprātīgi vai tiesību normu ietvaros neleģitīmi.
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">7. Kā tiek nodrošināta datu drošība?</h2>
                                <b>7.1</b> Datu pārzinis īsteno visus atbilstošos drošības pasākumus, lai nodrošinātu personas datu aizsardzību un konfidencialitāti, tostarp:
                                <br>
                                <ol>
                                    <li>Spēcīgas paroles politikas visos serveros</li>
                                    <li>HTTPS protokols mijiedarbībai ar API un tīmekļa klientiem</li>
                                    <li>SSH protokols savienojumam ar serveri</li>
                                    <li>Periodiski servera atjauninājumi ar jaunākajiem drošības uzlabojumiem</li>
                                </ol>

                                <br><br>
                                <b>7.2</b> Lūdzam ņemt vērā, ka ar Lietotāja iesniegtos datus apstrādā tikai īpaši pilnvaroti Datu pārziņa darbinieki, kas darbojas Datu pārziņa pakļautībā un tikai pēc viņa norādījumiem, kā arī saņēmēji, ja nepieciešams. Datu pārzinis apstrādei izvēlas personas ar atbilstošu kvalifikāciju, kas var sniegt pietiekamas garantijas attiecībā uz tehniskajām zināšanām un personas godprātīgumu, lai aizsargātu konfidencialitāti. Datu pārzinis veic visus nepieciešamos drošības pasākumus, lai aizsargātu un nodrošinātu personas datu neizpaušanu, konfidencialitāti un integritāti, arī izmantojot attiecīgās viņa partneru līgumsaistības. Jebkurā gadījumā Vietnes drošība var tikt pārkāpta tādu iemeslu dēļ, kas ir ārpus Datu pārziņa kontroles sfēras, kā arī tehnisku vai citu tīkla problēmu vai nepārvaramas varas vai nejaušu faktu dēļ. Tādā gadījumā nevar garantēt personas datu drošību.

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">8. Kas ir datu saņēmēji?</h2>
                                <b>8.1.</b> Lietotāja personas datu saņēmēji ir saistītie uzņēmumi, kas nodrošina Vietnes darbības tehnisko infrastruktūru, mitināšanas nodrošinātājs, kā arī uzņēmums, kas apņemas nosūtīt Lietotājiem elektronisko saziņu, kas saistīta ar Platformas darbību. Nepieciešamības gadījumā saskaņā ar spēkā esošajiem tiesību aktiem Datu pārzinis slēgs līgumus ar šādiem uzņēmumiem, kas saistīti ar drošības pasākumu ieviešanu un regulāru uzraudzību. Gadījumā, ja dati tiek pārsūtīti ārpus ES, ir visas nepieciešamās garantijas.
                                <br><br>
                                <b>8.2.</b> Ja Datu pārzinis saņem pieprasījumu paziņot vai pārsūtīt datus pēc attiecīgās administratīvās iestādes, advokāta, tiesas vai citas iestādes pieprasījuma, viņš var paziņot/pārsūtīt šos datus, lai izpildītu savu pienākumu, kas veikts sabiedrības interesēs pret šīs iestādes (ar vai bez Lietotāja iepriekšēja paziņojuma) saskaņā ar attiecīgajām tiesību normām. Ja Lietotājs ir iepriekš jābrīdina saskaņā ar tiesību normām, Lietotājam ir tiesības iebilst pret šo apstrādi, kā noteikts 7. punktā iepriekš.
                                <br><br>
                                <b>8.3.</b> Katra Lietotāja profesionālā informācija ir pieejama visiem reģistrētajiem Platformas lietotājiem iepriekšminētajos nolūkos.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">9. Saziņa ar datu pārzini</h2>
                                <b>9.1.</b> Par jebkuru jautājumu, kas saistīts ar šo privātuma politiku, Lietotāja datu apstrādi, kā arī Lietotāja tiesību īstenošanu, Lietotājs var sazināties ar Datu pārzini, izmantojot vienu no šiem veidiem: <br>
                                Tālrunis: {{ config("app.installation_company_phone") }}, <br>
                                E-pasts: {{ config("app.installation_company_email") }}
                                <br><br>
                                Gadījumā, ja Lietotājs uzzina par jebkādu datu pārkāpuma incidentu, viņš tiek lūgts nekavējoties par to informēt Datu pārzini.
                                <br><br>
                                <b>9.2.</b> Šos noteikumus regulē un papildina Noteikumi un nosacījumi, un tie kopā ar tiem veido vienotu tekstu.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">10. Savienojums ar citām vietnēm/sociālajiem medijiem</h2>
                                Šī Vietne savienojas ar citām vietnēm, izmantojot hipersaites. Šīs vietnes nav saistītas ar Datu pārziņa vietni, un to saturu Datu pārzinis nepārbauda un neiesaka. Tādējādi to satura precizitāti, likumību, pilnīgumu vai kvalitāti un Lietotāja personas datu apstrādes likumību nevar pārbaudīt un par tiem netiek sniegta nekāda garantija. Datu pārzini nevar saukt pie atbildības par tiem vai jebkādiem zaudējumiem, kas var tikt nodarīti Lietotājam to izmantošanas dēļ vai pēc tās. Datu pārzinis nevar pārbaudīt Lietotāja personas datu apstrādi šajās saistītajās Vietnēs un tādējādi neuzņemas nekādu atbildību. Kad Lietotājs piekļūst šīm vietnēm, viņam jāņem vērā, ka tiek piemēroti katras vietnes noteikumi un nosacījumi. Par jebkuru problēmu, kas var rasties attiecībā par saistītās vietnes saturu vai lietošanu, Lietotājam ir tieši jāsazinās ar katras Vietnes operatoru vai administratoru. Datu pārzinis neapstiprina un neatbalsta saistīto vietņu Saturu vai pakalpojumus, kuriem Lietotājs piekļūst, izmantojot Vietni.<br><br>
                                Vietne sniedz Lietotājam iespēju izveidot savienojumu un mijiedarboties ar sociālajiem medijiem pēc paša iniciatīvas un gribas. Tādā gadījumā Datu pārzinis nav atbildīgs par Lietotāja datu apstrādi, kas notiek ar sociālo mediju starpniecību vai tajos. Lietotājam ir tieši jāvēršas katrā konkrētajā sociālajā medijā, lai īstenotu savas likumīgās tiesības.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">11. Sīkdatnes</h2>
                                11.1. Platforma izmanto sīkdatnes, lai nodrošinātu pareizu vai efektīvāku darbību, lai uzlabotu Lietotāja navigāciju, sniegtu Lietotājam visas Platformas funkcionalitātes, nodrošinātu pareizu satura attēlošanu, kā arī analītiskiem un statistikas nolūkiem.
                                <br><br>
                                11.2. Sīkdatnes ir nelielas teksta datnes, kas tiek saglabātas Lietotāja datorā, kad viņš apmeklē digitālo platformu un tiek izmantotas kā līdzeklis datora identificēšanai.
                                <br><br>
                                11.3. Sīkdatnes, izņemot absolūti nepieciešamās sīkdatnes, tiek instalētas tikai tad, ja Lietotājs piekrīt to uzstādīšanai, kad viņš apmeklē šo Platformu. Apstiprinot sīkdatņu apkopošanu pie piekļuves šai Platformai, Lietotājs nepārprotami apliecina, ka ir izlasījis un sapratis konkrētos noteikumus un nosacījumus par sīkdatņu uzstādīšanu, darbību un mērķi un sniedz savu piekrišanu to lietošanai.
                                <br><br>
                                11.4. Lietotājs var arī nepiekrist sīkdatņu apkopošanai. Šādā gadījumā tiks instalētas tikai sīkdatnes, kas ir tehniski un funkcionāli nepieciešamas Platformas darbībai.
                                <br><br>
                                11.5. Lietotājs jebkurā laikā var pārvaldīt sīkdatņu izmantošanu un uzstādīšanu, izmantojot paneli, kurā viņš var izvēlēties, kuru sīkdatņu kategoriju viņš vēlas pieņemt un kuras nevēlas (vai pieprasīt instalēt tikai tehniski nepieciešamās sīkdatnes).
                                <br><br>
                                11.6. Konkrēti, Platformas izmantotās sīkdatnes ir šādas:
                                <br><br>

                                <table class="table table-striped table-responsive table-bordered">
                                    <tr>
                                        <th>Sīkdatņu veids</th>
                                        <th>Paskaidrojums</th>
                                        <th>Sīkdatņu piemēri</th>
                                        <th>Katras sīkdatnes uzstādīšanas ilgums</th>
                                        <th>Datu nodošana trešajām personām</th>
                                    </tr>
                                    <tr>
                                        <td>Absolūti nepieciešamās sīkdatnes</td>
                                        <td>Absolūti nepieciešamās sīkdatnes ir būtiskas pareizai Platformas darbībai. Šīs sīkdatnes ļauj Lietotājam pārlūkot un izmantot platformas funkcijas, piemēram, piekļuvi drošām zonām. Šīs sīkdatnes neatpazīst Lietotāja individuālo identitāti un bez tām nav iespējama vienmērīga Platformas darbība.
                                        </td>
                                        <td>crowdsourcing_app_cookies_consent_selection sīkdatņu izmantošanai (saglabā lietotāja sīkdatņu piekrišanas stāvokli pašreizējam domēnam)
                                            <br><br>
                                            crowdsourcing_app_cookies_consent_targeting sīkdatņu izmantošanai (saglabā lietotāja sīkdatņu piekrišanas stāvokli pašreizējam domēnam)
                                            <br><br>
                                            XSRF-TOKEN (Nodrošina apmeklētāja pārlūkošanas drošību, novēršot starpvietņu pieprasījumu viltošanu. Šī sīkdatne ir būtiska vietnes un apmeklētāja drošībai.)
                                            <br><br>
                                            ecas_lets_crowdsource_our_future_session (Kad lietotnei ir “jāatceras” pieteicies Lietotājs, kamēr viņš(-i) piekļūst Platformai)
                                            <br><br>
                                            Crowdsourcing_anonymous_user_id (izmanto anonīmu atbilžu glabāšanai anketās, piešķirot veselu skaitli Lietotājam, kurš iesniedz atbildi)
                                        </td>
                                        <td>1 gads
                                            <br><br>
                                            <br><br>
                                            1 diena
                                            <br><br>
                                            <br><br>
                                            Sesija
                                            <br><br>
                                            <br><br>
                                            5 gadi
                                        </td>
                                        <td>Nr.
                                            <br><br>
                                            <br><br>

                                            Nr.
                                            <br><br>
                                            <br><br>

                                            Nr.
                                            <br><br>
                                            <br><br>

                                            Nr.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Statistikas/analītiskās sīkdatnes</td>
                                        <td>Tās ir sīkdatnes, kas novērtē, kā apmeklētāji izmanto Platformu (piemēram, kuras lapas tiek apmeklētas biežāk un vai viņi saņem kļūdu ziņojumus no tīmekļa lapām). Šīs sīkdatnes tiek izmantotas statistikas nolūkos un platformas darbības uzlabošanai.
                                        </td>
                                        <td>_ga_4S9N5MK4VE, _gat,_ga, _gcl_au, _gid: Google Analytics sīkdatnes tiek izmantotas, lai izmērītu trafiku Platformā. Tiek saglabāta unikāla teksta virkne, lai identificētu pārlūkprogrammu, mijiedarbības laikspiedolu un pārlūkprogrammu/avota lapu, kas novirzīja Lietotāju uz Platformu. Sensitīva informācija netiek saglabāta.

                                        </td>
                                        <td>_ga_4S9N5MK4VE: 2 gadi
                                            <br><br>
                                            _gat:1 minūte
                                            <br><br>
                                            _ga:2 gadi
                                            <br><br>
                                            _gcl_au:3 mēneši
                                            <br><br>
                                            _gid:24 stundas
                                        </td>
                                        <td>Jā (Uzņēmums, kas sniedz statistikas un analītiskos pakalpojumus, ja tiek uzskatīts par trešo pusi)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">12. Bērnu privātums </h2>
                                Mūsu projekts nav orientēts uz personām, kuras nav sasniegušas 18 gadu vecumu (turpmāk tekstā ”Bērni”). Mēs apzināti neiegūstam personu identificējošu informāciju par personām, kuras nav sasniegušas 18 gadu vecumu. Ja esat vecāks vai aizbildnis un zināt, ka jūsu bērns ir sniedzis mums Personas datus, lūdzam ar mums sazināties. Ja mēs uzzinām, ka esam ieguvuši Personas datus par bērnu bez vecāku piekrišanas, mēs veicam pasākumus, lai dzēstu šādu informāciju no mūsu serveriem.


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mt-4 mb-4">13. Privātuma politikas grozījumi </h2>
                                Datu pārzinis patur tiesības grozīt šo Privātuma politiku, piemēram, ja tas ir nepieciešams, lai izpildītu jaunas prasības, ko nosaka piemērojamie tiesību akti, vadlīnijas vai tehniskās prasības, vai Datu pārziņa procesu un prakses pārskatīšanas gaitā. Lietotājs tiks informēts par jebkādiem šīs Privātuma politikas grozījumiem, izmantojot Platformu. Lietotājam regulāri jāpārbauda šī Privātuma politika attiecībā uz jebkādiem grozījumiem.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
