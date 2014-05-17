<?php

/**
 * This file is part of cocur/domain.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Domain;

/**
 * Domain
 *
 * @package   cocur/domain
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2014 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class Domain
{
    /** @var string */
    private $domainName;

    /**
     * Creates a new instance of Domain.
     *
     * @param string $domainName Domain name.
     *
     * @return Domain Domain object.
     */
    public static function create($domainName = null)
    {
        return new self($domainName);
    }

    /**
     * Constructor.
     *
     * @param string $domainName Domain name.
     */
    public function __construct($domainName = null)
    {
        if (null !== $domainName) {
            $this->setDomainName($domainName);
        }
    }

    /**
     * Sets the domain name.
     *
     * @param string $domainName Domain name.
     *
     * @return Domain
     */
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;

        return $this;
    }

    /**
     * Returns the domain name.
     *
     * @return string Domain name.
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * Returns the TLD of the domain name.
     *
     * @return string TLD of the domain name.
     */
    public function getTld()
    {
        return preg_replace('/(.*)\.([a-z]+)$/', '$2', $this->domainName);
    }
}
