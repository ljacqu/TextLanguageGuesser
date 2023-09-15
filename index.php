<?php

require 'config.php';
require 'functions.php';
header('Content-type: application/json; charset=utf-8');


if (!isset($_GET['secret'])) {
  echo toResultJson('Missing API secret!');
  exit;
}

if ($_GET['secret'] !== API_SECRET) {
  echo toResultJson('Invalid API secret!');
  exit;
}

require './data/languages.php';
$choices = readPossibleLines();
require './data/current_state.php';

$puzzleLine = selectQuestion($choices, $data_lastQuestions);

$puzzle = splitLanguageAndText($puzzleLine);
$newSize = array_unshift($data_lastQuestions, $puzzle);

while ($newSize > 10) {
  array_pop($data_lastQuestions);
  --$newSize;
}

$fh = fopen('./data/current_state.php', 'w') or die(toResultJson('Failed to update my file :( Please try again!'));
fwrite($fh, '<?php $data_lastQuestions = ' . var_export($data_lastQuestions, true) . ';');
fclose($fh);

echo toResultJson('Guess the language: ' . $puzzle['text']);
