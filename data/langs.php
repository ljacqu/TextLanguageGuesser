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
    'af' => lang($g, 'Afrikaans'),
    'be' => lang($s, 'Belarusian', 'belo', 'bela', 'belorussian', 'belarusan', 'byelorussian'),
    'bg' => lang($s, 'Bulgarian'),
    'bn' => lang($a, 'Bengali'),
    'br' => lang($c, 'Breton'),
    'ca' => lang($r, 'Catalan'),
    'cs' => lang($s, 'Czech', 'cz'),
    'cy' => lang($c, 'Welsh'),
    'da' => lang($g, 'Danish', 'dk'),
    'de' => lang($g, 'German', 'deutsch'),
    'el' => lang($o, 'Greek', 'gr'),
    'en' => lang($g, 'English'),
    'eo' => lang($o, 'Esperanto'),
    'es' => lang($r, 'Spanish', 'espanol'),
    'et' => lang($f, 'Estonian', 'ee'),
    'eu' => lang($o, 'Basque'),
    'fi' => lang($f, 'Finnish'),
    'fo' => lang($g, 'Faroese'),
    'fr' => lang($r, 'French'),
    'ga' => lang($c, 'Irish', 'gaelic'),
    'gd' => lang($c, 'Scottish Gaelic', 'scottish'),
    'hi' => lang($a, 'Hindi'),
    'hr' => lang($s, 'Croatian', 'cro'),
    'hu' => lang($f, 'Hungarian'),
    'hy' => lang($o, 'Armenian', 'arm'),
    'id' => lang($a, 'Indonesian'),
    'is' => lang($g, 'Icelandic'),
    'it' => lang($r, 'Italian'),
    'ja' => lang($a, 'Japanese', 'jp'),
    'ka' => lang($o, 'Georgian', 'ge'),
    'kk' => lang($t, 'Kazakh', 'kz', 'kazak'),
    'km' => lang($a, 'Khmer', 'kmer'),
    'ko' => lang($a, 'Korean'),
    'ky' => lang($t, 'Kyrgyz', 'kirgizh', 'kg'),
    'lb' => lang($g, 'Luxembourgish', 'lu', 'lux'),
    'lt' => lang($o, 'Lithuanian'),
    'lv' => lang($o, 'Latvian'),
    'mk' => lang($s, 'Macedonian'),
    'mn' => lang($a, 'Mongolian', 'mongol', 'mo'),
    'mt' => lang($o, 'Maltese'),
    'nb' => lang($g, 'Norwegian', 'no'),
    'nl' => lang($g, 'Dutch'),
    'pl' => lang($s, 'Polish'),
    'pt' => lang($r, 'Portuguese', 'portugese'),
    'rm' => lang($r, 'Romansh', 'roh', 'romansch', 'rumantsch'),
    'ro' => lang($r, 'Romanian'),
    'ru' => lang($s, 'Russian'),
    'sk' => lang($s, 'Slovak'),
    'sl' => lang($s, 'Slovene', 'slovenian', 'si'),
    'sr' => lang($s, 'Serbian'),
    'sq' => lang($o, 'Albanian', 'al'),
    'sv' => lang($g, 'Swedish', 'se'),
    'sw' => lang($b, 'Swahili'),
    'th' => lang($a, 'Thai'),
    'tl' => lang($a, 'Filipino', 'tagalog'),
    'tr' => lang($t, 'Turkish'),
    'uk' => lang($s, 'Ukrainian', 'ua'),
    'uz' => lang($t, 'Uzbek'),
    'vi' => lang($a, 'Vietnamese', 'vn', 'viet'),
    'xh' => lang($b, 'Xhosa', 'xosa', 'isixhosa'),
    'yo' => lang($b, 'Yoruba'),
    'zh' => lang($a, 'Chinese', 'cn'),
    'zu' => lang($b, 'Zulu')
  ];
}

function lang($group, $name, ...$aliases): Language {
  return new Language($name, $group, $aliases);
}
