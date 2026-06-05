# Progetto Finale Cyber Blog by Emanuele Morgillo Hack

Documentazione evidenze: [EVIDENZE_PROGETTO/evidence/](EVIDENZE_PROGETTO/evidence/)

## Stato challenge

| # | Challenge | Stato mitigazione |
|---|-----------|-------------------|
| 1 | Rate limiter | Completata (search, careers, global, login/register) |
| 2 | CSRF (GET → PATCH) | Completata |
| 3 | Logging | Completata |
| 4 | SSRF | Completata |
| 5 | Stored XSS | Completata |
| 6 | Mass assignment | Completata (profilo + `$fillable`) |

## Setup locale (Windows)

Hosts (`C:\Windows\System32\drivers\etc\hosts`):

```
127.0.0.1 cyber.blog
127.0.0.1 internal.admin
127.0.0.1 internal.finance
```

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# creare DB cyber_blog e configurare .env
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Terminale 1: `php artisan serve --host=cyber.blog --port=8000`  
Terminale 2: `npm run dev`  
Terminale 3: `cd YYY-FinancialApp && php -S internal.finance:8001`

- Blog: http://cyber.blog:8000  
- Admin: http://internal.admin:8000  

## Riferimenti challenge (dettaglio)

Vedi i readme in `EVIDENZE_PROGETTO/evidence/challenge-0X-*/readme.md` e il PDF del corso per scenari e payload di test.
