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

use Cocur\Domain\Data\DataLoader;

/**
 * DataLoaderTest
 *
 * @category   test
 * @package    cocur/domain
 * @subpackage whois
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  (c) 2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class DataLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Cocur\Domain\Data\DataLoader */
    private $loader;

    public function setUp()
    {
        $this->loader = new DataLoader();
    }

    /**
     * @test
     * @covers Cocur\Domain\Data\DataLoader::load()
     */
    public function load()
    {
        $data = $this->loader->load(__DIR__.'/../fixtures/tld.json');
        $this->assertEquals('aero', $data[0]['tld']);
    }

    /**
     * @test
     * @covers Cocur\Domain\Data\DataLoader::load()
     * @expectedException Cocur\Domain\Data\DataLoadException
     */
    public function loadNotExistingFile()
    {
        $this->loader->load(__DIR__.'/../fixtures/invalid.json');
    }
}
