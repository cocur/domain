<?php

/**
 * This file is part of cocur/domain.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Domain\Availability;

use Cocur\Domain\Domain;
use Cocur\Domain\Data\Data;
use Cocur\Domain\Whois\Client as WhoisClient;

/**
 * Client
 *
 * @package    cocur/domain
 * @subpackage availability
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class Client
{
    /** @var WhoisClient */
    private $whoisClient;

    /** @var Data */
    private $data;

    /** @var string */
    private $lastWhoisResult;

    /**
     * Constructor.
     *
     * @param WhoisClient $whoisClient WhoisClient object
     * @param Data        $data        Data object
     */
    public function __construct(WhoisClient $whoisClient, Data $data)
    {
        $this->whoisClient = $whoisClient;
        $this->data        = $data;
    }

    /**
     * Returns the WhoisClient object.
     *
     * @return WhoisClient
     */
    public function getWhoisClient()
    {
        return $this->whoisClient;
    }

    /**
     * Returns the Data object.
     *
     * @return Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns if the given domain is available.
     *
     * @param Domain|string  $domain Domain.
     *
     * @return boolean `true` if the domain is available, `false` if not.
     *
     * @throws AvailabilityException when no pattern exists for the given TLD.
     */
    public function isAvailable($domain)
    {
        if (false === ($domain instanceof Domain)) {
            $domain = Domain::create($domain);
        }

        $data = $this->data->getByTld($domain->getTld());
        if (false === isset($data['patterns']['notRegistered'])) {
            throw new AvailabilityException(
                sprintf('No pattern exists to check availability of %s domains.', $domain->getTld())
            );
        }

        $this->lastWhoisResult = $this->whoisClient->query($domain);

        if (preg_match($data['patterns']['notRegistered'], $this->lastWhoisResult)) {
            return true;
        }

        return false;
    }

    /**
     * Returns the WHOIS result from the last call to `isAvailable()`.
     *
     * @return string WHOIS result
     */
    public function getLastWhoisResult()
    {
        return $this->lastWhoisResult;
    }
}
