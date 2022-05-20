<?php

namespace OCA\EcloudDashboard\Migration;

use OCP\IConfig;
use OCP\Migration\IOutput;
use OCP\Migration\IRepairStep; 

class SetDefaultApp implements IRepairStep {
	/** @var IConfig */
	protected $config;

	public function __construct(IConfig $config) {
		$this->config = $config;
	}

	public function getName() {
		return 'Set the custom email template';
	}

	public function run(IOutput $output) {
		$this->config->setSystemValue('defaultapp', 'home,dashboard');
	}
}
