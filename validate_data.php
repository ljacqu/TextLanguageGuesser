<?php
error_reporting(E_ALL);

require 'functions.php';
require './data/languages.php';

$lines = readPossibleLines();

$languages = [];

foreach ($lines as $line) {
  if (!preg_match('~^[a-z]{2}:(.){10,}$~', $line)) {
    die('Invalid line: ' . $line);
  }
  
  $entry = splitLanguageAndText($line);
  if (empty($entry['lang'])) {
    die('Invalid language in line: ' . $line);
  }
  $languages[$entry['lang']] = 1;
}

echo 'Validated ' . count($lines) . ' messages.';
echo '<br />Total languages: ' . count(array_keys($languages));
