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
     * @param string $domainName Domain name.
     *
     * @return string Result of the WHOIS server.
     *
     * @throws WhoisException when the TLD does not exist.
     * @throws WhoisException when the connection to the WHOIS server failed.
     */
    public function query($domainName)
    {
        $tld = $this->getTld($domainName);

        try {
            $server = $this->data->getByTld($tld)['whoisServer'];
        } catch (DataException $e) {
            throw new WhoisException(sprintf('The TLD "%s" does not exist.', $tld), 0, $e);
        }

        $connection = $this->factory->createStreamConnection();
        try {
            $connection->open($server, 43);
            $connection->write("$domainName\r\n");
            $result = $connection->read();
            $connection->close();
        } catch (ConnectionException $e) {
            throw new WhoisException(sprintf('Could not query WHOIS for "%s".', $domainName), 0, $e);
        }

        return $result;
    }

    /**
     * Returns the TLD of the given domain name.
     *
     * @param string $domainName Domain name.
     *
     * @return string TLD
     */
    protected function getTld($domainName)
    {
        return preg_replace('/(.*)\.([a-z]+)$/', '$2', $domainName);
    }
}
