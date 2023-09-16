## Text language guesser


## Nightbot commands

| Command | Message |
| ------- | ------- |
| !langs  | See https://example.org/ext/lang
| !langq  | `$(eval const api = $(urlfetch json https://example.org/ext/lang/poll.php?secret=9085e6b174dab879); api.result)` |
| !guess  | `$(eval const api = $(urlfetch json https://example.org/ext/lang/answer.php?secret=9085e6b174dab879&a=$(querystring)); api.result)` |
