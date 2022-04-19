<?php
namespace OCA\EcloudDashboard\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

class PageController extends Controller {
	private $userId;

	public function __construct($AppName, IRequest $request, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
	}
	public function index() {
		return new TemplateResponse('ecloud-dashboard', 'edashboard');  // templates/edashboard.php
	}
}