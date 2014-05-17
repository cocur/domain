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
 * StreamConnection
 *
 * @package    cocur/domain
 * @subpackage connection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2014 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class StreamConnection implements ConnectionInterface
{
    /** @var resource */
    private $connection = null;

    /**
     * Opens a connection to the given hostname and port.
     *
     * @param string  $hostname Hostname
     * @param integer $port     Port
     *
     * @return StreamConnection
     *
     * @throws ConnectionException if the connection cannot be opened.
     */
    public function open($hostname, $port)
    {
        $this->connection = @stream_socket_client(sprintf('tcp://%s:%d', $hostname, $port), $errno, $errstr);

        if (false === $this->connection) {
            throw new ConnectionException(sprintf(
                'Could not open connection to "%s:%d": %s (%d)',
                $hostname,
                $port,
                $errstr,
                $errno
            ));
        }

        return $this;
    }

    /**
     * Writes to the connection.
     *
     * @param string $string String to write to the connection.
     *
     * @return StreamConnection
     *
     * @throws ConnectionException if the connection is not open.
     */
    public function write($string)
    {
        if (null === $this->connection) {
            throw new ConnectionException('Cannot write to connection, because connection is not open.');
        }

        fwrite($this->connection, $string);

        return $this;
    }

    /**
     * Reads from the connection.
     *
     * @param integer $length Number of bytes to read; if `null` all bytes are read.
     *
     * @return string Content from connection.
     *
     * @throws ConnectionException if the connection is not open.
     */
    public function read($length = null)
    {
        if (null === $this->connection) {
            throw new ConnectionException('Cannot read from connection, because connection is not open.');
        }

        if (null === $length) {
            return stream_get_contents($this->connection);
        } else {
            return fread($this->connection, $length);
        }
    }

    /**
     * Closes the connection.
     *
     * @return StreamConnection
     *
     * @throws ConnectionException if the connection is not open.
     */
    public function close()
    {
        if (null === $this->connection) {
            throw new ConnectionException('Cannot close connection, because connection is not open.');
        }

        fclose($this->connection);

        return $this;
    }
}
