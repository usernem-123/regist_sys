# Registrar ERD migration starter

These are initial Laravel migration files reconstructed from the clearer ERD screenshot.

## Install
Copy the PHP files into `database/migrations/` in your Laravel project.

Configure `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=registrar_sys
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Then run:
```powershell
php artisan migrate:status
php artisan migrate
```

## Important review notes
- The diagram shows `int` PKs but does not show whether they are auto-generated. These migrations use explicit integer primary keys, not auto-incrementing IDs.
- Column lengths and decimal precision are not specified in the image. `string()` and conservative decimal precisions are provisional implementation choices.
- `middle_name`, `email`, `contact_number`, some remarks/dates, and `final_grade` are nullable as a practical assumption; verify against the professor's requirements.
- Unique constraints on relationship combinations are inferred where duplicates would normally be invalid; confirm them against the official schema.
- `timestamps()` were not added because the ERD does not show `created_at` / `updated_at`.
- The screenshot labels are singular/plural-normalized to Laravel-style table names (e.g. `COLLEGE` -> `colleges`). Confirm whether the team expects exact uppercase table names before applying this schema to a shared database.
- Review the `CLEARANCE_DETAIL` office relationship and the relationship lines against the full ERD before using this in production.
- Test only against a fresh development database first.
