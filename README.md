# boardgames-web
CWA Individual work

## Database configuration and security

Set `DB_USER` and `DB_PASSWORD` in the PHP runtime environment before serving the application. `DB_HOST` defaults to `localhost`; `DB_NAME` defaults to `boardgames`. `.env.example` is a reference; plain PHP does not load dotenv files automatically. Install the PDO MySQL extension for a real development database. Existing route behavior is retained, but missing configuration or a failed connection now gives HTTP 503 with a generic message instead of leaking PDO internals. Connections use `utf8mb4`.

If the former committed password was ever used, manually rotate it and review Git history exposure. Removing it from current code does not revoke it. No real credentials were checked or rotated and no database/user data was changed.

Offline validation (Docker required):

```sh
docker run --rm --network none -v "$PWD:/app:ro" -w /app php:8.3-cli php tests/database_test.php
```

Tests use synthetic environment values in a network-disabled container, verify config rejection and safe error responses, and never connect to a real database. This limited change does not establish production readiness, verify MySQL queries or replace a full authentication/session review.
