# Challenge 05 - Stored XSS

## Attacco (prima della mitigazione)

Con Burp Suite, inviare nel body dell'articolo payload come `<script>alert('hacked')</script>` o `<img src="x" onerror="alert('hacked')">` e visualizzare l'articolo: lo script viene eseguito con `{!! $article->body !!}`.

## Mitigazione implementata

- `app/Services/HtmlSanitizer.php`: rimuove tag pericolosi e attributi event handler.
- `ArticleController@store` e `@update`: sanitizzazione in salvataggio.
- `articles/show.blade.php`: sanitizzazione anche in visualizzazione (defense in depth).

## Verifica post-mitigazione

1. Ripetere l'attacco con Burp: il payload viene neutralizzato.
2. Aprire l'articolo: nessun `alert`, HTML sicuro mostrato come testo/tag ammessi.

## Screenshot da aggiungere

- Burp con payload inviato.
- Pagina articolo senza esecuzione script.
