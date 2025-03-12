# hiPHoP

## Setup guide

Requirements:
  - `npm`
  - `php >= 7`
  - `mysql`

Steps:
  - Run `npm install`.
  - Run `cp config/env.example.php config/env.php` & fill in environment variables.

## Development guide

Run `make dev` to develop.

Create migrations: Run `php migrations/script.php` and follow its instructions.
