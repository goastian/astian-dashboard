<?php

/**
 * @copyright Copyright (c) 2021 ECORP SAS <dev@e.email>
 *
 * @author Akhil Potukuchi <akhil@e.email>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\EcloudDashboard\Controller;

use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IConfig;
use OCP\ILogger;
use OCP\AppFramework\Http\Response;
use OCP\AppFramework\Http\JSONResponse;

class EdashboardController extends Controller
{
    /** @var IConfig */
    private $config;

    /** @var ILogger */
    private $logger;

    public function __construct(
        string $appName,
        IRequest $request,
        IConfig $config,
        ILogger $logger
    ) {
        parent::__construct($appName, $request);
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @NoAdminRequired
     */

    public function index()
    {
        echo 'this is index'; die;
    }
    
}
