<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\Edashboard\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
       ['name' => 'apps#index', 'url' => '/apps', 'verb' => 'GET'],
       ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
       ['name' => 'apps#getStorageInfo', 'url' => '/apps/get-storageinfo', 'verb' => 'GET'],
       ['name' => 'apps#getRedirections', 'url' => '/apps/get-redirections', 'verb' => 'GET']       
    ]
];
