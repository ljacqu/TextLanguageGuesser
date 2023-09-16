## Text language guesser

Text-based language guessing game via a bot. This project has API endpoints for getting new texts and processing answers.

This is currently set up so that it can be called with Nightbot, a popular bot for Twitch.

## Setup
- Change the API secret in config.php
- Add the commands as detailed below


## Nightbot commands

| Command | Message |
| ------- | ------- |
| !langs  | See https://example.org/ext/lang
| !langq  | `$(eval const api = $(urlfetch json https://example.org/ext/lang/poll.php?secret=9085e6b174dab879); api.result)` |
| !guess  | `$(eval const api = $(urlfetch json https://example.org/ext/lang/answer.php?secret=9085e6b174dab879&a=$(querystring)); api.result)` |
| !g      | ^ same as !guess for convenience. Seems not to work as command alias, so copy the same text as above |

Timer: TBD
