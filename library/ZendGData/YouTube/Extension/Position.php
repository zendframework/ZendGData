<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\YouTube\Extension;

/**
 * Data model class to represent a playlist item's position in the list (yt:position)
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class Position extends \ZendGData\Extension
{

    protected $_rootElement = 'position';
    protected $_rootNamespace = 'yt';

    /**
     * Constructs a new ZendGData\YouTube\Extension\Position object.
     *
     * @param string $value (optional) The 1-based position in the playlist
     */
    public function __construct($value = null)
    {
        $this->registerAllNamespaces(\ZendGData\YouTube::$namespaces);
        parent::__construct();
        $this->_text = $value;
    }

    /**
     * Get the value for the position in the playlist
     *
     * @return int The 1-based position in the playlist
     */
    public function getValue()
    {
        return $this->_text;
    }

    /**
     * Set the value for the position in the playlist
     *
     * @param int $value The 1-based position in the playlist
     * @return \ZendGData\Extension\Visibility The element being modified
     */
    public function setValue($value)
    {
        $this->_text = $value;
        return $this;
    }

    /**
     * Magic toString method allows using this directly via echo
     * Works best in PHP >= 4.2.0
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }

}

