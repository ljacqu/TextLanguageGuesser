<?php

require './inc/config.php';
require './inc/functions.php';

setJsonHeader();
verifyApiSecret();

require './data/Language.php';
require './data/Languages.php';
$choices = readPossibleLines();
require './data/current_state.php';

//
// Check if current question is still unsolved.
//

$unsolvedPuzzle = returnLastQuestionIfUnsolved($data_lastQuestions);
if ($unsolvedPuzzle !== null) {
  $variant = filter_input(INPUT_GET, 'variant', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR);

  if ($variant === 'timer') {
    $timeSinceLastQuestion = time() - $unsolvedPuzzle['created'];
    if ($timeSinceLastQuestion < BOT_POLL_WAIT_SECONDS) {
      // Nightbot doesn't accept empty strings, but seems to trim responses and
      // not show anything if there are only spaces, so make sure to have a space in the response.
      die(toResultJson(' '));
    }
  } else if ($variant === 'new') {
    $timeSinceLastQuestion = time() - $unsolvedPuzzle['created'];
    $secondsToWait = USER_POLL_WAIT_SECONDS - $timeSinceLastQuestion;
    if ($timeSinceLastQuestion < USER_POLL_WAIT_SECONDS) {
      die(toResultJson('Please solve the current question, or wait ' . $secondsToWait . 's'));
    }
  } else {
    die(toResultJson('Guess the language: ' . removeLanguagePrefix($unsolvedPuzzle['line'])));
  }
}

//
// Create new puzzle
//

$puzzleLine = selectQuestion($choices, $data_lastQuestions);

$puzzle = createPuzzleRecord($puzzleLine);
$lastQuestion = null;
if (!empty($data_lastQuestions)) {
  $lastQuestion = &$data_lastQuestions[0];
}

$newSize = array_unshift($data_lastQuestions, $puzzle);

// Trim old puzzle
while ($newSize > 10) {
  array_pop($data_lastQuestions);
  --$newSize;
}

// Handle the previous puzzle in case it was unsolved
$preface = '';
if ($lastQuestion && !isset($lastQuestion['solver'])) {
  $preface = 'The previous text was in ' . Languages::getLanguageName($lastQuestion['lang']) . '. ';
  $lastQuestion['solver'] = '&__unsolved';
}

// Save and return new puzzle
updateCurrentState($data_lastQuestions);
echo toResultJson($preface . 'Guess the language: ' . removeLanguagePrefix($puzzle['line']));



function returnLastQuestionIfUnsolved($data_lastQuestions) {
  if (!empty($data_lastQuestions)) {
    $lastQuestion = $data_lastQuestions[0];
    if (!isset($lastQuestion['solver'])) {
      return $lastQuestion;
    }
  }
  return null;
}
