<?php

require 'config.php';
require 'functions.php';

setJsonHeader();
verifyApiSecret();

if (!isset($_GET['a'])) {
  die(toResultJson('Error! Please provide your answer'));
}

require './data/current_state.php';
require './data/Language.php';
require './data/Languages.php';

if (empty($data_lastQuestions)) {
  die(toResultJson('Error: No question was asked so far!'));
}

$currentRiddle = &$data_lastQuestions[0];
if (isset($currentRiddle['solver'])) {
  die(toResultJson('The answer was already solved by ' . $currentRiddle['solver']));
}

$answer = filter_input(INPUT_GET, 'a', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR) ?? '';
$answer = strtolower(trim($answer));

$languageAndCode = Languages::findLanguageAndCode($answer);
if ($languageAndCode['code'] === $currentRiddle['lang']) {
  $currentRiddle['solver'] = extractUser();

  updateCurrentState($data_lastQuestions);
  echo toResultJson('Congratulations! ' . $languageAndCode['lang']->getName() . ' is the right answer');
} else {

  if ($languageAndCode['lang'] === null) {
    $text = empty($answer) ? 'Please provide an answer!' : 'Unknown language! Run !langs to see the list';
  } else {
    $langName = $languageAndCode['lang']->getName();
    // return language in text if an alias was used, just to make it clear what language we inferred
    $text = $answer === strtolower($langName)
      ? 'Sorry, that\'s not the right answer'
      : 'Sorry, ' . $langName . ' is not correct';
  }

  echo toResultJson($text);
}

// --------------
// Functions
// --------------

function extractUser() {
  $solver = '';
  if (isset($_SERVER['HTTP_NIGHTBOT_USER'])) {
    $nightbotUser = $_SERVER['HTTP_NIGHTBOT_USER'];
    $solver = preg_replace('~^.*?name=([^&]+)&.*?$~', '\\1', $nightbotUser);
  }
  return $solver ? $solver : 'Unknown';
}
