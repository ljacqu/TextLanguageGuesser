<?php

require './inc/config.php';
require './inc/functions.php';


verifyApiSecret();

if (isset($_GET['msg'])) {
  $message = filter_input(INPUT_GET, 'msg', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR);
  require './data/current_callback.php';

  setJsonHeader();

  if (empty($message)) {
    die(toResultJson('Error: the message is empty'));
  }

  // TODO explain what to do
  if (empty($data_callbackUrl['url'])) {
    die(toResultJson('Nightbot callback URL is not set'));
  } else if ((time() - $data_callbackUrl['created']) > CALLBACK_URL_EXPIRATION_SECONDS) {
    die(toResultJson('Nightbot callback URL is not set, or too old!'));
  }

  $data = ['message' => $message];
  $jsonData = json_encode($data);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $data_callbackUrl['url']);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

  $response = curl_exec($ch);


  if (curl_errno($ch)) {
    echo toResultJson('Error send nightbot message: ' . curl_error($ch));
  } else {
    echo toResultJson('Successfully sent message (' . date('H:i') . ')');
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
    const callPollFile = () => {
      const request = new Request(`poll.php?secret=${secret}&variant=timer`, {
        method: "GET"
      });

      fetch(request)
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then((data) => {
          if (data.result.trim() !== '') {
            document.getElementById('result').innerHTML = data.result;
          }
          const currentdate = new Date();
          const datetime = currentdate.getHours() + ":"
            + currentdate.getMinutes() + ":"
            + currentdate.getSeconds();
          document.getElementById('time').innerHTML = datetime;
        })
        .catch((error) => {
          console.error("Fetch error:", error);
        });
    };

    function callPollRegularly() {
      callPollFile();
      setTimeout(callPollRegularly, 30000);
    }

    callPollRegularly();
  </script>
</head>
<body>
  <h2>Poll</h2>
  <div id="result">No response with text received yet</div>
  <div>Last request: <span id="time"></span></div>
</body>
</html>
