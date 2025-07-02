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

| Method | Endpoint           | Description           |
|--------|-------------------|-----------------------|
| GET    | `/emails`     | List all emails   |
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

## Publish Files

After installing, publish the module's migrations, config, views, or other assets:

```bash
php artisan vendor:publish --tag=email

## CRUD Example

```php
// Creating a new email template
$template = new EmailTemplate();
$template->title = 'Welcome Email';
$template->subject = 'Welcome to Our Service';
$template->description = '<p>Hello {{user_name}}, welcome!</p>';
$template->save();

// Updating an email template
$template = EmailTemplate::find(1);
$template->subject = 'Updated Subject';
$template->save();

// Deleting an email template
$template = EmailTemplate::find(1);
$template->delete();
```

## Customization

You can customize views, routes, and permissions by editing the configuration file.

## License

MIT license
