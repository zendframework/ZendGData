<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Books\Extension;

/**
 * Describes a thumbnail link
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Books
 */
class ThumbnailLink extends
    BooksLink
{

    /**
     * Constructor for ZendGData\Books\Extension\ThumbnailLink which
     * Describes a thumbnail link
     *
     * @param string|null $href Linked resource URI
     * @param string|null $rel Forward relationship
     * @param string|null $type Resource MIME type
     * @param string|null $hrefLang Resource language
     * @param string|null $title Human-readable resource title
     * @param string|null $length Resource length in octets
     */
    public function __construct($href = null, $rel = null, $type = null,
            $hrefLang = null, $title = null, $length = null)
    {
        $this->registerAllNamespaces(\ZendGData\Books::$namespaces);
        parent::__construct($href, $rel, $type, $hrefLang, $title, $length);
    }

}
