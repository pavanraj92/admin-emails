# Admin Email Template Manager

This package provides an Admin Email Template Manager for managing email templates within your application.

## Features

- Create new emails
- View a list of existing emails
- Update email details
- Delete emails

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

## Update `composer.json`

Add the following to your `composer.json` to use the package from a local path:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/pavanraj92/admin-emails.git"
    }
]
```

## Installation

```bash
composer require admin/emails --dev
```

## Usage

1. Publish the configuration and migration files:
    ```bash
    php artisan email:publish --force

    composer dump-autoload
    
    php artisan migrate
    ```
2. Access the Email manager from your admin dashboard.

## CRUD Example

```php
// Creating a new email template
$template = new EmailTemplate();
$template->title = 'Welcome Email';
$template->subject = 'Welcome to Our Service';
$template->description = '<p>Hello {{user_name}}, welcome!</p>';
$template->save();
```

## Customization

You can customize views, routes, and permissions by editing the configuration file.

## License

This package is open-sourced software licensed under the Dotsquares.write code in the readme.md file regarding to the admin/email manager
