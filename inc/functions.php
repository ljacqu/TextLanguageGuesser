<?php

function toResultJson($text) {
  return json_encode(['result' => $text], JSON_FORCE_OBJECT);
}

function readPossibleLines() {
  $foundPhpEnd = false;
  $contents = file_get_contents('./data/texts.php') or die(toResultJson('Error: failed to read the texts file'));

  $choice = [];
  foreach (explode("\n", $contents) as $line) {
    $line = trim($line);
    if (!$foundPhpEnd) {
      if ($line === '?>') {
        $foundPhpEnd = true;
      }
      continue;
    }

    if (empty($line) || $line[0] === '#') {
      continue;
    }

    $choice[] = $line;
  }

  if (empty($choice) && !$foundPhpEnd) {
    die(toResultJson('Error: Invalid text definitions'));
  }

  return $choice;
}

function selectQuestion($choices, $lastProblems) {
  $randomEntry = $choices[rand(0, count($choices) - 1)];
  if (count($choices) < 20) {
    return $randomEntry;
  }

  while (true) {
    if (!hasSubArrayWithValue($lastProblems, 'line', $randomEntry)) {
      return $randomEntry;
    }
    $randomEntry = $choices[rand(0, count($choices) - 1)];
  }
}

function hasSubArrayWithValue($haystack, $key, $valueToFind) {
  foreach ($haystack as $entryToSearch) {
    if ($entryToSearch[$key] === $valueToFind) {
      return true;
    }
  }
  return false;
}

function removeLanguagePrefix($textLine) {
  return substr($textLine, 3);
}

function createPuzzleRecord($textLine) {
  return [
    'lang' => substr($textLine, 0, 2),
    'created' => time(),
    'line' => $textLine
  ];
}

function verifyApiSecret() {
  if (!isset($_GET['secret'])) {
    die(toResultJson('Missing API secret!'));
  } else if ($_GET['secret'] !== API_SECRET) {
    die(toResultJson('Invalid API secret!'));
  }
}

function setJsonHeader() {
  header('Content-type: application/json; charset=utf-8');
}

function updateCurrentState($data_lastQuestions) {
  $fh = fopen('./data/current_state.php', 'w') or die(toResultJson('Error: failed to update the current state :( Please try again!'));
  fwrite($fh, '<?php $data_lastQuestions = ' . var_export($data_lastQuestions, true) . ';');
  fclose($fh);
}
