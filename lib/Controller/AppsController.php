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
    public function getGroups()
    {
        $response = new JSONResponse();
        $entries = $this->util->getGroupInfo();
        $response->setData($entries);
        return $response;
    }
}
