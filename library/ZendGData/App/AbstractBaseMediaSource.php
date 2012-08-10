<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\App;

/**
 * Concrete class to use a file handle as an attachment within a MediaEntry.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage App
 */
abstract class AbstractBaseMediaSource implements MediaSource
{

    /**
     * The content type for the attached file (example image/png)
     *
     * @var string
     */
    protected $_contentType = null;

    /**
     * The slug header value representing the attached file title, or null if
     * no slug should be used.  The slug header is only necessary in some cases,
     * usually when a multipart upload is not being performed.
     *
     * @var string
     */
    protected $_slug = null;

    /**
     * The content type for the attached file (example image/png)
     *
     * @return string The content type
     */
    public function getContentType()
    {
        return $this->_contentType;
    }

    /**
     * Set the content type for the file attached (example image/png)
     *
     * @param string $value The content type
     * @return \ZendGData\App\MediaFileSource Provides a fluent interface
     */
    public function setContentType($value)
    {
        $this->_contentType = $value;
        return $this;
    }

    /**
     * Returns the Slug header value.  Used by some services to determine the
     * title for the uploaded file.  Returns null if no slug should be used.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->_slug;
    }

    /**
     * Sets the Slug header value.  Used by some services to determine the
     * title for the uploaded file.  A null value indicates no slug header.
     *
     * @var string The slug value
     * @return \ZendGData\App\MediaSource Provides a fluent interface
     */
    public function setSlug($value)
    {
        $this->_slug = $value;
        return $this;
    }


    /**
     * Magic getter to allow acces like $source->foo to call $source->getFoo()
     * Alternatively, if no getFoo() is defined, but a $_foo protected variable
     * is defined, this is returned.
     *
     * TODO Remove ability to bypass getFoo() methods??
     *
     * @param string $name The variable name sought
     */
    public function __get($name)
    {
        $method = 'get'.ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } elseif (property_exists($this, "_${name}")) {
            return $this->{'_' . $name};
        } else {
            throw new InvalidArgumentException(
                    'Property ' . $name . ' does not exist');
        }
    }

    /**
     * Magic setter to allow acces like $source->foo='bar' to call
     * $source->setFoo('bar') automatically.
     *
     * Alternatively, if no setFoo() is defined, but a $_foo protected variable
     * is defined, this is returned.
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function __set($name, $val)
    {
        $method = 'set'.ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($val);
        } elseif (isset($this->{'_' . $name}) || ($this->{'_' . $name} === null)) {
            $this->{'_' . $name} = $val;
        } else {
            throw new InvalidArgumentException(
                    'Property ' . $name . '  does not exist');
        }
    }

    /**
     * Magic __isset method
     *
     * @param string $name
     */
    public function __isset($name)
    {
        $rc = new \ReflectionClass(get_called_class());
        $privName = '_' . $name;
        if (!($rc->hasProperty($privName))) {
            throw new InvalidArgumentException(
                    'Property ' . $name . ' does not exist');
        } else {
            if (isset($this->{$privName})) {
                if (is_array($this->{$privName})) {
                    if (count($this->{$privName}) > 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

}
