<?php

require './inc/config.php';
require './inc/functions.php';
require './data/current_callback.php';

setJsonHeader();
verifyApiSecret();

// Get Nightbot-Response-Url header, as documented in https://docs.nightbot.tv/variables/urlfetch
$callbackUrl = filter_input(INPUT_SERVER, 'HTTP_NIGHTBOT_RESPONSE_URL', FILTER_VALIDATE_URL);
if (empty($callbackUrl)) {
  die(toResultJson('Error: Invalid callback URL'));
}

$data_callbackUrl = [ 'url' => $callbackUrl, 'created' => time() ];

$fh = fopen('./data/current_callback.php', 'w') or die(toResultJson('Error: Could not save callback URL'));
fwrite($fh, '<?php $data_callbackUrl = ' . var_export($data_callbackUrl, true) . ';');
fclose($fh);

// Nightbot returns an error if the response is completely empty, but will trim the response and not
// write anything if trims to empty -> so return one space
echo toResultJson(' ');
