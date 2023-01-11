<?php

namespace OCA\EcloudDashboard\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Services\IInitialState;
use OCP\IConfig;
use OCP\IUserSession;
use OCA\EcloudDashboard\Util;

class PageController extends Controller {
	/** @var IInitialState */
	private $initialState;

	/** @var IConfig */
	private $config;
	
	/** @var IUserSession */
	private $userSession;

	public function __construct($appName, IRequest $request, IInitialState $initialState, IConfig $config, IUserSession $userSession, Util $util) {
		$this->initialState = $initialState;
		$this->config = $config;
		$this->util = $util;
		$this->userSession = $userSession;
		parent::__construct($appName, $request);
	}

	/**
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
		$this->initialState->provideIntialState('displayName', $displayName);
		return new TemplateResponse('ecloud-dashboard', 'dashboard');
	}
}
