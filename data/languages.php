<?php

class Languages {

  private static $instance;
  private $languages;

  private function __construct($languages) {
    $this->languages = $languages;
  }

  public static function getInstance() {
    if (self::$instance === null) {
      self::$instance = new Languages(self::languages());
    }
    return self::$instance;
  }

  public function getLanguages() {
    return $this->languages;
  }

  public static function findLanguageAndCode($identifier) {
    $langs = self::getInstance()->getLanguages();

    foreach ($langs as $code => $lang) {
      if ($code === $identifier
          || strtolower($lang->getName()) === $identifier
          || array_search($identifier, $lang->getAliases(), true)) {
        return ['code' => $code, 'lang' => $lang];
      }
    }
    return ['code' => null, 'lang' => null];
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
      'et' => self::entry('Estonian'),
      'eu' => self::entry('Basque'),
      'fi' => self::entry('Finnish'),
      'fr' => self::entry('French'),
      'ga' => self::entry('Irish', 'gaelic'),
      'gd' => self::entry('Scottish Gaelic', 'scottish'),
      'hu' => self::entry('Hungarian'),
      'is' => self::entry('Icelandic'),
      'it' => self::entry('Italian'),
      'ja' => self::entry('Japanese', 'jp'),
      'ko' => self::entry('Korean'),
      'lb' => self::entry('Luxembourgish', 'lu', 'lux'),
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
      'sq' => self::entry('Albanian', 'al'),
      'sv' => self::entry('Swedish', 'se'),
      'zh' => self::entry('Chinese', 'cn')
    ];
  }
}
