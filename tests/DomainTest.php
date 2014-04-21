<?php

namespace Cocur\Domain\DomainTest;

use Cocur\Domain\Domain;

/**
 * DomainTest
 *
 * @group unit
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
