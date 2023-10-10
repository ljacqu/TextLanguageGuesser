<?php

function toResultJson($text, $additionalProperties=null) {
  if ($additionalProperties) {
    $additionalProperties['result'] = $text;
    return json_encode($additionalProperties, JSON_FORCE_OBJECT);
  }
  return json_encode(['result' => $text], JSON_FORCE_OBJECT);
}

function readPossibleLines() {
  $contents = file_get_contents('./data/texts.php') or die(toResultJson('Error: failed to read the texts file'));

  $choice = [];
  foreach (explode("\n", $contents) as $line) {
    $line = trim($line);
    if (empty($line) || $line[0] === '#') {
      continue;
    }

    $choice[] = $line;
  }

  if (empty($choice)) {
    die(toResultJson('Error: Invalid text definitions'));
  }

  return $choice;
}

function selectQuestion($choices, $lastQuestions) {
  $skipLanguages = [];
  $skipTexts = [];

  $cnt = 1;
  foreach ($lastQuestions as $pastQuestion) {
    $stopCrit = 0;
    if ($cnt <= HISTORY_AVOID_LAST_N_LANGUAGES) {
      $skipLanguages[] = $pastQuestion['lang'];
    } else {
      ++$stopCrit;
    }

    if ($cnt <= HISTORY_AVOID_LAST_N_QUESTIONS) {
      $skipTexts[] = $pastQuestion['line'];
    } else {
      ++$stopCrit;
    }

    if ($stopCrit == 2) {
      break;
    }
    ++$cnt;
  }

  $actualChoices = array_filter($choices, function ($choice) use ($skipLanguages, $skipTexts) {
    $lang = substr($choice, 0, 2);
    return !in_array($lang, $skipLanguages, true) && !in_array($choice, $skipTexts, true);
  });

  if (empty($actualChoices)) {
    return null;
  }
  return $actualChoices[ array_rand($actualChoices, 1) ];
}

function removeLanguagePrefix($textLine) {
  return substr($textLine, 3);
}

// From https://stackoverflow.com/a/4167053
// For some reason, certain users (maybe using Twitch extensions?) write stuff like
// "xho 󠀀", which has a zero-width space at the end. PHP's trim() does not remove it.
function unicodeTrim($text) {
  return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $text);
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
    die(toResultJson('Error: Missing API secret!'));
  } else if ($_GET['secret'] !== API_SECRET) {
    die(toResultJson('Error: Invalid API secret!'));
  } else if (API_SECRET === 'setme') {
    die(toResultJson('Error: Update the API secret in config.php'));
  }
}

function setJsonHeader() {
  header('Content-type: application/json; charset=utf-8');
}

function updateCurrentState($data_lastQuestions) {
  $fh = fopen('./conf/current_state.php', 'w') or die(toResultJson('Error: failed to update the current state :( Please try again!'));
  fwrite($fh, '<?php $data_lastQuestions = ' . var_export($data_lastQuestions, true) . ';');
  fclose($fh);
}
