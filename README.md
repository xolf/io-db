[![Build Status](https://travis-ci.org/xolf/io-db.svg?branch=master)](https://travis-ci.org/xolf/io-db)

# io-db
#### Easy setup within 30 seconds
A static json database system

### Fetch documents from the database
```php
$user = $io->table('user')->document('admin');

echo $user->name;
```

### Write to documents
```php
$user = $io->table('user')->document('admin')->write(['password' => 123456]);

echo $user->name . ' Password: ' . $user->password;
```

### Find Documents
```php
$users = $io->table('user')->documents()->where(['rights' => 'admin']);

var_dump($users);
```
