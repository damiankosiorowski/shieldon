<?php
/*
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Shieldon\Firewall\Component;

use Shieldon\Firewall\IpTrait;
use function Shieldon\Firewall\get_request;

/**
 * Robot
 */
class Header extends ComponentProvider
{
    use IpTrait;

    const STATUS_CODE = 83;

    /**
     *  Very common requests from normal users.
     * 
     * @var string
     */
    protected $commonHeaderFileds = [
        'Accept',
        'Accept-Language',
        'Accept-Encoding',
    ];

    /**
     * Header information.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Header component constructor.
     */
    public function __construct()
    {
        $this->headers = get_request()->getHeaders();
        $this->deniedList = [];
    }

    /**
     * {@inheritDoc}
     */
    public function isDenied(): bool
    {
        if (!empty($this->deniedList)) {
            $intersect = array_intersect_key($this->deniedList, $this->headers);

            foreach ($intersect as $headerName => $headerValue) {
                $requestHeader = get_request()->getHeaderLine($headerName);

                // When found a header field contains a prohibited string.
                if (stripos($requestHeader, $headerValue) !== false) {
                    return true;
                }
            }
        }

        if ($this->strictMode) {

            foreach ($this->commonHeaderFileds as $fieldName) {

                // If strict mode is on, this value must be found.
                if (!isset($this->headers[$fieldName])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * All request headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Unique deny status code.
     *
     * @return int
     */
    public function getDenyStatusCode(): int
    {
        return self::STATUS_CODE;
    }
}