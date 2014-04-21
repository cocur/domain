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
 * ConnectionInterface
 *
 * @package    cocur/domain
 * @subpackage connection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
interface ConnectionInterface
{
    /**
     * Opens a connection.
     *
     * @param string  $hostname
     * @param integer $port
     *
     * @return ConnectionInterface
     */
    public function open($hostname, $port);

    /**
     * Reads from the connection.
     *
     * @param integer $length Number of bytes to read; if `null` all bytes are read.
     *
     * @return string
     */
    public function read($length = null);

    /**
     * Writes to the connection.
     *
     * @param string $string
     *
     * @return ConnectionInterface
     */
    public function write($string);

    /**
     * Closes the connection.
     *
     * @return ConnectionInterface
     */
    public function close();
}
