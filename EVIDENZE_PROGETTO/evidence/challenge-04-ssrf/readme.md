# Challenge 04 - SSRF (NewsAPI / Financial App)

## Attacco (prima della mitigazione)

Modificare l'`<option>` della select in scrittura articolo con `http://internal.finance:8001/user-data.php` e osservare dati finanziari nella risposta Livewire.

## Mitigazione implementata

- `LatestNews.php`: l'utente sceglie solo il **paese** (`it`, `gb`, `us`); l'URL NewsAPI è costruito lato server.
- `HttpService.php`: allowlist host, niente redirect, blocco `internal.finance` per non-admin.
- `config/cors.php`: origini ristrette al blog e admin panel.

## Verifica post-mitigazione

1. Come writer, aprire DevTools e tentare di inviare un URL arbitrario: la select non espone più URL modificabili.
2. Tentare SSRF verso `internal.finance` dalla UI writer: messaggio di errore / nessun dato finanziario.
3. Come admin su `internal.admin:8000`, la dashboard deve ancora caricare i dati finanziari.

## Screenshot da aggiungere

- Network tab con tentativo SSRF fallito.
- Dashboard admin con dati finanziari OK.
