<?php

/**
 * This file is part of cocur/domain.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Domain\DomainTest;

use Cocur\Domain\Domain;

/**
 * DomainTest
 *
 * @category  test
 * @package   cocur/domain
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2014 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @group     unit
 */
class DomainTest extends \PHPUnit_Framework_TestCase
{
    /** @var Domain */
    private $domain;

    public function setUp()
    {
        $this->domain = new Domain();
    }

    /**
     * @test
     * @covers Cocur\Domain\Domain::create()
     */
    public function create()
    {
        $domain = Domain::create('florian.ec');
        $this->assertInstanceOf('Cocur\Domain\Domain', $domain);
        $this->assertEquals('florian.ec', $domain->getDomainName());
    }

    /**
     * @test
     * @covers Cocur\Domain\Domain::__construct()
     */
    public function construct()
    {
        $domain = new Domain('florian.ec');
        $this->assertEquals('florian.ec', $domain->getDomainName());
    }

    /**
     * @test
     * @covers Cocur\Domain\Domain::setDomainName()
     * @covers Cocur\Domain\Domain::getDomainName()
     */
    public function setDomainNameAndGetDomainName()
    {
        $this->domain->setDomainName('florian.ec');
        $this->assertEquals('florian.ec', $this->domain->getDomainName());
    }

    /**
     * @test
     * @covers Cocur\Domain\Domain::getTld()
     */
    public function getTld()
    {
        $this->domain->setDomainName('florian.ec');
        $this->assertEquals('ec', $this->domain->getTld());
    }
}
