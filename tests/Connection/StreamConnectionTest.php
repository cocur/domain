<?php

/**
 * This file is part of cocur/domain.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Domain\Connection;

use Cocur\Domain\Connection\StreamConnection;

/**
 * StreamConnectionTest
 *
 * @group unit
 */
class StreamConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->conn = new StreamConnection();
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::open()
     */
    public function open()
    {
        $this->conn->open('127.0.0.1', 22);
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::open()
     * @expectedException Cocur\Domain\Connection\ConnectionException
     */
    public function openWhenNoConnectionPossible()
    {
        $this->conn->open('127.0.0.1', 123456789);
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::close()
     */
    public function close()
    {
        $this->conn->open('127.0.0.1', 22);
        $this->conn->close();
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::close()
     * @expectedException Cocur\Domain\Connection\ConnectionException
     */
    public function closeWhenNoConnectionExists()
    {
        $this->conn->close();
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::write()
     */
    public function write()
    {
        $this->conn->open('127.0.0.1', 22);
        $this->conn->write('foo');
        $this->conn->close();
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::write()
     * @expectedException Cocur\Domain\Connection\ConnectionException
     */
    public function writeWhenNoConnectionExists()
    {
        $this->conn->write('test');
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::read()
     */
    public function readLengthBytes()
    {
        $this->conn->open('127.0.0.1', 22);
        $this->assertNotNull($this->conn->read(100));
        $this->conn->close();
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\StreamConnection::read()
     * @expectedException Cocur\Domain\Connection\ConnectionException
     */
    public function readWhenNoConnectionExists()
    {
        $this->conn->read();
    }
}
