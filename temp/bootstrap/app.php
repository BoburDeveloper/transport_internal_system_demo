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
/*
 * global constants
 */
$document = 'document';
$technical = 'technical';
$medical = 'medical';
$roles = 'roles';
$users = 'users';
$orgs = 'orgs';
$dispatcher = 'dispatcher';
$director = 'director';
$drivers = 'drivers';

define('DOCUMENT', $document);
define('TECHNICAL', $technical);
define('MEDICAL', $medical);
define('ROLES', $roles);
define('USERS', $users);
define('ORGS', $orgs);
define('DISPATCHER', $dispatcher);
define('DIRECTOR', $director);
define('DRIVERS', $drivers);

define('TYPES', [
    $document=>['table'=>DOCUMENT, 'sequence'=>DOCUMENT.'_id_seq'],
    $technical=>['table'=>TECHNICAL, 'sequence'=>TECHNICAL.'_id_seq'],
    $medical=>['table'=>MEDICAL, 'sequence'=>MEDICAL.'_id_seq'],
    $roles=>['table'=>ROLES, 'sequence'=>ROLES.'_id_seq'],
    $users=>['table'=>USERS, 'sequence'=>USERS.'_id_seq'],
    $orgs=>['table'=>ORGS, 'sequence'=>ORGS.'_id_seq'],
    $dispatcher=>['table'=>DISPATCHER, 'sequence'=>DISPATCHER.'_id_seq'],
    $director=>['table'=>DIRECTOR, 'sequence'=>DIRECTOR.'_id_seq'],
    $drivers=>['table'=>DRIVERS, 'sequence'=>DRIVERS.'_id_seq'],
]);
/*
 * end  global consants
 */
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
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
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
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
