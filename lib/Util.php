<?php

namespace OCA\EcloudDashboard;

use OCP\IConfig;
use OCP\INavigationManager;
use OCP\App\IAppManager;
use OCP\L10N\IFactory;
use OCP\Files\IRootFolder;
use OCP\Files\Folder;
use OCP\IUser;
use OCP\IUserManager;
use OCP\IGroup;
use OCP\IGroupManager;
use OCP\IUserSession;

class Util
{

    private $appName;
    private $userId;
    private $config;
    private $navigationManager;
    private $appManager;
    private $root;
    /** @var IGroupManager */
    private $groupManager;

    /** @var IUserManager */
    private $userManager;

    /** @var IUserSession */
    private $userSession;

    private const DEFAULT_ORDER = array("/apps/files/", "/apps/rainloop/", "/apps/contacts/", "/apps/calendar/", "/apps/notes/", "/apps/tasks/", "/apps/photos/");
    public function __construct(
        IConfig $config,
        INavigationManager $navigationManager,
        IGroupManager $groupManager,
        IUserManager $userManager,
        IUserSession $userSession,
        $userId
    ) {
        $this->userId = $userId;
        $this->config = $config;
        $this->navigationManager = $navigationManager;
        $this->groupManager = $groupManager;
        $this->userManager = $userManager;
        $this->userSession = $userSession;
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
       unset($entriesByHref['/apps/dashboard/']);
       unset($entriesByHref['/apps/ecloud-dashboard/']);
       $entries = array_values($entriesByHref);
       
       return array( 'apps' => $entries  );
    }
    /**
     * returns a sorted list of the user's group GIDs
     *
     * @param IUser $user
     * @return array
     */
    public function getGroups(): array {
        $user = $this->userSession->getUser();
        if (!$user) {
            return [];
        }
        return $this->groupManager->getUserGroupIds($user);
    }
}
