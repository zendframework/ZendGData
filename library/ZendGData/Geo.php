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

/**
 * Service class for interacting with the services which use the
 * GeoRSS + GML extensions.
 * @link http://georss.org/
 * @link http://www.opengis.net/gml/
 * @link http://code.google.com/apis/picasaweb/reference.html#georss_reference
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Geo
 */
class Geo extends GData
{

    /**
     * Namespaces used for ZendGData\Geo
     *
     * @var array
     */
    public static $namespaces = array(
        array('georss', 'http://www.georss.org/georss', 1, 0),
        array('gml', 'http://www.opengis.net/gml', 1, 0)
    );


    /**
     * Create ZendGData\Geo object
     *
     * @param \Zend\Http\Client $client (optional) The HTTP client to use when
     *          when communicating with the Google Apps servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('ZendGData\Geo');
        $this->registerPackage('ZendGData\Geo\Extension');
        parent::__construct($client, $applicationId);
    }

}
