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

    public function setUp()
    {
        $this->factory = m::mock('Cocur\Domain\Connection\ConnectionFactory');
        $this->data = m::mock('Cocur\Domain\Data\Data');
        $this->client = new Client($this->factory, $this->data);
    }

    /**
     * @test
     * @covers Cocur\Domain\Whois\Client::query()
     * @covers Cocur\Domain\Whois\Client::getTld()
     */
    public function query()
    {
        $connection = m::mock('Cocur\Domain\Connection\ConnectionInterface');
        $connection->shouldReceive('open')->with('com.whois-servers.net', 43)->once()->andReturn($connection);
        $connection->shouldReceive('write')->with("florianeckerstorfer.com\r\n")->once()->andReturn($connection);
        $connection->shouldReceive('read')->once()->andReturn(file_get_contents(__DIR__.'/../fixtures/whois.txt'));
        $connection->shouldReceive('close')->once();

        $this->data
            ->shouldReceive('getByTld')
            ->with('com')
            ->once()
            ->andReturn(['whoisServer' => 'com.whois-servers.net']);

        $this->factory->shouldReceive('createStreamConnection')->once()->andReturn($connection);

        $result = $this->client->query('florianeckerstorfer.com');

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
}
