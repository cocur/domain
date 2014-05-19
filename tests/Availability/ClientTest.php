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

use \Mockery as m;
use Cocur\Domain\Availability\Client;

/**
 * ClientTest
 *
 * @category   test
 * @package    cocur/domain
 * @subpackage availability
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    private $client;

    /** @var Cocur\Domain\Whois\Client */
    private $whoisClient;

    /** @var Cocur\Domain\Data\Data */
    private $data;

    /** @var array */
    private $comData = ['patterns' => ['notRegistered' => '/No match for /']];

    public function setUp()
    {
        $this->whoisClient = m::mock('Cocur\Domain\Whois\Client');
        $this->data = m::mock('Cocur\Domain\Data\Data');

        $this->client = new Client($this->whoisClient, $this->data);
    }

    /**
     * @test
     * @covers Cocur\Domain\Availability\Client::__construct()
     * @covers Cocur\Domain\Availability\Client::getWhoisClient()
     */
    public function constructAndGetWhoisClient()
    {
        $this->assertEquals($this->whoisClient, $this->client->getWhoisClient());
    }

    /**
     * @test
     * @covers Cocur\Domain\Availability\Client::__construct()
     * @covers Cocur\Domain\Availability\Client::getData()
     */
    public function constructAndGetData()
    {
        $this->assertEquals($this->data, $this->client->getData());
    }

    /**
     * @test
     * @covers Cocur\Domain\Availability\Client::isAvailable()
     * @covers Cocur\Domain\Availability\Client::getLastWhoisResult()
     */
    public function isAvailableReturnsTrue()
    {
        $whoisResult = file_get_contents(__DIR__.'/../fixtures/whois_notreg.txt');

        $domain = m::mock('Cocur\Domain\Domain');
        $domain->shouldReceive('getTld')->once()->andReturn('com');

        $this->data->shouldReceive('getByTld')->with('com')->once()->andReturn($this->comData);
        $this->whoisClient
            ->shouldReceive('query')
            ->with($domain)
            ->once()
            ->andReturn($whoisResult);

        $this->assertTrue($this->client->isAvailable($domain));
        $this->assertEquals($whoisResult, $this->client->getLastWhoisResult());
    }

    /**
     * @test
     * @covers Cocur\Domain\Availability\Client::isAvailable()
     */
    public function isAvailableReturnsFalse()
    {
        $whoisResult = file_get_contents(__DIR__.'/../fixtures/whois_reg.txt');

        $domain = m::mock('Cocur\Domain\Domain');
        $domain->shouldReceive('getTld')->once()->andReturn('com');

        $this->data->shouldReceive('getByTld')->with('com')->once()->andReturn($this->comData);
        $this->whoisClient
            ->shouldReceive('query')
            ->with($domain)
            ->once()
            ->andReturn($whoisResult);

        $this->assertFalse($this->client->isAvailable($domain));
        $this->assertEquals($whoisResult, $this->client->getLastWhoisResult());
    }

    /**
     * @test
     * @covers Cocur\Domain\Availability\Client::isAvailable()
     */
    public function isAvailableReceivesString()
    {
        $this->data->shouldReceive('getByTld')->with('com')->once()->andReturn($this->comData);
        $this->whoisClient
            ->shouldReceive('query')
            ->once()
            ->andReturn(file_get_contents(__DIR__.'/../fixtures/whois_notreg.txt'));

        $this->assertTrue($this->client->isAvailable('florianeckerstorfer.com'));
    }

    /**
     * @test
     * @covers Cocur\Domain\Availability\Client::isAvailable()
     * @expectedException Cocur\Domain\Availability\AvailabilityException
     */
    public function isAvailableHasNoPattern()
    {
        $this->data->shouldReceive('getByTld')->with('com')->once()->andReturn([]);

        $this->client->isAvailable('florianeckerstorfer.com');
    }
}
