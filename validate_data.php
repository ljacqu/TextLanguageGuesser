<?php
error_reporting(E_ALL);

require './inc/functions.php';
require './data/Language.php';
require './data/Languages.php';

// Check the text lines
$lines = readPossibleLines();

$languagesWithText = [];

foreach ($lines as $line) {
  if (!preg_match('~^[a-z]{2}:(.){10,}$~', $line)) {
    die('Invalid line: ' . $line);
  }

  $entry = createPuzzleRecord($line);
  if (empty($entry['lang'])) {
    die('Invalid language in line: ' . $line);
  }
  $languagesWithText[$entry['lang']] = 1;
}

echo 'Validated ' . count($lines) . ' messages.';
echo '<br />Total languages: ' . count(array_keys($languagesWithText));

// Check the language definitions
$identifiers = [];
$languagesWithNoText = [];
foreach (Languages::getAllLanguages() as $code => $lang) {
  $name = strtolower($lang->getName());
  if (isset($identifiers[$name])) {
    die('Identifier "' . $name . '" is duplicated');
  }
  $identifiers[$name] = 1;

  if (isset($identifiers[$code])) {
    die('The code "' . $code . '" was already used');
  } else if (strtolower($code) !== $code) {
    die('The code "' . $code . '" is not in lower case');
  }
  $identifiers[$code] = 1;

  foreach ($lang->getAliases() as $alias) {
    if (isset($identifiers[$alias])) {
      die('The alias "' . $alias . '" was already used');
    } else if (strtolower($alias) !== $alias) {
      die('The alias "' . $alias . '" is not in lower case');
    }
    $identifiers[$alias] = 1;
  }

  if (!isset($languagesWithText[$code])) {
    $languagesWithNoText[] = $code;
  }
}

echo '<br />Validated ' . count($identifiers) . ' language identifiers';
if (!empty($languagesWithNoText)) {
  echo '<br />Warning: The following languages have no texts: ' . implode(', ', $languagesWithNoText);
}
