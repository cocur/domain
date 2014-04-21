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

use \Mockery as m;
use Cocur\Domain\Whois\Client;

/**
 * WhoisClientTest
 *
 * @category   test
 * @package    cocur/domain
 * @subpackage whois
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    private $client;

    /** @var Cocur\Domain\Data\Data */
    private $data;

    /** @var Cocur\Domain\Connection\ConnectionFactory */
    private $factory;

    /** @var array */
    private $comData = [
        'whoisServer' => 'com.whois-servers.net',
        'pattern'     => ['quotaExceeded' => '/% Quota exceeded/']
    ];

    public function setUp()
    {
        $this->factory = m::mock('Cocur\Domain\Connection\ConnectionFactory');
        $this->data = m::mock('Cocur\Domain\Data\Data');
        $this->client = new Client($this->factory, $this->data);
    }

    /**
     * @test
     * @covers Cocur\Domain\Whois\Client::query()
     */
    public function query()
    {
        $domain = m::mock('Cocur\Domain\Domain');
        $domain->shouldReceive('getDomainName')->once()->andReturn('florianeckerstorfer.com');
        $domain->shouldReceive('getTld')->once()->andReturn('com');

        $connection = m::mock('Cocur\Domain\Connection\ConnectionInterface');
        $connection->shouldReceive('open')->with('com.whois-servers.net', 43)->once()->andReturn($connection);
        $connection->shouldReceive('write')->with("florianeckerstorfer.com\r\n")->once()->andReturn($connection);
        $connection->shouldReceive('read')->once()->andReturn(file_get_contents(__DIR__.'/../fixtures/whois_reg.txt'));
        $connection->shouldReceive('close')->once();

        $this->data
            ->shouldReceive('getByTld')
            ->with('com')
            ->once()
            ->andReturn($this->comData);

        $this->factory->shouldReceive('createStreamConnection')->once()->andReturn($connection);

        $result = $this->client->query($domain);

        $this->assertRegExp('/Domain Name: FLORIANECKERSTORFER\.COM/', $result);
    }

    /**
     * @test
     * @covers Cocur\Domain\Whois\Client::query()
     * @expectedException Cocur\Domain\Whois\WhoisException
     */
    public function queryTldDoesNotExist()
    {
        $this->data
            ->shouldReceive('getByTld')
            ->with('com')
            ->once()
            ->andThrow('Cocur\Domain\Data\DataException');

        $this->client->query('florianeckerstorfer.com');
    }

    /**
     * @test
     * @covers Cocur\Domain\Whois\Client::query()
     * @expectedException Cocur\Domain\Whois\WhoisException
     */
    public function queryConnectionFailed()
    {
        $connection = m::mock('Cocur\Domain\Connection\ConnectionInterface');
        $connection->shouldReceive('open')->andThrow('Cocur\Domain\Connection\ConnectionException');
        $this->data->shouldReceive('getByTld')->andReturn(['whoisServer' => 'a']);
        $this->factory->shouldReceive('createStreamConnection')->once()->andReturn($connection);

        $this->client->query('florianeckerstorfer.com');
    }

    /**
     * @test
     * @covers Cocur\Domain\Whois\Client::query()
     * @expectedException Cocur\Domain\Whois\QuotaExceededException
     */
    public function queryHasQuotaExceeded()
    {
        $domain = m::mock('Cocur\Domain\Domain');
        $domain->shouldReceive('getDomainName')->once()->andReturn('florianeckerstorfer.com');
        $domain->shouldReceive('getTld')->once()->andReturn('com');

        $connection = m::mock('Cocur\Domain\Connection\ConnectionInterface');
        $connection->shouldReceive('open')->andReturn($connection);
        $connection->shouldReceive('write')->andReturn($connection);
        $connection->shouldReceive('read')->andReturn(file_get_contents(__DIR__.'/../fixtures/whois_quota.txt'));
        $connection->shouldReceive('close');

        $this->data
            ->shouldReceive('getByTld')
            ->andReturn($this->comData);

        $this->factory->shouldReceive('createStreamConnection')->andReturn($connection);

        $this->client->query($domain);
    }
}
