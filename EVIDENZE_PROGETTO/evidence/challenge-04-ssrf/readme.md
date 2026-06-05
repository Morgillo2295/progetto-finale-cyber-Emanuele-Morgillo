### Challenge 4 - Manomissione input / SSRF

È stata individuata e mitigata una vulnerabilità di SSRF nella funzionalità di suggerimento news.
L’attacco consisteva nella manomissione del valore selezionato nella UI per indurre il server a contattare un endpoint interno non autorizzato.

La mitigazione è stata implementata tramite:
- allowlist server-side degli endpoint;
- validazione della proprietà Livewire;
- blocco degli host non ammessi;
- restrizione dell’accesso a `internal.finance` ai soli amministratori.