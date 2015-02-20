pubnub-laravel
==============

**NOTE** This is a beta release.

This is a nice, clean, OOP Laravel 4 wrapper for [Pubnub's terrible php library](https://github.com/pubnub/php-composer).

All of the (useful) public methods of the base library have been wrapped and exposed with [proper parameters](https://github.com/pubnub/php-composer/blob/master/lib/Pubnub/Pubnub.php#L83-L86), consistent return values, and actual exceptions instead of [incomprehensible array-errors](https://github.com/pubnub/php-composer/blob/master/lib/Pubnub/Pubnub.php#L122).

Two methods have not been wrapped or exposed: `history()` and `detailedHistory()`, because they return a completely metadata-less array of messages that isn't actually that useful.

Here are some things still to do. Got some time and a good brain? Submit a pull request!

- [ ] Write some tests. Not sure how best to do this, we'd need to mock the Pubnub calls somehow.
- [ ] You can't work with more than one channel at once; this is a restriction of the base library, but maybe one that could be worked around?
- [ ] I'm not an expert in this sort of blocking architecture. There may be a better way to implement the `subscribe()` method, but I'm not sure what it is at this stage.
- [ ] Maybe figure out the history and detailedHistory methods.
- [ ] The `presence()` method doesn't seem to do anything, at least in my brief testing. I think it's just borken? On that note:
- [ ] Maybe stop wrapping the base library and just rewrite the whole damn thing cause seriously what is it up to.

## Installing

To install, add the package to your `composer.json`:

```json
"require" : {
    ...
    "auraeq/pubnub-laravel" : "dev-master"
    ...
}
```

then run `composer update`.

Add the following to your `config/app.php` under `'providers'`:

```php
'Aura\PubnubLaravel\PubnubLaravelServiceProvider',
```

And then add the following to your `config/app.php` under `'aliases'`:

```php
'Pubnub'  => 'Aura\PubnubLaravel\Facades\PubnubLaravelFacade'
```

You'll also want to publish the config file:

```bash
php artisan config:publish aura/pubnub-laravel
```

And then configure at least your `'origin'`, `'publish_key'` and `'subscriber_key'`.

## Usage

To set the channel:

```php
Pubnub::setChannel('channel');
```

You can also set to channel for each method individually, as outlined below. If you try to use a method without having a channel set, a `PubnubChannelException` will be thrown.

---

To publish a message:

```php
Pubnub::publish($message[, $channel]);
```

Returns `true` on success or throws `PubnubPublishFailedException` on failure.

---

**Note** This method is blocking. It will never end until there's an error, you return false from your callback, or php times out (I guess).

To subscribe to a message:

```php
Pubnub::subscribe(Closure $callback[, $channel]);
```

Returns `true` on success or throws `PubnubSubscribeFailedException` on failure.

There is also a `presence()` method with the same signature that is supposed to notify you of arrivals/departures in the channel you're subscribed to, but it doesn't seem to work (see note above).

---

To see who's currently subscribed:

```php
Pubnub::hereNow([$channel]);
```

Returns an array of UUIDs from Pubnub.
