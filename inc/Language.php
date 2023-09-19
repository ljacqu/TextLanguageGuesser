<?php

class Language {

  private $name;
  private $group;
  private $aliases;

  function __construct($name, $group, $aliases) {
    $this->name = $name;
    $this->group = $group;
    $this->aliases = $aliases;
  }

  function getName() {
    return $this->name;
  }

  function getGroup() {
    return $this->group;
  }

  function getAliases() {
    return $this->aliases;
  }
}
