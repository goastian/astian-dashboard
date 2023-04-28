<?php


namespace OCA\MurenaDashboard\Listeners;

use OCP\EventDispatcher\Event;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use \OCP\EventDispatcher\IEventListener;
use OCP\Util;
use OCP\IUserSession;
use OCP\INavigationManager;
use OCP\App\IAppManager;

class BeforeTemplateRenderedListener implements IEventListener {
	private Util $util;
	private IUserSession $userSession;
	private INavigationManager $navigationManager;
	private IAppManager $appManager;
	private string $appName;

	private const ONLYOFFICE_APP_ID = 'onlyoffice';

	public function __construct($appName, Util $util, IUserSession $userSession, INavigationManager $navigationManager) {
		$this->appName = $appName;
		$this->util = $util;
		$this->userSession = $userSession;
	}

	public function handle(Event $event): void {
		if (!($event instanceof BeforeTemplateRenderedEvent)) {
			return;
		}
		if ($this->userSession->isLoggedIn()) {
			$this->util->addStyle($this->appName, 'murena-dashboard');
		}
	}

}
