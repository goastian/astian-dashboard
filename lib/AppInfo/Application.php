<?php

namespace OCA\MurenaDashboard\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCA\MurenaDashboard\Listeners\BeforeTemplateRenderedListener;

class Application extends App implements IBootstrap {
	public const APP_ID = 'murena-dashboard';

	public function __construct(array $urlParams = []) {
		parent::__construct(self::APP_ID, $urlParams);
	}

	public function register(IRegistrationContext $context): void {
		$context->registerEventListener(BeforeTemplateRenderedEvent::class, BeforeTemplateRenderedListener::class);
	}

	public function boot(IBootContext $context): void {
	}
}
