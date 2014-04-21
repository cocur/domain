<?php

/**
 * This file is part of cocur/domain.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Domain\Data;

use Cocur\Domain\Data\Data;

/**
 * DataTest
 *
 * @category   test
 * @package    cocur/domain
 * @subpackage data
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class DataTest extends \PHPUnit_Framework_TestCase
{
    /** @var Data */
    private $data;

    public function setUp()
    {
        $this->data = new Data([['tld' => 'com', 'whoisServer' => 'com.whois-servers.net']]);
    }

    /**
     * @test
     * @covers Cocur\Domain\Data\Data::hasTld()
     */
    public function hasTld()
    {
        $this->assertTrue($this->data->hasTld('com'));
        $this->assertFalse($this->data->hasTld('invalid'));
    }

    /**
     * @test
     * @covers Cocur\Domain\Data\Data::getByTld()
     */
    public function getByTld()
    {
        $this->assertEquals('com.whois-servers.net', $this->data->getByTld('com')['whoisServer']);
    }

    /**
     * @test
     * @covers Cocur\Domain\Data\Data::getByTld()
     * @expectedException Cocur\Domain\Data\DataException
     */
    public function getByTldThrowsException()
    {
        $this->data->getByTld('invalid');
    }
}
