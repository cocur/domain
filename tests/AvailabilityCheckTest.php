<?php

namespace Cocur\Domain;

use Cocur\Domain\Connection\ConnectionFactory;
use Cocur\Domain\Data\DataLoader;
use Cocur\Domain\Whois\Client as WhoisClient;
use Cocur\Domain\Whois\QuotaExceededException;
use Cocur\Domain\Whois\WhoisException;
use Cocur\Domain\Availability\Client as AvailabilityClient;

/**
 * AvailabilityCheckTest
 *
 * @group functional
 */
class AvailabilityCheckTest extends \PHPUnit_Framework_TestCase
{
    /** @var AvailabilityClient */
    private $client;

    public function setUp()
    {
        $factory = new ConnectionFactory();
        $dataLoader = new DataLoader();
        $data = $dataLoader->load(__DIR__.'/../data/tld.json');

        $this->client = new AvailabilityClient(new WhoisClient($factory, $data), $data);
    }

    /**
     * @test
     * @dataProvider domainProvider
     */
    public function checkAvailable($domain, $isAvailable)
    {
        try {
            $result = $this->client->isAvailable($domain);
            if ($result !== $isAvailable) {
                echo "\n$domain\n";
                print_r($this->client->getLastWhoisResult());
                echo "\n";
            }
            $this->assertEquals($isAvailable, $result);
        } catch (QuotaExceededException $e) {
            $this->markTestSkipped(sprintf('Quota for WHOIS server exceeded: %s', $domain));
        } catch (WhoisException $e) {
            $this->markTestSkipped(sprintf('WHOIS failed for: %s', $domain));
        }
    }

    public function domainProvider()
    {
        return [
            [ 'nic.aero', false ], [ 'nicabcdefgh.aero', true ],
            [ 'nic.asia', false ], [ 'nicabcdefgh.asia', true ],
            [ 'nic.biz', false ], [ 'nicabcdefgh.biz', true ],
            [ 'nic.cat', false ], [ 'nicabcdefgh.cat', true ],
            [ 'nic.com', false ], [ 'nicabcdefgh.com', true ],
            [ 'nic.coop', false ], [ 'nicabcdefgh.coop', true ],
            [ 'nic.info', false ], [ 'nicabcdefgh.info', true ],
            [ 'nic.jobs', false ], [ 'nicabcdefgh.jobs', true ],
            [ 'nic.mobi', false ], [ 'nicabcdefgh.mobi', true ],
            [ 'nic.museum', false ], [ 'nicabcdefgh.museum', true ],
            [ 'nic.name', false ], [ 'nicabcdefgh.name', true ],
            [ 'nic.net', false ], [ 'nicabcdefgh.net', true ],
            [ 'nic.org', false ], [ 'nicabcdefgh.org', true ],
            [ 'nic.pro', false ], [ 'nicabcdefgh.pro', true ],
            [ 'nic.tel', false ], [ 'nicabcdefgh.tel', true ],
            [ 'nic.travel', false ], [ 'nicabcdefgh.travel', true ],
            [ 'nic.xxx', false ], [ 'nicabcdefgh.xxx', true ],
            [ 'nic.edu', false ], [ 'nicabcdefgh.edu', true ],
            [ 'nic.gov', false ], [ 'nicabcdefgh.gov', true ],
            [ 'nic.ac', false ], [ 'nicabcdefgh.ac', true ],
            [ 'nic.ae', false ], [ 'nicabcdefgh.ae', true ],
            [ 'nic.af', false ], [ 'nicabcdefgh.af', true ],
            [ 'nic.ag', false ], [ 'nicabcdefgh.ag', true ],
            [ 'nic.ai', false ], [ 'nicabcdefgh.ai', true ],
            [ 'nic.am', false ], [ 'nicabcdefgh.am', true ],
            [ 'nic.as', false ], [ 'nicabcdefgh.as', true ],
            [ 'nic.at', false ], [ 'nicabcdefgh.at', true ],
            [ 'audns.net.au', false ], [ 'nicabcdefgh.au', true ],
            [ 'dns.be', false ], [ 'nicabcdefgh.be', true ],
            [ 'nic.bg', false ], [ 'nicabcdefgh.bg', true ],
            // [ 'nic.bi', false ], [ 'nicabcdefgh.bi', true ],
            // [ 'nic.bo', false ], [ 'nicabcdefgh.bo', true ],
            [ 'nic.br', false ], [ 'nicabcdefgh.br', true ],
            [ 'nic.by', false ], [ 'nicabcdefgh.by', true ],
            [ 'nic.ca', false ], [ 'nicabcdefgh.ca', true ],
            [ 'nic.cc', false ], [ 'nicabcdefgh.cc', true ],
            [ 'nic.ch', false ], [ 'nicabcdefgh.ch', true ],
            [ 'nic.ci', false ], [ 'nicabcdefgh.ci', true ],
            // [ 'nic.cl', false ], [ 'nicabcdefgh.cl', true ],
            [ 'nic.cn', false ], [ 'nicabcdefgh.cn', true ],
            [ 'nic.co', false ], [ 'nicabcdefgh.co', true ],
            [ 'nic.cx', false ], [ 'nicabcdefgh.cx', true ],
            [ 'nic.cz', false ], [ 'nicabcdefgh.cz', true ],
            [ 'nic.de', false ], [ 'nicabcdefgh.de', true ],
            [ 'nic.dk', false ], [ 'nicabcdefgh.dk', true ],
            [ 'nic.dm', false ], [ 'nicabcdefgh.dm', true ],
            [ 'nic.ec', false ], [ 'nicabcdefgh.ec', true ],
            [ 'nic.ee', false ], [ 'nicabcdefgh.ee', true ],
            [ 'nic.eu', false ], [ 'nicabcdefgh.eu', true ],
            [ 'nic.fi', false ], [ 'nicabcdefgh.fi', true ],
            [ 'nic.fo', false ], [ 'nicabcdefgh.fo', true ],
            [ 'nic.fr', false ], [ 'nicabcdefgh.fr', true ],
            [ 'nic.gd', false ], [ 'nicabcdefgh.gd', true ],
            [ 'nic.gg', false ], [ 'nicabcdefgh.gg', true ],
            [ 'nic.gl', false ], [ 'nicabcdefgh.gl', true ],
            [ 'nic.gs', false ], [ 'nicabcdefgh.gs', true ],
            [ 'nic.gy', false ], [ 'nicabcdefgh.gy', true ],
            [ 'nic.hk', false ], [ 'nicabcdefgh.hk', true ],
            [ 'nic.hn', false ], [ 'nicabcdefgh.hn', true ],
            // [ 'dns.hr', false ], [ 'nicabcdefgh.hr', true ],
            // [ 'nic.ht', false ], [ 'nicabcdefgh.ht', true ],
            [ 'nic.ie', false ], [ 'nicabcdefgh.ie', true ],
            [ 'isoc.org.il', false ], [ 'nicabcdefgh.il', true ],
            [ 'nic.im', false ], [ 'nicabcdefgh.im', true ],
            [ 'nic.in', false ], [ 'nicabcdefgh.in', true ],
            [ 'nic.io', false ], [ 'nicabcdefgh.io', true ],
            [ 'nic.iq', false ], [ 'nicabcdefgh.iq', true ],
            [ 'nic.ir', false ], [ 'nicabcdefgh.ir', true ],
            [ 'nic.is', false ], [ 'nicabcdefgh.is', true ],
            [ 'nic.it', false ], [ 'nicabcdefgh.it', true ],
            [ 'nic.je', false ], [ 'nicabcdefgh.je', true ],
            [ 'nic.jp', false ], [ 'nicabcdefgh.jp', true ],
            [ 'kenic.or.ke', false ], [ 'nicabcdefgh.ke', true ],
            [ 'nic.kg', false ], [ 'nicabcdefgh.kg', true ],
            [ 'nic.ki', false ], [ 'nicabcdefgh.ki', true ],
            [ 'nic.kr', false ], [ 'nicabcdefgh.kr', true ],
            [ 'nic.kz', false ], [ 'nicabcdefgh.kz', true ],
            [ 'nic.la', false ], [ 'nicabcdefgh.la', true ],
            [ 'nic.li', false ], [ 'nicabcdefgh.li', true ],
            [ 'domreg.lt', false ], [ 'nicabcdefgh.lt', true ],
            [ 'nic.lu', false ], [ 'nicabcdefgh.lu', true ],
            [ 'nic.lv', false ], [ 'nicabcdefgh.lv', true ],
            [ 'nic.ly', false ], [ 'nicabcdefgh.ly', true ],
            [ 'nic.ma', false ], [ 'nicabcdefgh.ma', true ],
            [ 'nic.md', false ], [ 'nicabcdefgh.md', true ],
            [ 'nic.me', false ], [ 'nicabcdefgh.me', true ],
            [ 'nic.mg', false ], [ 'nicabcdefgh.mg', true ],
            [ 'nic.ms', false ], [ 'nicabcdefgh.ms', true ],
            [ 'nic.mu', false ], [ 'nicabcdefgh.mu', true ],
            [ 'nic.mx', false ], [ 'nicabcdefgh.mx', true ],
            [ 'nic.my', false ], [ 'nicabcdefgh.my', true ],
            [ 'nic.na', false ], [ 'nicabcdefgh.na', true ],
            [ 'whois.nc', false ], [ 'nicabcdefgh.nc', true ],
            [ 'nic.nf', false ], [ 'nicabcdefgh.nf', true ],
            [ 'nic.ng', false ], [ 'nicabcdefgh.ng', true ],
            [ 'nic.nl', false ], [ 'nicabcdefgh.nl', true ],
            [ 'nic.no', false ], [ 'nicabcdefgh.no', true ],
            [ 'nic.nu', false ], [ 'nicabcdefgh.nu', true ],
            [ 'whois.nc', false ], [ 'nicabcdefgh.co.nz', true ],
            [ 'nic.om', false ], [ 'nicabcdefgh.om', true ],
            [ 'nic.pe', false ], [ 'nicabcdefgh.pe', true ],
            [ 'nic.pl', false ], [ 'nicabcdefgh.pl', true ],
            [ 'nic.pm', false ], [ 'nicabcdefgh.pm', true ],
            // [ 'nic.ps', false ], [ 'nicabcdefgh.ps', true ],
            [ 'nic.pt', false ], [ 'nicabcdefgh.pt', true ],
            [ 'nic.qa', false ], [ 'nicabcdefgh.qa', true ],
            [ 'nic.re', false ], [ 'nicabcdefgh.re', true ],
            [ 'nic.ro', false ], [ 'nicabcdefgh.ro', true ],
            [ 'nic.rs', false ], [ 'nicabcdefgh.rs', true ],
            [ 'nic.ru', false ], [ 'nicabcdefgh.ru', true ],
            [ 'nic.sa', false ], [ 'nicabcdefgh.sa', true ],
            // [ 'nic.sb', false ], [ 'nicabcdefgh.sb', true ],
            [ 'nic.sc', false ], [ 'nicabcdefgh.sc', true ],
            [ 'nic.se', false ], [ 'nicabcdefgh.se', true ],
            [ 'nic.sg', false ], [ 'nicabcdefgh.sg', true ],
            [ 'nic.sh', false ], [ 'nicabcdefgh.sh', true ],
            [ 'nic.si', false ], [ 'nicabcdefgh.si', true ],
            [ 'nic.sk', false ], [ 'nicabcdefgh.sk', true ],
            [ 'nic.sm', false ], [ 'nicabcdefgh.sm', true ],
            [ 'nic.so', false ], [ 'nicabcdefgh.so', true ],
            [ 'nic.st', false ], [ 'nicabcdefgh.st', true ],
            [ 'nic.su', false ], [ 'nicabcdefgh.su', true ],
            [ 'nic.tc', false ], [ 'nicabcdefgh.tc', true ],
            [ 'nic.tf', false ], [ 'nicabcdefgh.tf', true ],
            [ 'thnic.co.th', false ], [ 'nicabcdefgh.th', true ],
            [ 'nic.tk', false ], [ 'nicabcdefgh.tk', true ],
            [ 'nic.tl', false ], [ 'nicabcdefgh.tl', true ],
            [ 'nic.tm', false ], [ 'nicabcdefgh.tm', true ],
            [ 'nic.to', false ], [ 'nicabcdefgh.to', true ],
            [ 'nic.tr', false ], [ 'nicabcdefgh.com.tr', true ],
            [ 'nic.tv', false ], [ 'nicabcdefgh.tv', true ],
            [ 'nic.tw', false ], [ 'nicabcdefgh.tw', true ],
            [ 'tznic.or.tz', false ], [ 'nicabcdefgh.tz', true ],
            [ 'nic.ua', false ], [ 'nicabcdefgh.ua', true ],
            [ 'registry.co.ug', false ], [ 'nicabcdefgh.ug', true ],
            [ 'nic.uk', false ], [ 'nicabcdefgh.co.uk', true ],
            [ 'nic.us', false ], [ 'nicabcdefgh.us', true ],
            [ 'nic.uy', false ], [ 'nicabcdefgh.uy', true ],
            [ 'nic.uz', false ], [ 'nicabcdefgh.uz', true ],
            [ 'nic.vc', false ], [ 'nicabcdefgh.vc', true ],
            // [ 'nic.ve', false ], [ 'nicabcdefgh.ve', true ],
            [ 'nic.vg', false ], [ 'nicabcdefgh.co.vg', true ],
            [ 'nic.wf', false ], [ 'nicabcdefgh.wf', true ],
            // [ 'nic.ws', false ], [ 'nicabcdefgh.ws', true ],
            [ 'nic.yt', false ], [ 'nicabcdefgh.yt', true ],
        ];
    }
}
