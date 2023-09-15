<?php

function toResultJson($text) {
  return json_encode(['result' => $text], JSON_FORCE_OBJECT);
}

function readPossibleLines() {
  $foundPhpEnd = false;
  $contents = file_get_contents('./data/texts.php') or die(json_encode(['result' => 'Failed to read languages file']));

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
    die(json_encode(['result' => 'Invalid text definitions'], JSON_FORCE_OBJECT));
  }

  return $choice;
}

function selectQuestion($choices, $lastProblems) {
  $randomEntry = $choices[rand(0, count($choices) - 1)];
  if (count($choices) < 20) {
    return $randomEntry;
  }

  while (true) {
    if (!hasSubArrayWithValue($lastProblems, 'full', $randomEntry)) {
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

function splitLanguageAndText($textLine) {
  $text = substr($textLine, 3);
  return [
    'lang' => Languages::LANG[substr($textLine, 0, 2)],
    'text' => $text,
    'full' => $textLine,
    'short' => shortenText($text, 15)
  ];
}

function shortenText($text, $maxLength) {
  if (strlen($text) > $maxLength) {
    return trim(mb_substr($text, 0, $maxLength)) . "…";
  }
  return $text;
}
