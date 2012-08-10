<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\GApps;

use ZendGData\GApps;

/**
 * Assists in constructing queries for Google Apps nickname entries.
 * Instances of this class can be provided in many places where a URL is
 * required.
 *
 * For information on submitting queries to a server, see the Google Apps
 * service class, ZendGData\GApps.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GApps
 */
class NicknameQuery extends AbstractQuery
{

    /**
     * If not null, indicates the name of the nickname entry which
     * should be returned by this query.
     *
     * @var string
     */
    protected $_nickname = null;

    /**
     * Create a new instance.
     *
     * @param string $domain (optional) The Google Apps-hosted domain to use
     *          when constructing query URIs.
     * @param string $nickname (optional) Value for the nickname
     *          property.
     * @param string $username (optional) Value for the username
     *          property.
     * @param string $startNickname (optional) Value for the
     *          startNickname property.
     */
    public function __construct($domain = null, $nickname = null,
            $username = null, $startNickname = null)
    {
        parent::__construct($domain);
        $this->setNickname($nickname);
        $this->setUsername($username);
        $this->setStartNickname($startNickname);
    }

    /**
     * Set the nickname to query for. When set, only users with a nickname
     * matching this value will be returned in search results. Set to
     * null to disable filtering by username.
     *
     * @param string $value The nickname to filter search results by, or null
     *          to  disable.
     */
     public function setNickname($value)
     {
         $this->_nickname = $value;
     }

    /**
     * Get the nickname to query for. If no nickname is set, null will be
     * returned.
     *
     * @see setNickname
     * @return string The nickname to filter search results by, or null if
     *              disabled.
     */
    public function getNickname()
    {
        return $this->_nickname;
    }

    /**
     * Set the username to query for. When set, only users with a username
     * matching this value will be returned in search results. Set to
     * null to disable filtering by username.
     *
     * @param string $value The username to filter search results by, or null
     *          to disable.
     */
    public function setUsername($value)
    {
        if ($value !== null) {
            $this->_params['username'] = $value;
        } else {
            unset($this->_params['username']);
        }
    }

    /**
     * Get the username to query for. If no username is set, null will be
     * returned.
     *
     * @see setUsername
     * @return string The username to filter search results by, or null if
     *              disabled.
     */
    public function getUsername()
    {
        if (array_key_exists('username', $this->_params)) {
            return $this->_params['username'];
        } else {
            return null;
        }
    }

    /**
     * Set the first nickname which should be displayed when retrieving
     * a list of nicknames.
     *
     * @param string $value The first nickname to be returned, or null to
     *              disable.
     */
    public function setStartNickname($value)
    {
        if ($value !== null) {
            $this->_params['startNickname'] = $value;
        } else {
            unset($this->_params['startNickname']);
        }
    }

    /**
     * Get the first nickname which should be displayed when retrieving
     * a list of nicknames.
     *
     * @return string The first nickname to be returned, or null to
     *              disable.
     */
    public function getStartNickname()
    {
        if (array_key_exists('startNickname', $this->_params)) {
            return $this->_params['startNickname'];
        } else {
            return null;
        }
    }

    /**
     * Returns the URL generated for this query, based on it's current
     * parameters.
     *
     * @return string A URL generated based on the state of this query.
     */
    public function getQueryUrl()
    {

        $uri = $this->getBaseUrl();
        $uri .= GApps::APPS_NICKNAME_PATH;
        if ($this->_nickname !== null) {
            $uri .= '/' . $this->_nickname;
        }
        $uri .= $this->getQueryString();
        return $uri;
    }

}
