<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData;

use Zend\Http\Client\Adapter;

/**
 * Extends the default HTTP adapter to handle streams instead of discrete body
 * strings.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GData
 */
class HttpAdapterStreamingSocket extends Adapter\Socket
{

    /**
     * The amount read from a stream source at a time.
     *
     * @var integer
     */
    const CHUNK_SIZE = 1024;

    /**
     * Send request to the remote server with streaming support.
     *
     * @param string        $method
     * @param \Zend\Uri\Uri $uri
     * @param string        $http_ver
     * @param array         $headers
     * @param string        $body
     * @return string Request as string
     */
    public function write($method, $uri, $http_ver = '1.1', $headers = array(),
        $body = '')
    {
        // Make sure we're properly connected
        if (! $this->socket) {
            throw new Adapter\Exception\RuntimeException(
                'Trying to write but we are not connected'
            );
        }

        $host = $uri->getHost();
        $host = (strtolower($uri->getScheme()) == 'https' ? $this->config['ssltransport'] : 'tcp') . '://' . $host;
        if ($this->connected_to[0] != $host || $this->connected_to[1] != $uri->getPort()) {
            throw new Adapter\Exception\RuntimeException(
                'Trying to write but we are connected to the wrong host'
            );
        }

        // Save request method for later
        $this->method = $method;

        // Build request headers
        $path = $uri->getPath();
        if ($uri->getQuery()) $path .= '?' . $uri->getQuery();
        $request = "{$method} {$path} HTTP/{$http_ver}\r\n";
        foreach ($headers as $k => $v) {
            if (is_string($k)) $v = ucfirst($k) . ": $v";
            $request .= "$v\r\n";
        }

        // Send the headers over
        $request .= "\r\n";
        if (! @fwrite($this->socket, $request)) {
            throw new Adapter\Exception\RuntimeException(
                'Error writing request to server'
            );
        }


        //read from $body, write to socket
        $chunk = $body->read(self::CHUNK_SIZE);
        while ($chunk !== FALSE) {
            if (! @fwrite($this->socket, $chunk)) {
                throw new Adapter\Exception\RuntimeException(
                    'Error writing request to server'
                );
            }
            $chunk = $body->read(self::CHUNK_SIZE);
        }
        $body->closeFileHandle();
        return 'Large upload, request is not cached.';
    }
}
