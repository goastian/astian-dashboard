<?php

namespace OCA\MurenaDashboard\Listeners;

use OCP\EventDispatcher\Event;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use \OCP\EventDispatcher\IEventListener;
use OCP\Util;
use OCP\IRequest;

class BeforeTemplateRenderedListener implements IEventListener {
	private Util $util;
	private IRequest $request;
	private string $appName;

	public function __construct($appName, Util $util,  IRequest $request) {
		$this->appName = $appName;
		$this->util = $util;
		$this->userSession = $userSession;
		$this->request = $request;

	}
	public function handle(Event $event): void {
		if (!($event instanceof BeforeTemplateRenderedEvent)) {
			return;
		}
		$pathInfo = $this->request->getPathInfo();

		if (strpos($pathInfo, '/apps/murena-dashboard/') !== false) {
			$this->util->addStyle($this->appName, 'murena-dashboard');
		}

	}
}