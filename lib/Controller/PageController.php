<?php

namespace OCA\MurenaDashboard\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Services\IInitialState;
use OCP\IConfig;
use OCP\IUserSession;
use OCA\MurenaDashboard\Util;

class PageController extends Controller {
	/** @var IInitialState */
	private $initialState;

	/** @var IConfig */
	private $config;
	
	/** @var IUserSession */
	private $userSession;

	private $appName;

	private $util;

	public function __construct($appName, IRequest $request, IInitialState $initialState, IConfig $config, IUserSession $userSession, Util $util) {
		$this->initialState = $initialState;
		$this->config = $config;
		$this->util = $util;
		$this->userSession = $userSession;
		$this->appName = $appName;
		parent::__construct($appName, $request);
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index() {
		$referralUrl = $this->config->getSystemValue('shop_referral_program_url', '');
		$storageUrl = $this->config->getAppValue('increasestoragebutton', 'link', '');
		$entries = $this->util->getAppEntries();
		$displayName = $this->userSession->getUser()->getDisplayName();

		$this->initialState->provideInitialState('shopReferralProgramUrl', $referralUrl);
		$this->initialState->provideInitialState('increaseStorageUrl', $storageUrl);
		$this->initialState->provideInitialState('entries', $entries);
		$this->initialState->provideInitialState('displayName', $displayName);
		return new TemplateResponse($this->appName, 'dashboard');
	}
}
