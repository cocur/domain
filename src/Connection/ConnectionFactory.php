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

/**
 * ConnectionFactory
 *
 * @package    cocur/domain
 * @subpackage connection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class ConnectionFactory
{
    /**
     * Creates a new StreamConnection object.
     *
     * @return StreamConnection
     */
    public function createStreamConnection()
    {
        return new StreamConnection();
    }
}
