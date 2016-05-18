[![Build Status](https://travis-ci.org/xolf/io-db.svg?branch=master)](https://travis-ci.org/xolf/io-db)

# io-db
#### Easy setup within 30 seconds
A static json database system

```php
$user = $io->table('user')->document('admin');

echo $user->name;
```

```php
$user = $io->table('user')->document('admin')->write(['password' => 123456]);

echo $user->name . ' Password: ' . $user->password;
```

