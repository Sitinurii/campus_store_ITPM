# Repository Guidance

## Project
- This workspace currently contains a standalone PHP/MySQLi connection script in `koneksi.php`.
- Local development targets MAMP at `localhost:8889` and the `campus_store` database.
- No dependency manager, test suite, or application framework is currently present.

## Changes
- Keep changes compatible with the existing plain PHP and MySQLi setup unless the project is deliberately migrated.
- Treat the credentials in `koneksi.php` as local development values; do not add real credentials or secrets to committed files.
- Preserve the script's current role as a connection check unless the user asks to change its behavior.

## Validation
- Run `php -l koneksi.php` after PHP changes to check syntax.
- Runtime connection checks require MAMP's MySQL server and the configured database to be available.