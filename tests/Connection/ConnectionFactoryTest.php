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

use Cocur\Domain\Connection\ConnectionFactory;

/**
 * ConnectionFactoryTest
 *
 * @category   test
 * @package    cocur/domain
 * @subpackage connection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class ConnectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->factory = new ConnectionFactory();
    }

    /**
     * @test
     * @covers Cocur\Domain\Connection\ConnectionFactory::createStreamConnection()
     */
    public function createStreamConnection()
    {
        $this->assertInstanceOf('Cocur\Domain\Connection\StreamConnection', $this->factory->createStreamConnection());
    }
}
