# Admin Email Template Manager

This package provides an Admin Email Template Manager for managing email templates within your application.

---

## Features

- Create new emails
- View a list of existing emails
- Update email details
- Delete emails

---

## Requirements

- PHP >=8.2
- Laravel Framework >= 12.x

---

## Installation

### 1. Add Git Repository to `composer.json`

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/pavanraj92/admin-emails.git"
    }
]
```

### 2. Require the package via Composer
```bash
composer require admin/emails --dev
```

### 3. Publish assets
    ```bash
    php artisan emails:publish --force
    ```
---

## Usage

1. **Create**: Add a new email with name and description.
2. **Read**: View all emails in a paginated list.
3. **Update**: Edit email information.
4. **Delete**: Remove emails that are no longer needed.

## Example Endpoints

| Method | Endpoint      | Description           |
|--------|---------------|-----------------------|
| GET    | `/emails`     | List all emails       |
| POST   | `/emails`     | Create a new category |
| GET    | `/emails/{id}`| Get category details  |
| PUT    | `/emails/{id}`| Update a category     |
| DELETE | `/emails/{id}`| Delete a category     |

---

## Protecting Admin Routes

Protect your routes using the provided middleware:

```php
Route::middleware(['web','admin.auth'])->group(function () {
    // Admin emails routes here
});
```
---
## Database Tables

- `emails` - Stores email information
---

## License

This package is open-sourced software licensed under the MIT license.
