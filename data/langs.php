<?php

function createLanguages() {
  // Note: Currently, the entries are sorted by array key, which MUST be two characters
  // and is currently the ISO 639-1 code of the language. Aliases must be in lower case.
  return [
    'af' => lang('Afrikaans'),
    'bg' => lang('Bulgarian'),
    'br' => lang('Breton'),
    'ca' => lang('Catalan'),
    'cs' => lang('Czech', 'cz'),
    'cy' => lang('Welsh'),
    'da' => lang('Danish', 'dk'),
    'de' => lang('German', 'deutsch'),
    'el' => lang('Greek', 'gr'),
    'en' => lang('English'),
    'eo' => lang('Esperanto'),
    'es' => lang('Spanish', 'espanol'),
    'et' => lang('Estonian', 'ee'),
    'eu' => lang('Basque'),
    'fi' => lang('Finnish'),
    'fr' => lang('French'),
    'ga' => lang('Irish', 'gaelic'),
    'gd' => lang('Scottish Gaelic', 'scottish'),
    'hu' => lang('Hungarian'),
    'id' => lang('Indonesian'),
    'is' => lang('Icelandic'),
    'it' => lang('Italian'),
    'ja' => lang('Japanese', 'jp'),
    'ko' => lang('Korean'),
    'lb' => lang('Luxembourgish', 'lu', 'lux'),
    'lt' => lang('Lithuanian'),
    'lv' => lang('Latvian'),
    'mk' => lang('Macedonian'),
    'mt' => lang('Maltese'),
    'nb' => lang('Norwegian', 'no'),
    'nl' => lang('Dutch'),
    'pl' => lang('Polish'),
    'pt' => lang('Portuguese', 'portugese'),
    'ro' => lang('Romanian'),
    'ru' => lang('Russian'),
    'sk' => lang('Slovak'),
    'sl' => lang('Slovene', 'slovenian'),
    'sr' => lang('Serbian'),
    'sq' => lang('Albanian', 'al'),
    'sv' => lang('Swedish', 'se'),
    'tl' => lang('Filipino', 'tagalog'),
    'tr' => lang('Turkish'),
    'uk' => lang('Ukrainian', 'ua'),
    'zh' => lang('Chinese', 'cn')
  ];
}

function lang($name, ...$aliases): Language {
  return new Language($name, $aliases);
}
