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
    'en' => lang($g, 'English', 'eng'),
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
