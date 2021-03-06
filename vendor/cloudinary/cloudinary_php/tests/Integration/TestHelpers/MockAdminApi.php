<?php
/**
 * This file is part of the Cloudinary PHP package.
 *
 * (c) Cloudinary
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudinary\Test\Integration\TestHelpers;

use Cloudinary\Api\Admin\AdminApi;
use GuzzleHttp\Handler\MockHandler;

/**
 * Class MockAdminApi
 */
class MockAdminApi extends AdminApi
{
    /**
     * MockAdminApi constructor.
     *
     * @param mixed $configuration
     */
    public function __construct($configuration = null)
    {
        parent::__construct($configuration);

        $this->apiClient = new MockApiClient($configuration);
    }

    /**
     * Returns mock handler.
     *
     * @return MockHandler
     */
    public function getMockHandler()
    {
        return $this->apiClient->mockHandler;
    }
}
