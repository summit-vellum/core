## Requirements

- PHP >= 7.2.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Database Migration
When you want to migrate database only use the following command:
```php 
php artisan migrate
```

## Database Seeding
When you want to seed data use the following command:
```php 
php artisan db:seed 
```

## How to create resources 
When you want to create resources use the following command:

Example:
```php 
php artisan make:module Category
```
Note: Resource name must be {PascalCase}

## Publish all resources 
When you want to publish resources use the following command:

Example:
```php 
php artisan vendor:publish
```