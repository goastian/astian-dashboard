<?php

namespace OCA\EcloudDashboard\AppInfo;

use OCP\AppFramework\App;

class Application extends App
{
    public function __construct(array $urlParams = array())
    {
        $appName = "home";
        parent::__construct($appName, $urlParams);
    }
}
