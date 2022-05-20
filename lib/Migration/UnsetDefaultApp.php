<?php

namespace OCA\EcloudDashboard\Migration;

use OCP\IConfig;
use OCP\Migration\IOutput;
use OCP\Migration\IRepairStep;

class UnsetEmailTemplate implements IRepairStep {
	/** @var IConfig */
	protected $config; 

	public function __construct(IConfig $config) {
		$this->config = $config;
	}

	public function getName() {
		return 'Reset the email template to default'; 
	}

	public function run(IOutput $output) {
		if ($this->config->getSystemValue('defaultapp') === EMailTemplate::class) {
			$this->config->deleteSystemValue('defaultapp');
		}
	}
}

