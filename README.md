## Text language guesser

Text-based language guessing game via a bot. This project has API endpoints for getting new texts and processing answers.

This is currently set up so that it can be called with Nightbot, a popular bot for Twitch.
In particular, the user that solves the answer is inferred by a HTTP header specific to Nightbot. You can change the logic
in `answer.php`, e.g. by hardcoding it to a string like "Unknown". While the user that solved the answer is logged, this
information is not used or displayed anywhere at the moment!

## Setup
- Change the API secret in config.php
- Add the commands as detailed below

## Adding new texts

Modify the text lines in `data/texts.php`
- Do not change the starting PHP code
- Run validate_data.php and fix any errors
- Empty lines will be ignored
- You can write comments by starting a line with `#`—they will be ignored!

### Adding new languages

Modify `data/Languages.php`. Note that the entire code base assumes that languages have a two-letter code! Do not use codes of any other length!


## Nightbot commands

| Command | Message |
| ------- | ------- |
| !langs  | See https://example.org/ext/lang
| !langq  | `$(eval const api = $(urlfetch json https://example.org/ext/lang/poll.php?secret=9085e6b174dab879&variant=$(querystring)); api.result)` |
| !guess  | `$(eval const api = $(urlfetch json https://example.org/ext/lang/answer.php?secret=9085e6b174dab879&a=$(querystring)); api.result)` |
| !g      | ^ same as !guess for convenience. Seems not to work as command alias, so copy the same text as above |

## Files
- `answer.php` is called by the !guess command to process answers
- `poll.php` is used by the !q command and can be called from a timer
- `validate_data.php` should be run whenever you add new texts or languages
- `regular_poll.php`: Open this in your browser and keep it open to regularly call poll.php and send results to Nightbot
