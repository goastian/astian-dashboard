<?php

namespace OCA\MurenaDashboard\AppInfo;

use OCP\AppFramework\App;

class Application extends App {
	public function __construct(array $urlParams = array()) {
		$appName = "murena-dashboard";
		parent::__construct($appName, $urlParams);
	}
}
