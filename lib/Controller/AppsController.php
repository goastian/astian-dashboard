<?php

namespace OCA\EcloudDashboard\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCA\EcloudDashboard\Util;

class AppsController extends Controller
{

    private $util;

    public function __construct(
        $appName,
        IRequest $request,
        Util $util
    ) {
        parent::__construct($appName, $request);
        $this->util = $util;
    }
    /**
     * @NoAdminRequired
     * @return JSONResponse
     */
    public function getOrder()
    {
        $response = new JSONResponse();
        $response->setData(array("order" => $this->util->getOrder()));
        return $response;
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
     *  @NoAdminRequired
     * @return JSONResponse
     */

    public function getstorage()
    {
        $response = new JSONResponse();
        $storageInfo = $this->util->getStorageinfo();
        $userDisplayName = \OC_User::getDisplayName();
        $response->setData(array('userDisplayName' => $userDisplayName, 'storageinfo' => $storageInfo['storageInfo'] ));
        return $response;
    }

    public function getuserinfo()
    {
        $response = new JSONResponse();
        $userDisplayName = \OC_User::getDisplayName();
        $userdata = array('name' => $userDisplayName);
        $response->setData(array('userinfo' => $userdata ));
        return $response;
    }
    /**
     * @NoAdminRequired
     */

    public function updateOrder(string $order)
    {
        $this->util->updateOrder($order);
    }
}
