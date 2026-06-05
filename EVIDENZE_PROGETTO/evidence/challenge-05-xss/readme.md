# Challenge 5 - Validazione contenuto articolo non presente o non corretta

## Scenario

Durante la creazione di un articolo, il contenuto del body può essere manomesso e usato per inserire script malevoli.

## Attacco

L’attacco consiste nell’inserire un payload JavaScript nel body dell’articolo tramite modifica della richiesta.

## Mitigazione

La mitigazione è stata fatta filtrando e sanitizzando il contenuto prima del salvataggio e gestendo l’output in modo sicuro.

## Verifica finale

Dopo la correzione, il payload non viene più eseguito quando l’articolo viene visualizzato, dando un messaggio di errore.
