# SmsAero notifications channel for Laravel 5.3

This package makes it easy to send notifications using [smsaero.ru](//smsaero.ru)  with Laravel 5.3.

## Installation

Require this package in your composer.json and run composer update

```bash
"cazzzt/laravel-notification-smsaero": "@dev"
```

Then you must install the service provider:
```php
// config/app.php
'providers' => [
    ...
    Cazzzt\SmsAero\SmsAeroServiceProvider::class,
],
```

### Setting up the SmsAero service

Add your SmsAero login, secret key (hashed password), default sign and send channel to your `config/services.php`:

```php
// config/services.php
...
'smsaero' => [
    'user'  => env('SMSAERO_USER'),
    'secret' => env('SMSAERO_SECRET'),
    'sign' => env('SMSAERO_SIGN'),
    'digital' => env('SMSAERO_DIGITAL'),
],
...
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use Cazzzt\SmsAero\SmsAeroMessage;
use Cazzzt\SmsAero\SmsAeroChannel;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [SmsAeroChannel::class];
    }

    public function toSmsAero($notifiable)
    {
        return (new SmsAeroMessage())
            ->content('Task #{$notifiable->id} is complete!');
    }
}
```

### Available methods

`from()`: Sets the sender's name or phone number.

`content()`: Sets a content of the notification message.

## Testing

In the near future..

## Security

If you discover any security related issues, please email alex.i.lukin@yandex.ru instead of using the issue tracker.


## License

The MIT License (MIT).
