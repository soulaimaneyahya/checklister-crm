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
---
### Testig
I added tests for the controller functions. You can run 

```bash
php vendor/bin/phpunit --testdox
```
to test them out.

WeCan tests our database with a successful seeder that generates complete system data
```
php artisan db:seed
```

### User Payment

Using php tinker

- $user = User::with('payment')->find(2);
- $user->payment->payment_status;
- $payment = Payment::where('user_id', $user->id)->first();
- $payment->payment_status = "cancelled";
- $payment->save();
- $user->payment && $user->payment->payment_status == "approved"; # T || F
