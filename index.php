<html>
<head>
  <title>Language guess</title>
  <style type="text/css">
    td, th {
      border: 1px solid #000;
    }
    table {
      border-collapse: collapse;
    }
    .lang {
      background-color: #000;
    }
    .lang:hover {
      background-color: #fff;
    }
  </style>
</head>
<body>

  <?php

require 'functions.php';
require './data/current_state.php';

echo '<h2>Recent riddles</h2>';
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
</body>
</html>
