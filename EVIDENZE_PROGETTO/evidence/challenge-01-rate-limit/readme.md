# Challenge 01 - Rate limiting

La rotta pubblica `/articles/search` era esposta senza limiti di richieste, rendendo possibile un abuso tramite spam o richieste automatizzate.

La mitigazione consiste in:

- Rate limiter su `/articles/search` (`throttle:article-search`, 10 req/min per IP).
- Rate limiter globale sul gruppo `web` (`throttle:global`, 120 req/min per IP) in `bootstrap/app.php`.
- Rate limiter su `/careers/submit` (`throttle:careers-submit`, 5 req/min per IP).
- Login Fortify: 5 tentativi/min (email + IP). Registrazione: 5 req/min per IP.

Il test finale ha confermato la comparsa della risposta `429 Too Many Requests` dopo il superamento della soglia.