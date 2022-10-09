### CLI
We should be able to create and delete user & admin from the command line, using tinker, factory, db:seed

```
User::create([
    'name' => 'manager',
    'email' => 'manager@admin.com',
    'password' => bcrypt('manager'),
    'is_admin' => 1,
]);
```
