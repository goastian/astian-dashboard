<?php

namespace OCA\EcloudDashboard;

use OCP\IConfig;
use OCP\INavigationManager;
use OCP\App\IAppManager;
use OCP\L10N\IFactory;
use OCP\IUser;
use OCP\IUserManager;
use OCP\IGroupManager;
use OCP\IUserSession;

class Util {
	private $appName;
	private $userId;
	private $config;
	private $navigationManager;
	private $appManager;
	private $root;
	private $l10nFac;
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
		IAppManager $appManager,
		IFactory $l10nFac,
		$userId
	) {
		$this->userId = $userId;
		$this->config = $config;
		$this->navigationManager = $navigationManager;
		$this->groupManager = $groupManager;
		$this->userManager = $userManager;
		$this->appManager = $appManager;
		$this->l10nFac = $l10nFac;
		$this->userSession = $userSession;
	}

	private function getOnlyOfficeEntries() {
		$l = $this->l10nFac->get("onlyoffice");
		$onlyOfficeEntries = array(
			array(
				"id" => "onlyoffice_docx",
				"icon" => "/svg/core/filetypes/x-office-document",
				"name" => $l->t("Document"),
			),
			array(
				"id" => "onlyoffice_xlsx",
				"icon" => "/svg/core/filetypes/x-office-spreadsheet",
				"name" => $l->t("Spreadsheet"),
			),
			array(
				"id" => "onlyoffice_pptx",
				"icon" => "/svg/core/filetypes/x-office-presentation",
				"name" => $l->t("Presentation"),
			),
		);
		$onlyOfficeEntries = array_map(function ($entry) {
			$entry["type"] = "onlyoffice";
			$entry["active"] = false;
			$entry["href"] = "/apps/onlyoffice/ajax/new?id=".$entry["id"];
			return $entry;
		}, $onlyOfficeEntries);

		return $onlyOfficeEntries;
	}
	public function getOrder() {
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
	public function getAppEntries() {
		$entries = array_values($this->navigationManager->getAll());
		$order = $this->getOrder();
		$entriesByHref = array();
		if ($this->appManager->isEnabledForUser("onlyoffice")) {
			$office_entries = $this->getOnlyOfficeEntries();
			$entries = array_merge($entries, $office_entries);
		}
		$betaGroupName = $this->config->getSystemValue("beta_group_name");
		$isBeta = $this->checkIsBetaUser();
		foreach ($entries as &$entry) {
			if (strpos($entry["id"], "external_index") !== 0) {
				$entry["style"] = "";
				$entry["target"] = "";
			} else {
				$entry["style"] = "background-image: url('". $entry["icon"] ."')";
				$entry["target"] = "_blank";
			}

			$entry["iconOffsetY"] = 0;
			$entry["betaClass"] = '';
			if ($isBeta) {
				$enabledValue = $this->config->getAppValue($entry['id'], 'enabled', 'no');
				if ($enabledValue !== 'no' && $enabledValue !== 'yes') {
					if (strpos($enabledValue, $betaGroupName)) {
						$entry["betaClass"] = 'beta-app';
					}
				}
			}
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
		unset($entriesByHref['']);
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

	private function checkIsBetaUser() {
		$user = $this->userSession->getUser();
		$usersGroups = $this->groupManager->getUserGroupIds($user);
		$betaGroupName = $this->config->getSystemValue("beta_group_name");
		if (in_array($betaGroupName, $usersGroups)) {
			return true;
		}
		return false;
	}
}
