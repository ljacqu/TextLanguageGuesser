<?php

function createLanguages() {
  $a = 'asian';
  $b = 'african';
  $c = 'celtic';
  $f = 'finno';
  $s = 'slavic';
  $g = 'germanic';
  $r = 'romance';
  $t = 'turkic';
  $o = 'other';

  // Note: Currently, the entries are sorted by array key, which MUST be two characters
  // and is currently the ISO 639-1 code of the language. Aliases must be in lower case.
  return [
    'af' => lang($g, 'Afrikaans', 'afr'),
    'be' => lang($s, 'Belarusian', 'bel', 'belo', 'bela', 'belorussian', 'belarusan', 'byelorussian'),
    'bg' => lang($s, 'Bulgarian', 'bul'),
    'bn' => lang($a, 'Bengali', 'ben'),
    'br' => lang($c, 'Breton', 'bre'),
    'ca' => lang($r, 'Catalan', 'cat'),
    'cs' => lang($s, 'Czech', 'cz', 'cze'),
    'cy' => lang($c, 'Welsh', 'wel', 'cym'),
    'da' => lang($g, 'Danish', 'dan', 'dk'),
    'de' => lang($g, 'German', 'ger', 'deu', 'deutsch'),
    'el' => lang($o, 'Greek', 'gre', 'ell', 'gr'),
    'eo' => lang($o, 'Esperanto', 'epo'),
    'es' => lang($r, 'Spanish', 'spa', 'espanol'),
    'et' => lang($f, 'Estonian', 'est', 'ee'),
    'eu' => lang($o, 'Basque', 'baq', 'eus', 'bas'),
    'fi' => lang($f, 'Finnish', 'fin'),
    'fo' => lang($g, 'Faroese', 'fao', 'far'),
    'fr' => lang($r, 'French', 'fra', 'fre'),
    'ga' => lang($c, 'Irish', 'gle', 'gaelic', 'iri'),
    'gd' => lang($c, 'Scottish Gaelic', 'gla', 'scottish', 'sga'),
    'hi' => lang($a, 'Hindi', 'hin'),
    'hr' => lang($s, 'Croatian', 'hrv', 'cro'),
    'hu' => lang($f, 'Hungarian', 'hun'),
    'hy' => lang($o, 'Armenian', 'arm', 'hye'),
    'id' => lang($a, 'Indonesian', 'ind'),
    'is' => lang($g, 'Icelandic', 'ice', 'isl'),
    'it' => lang($r, 'Italian', 'ita'),
    'ja' => lang($a, 'Japanese',  'jpn', 'jp', 'jap'),
    'ka' => lang($o, 'Georgian', 'geo', 'kat', 'ge'),
    'kk' => lang($t, 'Kazakh', 'kz', 'kaz', 'kazak'),
    'km' => lang($a, 'Khmer', 'khm', 'kmer'),
    'ko' => lang($a, 'Korean', 'kor'),
    'ky' => lang($t, 'Kyrgyz', 'kir', 'kirgizh', 'kg', 'kyr'),
    'lb' => lang($g, 'Luxembourgish', 'ltz', 'lu', 'lux'),
    'lt' => lang($o, 'Lithuanian', 'lit'),
    'lv' => lang($o, 'Latvian', 'lav', 'lat'),
    'mk' => lang($s, 'Macedonian', 'mac', 'mkd'),
    'mn' => lang($a, 'Mongolian', 'mon', 'mongol', 'mo'),
    'mt' => lang($o, 'Maltese', 'mlt', 'mal'),
    'nb' => lang($g, 'Norwegian', 'nor', 'no'),
    'nl' => lang($g, 'Dutch', 'dut', 'nld'),
    'pl' => lang($s, 'Polish', 'pol'),
    'pt' => lang($r, 'Portuguese', 'por', 'portugese'),
    'rm' => lang($r, 'Romansh', 'roh', 'romansch', 'rumantsch'),
    'ro' => lang($r, 'Romanian', 'rum', 'ron'),
    'ru' => lang($s, 'Russian', 'rus'),
    'sb' => lang($s, 'Sorbian', 'wen', 'sorb'), // no official two-letter code
    'sk' => lang($s, 'Slovak', 'slo', 'slk'),
    'sl' => lang($s, 'Slovene', 'slv', 'slovenian', 'si'),
    'sr' => lang($s, 'Serbian', 'srp', 'ser'),
    'sq' => lang($o, 'Albanian', 'alb', 'sqi', 'al'),
    'sv' => lang($g, 'Swedish', 'swe', 'se'),
    'sw' => lang($b, 'Swahili', 'swa'),
    'th' => lang($a, 'Thai', 'tha'),
    'tl' => lang($a, 'Filipino', 'fil', 'tagalog'),
    'tr' => lang($t, 'Turkish', 'tur'),
    'uk' => lang($s, 'Ukrainian', 'ukr', 'ua'),
    'uz' => lang($t, 'Uzbek', 'uzb'),
    'vi' => lang($a, 'Vietnamese', 'vie', 'vn', 'viet'),
    'xh' => lang($b, 'Xhosa', 'xho', 'xosa', 'isixhosa'),
    'yo' => lang($b, 'Yoruba', 'yor'),
    'zh' => lang($a, 'Chinese', 'chi', 'zho', 'cn'),
    'zu' => lang($b, 'Zulu', 'zul')
  ];
}

function lang($group, $name, ...$aliases): Language {
  return new Language($name, $group, $aliases);
}

function getDemoText($code) {
  // Article 20 of the human rights
  switch ($code) {
    case 'af': return 'Elkeen het die reg tot vryheid van vreedsame vergadering en assosiasie.';
    case 'be': return 'Кожны чалавек мае права на свабоду мірных сходаў і асацыяцый.';
    case 'bg': return 'Всеки човек има право на свобода на мирни събрания и сдружения.';
    case 'bn': return 'প্রত্যেকের‌ই শান্তিপূর্ণ সমাবেশে অংশগ্রহণ ও সমিতি গঠনের স্বাধীনতায় অধিকার রয়েছে।';
    case 'br': return 'Pep den en deus gwir d’ar frankiz d’en em vodañ ha d’en em gevreañ e peoc’h.';
    case 'ca': return 'Tota persona té dret a la llibertat de reunió i d’associació pacífiques.';
    case 'cs': return 'Každému je zaručena svoboda pokojného shromažďování a sdružování.';
    case 'cy': return 'Y mae gan bawb hawl i ryddid ymgynnull a chymdeithasu heddychlon.';
    case 'da': return 'Alle har ret til under fredelige former frit at forsamles og danne foreninger.';
    case 'de': return 'Alle Menschen haben das Recht, sich friedlich zu versammeln und zu Vereinigungen zusammenzuschließen.';
    case 'el': return 'Καθένας έχει το δικαίωμα να συνέρχεται και να συνεταιρίζεται ελεύθερα και για ειρηνικούς σκοπούς.';
    case 'eo': return 'Ĉiu havas la rajton je libereco de pacema kunvenado kaj asociiĝo.';
    case 'es': return 'Toda persona tiene derecho a la libertad de reunión y de asociación pacíficas.';
    case 'et': return 'Igal inimesel on õigus rahumeelse kogunemise ja liitumise vabadusele.';
    case 'eu': return 'Nornahik du bakean biltzeko eta elkartzeko eskubidea.';
    case 'fi': return 'Kaikilla on oikeus rauhanomaiseen kokoontumis- ja yhdistymisvapauteen.';
    case 'fo': return 'Øll hava rætt til frítt og á friðarligan hátt at koma saman og taka seg saman í felagsskapir.';
    case 'fr': return 'Toute personne a droit à la liberté de réunion et d’association pacifiques.';
    case 'ga': return 'Tá ag gach uile dhuine an ceart go mbeidh saoirse aige teacht ar tionól agus gabháil le comhlachas go sítheoilte';
    case 'gd': return 'Tha còir aig na h-uile saorsa a bhith aca airson co-chruinneachadh agus co-chomunn.';
    case 'hi': return 'प्रत्येक व्यक्ति को शान्ति पूर्ण सभा करने या समिति बनाने की स्वतन्त्रता का अधिकार है ।';
    case 'hr': return 'Svatko ima pravo na slobodu mirnog okupljanja i udruživanja.';
    case 'hu': return 'Minden személynek joga van békés célú gyülekezési és egyesülési szabadsághoz.';
    case 'hy': return 'Յուրաքանչյուր ոք ունի խաղաղ հավաքների ու միություններ կազմելու իրավունք։';
    case 'id': return 'Setiap orang mempunyai hak atas kebebasan berkumpul dan berserikat secara damai.';
    case 'is': return 'Hverjum manni skal frjálst að eiga þátt í friðsamlegum fundahöldum og félagsskap.';
    case 'it': return 'Ogni individuo ha diritto alla libertà di riunione e di associazione pacifica.';
    case 'ja': return 'すべて人は、平和的な集会及び結社の自由を享有する権利を有する。';
    case 'ka': return 'ყოველ ადამიანს აქვს უფლება მშვიდობიანი შეკრებისა და გაერთიანების თავისუფლებისა.';
    case 'kk': return 'Әр адамның бейбіт жиналыстар және ассоциацияаларды құру бостандығына құқығы бар.';
    case 'km': return 'មនុស្សគ្រប់រូប មានសិទ្ធិសេរីភាពក្នុងការប្រជុំ ឬការរួមគ្នាជាសមាគម ដោយសន្ដិវិធី។';
    case 'ko': return '모든 사람은 평화적인 집회 및 결사의 자유에 대한 권리를 가진다.';
    case 'ky': return 'Ар бир адам тынч чогулуштар менен ассоциациялар эркиндигине укуктуу.';
    case 'lb': return 'All Mënsch huet d\'Recht op Versammlungs- a Verenegongsfräiheet am friddleche Sënn.';
    case 'lt': return 'Kiekvienas žmogus turi teisę į taikių susirinkimų ir asociacijų laisvę.';
    case 'lv': return 'Ikvienam ir tiesības uz miermīlīgu sapulču un asociācijas brīvību.';
    case 'mk': return 'Секој има право на слобода на мирни собири и здружување.';
    case 'mn': return 'Хүн бүр тайван замаар сайн дураар хуран цуглах, эвлэлдэн нэгдэх эрхтэй.';
    case 'mt': return 'Kulħadd għandu l-jedd għal-libertà li jiltaqa’ u jissieħeb ma’ oħrajn fil-paċi.';
    case 'nb': return 'Enhver har rett til fritt å delta i fredelige møter og organisasjoner.';
    case 'nl': return 'Een ieder heeft recht op vrijheid van vreedzame vereniging en vergadering.';
    case 'pl': return 'Każdy człowiek ma prawo spokojnego zgromadzania i stowarzyszania się.';
    case 'pt': return 'Toda a pessoa tem direito à liberdade de reunião e de associação pacíficas.';
    case 'rm': return 'Mincha uman ha il dret a la libertà da reuniun e d\'associaziun cun meras paschaivlas.';
    case 'ro': return 'Orice persoană are dreptul la libertatea de întrunire și de asociere pașnică.';
    case 'ru': return 'Каждый человек имеет право на свободу мирных собраний и ассоциаций.';
    case 'sb': return 'Kóždy ma prawo na swobodu zhromadźnja a zjednoćenja za měrliwe zaměry.';
    case 'sk': return 'Každému je zaručená sloboda pokojného shromažďovania a sdružovania sa.';
    case 'sl': return 'Vsakdo ima pravico do svobodnega in mirnega zbiranja in združevanja.';
    case 'sr': return 'Свако има право на слободу мирног окупљања и удруживања.';
    case 'sq': return 'Gjithkush ka të drejtën e lirisë së mbledhjes dhe bashkimit paqësor.';
    case 'sv': return 'Envar har rätt till frihet i fråga om fredliga möten och sammanslutningar.';
    case 'sw': return 'Kila mtu anayo haki ya kushiriki katika mkutano na chama kwa hali ya amani.';
    case 'th': return 'ทุกคนมีสิทธิในอิสรภาพแห่งการร่วมประชุมและการตั้งสมาคมโดยสันติ';
    case 'tl': return 'Ang bawat tao\'y may karapatan sa kalayaan sa mapayapang pagpupulong at pagsasamahan.';
    case 'tr': return 'Her şahıs saldırısız toplanma ve dernek kurma ve derneğe katılma serbestisine maliktir.';
    case 'uk': return 'Кожна людина має право на свободу мирних зборів і асоціацій.';
    case 'uz': return 'Har bir inson osoyishta yigʻilishlar va uyushmalar oʻtkazish huquqiga egadir.';
    case 'vi': return 'Mọi người đều có quyền tự do họp hành và tham gia hiệp hội một cách hoà bình.';
    case 'xh': return 'Wonke umntu unelungelo lenkululeko yeendibano zoxolo kunye neentlanganiso zoxolo.';
    case 'yo': return 'Ẹnì kọ̀ọ̀kan ló ní ẹ̀tọ́ sí òmìnira láti pé jọ pọ̀ àti láti dara pọ̀ mọ́ àwọn mìíràn ní àlàáfíà.';
    case 'zh': return '人人有权享有和平集会和结社的自由。';
    case 'zu': return 'Wonke umuntu unelungelo lokuhlanganyela ngokukhululeka embuthanweni woxolo.';
  }
}
