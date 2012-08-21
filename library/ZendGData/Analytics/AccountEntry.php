<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Analytics;

use ZendGData\Entry;
use ZendGData\Analytics;

/**
 * @category   Zend
 * @package    ZendGData
 * @subpackage Analytics
 */
class AccountEntry extends Entry
{
    protected $_accountId;
    protected $_accountName;
    protected $_profileId;
    protected $_webPropertyId;
    protected $_currency;
    protected $_timezone;
    protected $_tableId;
    protected $_profileName;
    protected $_goal;

    /**
     * @see ZendGData\Entry::__construct()
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Analytics::$namespaces);
        parent::__construct($element);
    }

    /**
     * @param DOMElement $child
     * @return void
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName){
            case $this->lookupNamespace('analytics') . ':' . 'property';
                $property = new Extension\Property();
                $property->transferFromDOM($child);
                $this->{$property->getName()} = $property;
                break;
            case $this->lookupNamespace('analytics') . ':' . 'tableId';
                $tableId = new Extension\TableId();
                $tableId->transferFromDOM($child);
                $this->_tableId = $tableId;
                break;
            case $this->lookupNamespace('ga') . ':' . 'goal';
                $goal = new Extension\Goal();
                $goal->transferFromDOM($child);
                $this->_goal = $goal;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }
}
