<?php

class Language {

  private $name;
  private $aliases;

  public function __construct($name, $aliases) {
    $this->name = $name;
    $this->aliases = $aliases;
  }

  function getName() {
    return $this->name;
  }

  function getAliases() {
    return $this->aliases;
  }
}
