# FBReviews
Facebook Reviews Scraper for Laravel 5

## Installation

To install, run the following in your project directory:

``` bash
$ composer require div-art/fbreviews
```

Then in `config/app.php` add the following to the `providers` array:

```
\DivArt\FBReviews\FBReviewsServiceProvider::class,
```

Also in `config/app.php`, add the Facade class to the `aliases` array:

```
'FBReviews' => \DivArt\FBReviews\Facades\FBReviews::class,
```

## Configuration

To publish FBReviews configuration file, run the following `vendor:publish` command:

``` bash
$ php artisan vendor:publish --provider="DivArt\FBReviews\FBReviewsServiceProvider"
```

This will create a fbreview.php in your config directory. Then you can make next command

``` bash
$ php artisan migrate
```

Add this code to app/Console/Kernel.php to method "schedule"

```
$schedule->command('fbreview:scrap')
    ->timezone(config('fbreview.fb_timezone'))
    ->dailyAt(config('fbreview.fb_daily_at'));
```
Add this conf to .env file

```
FACEBOOK_API_KEY=<YOUR FACEBOOK API KEY>
FACEBOOK_SECRET_KEY=<YOUR FACEBOOK SECRET KEY>
FACEBOOK_DAILY_AT=<TIME AT DAY SHEDULER>
FACEBOOK_TIMEZONE=<TIMEZOME>
```
Add to cron

```
// cron sheduler
* * * * * php \path\artisan schedule:run
```

# Usage

Send GET requet to <YOUR DOMAIN>/fbreview/reviews?url=<YOUR PAGE FACEBOOK>

# Methods

Get reviews 

```
FBReviews::getByID(<FACEBOOK PAGE ID>);
FBReviews::getByUrl(<FACEBOOK PAGE URL>);
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.