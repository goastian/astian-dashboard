<?php

namespace OCA\MurenaDashboard\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Services\IInitialState;
use OCP\IConfig;
use OCP\IUserSession;
use OCA\EcloudAccounts\Service\AppsService;

class PageController extends Controller {
	/** @var IInitialState */
	private $initialState;

	/** @var IConfig */
	private $config;
	
	/** @var IUserSession */
	private $userSession;

	private AppsService $appsService;

	public function __construct($appName, IRequest $request, IInitialState $initialState, IConfig $config, IUserSession $userSession, AppsService $appsService) {
		$this->initialState = $initialState;
		$this->config = $config;
		$this->userSession = $userSession;
		$this->appsService = $appsService;
		parent::__construct($appName, $request);
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index() {
		$referralUrl = $this->config->getSystemValue('shop_referral_program_url', '');
		$storageUrl = $this->config->getAppValue('increasestoragebutton', 'link', '');
		$entries = $this->appsService->getAppEntries();
		$displayName = $this->userSession->getUser()->getDisplayName();
		$this->initialState->provideInitialState('shopReferralProgramUrl', $referralUrl);
		$this->initialState->provideInitialState('increaseStorageUrl', $storageUrl);
		$this->initialState->provideInitialState('entries', $entries['apps']);
		$this->initialState->provideInitialState('displayName', $displayName);
		return new TemplateResponse($this->appName, 'dashboard');
	}
}
