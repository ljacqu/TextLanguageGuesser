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
  th a {
    text-decoration: none;
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
    .command {
      color: #ffdf90;
    }
    th a {
      color: #99f;
    }
    th a:hover {
      color: #ff9;
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
    .command {
      color: #f40;
    }
    th a {
      color: #007;
    }
    th a:hover {
      color: #33f;
    }
  }
  </style>
</head>
<body>

<?php
require './conf/config.php';
require './inc/functions.php';
require './conf/current_state.php';
require './inc/Language.php';
require './inc/Languages.php';
require './data/langs.php';

echo '<h2>Recent riddles</h2>';
if (empty($data_lastQuestions)) {
  echo 'No data to show!';
  exit;
}
echo '<p>Answer the riddles with <span class="command">' . COMMAND_ANSWER . '</span>; display the current question with <span class="command">' 
  . COMMAND_QUESTION . '</span>; create a new question with <span class="command">' . COMMAND_QUESTION . ' new</span>.';
echo '<p>Hover over the language column below to see the answer!</p>';

echo '<table><tr><th>Text</th><th>Language</th></tr>';
foreach ($data_lastQuestions as $question) {
  echo "<tr><td>" . htmlspecialchars(removeLanguagePrefix($question['line'])) . "</td>";
  if (isset($question['solver'])) {
    echo "<td class='lang'>" . htmlspecialchars(Languages::getLanguageName($question['lang']));
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
          <th><a href="?sort=name" title="Click to sort by name">Language</a></th>
          <th><a href="?sort=group" title="Click to sort by group">Group</a></th>
          <th>Aliases</th>
        </tr>
        <?php
$languagesByCode = Languages::getAllLanguages();

$sortFn = filter_input(INPUT_GET, 'sort', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR) === 'group'
  ? function ($a, $b) { return strcmp($a->getGroup(), $b->getGroup()); }
  : function ($a, $b) { return strcmp($a->getName(),  $b->getName()); };
uasort($languagesByCode, $sortFn);

foreach ($languagesByCode as $code => $lang) {
  $aliases = implode(', ', $lang->getAliases());
  $aliases = empty($aliases) ? $code : ($code . ', ' . $aliases);
  echo "<tr><td>{$lang->getName()}</td><td>{$lang->getGroup()}</td><td>$aliases</td></tr>";
}
        ?>
      </table>
    </div>


    <div style="margin-left: 10px; margin-bottom: 20px; float: left">
      <br />
      When prompted to guess the language of a text, you can use the language name or any of its aliases.
    For example, you can use any of the following to answer with German:
      <ul>
        <li><span class="command"><?php echo COMMAND_ANSWER ?> german</span></li>
        <li><span class="command"><?php echo COMMAND_ANSWER ?> de</span></li>
        <li><span class="command"><?php echo COMMAND_ANSWER ?> deutsch</span></li>
      </ul>

      <br />
      Note: The first alias in the table is always the ISO 639-1 code of the language.
    </div>
  </div>
  
</body>
</html>
