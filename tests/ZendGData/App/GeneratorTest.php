<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\App;

use ZendGData\App\Extension;

/**
 * @category   Zend
 * @package    ZendGData\App
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\App
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->generatorText = file_get_contents(
                'ZendGData/App/_files/GeneratorElementSample1.xml',
                true);
        $this->generator = new Extension\Generator();
    }

    public function testEmptyGeneratorShouldHaveEmptyExtensionsList()
    {
        $this->assertTrue(is_array($this->generator->extensionElements));
        $this->assertTrue(count($this->generator->extensionElements) == 0);
    }

    public function testEmptyGeneratorToAndFromStringShouldMatch()
    {
        $generatorXml = $this->generator->saveXML();
        $newGenerator = new Extension\Generator();
        $newGenerator->transferFromXML($generatorXml);
        $newGeneratorXml = $newGenerator->saveXML();
        $this->assertTrue($generatorXml == $newGeneratorXml);
    }

    public function testGeneratorToAndFromStringShouldMatch()
    {
        $this->generator->uri = 'http://code.google.com/apis/gdata/';
        $this->generator->version = '1.0';
        $this->generator->text = 'Google data APIs';
        $generatorXml = $this->generator->saveXML();
        $newGenerator = new Extension\Generator();
        $newGenerator->transferFromXML($generatorXml);
        $newGeneratorXml = $newGenerator->saveXML();
        $this->assertEquals($newGeneratorXml, $generatorXml);
        $this->assertEquals('http://code.google.com/apis/gdata/',
                $newGenerator->uri);
        $this->assertEquals('1.0', $newGenerator->version);
        $this->assertEquals('Google data APIs', $newGenerator->text);
    }

    public function testConvertGeneratorWithDraftToAndFromString()
    {
        $this->generator->transferFromXML($this->generatorText);
        $this->assertEquals('http://code.google.com/apis/gdata/',
                $this->generator->uri);
        $this->assertEquals('1.0', $this->generator->version);
        $this->assertEquals('Google data APIs', $this->generator->text);
    }

}
