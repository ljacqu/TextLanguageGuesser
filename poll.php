<?php

require './inc/config.php';
require './inc/functions.php';

setJsonHeader();
verifyApiSecret();


require './data/Language.php';
require './data/Languages.php';
$choices = readPossibleLines();
require './data/current_state.php';

if (!empty($data_lastQuestions)) {
  $lastQuestion = $data_lastQuestions[0];
  if (!isset($lastQuestion['solver']) && (time() - $lastQuestion['created']) < POLL_WAIT_SECONDS) {
    // Nightbot doesn't accept empty strings, but seems to trim responses and not show anything if there are only spaces.
    die(toResultJson(' '));
  }
}

$puzzleLine = selectQuestion($choices, $data_lastQuestions);

$puzzle = createPuzzleRecord($puzzleLine);
$lastQuestion = null;
if (!empty($data_lastQuestions)) {
  $lastQuestion = &$data_lastQuestions[0];
}

$newSize = array_unshift($data_lastQuestions, $puzzle);

while ($newSize > 10) {
  array_pop($data_lastQuestions);
  --$newSize;
}

$preface = '';
if ($lastQuestion && !isset($lastQuestion['solver'])) {
  $preface = 'The previous text was in ' . Languages::getLanguageName($lastQuestion['lang']) . '. ';
  $lastQuestion['solver'] = '&__unsolved';
}

updateCurrentState($data_lastQuestions);

echo toResultJson($preface . 'Guess the language: ' . removeLanguagePrefix($puzzle['line']));
