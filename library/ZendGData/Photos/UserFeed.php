<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Photos;

use ZendGData\Photos;

/**
 * Data model for a collection of entries for a specific user, usually
 * provided by the servers.
 *
 * For information on requesting this feed from a server, see the
 * service class, ZendGData\Photos.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Photos
 */
class UserFeed extends \ZendGData\Feed
{

    /**
     * gphoto:user element
     *
     * @var \ZendGData\Photos\Extension\User
     */
    protected $_gphotoUser = null;

    /**
     * gphoto:thumbnail element
     *
     * @var \ZendGData\Photos\Extension\Thumbnail
     */
    protected $_gphotoThumbnail = null;

    /**
     * gphoto:nickname element
     *
     * @var \ZendGData\Photos\Extension\Nickname
     */
    protected $_gphotoNickname = null;

    protected $_entryClassName = 'ZendGData\Photos\UserEntry';
    protected $_feedClassName = 'ZendGData\Photos\UserFeed';

    protected $_entryKindClassMapping = array(
        'http://schemas.google.com/photos/2007#album' => 'ZendGData\Photos\AlbumEntry',
        'http://schemas.google.com/photos/2007#photo' => 'ZendGData\Photos\PhotoEntry',
        'http://schemas.google.com/photos/2007#comment' => 'ZendGData\Photos\CommentEntry',
        'http://schemas.google.com/photos/2007#tag' => 'ZendGData\Photos\TagEntry'
    );

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Photos::$namespaces);
        parent::__construct($element);
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them in the $_entry array based upon DOM data.
     *
     * @param DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
            case $this->lookupNamespace('gphoto') . ':' . 'user';
                $user = new Extension\User();
                $user->transferFromDOM($child);
                $this->_gphotoUser = $user;
                break;
            case $this->lookupNamespace('gphoto') . ':' . 'nickname';
                $nickname = new Extension\Nickname();
                $nickname->transferFromDOM($child);
                $this->_gphotoNickname = $nickname;
                break;
            case $this->lookupNamespace('gphoto') . ':' . 'thumbnail';
                $thumbnail = new Extension\Thumbnail();
                $thumbnail->transferFromDOM($child);
                $this->_gphotoThumbnail = $thumbnail;
                break;
            case $this->lookupNamespace('atom') . ':' . 'entry':
                $entryClassName = $this->_entryClassName;
                $tmpEntry = new \ZendGData\App\Entry($child);
                $categories = $tmpEntry->getCategory();
                foreach ($categories as $category) {
                    if ($category->scheme == Photos::KIND_PATH &&
                        $this->_entryKindClassMapping[$category->term] != "") {
                            $entryClassName = $this->_entryKindClassMapping[$category->term];
                            break;
                    } else {
                        throw new \ZendGData\App\Exception('Entry is missing kind declaration.');
                    }
                }

                $newEntry = new $entryClassName($child);
                $newEntry->setService($this->getService());
                $this->_entry[] = $newEntry;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_gphotoUser != null) {
            $element->appendChild($this->_gphotoUser->getDOM($element->ownerDocument));
        }
        if ($this->_gphotoNickname != null) {
            $element->appendChild($this->_gphotoNickname->getDOM($element->ownerDocument));
        }
        if ($this->_gphotoThumbnail != null) {
            $element->appendChild($this->_gphotoThumbnail->getDOM($element->ownerDocument));
        }

        return $element;
    }

    /**
     * Get the value for this element's gphoto:user attribute.
     *
     * @see setGphotoUser
     * @return string The requested attribute.
     */
    public function getGphotoUser()
    {
        return $this->_gphotoUser;
    }

    /**
     * Set the value for this element's gphoto:user attribute.
     *
     * @param string $value The desired value for this attribute.
     * @return \ZendGData\Photos\Extension\User The element being modified.
     */
    public function setGphotoUser($value)
    {
        $this->_gphotoUser = $value;
        return $this;
    }

    /**
     * Get the value for this element's gphoto:nickname attribute.
     *
     * @see setGphotoNickname
     * @return string The requested attribute.
     */
    public function getGphotoNickname()
    {
        return $this->_gphotoNickname;
    }

    /**
     * Set the value for this element's gphoto:nickname attribute.
     *
     * @param string $value The desired value for this attribute.
     * @return \ZendGData\Photos\Extension\Nickname The element being modified.
     */
    public function setGphotoNickname($value)
    {
        $this->_gphotoNickname = $value;
        return $this;
    }

    /**
     * Get the value for this element's gphoto:thumbnail attribute.
     *
     * @see setGphotoThumbnail
     * @return string The requested attribute.
     */
    public function getGphotoThumbnail()
    {
        return $this->_gphotoThumbnail;
    }

    /**
     * Set the value for this element's gphoto:thumbnail attribute.
     *
     * @param string $value The desired value for this attribute.
     * @return \ZendGData\Photos\Extension\Thumbnail The element being modified.
     */
    public function setGphotoThumbnail($value)
    {
        $this->_gphotoThumbnail = $value;
        return $this;
    }

}
