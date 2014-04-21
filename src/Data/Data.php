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

/**
 * Data
 *
 * @package    cocur/domain
 * @subpackage data
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class Data
{
    /** @var array */
    private $data;

    /**
     * Constructor.
     *
     * @param array $data
     *
     * @codeCoverageIgnore
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Returns if data for the given TLD exists.
     *
     * @param string $tld
     *
     * @return boolean `true` if data exists, `false` otherwise.
     */
    public function hasTld($tld)
    {
        foreach ($this->data as $data) {
            if ($tld === $data['tld']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the data for the given TLD.
     *
     * @param string $tld
     *
     * @return array Data for the given TLD.
     *
     * @throws DataException when there exists no data for the given TLD.
     */
    public function getByTld($tld)
    {
        foreach ($this->data as $data) {
            if ($tld === $data['tld']) {
                return $data;
            }
        }

        throw new DataException(sprintf('There exists no data for the TLD "%s".', $tld));
    }
}

