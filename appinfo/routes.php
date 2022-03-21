<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. edashboard#index -> OCA\ECloudDashboard\Controller\EdashboardController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
	   ['name' => 'edashboard#index', 'url' => '/', 'verb' => 'GET'],
	   ['name' => 'edashboard#do_echo', 'url' => '/echo', 'verb' => 'POST'],
    ]
];
