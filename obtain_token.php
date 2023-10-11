<?php

require './conf/config.php';
require './inc/functions.php';
require './conf/current_token.php';

if (isset($_GET['state']) && !isset($_GET['secret'])) {
  // Very ugly, but does the trick—Nightbot login allows to pass on a state param,
  // which we fill with our secret.
  $_GET['secret'] = $_GET['state'];
}

verifyApiSecret();

// Use ?debug to see the self URL and make sure there is a redirect URL entry in
// https://nightbot.tv/account/applications that is IDENTICAL. Wildcards are not supported.
// Make sure that the URL that is being logged is also correct, in case some server
// environment variables are somehow wrong.

if (isset($_GET['debug'])) {
  var_dump(buildSelfUrl());
  exit;
}


// Documentation: https://api-docs.nightbot.tv/#oauth-2

$code = filter_input(INPUT_GET, 'code', FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR);
if (!empty($code)) {
  $data = [
    'client_id' => NIGHTBOT_CLIENT_ID,
    'client_secret' => NIGHTBOT_CLIENT_SECRET,
    'code' => $code,
    'grant_type' => 'authorization_code',
    'redirect_uri' => buildSelfUrl()
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.nightbot.tv/oauth2/token');
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $response = curl_exec($ch);

  // Debugging? Uncomment the line below to see what was returned.
  // var_dump($response);

  if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
  } else {

    /*
     * $token should be something like this:
     * array (
     *  'access_token' => '1234567890abcdefedcba09876543210a0c7f1a3',
     *  'token_type' => 'bearer',
     *  'expires_in' => 2592000,
     *  'refresh_token' => 'fedcba09876543210abcdef0123456789a5c3b0d',
     *  'scope' => 'channel_send',
     * );
     */
    $token = json_decode($response, true);


    if (isset($token['message'])) {
      // Nightbot likes to send a HTTP OK status with a "message" containing an error,
      // so pick up on this here. The OAuth response does not have a property "message"
      die('Error: ' . htmlspecialchars($token['message']));
    } else if (!isset($token['access_token'])) {
      die('Error: The response did not include the token');
    } else if (!isset($token['expires_in'])) {
      die('Error: Expiration property was not part of the response');
    }

    $token['expires'] = time() + $token['expires_in'] - 30;

    $fh = fopen('./conf/current_token.php', 'w') or die('Failed to write to file');
    fwrite($fh, '<?php $data_token = ' . var_export($token, true) . ';');
    fclose($fh);

    echo 'Sucess! The token has been persisted!';
  }
  exit;
}

$validToken = false;
if (isset($data_token['access_token'])) {
  echo 'The token will expire on ' . date('Y-m-d, H:i', $data_token['expires']);


  if (time() >= $data_token['expires']) {
    echo '. <b>Token is expired!</b>';
  } else {
    echo '. <span style="color: green">Token is valid &checkmark;</span>';
  }
  $validToken = time() > $data_token['expires'] - 7200; // allow to regenerate a token if it is only valid for 2 hours, or less
} else {
  echo 'No token exists yet.';
}

if (!$validToken || isset($_GET['force'])) {
  $redirectUrl = buildSelfUrl();
  $url = "https://api.nightbot.tv/oauth2/authorize?response_type=code&client_id=" . NIGHTBOT_CLIENT_ID . "&redirect_uri=" . urlencode($redirectUrl) . "&scope=channel_send&state=" . API_SECRET;
  echo '<br /><a href="' . $url . '">Click here to obtain a token</a>';
}

function buildSelfUrl() {
  return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
}
