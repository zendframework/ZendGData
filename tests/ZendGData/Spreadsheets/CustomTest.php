<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Spreadsheets;

use ZendGData\Spreadsheets\Extension;

/**
 * @category   Zend
 * @package    ZendGData\Spreadsheets
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Spreadsheets
 */
class CustomTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->custom = new Extension\Custom();
    }

    public function testToAndFromString()
    {
        $this->custom->setText('value');
        $this->assertTrue($this->custom->getText() == 'value');
        $this->custom->setColumnName('column_name');
        $this->assertTrue($this->custom->getColumnName() == 'column_name');
        $newCustom = new Extension\Custom();
        $doc = new \DOMDocument();
        $doc->loadXML($this->custom->saveXML());
        $newCustom->transferFromDom($doc->documentElement);
        $this->assertTrue($this->custom->getText() == $newCustom->getText());
        $this->assertTrue($this->custom->getColumnName() == $newCustom->getColumnName());
    }

}
