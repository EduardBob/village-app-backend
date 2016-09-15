<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => env('APP_DEBUG'),

	/*
	|--------------------------------------------------------------------------
	| Application cache
	|--------------------------------------------------------------------------
	| Set this to true to use the cache decorators, this will greatly improve
	| the application speed and performance
	*/
	'cache' => env('APP_CACHE', false),

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => 'http://localhost',

	/*
	|--------------------------------------------------------------------------
	| Allow static translations to be editable via GUI
	|--------------------------------------------------------------------------
	| Enabling this will have slight performance hit,
	| about 20 to 50ms page load time increase.
	*/
	'translations-gui' => true,

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => env('APP_TIMEZONE', 'UTC'),

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'ru',

	/*
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => env('APP_KEY', 'Hn9Q.<agDv*kfuNT,V8zsehZ84]wW2bg'),

	'cipher' => MCRYPT_RIJNDAEL_128,

	/*
	|--------------------------------------------------------------------------
	| Logging Configuration
	|--------------------------------------------------------------------------
	|
	| Here you may configure the log settings for your application. Out of
	| the box, Laravel uses the Monolog PHP logging library. This gives
	| you a variety of powerful log handlers / formatters to utilize.
	|
	| Available Settings: "single", "daily", "syslog", "errorlog"
	|
	*/

	'log' => 'daily',

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => [

		/*
		 * Laravel Framework Service Providers...
		 */
		\Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
		\Illuminate\Auth\AuthServiceProvider::class,
		\Illuminate\Bus\BusServiceProvider::class,
		\Illuminate\Cache\CacheServiceProvider::class,
		\Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
		\Illuminate\Routing\ControllerServiceProvider::class,
		\Illuminate\Cookie\CookieServiceProvider::class,
		\Illuminate\Database\DatabaseServiceProvider::class,
		\Illuminate\Encryption\EncryptionServiceProvider::class,
		\Illuminate\Filesystem\FilesystemServiceProvider::class,
		\Illuminate\Foundation\Providers\FoundationServiceProvider::class,
		\Illuminate\Hashing\HashServiceProvider::class,
		\Illuminate\Mail\MailServiceProvider::class,
		\Illuminate\Pagination\PaginationServiceProvider::class,
		\Illuminate\Pipeline\PipelineServiceProvider::class,
		\Illuminate\Queue\QueueServiceProvider::class,
		\Illuminate\Redis\RedisServiceProvider::class,
		\Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
		\Illuminate\Session\SessionServiceProvider::class,
		\Illuminate\Translation\TranslationServiceProvider::class,
		\Illuminate\Validation\ValidationServiceProvider::class,
		\Illuminate\View\ViewServiceProvider::class,

		/*
		 * Application Service Providers...
		 */
		\App\Providers\AppServiceProvider::class,
		\App\Providers\BusServiceProvider::class,
		\App\Providers\ConfigServiceProvider::class,
		\App\Providers\EventServiceProvider::class,
		\App\Providers\RouteServiceProvider::class,

		\Modules\Core\Providers\AsgardServiceProvider::class,
		\Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,

		\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
		\EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider::class,
		\Yajra\Datatables\DatatablesServiceProvider::class,
		\Jenssegers\Date\DateServiceProvider::class,
		\Davibennun\LaravelPushNotification\LaravelPushNotificationServiceProvider::class,
		\Maatwebsite\Excel\ExcelServiceProvider::class,
//		\Felixkiss\UniqueWithValidator\UniqueWithValidatorServiceProvider::class,
	],

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => [

		'App'       => \Illuminate\Support\Facades\App::class,
		'Artisan'   => \Illuminate\Support\Facades\Artisan::class,
		'Auth'      => \Illuminate\Support\Facades\Auth::class,
		'Blade'     => \Illuminate\Support\Facades\Blade::class,
		'Bus'       => \Illuminate\Support\Facades\Bus::class,
		'Cache'     => \Illuminate\Support\Facades\Cache::class,
		'Config'    => \Illuminate\Support\Facades\Config::class,
		'Cookie'    => \Illuminate\Support\Facades\Cookie::class,
		'Crypt'     => \Illuminate\Support\Facades\Crypt::class,
		'DB'        => \Illuminate\Support\Facades\DB::class,
		'Eloquent'  => \Illuminate\Database\Eloquent\Model::class,
		'Event'     => \Illuminate\Support\Facades\Event::class,
		'File'      => \Illuminate\Support\Facades\File::class,
		'Hash'      => \Illuminate\Support\Facades\Hash::class,
		'Input'     => \Illuminate\Support\Facades\Input::class,
		'Inspiring' => \Illuminate\Foundation\Inspiring::class,
		'Lang'      => \Illuminate\Support\Facades\Lang::class,
		'Log'       => \Illuminate\Support\Facades\Log::class,
		'Mail'      => \Illuminate\Support\Facades\Mail::class,
		'Password'  => \Illuminate\Support\Facades\Password::class,
		'Queue'     => \Illuminate\Support\Facades\Queue::class,
		'Redirect'  => \Illuminate\Support\Facades\Redirect::class,
		'Redis'     => \Illuminate\Support\Facades\Redis::class,
		'Request'   => \Illuminate\Support\Facades\Request::class,
		'Response'  => \Illuminate\Support\Facades\Response::class,
		'Route'     => \Illuminate\Support\Facades\Route::class,
		'Schema'    => \Illuminate\Support\Facades\Schema::class,
		'Session'   => \Illuminate\Support\Facades\Session::class,
		'Storage'   => \Illuminate\Support\Facades\Storage::class,
		'URL'       => \Illuminate\Support\Facades\URL::class,
		'Validator' => \Illuminate\Support\Facades\Validator::class,
		'View'      => \Illuminate\Support\Facades\View::class,
		'PdfParser' => \Smalot\PdfParser\Parser::class,
		'Excel' => Maatwebsite\Excel\Facades\Excel::class,
//      'Sentry' => \Cartalyst\Sentry\Facades\Laravel\Sentry::class,

//		custom
        'JWTAuth' => \Tymon\JWTAuth\Facades\JWTAuth::class,
        'JWTFactory' => \Tymon\JWTAuth\Facades\JWTFactory::class,
//      'Datatables' => Yajra\Datatables\Datatables::class,
        'Date' => \Jenssegers\Date\Date::class,
		'PushNotification' => \Davibennun\LaravelPushNotification\Facades\PushNotification::class,
	],

];
