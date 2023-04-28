<?php

namespace OCA\MurenaDashboard\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCA\MurenaLauncher\Listeners\BeforeTemplateRenderedListener;

class Application extends App {
	public function __construct(array $urlParams = array()) {
		$appName = "murena-dashboard";
		parent::__construct($appName, $urlParams);
	}
	public function register(IRegistrationContext $context): void {
		$context->registerEventListener(BeforeTemplateRenderedEvent::class, BeforeTemplateRenderedListener::class);
	}

	public function boot(IBootContext $context): void {
	}

}
