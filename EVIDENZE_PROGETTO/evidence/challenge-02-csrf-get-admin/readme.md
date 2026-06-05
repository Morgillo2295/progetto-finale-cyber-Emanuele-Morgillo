# Challenge 02 - Mitigazione CSRF e state change via GET

Le rotte admin che assegnavano ruoli erano esposte tramite metodo GET, permettendo modifiche di stato applicativo attraverso URL diretti.

La mitigazione consiste nella conversione delle rotte in PATCH e nella sostituzione dei link con form protetti da token CSRF.

Il test finale ha confermato che il vecchio URL diretto non è più accettato e che l’azione funziona solo tramite submit controllato dal pannello admin.