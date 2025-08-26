# Non-Profit Portal Backend (Pure PHP 8 + MySQL)

Custom lightweight MVC-ish REST API for Employees, Salaries, and Leaves.
- PHP 8+, PDO (MySQL), no frameworks
- Router with dynamic params
- Repository pattern + PDO prepared statements
- JSON responses, CORS enabled

## Quick start
```bash
# 1) Install autoload (no deps, just PSR-4)
composer dump-autoload

# 2) Configure DB
cp app/Config/config.php app/Config/config.local.php  # optional
# edit app/Config/config.php with your DB creds

# 3) Create database + tables
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS nonprofit_portal CHARACTER SET utf8mb4;"
mysql -u root -p nonprofit_portal < database/schema.sql
mysql -u root -p nonprofit_portal < database/seed.sql

# 4) Run
php -S localhost:8000 -t public
```

## Endpoints
- GET    /api/v1/employees
- POST   /api/v1/employees
- GET    /api/v1/employees/{id}
- PUT    /api/v1/employees/{id}
- DELETE /api/v1/employees/{id}

- GET    /api/v1/salaries           (?employee_id=ID optional)
- POST   /api/v1/salaries
- PUT    /api/v1/salaries/{id}
- DELETE /api/v1/salaries/{id}
- POST   /api/v1/salaries/calculate   # returns net from base/bonus/deduction

- GET    /api/v1/leaves
- POST   /api/v1/leaves
- PUT    /api/v1/leaves/{id}
- DELETE /api/v1/leaves/{id}
