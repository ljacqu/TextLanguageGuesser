<?php

require 'config.php';
require 'functions.php';

setJsonHeader();
verifyApiSecret();


require './data/languages.php';
$choices = readPossibleLines();
require './data/current_state.php';

$puzzleLine = selectQuestion($choices, $data_lastQuestions);

$puzzle = splitLanguageAndText($puzzleLine);
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
  $preface = 'The text was in ' . $lastQuestion['lnam'] . '. ';
  $lastQuestion['solver'] = '__unsolved';
}

updateCurrentState($data_lastQuestions);

echo toResultJson($preface . 'Guess the language: ' . $puzzle['text']);
