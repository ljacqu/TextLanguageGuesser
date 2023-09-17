<?php

class Languages {

  private static $instance;
  private $languages;

  private function __construct($languages) {
    $this->languages = $languages;
  }

  static function getInstance(): Languages {
    if (self::$instance === null) {
      self::$instance = new Languages(self::languages());
    }
    return self::$instance;
  }

  static function getAllLanguages() {
    return self::getInstance()->getLanguages();
  }

  static function getLanguageName($code) {
    $langs = self::getInstance()->getLanguages();
    return $langs[$code]->getName();
  }

  static function findLanguageAndCode($identifier) {
    $langs = self::getInstance()->getLanguages();

    foreach ($langs as $code => $lang) {
      if ($code === $identifier
          || strtolower($lang->getName()) === $identifier
          || array_search($identifier, $lang->getAliases(), true) !== false) {
        return ['code' => $code, 'lang' => $lang];
      }
    }
    return ['code' => null, 'lang' => null];
  }

  private function getLanguages(): array {
    return $this->languages;
  }

  private static function entry($name, ...$aliases): Language {
    return new Language($name, $aliases);
  }

  private static function languages() {
    return [
      'af' => self::entry('Afrikaans'),
      'bg' => self::entry('Bulgarian'),
      'br' => self::entry('Breton'),
      'ca' => self::entry('Catalan'),
      'cs' => self::entry('Czech', 'cz'),
      'cy' => self::entry('Welsh'),
      'da' => self::entry('Danish'),
      'de' => self::entry('German', 'deutsch'),
      'el' => self::entry('Greek', 'gr'),
      'en' => self::entry('English'),
      'eo' => self::entry('Esperanto'),
      'es' => self::entry('Spanish', 'espanol'),
      'et' => self::entry('Estonian', 'ee'),
      'eu' => self::entry('Basque'),
      'fi' => self::entry('Finnish'),
      'fr' => self::entry('French'),
      'ga' => self::entry('Irish', 'gaelic'),
      'gd' => self::entry('Scottish Gaelic', 'scottish'),
      'hu' => self::entry('Hungarian'),
      'id' => self::entry('Indonesian'),
      'is' => self::entry('Icelandic'),
      'it' => self::entry('Italian'),
      'ja' => self::entry('Japanese', 'jp'),
      'ko' => self::entry('Korean'),
      'lb' => self::entry('Luxembourgish', 'lu', 'lux'),
      'lt' => self::entry('Lithuanian'),
      'lv' => self::entry('Latvian'),
      'mk' => self::entry('Macedonian'),
      'mt' => self::entry('Maltese'),
      'nb' => self::entry('Norwegian', 'no'),
      'nl' => self::entry('Dutch'),
      'pl' => self::entry('Polish'),
      'pt' => self::entry('Portuguese', 'portugese'),
      'ro' => self::entry('Romanian'),
      'ru' => self::entry('Russian'),
      'sk' => self::entry('Slovak'),
      'sl' => self::entry('Slovene', 'slovenian'),
      'sr' => self::entry('Serbian'),
      'sq' => self::entry('Albanian', 'al'),
      'sv' => self::entry('Swedish', 'se'),
      'tl' => self::entry('Filipino', 'tagalog'),
      'tr' => self::entry('Turkish'),
      'uk' => self::entry('Ukrainian', 'ua'),
      'zh' => self::entry('Chinese', 'cn')
    ];
  }
}
