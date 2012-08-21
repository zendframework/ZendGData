<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest;

/**
 * @category   Zend
 * @package    ZendGData\Books
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Books
 */
class BooksTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->gdata = new \ZendGData\Books(new \Zend\Http\Client());
    }

    public function testBooks()
    {
        $this->assertTrue(true);
    }

}
