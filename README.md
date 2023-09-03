# Laravel casts

This package provides some additional castable classes for Laravel.

## Requirements

- PHP 8.1 and above
- Laravel 9 or 10

## Installation

Require this package with composer using the following command:

```bash
composer require bbprojectnet/laravel-casts
```

## Casts

### AsEnumCollection

Casts a value (json) to a Laravel Collection of Enums.

```php
protected $casts = [
	'roles' => AsEnumCollection::class . ':' . Role::class,
];
```

### AsHash

Saves the value as a hash using the Laravel Hash facade. As of Laravel 10, same as `hashed` cast.

```php
protected $casts = [
	'password' => AsHash::class,
];
```

### AsInterval

Casts a seconds value (integer) as a CarbonInterval class.

```php
protected $casts = [
	'timeout' => AsInterval::class,
];
```

### AsStrictArray

Same as `array`, except that a `null` value is cast to an empty array. Similarly, an empty array is stored in the database as `null`.

```php
protected $casts = [
	'items' => AsStrictArray::class,
];
```

### AsTimeZone

Cast a value (string) as a DateTimeZone class.

```php
protected $casts = [
	'timezone' => AsTimeZone::class,
];
```

## License

The Laravel casts package is open-sourced software licensed under the MIT license.
