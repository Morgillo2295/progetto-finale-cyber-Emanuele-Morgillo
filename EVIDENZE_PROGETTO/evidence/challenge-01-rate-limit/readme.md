# Challenge 01 - Rate limiting

La rotta pubblica `/articles/search` era esposta senza limiti di richieste, rendendo possibile un abuso tramite spam o richieste automatizzate.

La mitigazione consiste nell’aver aggiunto un rate limiter custom per IP, configurato in `AppServiceProvider.php` e applicato alla rotta con `throttle:article-search`.

Il test finale ha confermato la comparsa della risposta `429 Too Many Requests` dopo il superamento della soglia.