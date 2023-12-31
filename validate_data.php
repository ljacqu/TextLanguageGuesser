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
  $languagesWithText[$entry['lang']] = ($languagesWithText[$entry['lang']] ?? 0) + 1;
}

echo 'Validated ' . count($lines) . ' messages.';
echo '<br />Total languages: ' . count($languagesWithText);

// Check the language definitions
$identifiers = [];
$languagesWithNoText = [];
$allCodes = [];
foreach (Languages::getAllLanguages() as $code => $lang) {
  $allCodes[] = $code;
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

// Check demo sentences
$demoLines = explode("\n", file_get_contents('./data/demo_texts.txt'));
$languagesWithDemo = [];
foreach ($demoLines as $demoText) {
  $demoText = trim($demoText);
  if (empty($demoText)) {
    continue;
  }

  if (!preg_match('/^[a-z]{2}:./', $demoText)) {
    die('Found demo text line in unsupported format: "' . htmlspecialchars($demoText) . '"');
  }
  $code = substr($demoText, 0, 2);
  if (isset($languagesWithDemo[$code])) {
    echo '<br />Error: Language ' . $code . ' has multiple demo sentences';
  } else if (!in_array($code, $allCodes)) {
    echo '<br />Warning: Found demo sentence for unknown language code "' . $code . '"';
  }
  $languagesWithDemo[$code] = true;
}

foreach ($allCodes as $code) {
  if (!isset($languagesWithDemo[$code])) {
    echo '<br />Warning: No demo sentence for language "' . $code . '"';
  }
}
echo '<br />Validated ' . count($demoLines) . ' demo lines';


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

// Output
if (isset($_GET['output'])) {
  echo '<table border="1" style="font-family: Arial; font-size: 10pt; border-collapse: collapse">
          <tr><th>Lang</th><th>Message</th></tr>';
  foreach ($lines as $line) {
    $lang = substr($line, 0, 2);
    $text = substr($line, 3);
    echo "\n<tr><td>$lang</td><td>$text</td></tr>";
  }
  echo '</table>';
} else {
  echo '<p><a href="?output">Show all sentences</a></p>';
}

if (isset($_GET['dist'])) {
  echo '<table><tr><th>Language</th><th>Number of texts</th></tr>';
  foreach (Languages::getAllLanguages() as $code => $lang) {
    $cnt = $languagesWithText[$code] ?? 0;
    echo "\n<tr><td title='" . htmlspecialchars($lang->getName()) . "'>$code</td><td>$cnt</td></tr>";
  }
  echo '</table>';
} else {
  echo '<p><a href="?dist">Show sentences by language</a></p>';
}
