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
 * Service class for interacting with the services which use the media extensions
 * @link http://code.google.com/apis/gdata/calendar.html
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Media
 */
class Media extends GData
{

    /**
     * Namespaces used for ZendGData\Photos
     *
     * @var array
     */
    public static $namespaces = array(
        array('media', 'http://search.yahoo.com/mrss/', 1, 0)
    );

    /**
     * Create ZendGData\Media object
     *
     * @param \Zend\Http\Client $client (optional) The HTTP client to use when
     *          when communicating with the Google Apps servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('ZendGData\Media');
        $this->registerPackage('ZendGData\Media\Extension');
        parent::__construct($client, $applicationId);
    }

}
