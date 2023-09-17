<?php

class Languages {

  private static $instance;
  private $languages;

  private function __construct($languages) {
    $this->languages = $languages;
  }

  static function getAllLanguages() {
    if (self::$instance === null) {
      self::$instance = new Languages(createLanguages());
    }
    return self::$instance->getLanguages();
  }

  static function getLanguageName($code) {
    $langs = self::getAllLanguages();
    return $langs[$code]->getName();
  }

  static function findLanguageAndCode($identifier) {
    $langs = self::getAllLanguages();

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
}
