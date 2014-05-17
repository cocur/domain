<?php

/**
 * This file is part of cocur/domain.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Domain\Whois;

use Cocur\Domain\Domain;
use Cocur\Domain\Data\Data;
use Cocur\Domain\Data\DataException;
use Cocur\Domain\Connection\ConnectionFactory;
use Cocur\Domain\Connection\ConnectionException;

/**
 * Client
 *
 * @package    cocur/domain
 * @subpackage whois
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class Client
{
    /** @var ConnectionFactory */
    private $factory;

    /** @var Data */
    private $data;

    /**
     * Constructor.
     *
     * @param ConnectionFactory $factory
     * @param Data              $data
     *
     * @codeCoverageIgnore
     */
    public function __construct(ConnectionFactory $factory, Data $data)
    {
        $this->factory = $factory;
        $this->data = $data;
    }

    /**
     * Queries the WHOIS server for the given domain name.
     *
     * @param Domain|string $domain Domain name.
     *
     * @return string Result of the WHOIS server.
     *
     * @throws WhoisException when the TLD does not exist.
     * @throws WhoisException when the connection to the WHOIS server failed.
     * @throws QuotaExceededException if the quota for the WHOIS server is exceeded.
     */
    public function query($domain)
    {
        if (false === $domain instanceof Domain) {
            $domain = Domain::create($domain);
        }
        $tld = $domain->getTld();

        try {
            $data = $this->data->getByTld($tld);
        } catch (DataException $e) {
            throw new WhoisException(sprintf('The TLD "%s" does not exist.', $tld), 0, $e);
        }

        $connection = $this->factory->createStreamConnection();
        try {
            $connection->open($data['whoisServer'], 43);
            $connection->write(sprintf("%s\r\n", $domain->getDomainName()));
            $whois = $connection->read();
            $connection->close();
        } catch (ConnectionException $e) {
            throw new WhoisException(sprintf('Could not query WHOIS for "%s".', $domain->getDomainName()), 0, $e);
        }

        if (true === isset($data['pattern']['quotaExceeded']) &&
            preg_match($data['pattern']['quotaExceeded'], $whois)) {
            throw new QuotaExceededException(sprintf('Quota exceeded for WHOIS server "%s".', $data['whoisServer']));
        }

        return $whois;
    }
}
