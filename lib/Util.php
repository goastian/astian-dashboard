<?php

namespace OCA\EcloudDashboard;

use OCP\IConfig;
use OCP\INavigationManager;
use OCP\App\IAppManager;
use OCP\L10N\IFactory;
use OCP\Files\IRootFolder;
use OCP\Files\Folder;
use OC_Util as OCUtil;
use OC_Helper as OCHelper;

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
        $order_raw = $this->config->getUserValue($this->userId, 'ecloud-launcher', 'order');
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

        foreach ($entries as &$entry) {
            $iconName = basename($entry["icon"]);
            $iconName = preg_split('/.svg/', $iconName)[0] .'-new';
            $entry["icon"] = "/svg/" . $entry["id"] . "/" . $iconName;
            $entry["iconOffsetY"] = 0;
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
       $entries = array_values($entriesByHref);      
       return array( 'apps' => $entries);
    }


    public function humanFileSize($bytes) {
        if ($bytes < 0) {
            return "?";
        }
        if ($bytes < 1024) {
            return "$bytes B";
        }
        $bytes = round($bytes / 1024, 0);
        if ($bytes < 1024) {
            return "$bytes KB";
        }
        $bytes = round($bytes / 1024, 1);
        if ($bytes < 1024) {
            return "$bytes MB";
        }
        $bytes = round($bytes / 1024, 1);
        if ($bytes < 1024) {
            return "$bytes GB";
        }
        $bytes = round($bytes / 1024, 1);
        if ($bytes < 1024) {
            return "$bytes TB";
        }

        $bytes = round($bytes / 1024, 1);
        return "$bytes PB";
    }
    public function getStorageinfo()
    {
        $usedMailQuota = $this->config->getUserValue($this->userId, $this->appName, 'usedMailQuota', 200000000);
        OCUtil::setupFS();
        $storageInfo = OCHelper::getStorageInfo('/');

        $humanUsed = $this->humanFileSize($storageInfo['used']);

        if ($storageInfo['quota'] > 0) {
            $percent = ($storageInfo['used'] * 100 ) / $storageInfo['quota'];
            $humanQuota = $this->humanFileSize($storageInfo['quota']);
            $quota_used = $humanUsed.' of '.$humanQuota. '('.$percent.'%)' . ' used';
        }else{
            $percent = 0;
            $quota_used = $humanUsed.' used';
        }

        return [
            'freeSpace' => $storageInfo['free'],
            'quota' => $storageInfo['quota'],
            'used' => $storageInfo['used'],
            'owner' => $storageInfo['owner'],
            'quota_used' => $quota_used,
            'percent' => $percent,
            'ownerDisplayName' => $storageInfo['ownerDisplayName']
        ];
    }

}
