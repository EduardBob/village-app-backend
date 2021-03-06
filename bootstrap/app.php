<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
	realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
	'Illuminate\Contracts\Http\Kernel',
	'App\Http\Kernel'
);

$app->singleton(
	'Illuminate\Contracts\Console\Kernel',
	'App\Console\Kernel'
);

$app->singleton(
	'Illuminate\Contracts\Debug\ExceptionHandler',
	'App\Exceptions\Handler'
);

$app->bind(
	\Modules\User\Http\Controllers\Admin\UserController::class,
	\Modules\Village\Http\Controllers\Admin\UserController::class
);

$app->bind(
	\Modules\User\Http\Requests\CreateUserRequest::class,
	\Modules\Village\Http\Requests\CreateUserRequest::class
);

$app->bind(
	\Modules\User\Http\Requests\UpdateUserRequest::class,
	\Modules\Village\Http\Requests\UpdateUserRequest::class
);

$app->bind(
	\Modules\User\Events\Handlers\SendRegistrationConfirmationEmail::class,
	\Modules\Village\Events\Handlers\SendRegistrationConfirmationEmail::class
);

$app->bind(
	\Modules\User\Events\Handlers\SendResetCodeEmail::class,
	\Modules\Village\Events\Handlers\SendResetCodeEmail::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
