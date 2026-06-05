# Challenge 06 - Mass assignment

## Attacco (prima della mitigazione)

Con `is_admin` in `$fillable` e form profilo, aggiungere campo nascosto `is_admin=1` via DevTools e inviare: privilege escalation.

## Mitigazione implementata

- `User::$fillable` limitato a `name`, `email`, `password`.
- `ProfileController` aggiorna solo campi validati esplicitamente.
- Rotte `/profile` (GET/PUT) e link in navbar.

## Verifica post-mitigazione

1. Aprire `/profile`, aggiungere input `is_admin=1` nel form.
2. Salvare: l'utente non diventa admin.
3. Controllare DB o pannello admin: ruoli invariati.

## Screenshot da aggiungere

- DevTools con campo extra inviato.
- Profilo/ruoli utente invariati dopo submit.
