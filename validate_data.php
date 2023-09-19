<?php
error_reporting(E_ALL);

require './conf/config.php';
require './inc/functions.php';
require './inc/Language.php';
require './inc/Languages.php';
require './data/langs.php';

// Check the text lines
$lines = readPossibleLines();

$languagesWithText = [];

$allLanguages = Languages::getAllLanguages();
foreach ($lines as $line) {
  if (!preg_match('~^[a-z]{2}:(.){10,}$~', $line)) {
    die('Invalid line: ' . $line);
  }

  $entry = createPuzzleRecord($line);
  if (empty($entry['lang'])) {
    die('Invalid language in line: ' . $line);
  } else if (!isset($allLanguages[$entry['lang']])) {
    die('Unknown language: ' . $entry['lang']);
  }
  $languagesWithText[$entry['lang']] = 1;
}

echo 'Validated ' . count($lines) . ' messages.';
echo '<br />Total languages: ' . count($languagesWithText);

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

// Check some configurations
if (HISTORY_AVOID_LAST_N_QUESTIONS > HISTORY_KEEP_ENTRIES) {
  echo '<br />Note: HISTORY_AVOID_LAST_N_QUESTIONS is larger than HISTORY_KEEP_ENTRIES';
}
if (HISTORY_AVOID_LAST_N_LANGUAGES > HISTORY_KEEP_ENTRIES) {
  echo '<br />Note: HISTORY_AVOID_LAST_N_LANGUAGES is larger than HISTORY_KEEP_ENTRIES';
}

if (HISTORY_AVOID_LAST_N_QUESTIONS >= count($lines)) {
  echo '<br />Error: HISTORY_AVOID_LAST_N_QUESTIONS is larger than the total number of questions';
}
if (HISTORY_AVOID_LAST_N_LANGUAGES >= count($languagesWithText)) {
  echo '<br />Error: HISTORY_AVOID_LAST_N_LANGUAGES is larger than the total number of languages with entries';
}
