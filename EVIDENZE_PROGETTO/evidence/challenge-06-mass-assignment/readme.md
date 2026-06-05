# Challenge 6 - Uso non corretto della proprietà fillable nei modelli

## Scenario

Un utente malevolo può alterare il form profilo e tentare di inviare campi non previsti, come quelli legati ai ruoli.

## Attacco

L’attacco consiste nel modificare la richiesta e aggiungere campi sensibili per tentare una privilege escalation tramite mass assignment.

## Mitigazione

La mitigazione è stata fatta definendo correttamente la proprietà `fillable` del modello, includendo solo i campi realmente gestiti dal form.

## Verifica finale

Dopo la correzione, i campi non autorizzati non vengono più assegnati al modello.

## Screenshot

- Pagina profilo prima dell’attacco.
- Request modificata con campo non autorizzato.
- Effetto della vulnerabilità.
- Codice con `fillable` corretto.
- Verifica finale dopo il fix.