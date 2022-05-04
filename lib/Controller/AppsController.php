<?php

namespace OCA\EcloudDashboard\Controller;

use OCP\IRequest;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCA\EcloudDashboard\Util;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\IL10N;

class AppsController extends Controller
{

    protected $appName;
	protected $request;
	protected $config;
	protected $userSession;
	protected $localization;
	protected $cookieToken = 'nc_token';
	protected $cookieUsername = 'nc_username';

    public function __construct(
        $AppName,
        IRequest $request,
        Util $util,
		IConfig $config,
		IUserSession $userSession,
		IL10N $localization
    ) {
        parent::__construct($AppName, $request);
        $this->util = $util;
		$this->appName = $AppName;
		$this->request = $request;
		$this->config = $config;
		$this->userSession = $userSession;
    	$this->localization = $localization;
    }
    /**
     * @NoAdminRequired
     * @return JSONResponse
     */
    public function index()
    {
        $response = new JSONResponse();
        $entries = $this->util->getAppEntries();
        $response->setData($entries);
        return $response;
    }
    /**
     * @NoAdminRequired
     * @return JSONResponse
     */
    public function getRedirections()
    {
        $response = new JSONResponse();
        
        //getting Group data
        $groupData = $this->util->getGroups();   

		//getting redirection links
		$redirectData = $this->getRedirectLink();

		$redirectURL = 'https://doc.e.foundation/support-topics/referral-program'; //default

		if (in_array("Premium", $groupData) || in_array("premium", $groupData))
		{
		  	$redirectURL =  str_replace('/ecloud-subscriptions', '', $redirectData['link']) . '/my-account/referral_coupons/';
		}
		
		$entries = array( 'redirectURL' => $redirectURL );  

        return  $response->setData(array_merge( $redirectData, $entries));;
    }
	public function getRedirectLink()
	{
		$link = $this->config->getAppValue(
		'increasestoragebutton',
		'link'
		);
		
		if ($link != '' && !filter_var($link, FILTER_VALIDATE_URL)) {
			throw new LinkNotURLException(
				$this->localization->t(
				'The given link is not a URL'
				)
			);
		}
		$userQuota = $this->userSession->getUser()->getQuota();
		$userQuota = str_replace(' ', '', $userQuota);
		
		$storageLink = $link . ((strpos($link, '?') !== false) ? '&' : '?') .
		'username=' . urlencode($this->request->getCookie($this->cookieUsername)) .
		'&token=' . urlencode($this->request->getCookie($this->cookieToken)) .
		'&current-quota=' . $userQuota .
		'&from=nextcloud';

		return array('storageLink' => $storageLink , 'link' => $link);
	}
}
