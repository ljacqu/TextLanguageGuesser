<?php

require 'config.php';
require 'functions.php';
//header('Content-type: application/json; charset=utf-8');


if (!isset($_GET['secret'])) {
  echo toResultJson('Missing API secret!');
  exit;
}

if ($_GET['secret'] !== API_SECRET) {
  echo toResultJson('Invalid API secret!');
  exit;
}

require './data/current_state.php';

if (empty($data_lastQuestions)) {
  die(toResultJson('Error! No questions so far'));
}

$count = 0;
$response = '';
foreach ($data_lastQuestions as &$question) {

  if ($count === 0) {
    $response .= 'The last text ("' . $question['short'] . '") was in ' . $question['lang'];
  } else if (!($question['responded'] ?? false)) {
    $response .= '. The text before ("' . $question['short'] . '") was in ' . $question['lang'] . '.';
  }
  $question['responded'] = true;
  if (++$count > 1) {
    break;
  }
}

$fh = fopen('./data/current_state.php', 'w') or die(toResultJson('Failed to update my status :( Please try again!'));
fwrite($fh, '<?php $data_lastQuestions = ' . var_export($data_lastQuestions, true) . ';');
fclose($fh);

echo toResultJson($response);
