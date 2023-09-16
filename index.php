<!DOCTYPE html>
<html>
<head>
  <title>Language guess</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <style type="text/css">

  body, table {
    font-family: Arial;
    font-size: 11pt;
  }
  td, th {
    padding: 2px;
  }
  table {
    border-collapse: collapse;
  }
  .command {
    font-family: Consolas, monospace;
  }

  @media (prefers-color-scheme: dark) {
    body {
      background-color: #111;
      color: #eee;
    }
    td, th {
      border: 1px solid #999;
    }
    .lang {
      color: #111;
    }
    .lang:hover {
      color: #111;
      background-color: #cc0;
    }
  }

  @media (prefers-color-scheme: light) {
    body {
      background-color: #fff;
      color: #000;
    }
    td, th {
      border: 1px solid #000;
    }
    .lang {
      color: #fff;
    }
    .lang:hover {
      color: #000;
      background-color: #ff0;
    }
  }
  </style>
</head>
<body>

  <?php

require 'functions.php';
require './data/current_state.php';
require './data/Language.php';
require './data/Languages.php';

  echo '<h2>Recent riddles</h2>
       <p>Hover over the language column to see the answer!</p>';
if (empty($data_lastQuestions)) {
  echo 'No data to show!';
  exit;
}

echo '<table><tr><th>Text</th><th>Language</th></tr>';
foreach ($data_lastQuestions as $question) {
  echo "<tr><td>" . htmlspecialchars($question['text']) . "</td>";
  if (isset($question['solver'])) {
    echo "<td class='lang'>" . htmlspecialchars($question['lnam']);
  } else {
    echo '<td>Not yet solved';
  }
  echo "</td></tr>";
}
echo "</table>";
  ?>

<h2>Languages</h2>
  <div style="width: 100%">
    <div style="float: left; margin-bottom: 20px;">
      <table>
        <tr>
          <th>Language</th>
          <th>Aliases</th>
        </tr>
        <?php
$languagesByCode = Languages::getInstance()->getLanguages();
uasort($languagesByCode, function ($a, $b) {
  return strcmp($a->getName(), $b->getName());
});

foreach ($languagesByCode as $code => $lang) {
  $aliases = implode(', ', $lang->getAliases());
  $aliases = empty($aliases) ? $code : ($code . ', ' . $aliases);
  echo "<tr><td>{$lang->getName()}</td><td>$aliases</td></tr>";
}
        ?>
      </table>
    </div>


    <div style="margin-left: 10px; margin-bottom: 20px; float: left">
      <br />
      When prompted to guess the language of a text, you can use the language name or any of its aliases.
    For example, you can use any of the following to answer with German:<ul class="command">
        <li>!guess german</li>
        <li>!guess de</li>
        <li>!guess deutsch</li>
      </ul>

      Note: The first alias is always the ISO 639-1 code of the language.
    </div>
  </div>
  
</body>
</html>
