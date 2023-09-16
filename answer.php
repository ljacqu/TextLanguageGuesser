<?php

require 'config.php';
require 'functions.php';

setJsonHeader();
verifyApiSecret();

if (!isset($_GET['a'])) {
  die(toResultJson('Error! Please provide your answer'));
}

require './data/current_state.php';

if (empty($data_lastQuestions)) {
  die(toResultJson('Error: No question was asked so far!'));
}

$currentRiddle = &$data_lastQuestions[0];
if (isset($currentRiddle['solver'])) {
  die(toResultJson('The answer was already solved by ' . $currentRiddle['solver']));
}

$answer = filter_input(INPUT_GET, 'a', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR) ?? '';
$answer = strtolower($answer);

if ($answer === strtolower($currentRiddle['lnam']) || $answer === strtolower($currentRiddle['lang'])) {
  $solver = $_SERVER['HTTP_NIGHTBOT_USER'] ?? 'Unknown';
  $currentRiddle['solver'] = $solver;

  updateCurrentState($data_lastQuestions);
  echo toResultJson('Congratulations! ' . $currentRiddle['lnam'] . ' is the right answer');
} else {
  echo toResultJson('Sorry, that\'s not the right answer');
}
