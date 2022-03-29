<?php

namespace OCA\EcloudDashboard;

use OCP\IConfig;
use OCP\INavigationManager;
use OCP\App\IAppManager;
use OCP\L10N\IFactory;
use OCP\Files\IRootFolder;
use OCP\Files\Folder;

class Util
{

    private $appName;
    private $userId;
    private $config;
    private $navigationManager;
    private $appManager;
    private $l10nFac;
    private $root;

    private const DEFAULT_ORDER = array("/apps/files/", "/apps/rainloop/", "/apps/contacts/", "/apps/calendar/", "/apps/notes/", "/apps/tasks/", "/apps/photos/");
    public function __construct(
        $appName,
        IConfig $config,
        INavigationManager $navigationManager,
        IAppManager $appManager,
        IFactory $l10nFac,
        IRootFolder $root,
        $userId
    ) {
        $this->appName = $appName;
        $this->userId = $userId;
        $this->config = $config;
        $this->navigationManager = $navigationManager;
        $this->appManager = $appManager;
        $this->l10nFac = $l10nFac;
        $this->root = $root;
    }


    public function getOrder()
    {
        $order_raw = $this->config->getUserValue($this->userId, $this->appName, 'order');
        // If order raw empty try to get from 'apporder' app config
        $order_raw = !$order_raw ? $this->config->getUserValue($this->userId, 'apporder', 'order') : $order_raw;
        // If order raw is still empty, return empty array
        if (!$order_raw) {
            return self::DEFAULT_ORDER;
        }
        $order = json_decode($order_raw);
        return $order;
    }
    public function getAppEntries()
    {
        $entries = array_values($this->navigationManager->getAll());
        $order = $this->getOrder();
        $external = array();
        $entriesByHref = array();
        // slice
        foreach ($entries as &$entry) {
            $entriesByHref[$entry["href"]] = $entry;
        }
        /*
         Sort apps according to order
         Since "entriesByHref" is indexed by "href", simply reverse the order array and prepend in "entriesByHref"
         Prepend is done by using each "href" in the reversed order array and doing a union of the "entriesByHref"
         array with the current element
        */
        if ($order) {
            $order = array_reverse($order);
            foreach ($order as $href) {
                if (!empty($entriesByHref[$href])) {
                    $entriesByHref = array($href => $entriesByHref[$href]) + $entriesByHref;
                }
            }
        }
       $apps =array_values($entriesByHref);      
        return array("apps" => $apps );
    }

    public function getStorageinfo()
    {
        // $storageInfo = \OC_Helper::getStorageInfo('/');
        $usedMailQuota = $this->config->getUserValue($this->userId, $this->appName, 'usedMailQuota', 200000000);
        // $usedMailQuota = $this->config->getUserValue($this->userSession->getUser()->getUID(), 'ecloud-core', 'usedMailQuota', 200000000);
        \OC_Util::setupFS();
		$dirInfo = \OC\Files\Filesystem::getFileInfo('/', false);
		$storageInfo =  \OC_Helper::getStorageInfo('/', $dirInfo);

        // $storageInfo = \OC_Helper::getStorageInfo('/');
		$totalSpace = \OC_Helper::humanFileSize($storageInfo['total']);
		$freeSpace = \OC_Helper::humanFileSize($storageInfo['free']);
		$usedSpace = \OC_Helper::humanFileSize($storageInfo['used']);
		$usedMailQuota = \OC_Helper::humanFileSize($usedMailQuota);
        $storageInfo['totalSpace'] = $totalSpace;
        $storageInfo['freeSpace'] = $freeSpace;
        $storageInfo['usedSpace'] = $usedSpace;
        $storageInfo['usedMailQuota'] = $usedMailQuota;
        return array('storageInfo' => $storageInfo);
    }
}
