<?php

require './conf/config.php';
require './inc/functions.php';

setJsonHeader();
verifyApiSecret();

if (!isset($_GET['a'])) {
  die(toResultJson('Please provide a guess! Type ' . COMMAND_QUESTION . ' to see the text.'));
}

require './conf/current_state.php';
require './inc/Language.php';
require './inc/Languages.php';
require './data/langs.php';

if (empty($data_lastQuestions)) {
  die(toResultJson('Error: No question was asked so far!'));
}

$currentRiddle = &$data_lastQuestions[0];
if (isset($currentRiddle['solver'])) {
  die(toResultJson('The answer was solved by ' . $currentRiddle['solver']));
}

$answer = filter_input(INPUT_GET, 'a', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR) ?? '';
$answer = strtolower(trim($answer));

$languageAndCode = Languages::findLanguageAndCode($answer);
if ($languageAndCode['code'] === $currentRiddle['lang']) {
  $currentRiddle['solver'] = extractUser();

  updateCurrentState($data_lastQuestions);
  $congratsOptions = ['Congratulations!', 'Nice!', 'Excellent!', 'Splendid!', 'Perfect!', 'Well done!', 'Awesome!', 'Good job!'];
  $start = $congratsOptions[rand(0, count($congratsOptions)-1)];
  echo toResultJson($start . ' ' . $languageAndCode['lang']->getName() . ' is the right answer');
} else {

  if ($languageAndCode['lang'] === null) {
    $text = empty($answer) ? 'Please provide an answer!' : 'Unknown language! Run ' . COMMAND_LANGUAGES . ' to see the list';
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
  if (isset($_SERVER[USER_HTTP_HEADER])) {
    $nightbotUser = $_SERVER[USER_HTTP_HEADER];
    $solver = preg_replace('~^.*?name=([^&]+)&.*?$~', '\\1', $nightbotUser);
  }
  return $solver ? $solver : 'Unknown';
}
