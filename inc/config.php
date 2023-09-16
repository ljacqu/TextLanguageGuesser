<?php

define('API_SECRET', '9085e6b174dab879');

/**
 * If poll.php is called by Nightbot automatically and there is an unsolved riddle, how many seconds from its creation
 * should we wait before solving the riddle and generating a new one?
 */
define('BOT_POLL_WAIT_SECONDS', 180);

/**
 * If poll.php is called by a user (via Nightbot) and there is an unsolved riddle, how many seconds from its creation
 * should we wait before solving the riddle and generating a new one?
 */
define('USER_POLL_WAIT_SECONDS', 90);

/**
 * HTTP header name, as transformed by PHP, that Nightbot sends for identifying the
 * originator of the request. The actual header is 'Nightbot-User'.
 * See https://docs.nightbot.tv/variables/urlfetch
 */
define('USER_HTTP_HEADER', 'HTTP_NIGHTBOT_USER');

define('COMMAND_QUESTION', '!q');
define('COMMAND_ANSWER', '!g');
define('COMMAND_LANGUAGES', '!langs');
