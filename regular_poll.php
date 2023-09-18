<?php

require './conf/config.php';
require './inc/functions.php';
require './conf/current_token.php';

verifyApiSecret();

if (isset($_GET['msg'])) {
  $message = filter_input(INPUT_GET, 'msg', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR);

  setJsonHeader();

  if (empty($message)) {
    die(toResultJson('Error: the message is empty'));
  }

  if (isTokenExpired($data_token)) {
    die(toResultJson('Error: Missing or expired Nightbot token'));
  }

  $data = ['message' => $message];
  $jsonData = json_encode($data);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.nightbot.tv/1/channel/send');
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $data_token['access_token']
  ]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    echo toResultJson('Error sending Nightbot message: ' . curl_error($ch));
  } else {
    $jsonAnswer = json_decode($response, true);
    if (isset($jsonAnswer['message'])) {
      echo toResultJson('Error: ' . $jsonAnswer['message']);
    } else {
      echo toResultJson('Successfully sent message (' . date('H:i') . ')');
    }
  }

  curl_close($ch);
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Language guesser - refresher</title>
  <script>
    const secret = '<?php echo API_SECRET ?>';

    function getCurrentTimeAsString() {
      const currentdate = new Date();
      return String(currentdate.getHours()).padStart(2, '0')
        + ":" + String(currentdate.getMinutes()).padStart(2, '0')
        + ":" + String(currentdate.getSeconds()).padStart(2, '0');
    }

    const callPollFile = () => {
      const request = new Request(`poll.php?secret=${secret}&variant=timer`, {
        method: 'GET'
      });

      const pollErrorElem = document.getElementById('pollerror');
      fetch(request)
        .then((response) => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then((data) => {
          if (data.result.trim() !== '') {
            document.getElementById('result').innerHTML = data.result;
          }

          document.getElementById('time').innerHTML = getCurrentTimeAsString();

          pollErrorElem.style.display = 'none';
          return data.result;
        })
        .then((result) => {
          if (result.trim() !== '') {
            sendMessage(result);
          }
          setBodyBgColor('#e5fff9');
        })
        .catch((error) => {
          pollErrorElem.style.display = 'block';
          document.getElementById('pollerrormsg').innerHTML = error.message;
          setBodyBgColor('#fff0f0');
        });
    };

    const sendMessage = (msg) => {
      const request = new Request(`regular_poll.php?secret=${secret}&msg=` + encodeURIComponent(msg), {
        method: 'GET'
      });

      const msgElem = document.getElementById('msg');
      fetch(request)
        .then((response) => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then((data) => {
          if (!data.result || !data.result.startsWith('Success')) {
            msgElem.className = 'error';
            msgElem.innerText = data.result ?? data;
          } else {
            msgElem.className = '';
            msgElem.innerText = data.result;
          }
          setBodyBgColor('#eeffee');
        })
        .catch((error) => {
          msgElem.className = 'error';
          msgElem.innerText = error.message;
          setBodyBgColor('#fff0f0');
        });
    };

    var isActive = true;

    function setBodyBgColor(color) {
      document.body.style.backgroundColor = color;
    }

    function togglePause() {
      const isChecked = document.getElementById('pause').checked;
      isActive = !isChecked;
      setBodyBgColor(isActive ? '#fff' : '#ccc');
    }

    function callPollRegularly() {
      if (isActive) {
        callPollFile();
      }
      setTimeout(callPollRegularly, 3000);
    }
  </script>
  <style>
  body {
    font-family: Arial;
  }
  .error {
    color: #f00;
    background-color: #fcc;
  }
  #result {
    border: 1px solid #999;
    background-color: #ccc;
    padding: 5px;
    margin: 12px;
    display: inline-block;
  }
  </style>
</head>
<body onload="togglePause(); callPollRegularly()">
  <h2>Poll</h2>
  <div id="result" title="Last guess message"><span style="color: #333; font-style: italic; font-size: 0.9em">No response with text received yet</span></div>
  <div>Last request: <span id="time"></span></div>
  <div id="pollerror" class="error" style="display: none">Error during last call: <span id="pollerrormsg"></span> </div>
  <div>Last Nightbot message: <span id="msg"></span></div>

  <div>
    <input type="checkbox" name="pause" id="pause" onchange="togglePause();" /> <label for="pause">Pause</label>
  </div>

  <?php
  if (isTokenExpired($data_token)) {
    echo '<h2>No Nightbot token</h2>
      <div class="error" style="padding: 9px">No valid Nightbot token has been found!
      Please go to <a href="obtain_token.php?secret=' . API_SECRET . '">obtain_token</a> to generate a new one</div>';
  }
  ?>
</body>
</html>

<?php

function isTokenExpired($data_token) {
  return !isset($data_token['access_token']) || time() > $data_token['expires'];
}
