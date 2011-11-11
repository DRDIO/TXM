<?php

require_once 'Rackspace/Exception.php';
require_once 'Rackspace/Http.php';

/**
 * Class for handling Cloud Files Authentication, call it's {@link authenticate()}
 * method to obtain authorized service urls and an authentication token.
 *
 * Example:
 * <code>
 * # Create the authentication instance
 * #
 * $auth = new Rackspace_Authentication("username", "api_key");
 *
 * # NOTE: For UK Customers please specify your AuthURL Manually
 * # There is a Predfined constant to use EX:
 * #
 * # $auth = new Rackspace_Authentication("username, "api_key", NULL, self::UK_AUTHURL);
 * # Using the self::UK_AUTHURL keyword will force the api to use the UK AuthUrl.
 * # rather then the US one. The NULL Is passed for legacy purposes and must
 * # be passed to function correctly.
 *
 * # NOTE: Some versions of cURL include an outdated certificate authority (CA)
 * #       file.  This API ships with a newer version obtained directly from
 * #       cURL's web site (http://curl.haxx.se).  To use the newer CA bundle,
 * #       call the Rackspace_Authentication instance's 'ssl_use_cabundle()' method.
 * #
 * # $auth->ssl_use_cabundle(); # bypass cURL's old CA bundle
 *
 * # Perform authentication request
 * #
 * $auth->authenticate();
 * </code>
 *
 * @package php-cloudfiles
 */
class Rackspace_Authentication
{
    const DEFAULT_CF_API_VERSION = 1;
    const US_AUTHURL = 'https://auth.api.rackspacecloud.com';
    const UK_AUTHURL = 'https://lon.auth.api.rackspacecloud.com';

    public $dbug;
    public $username;
    public $api_key;
    public $auth_host;
    public $account;

    /**
     * Instance variables that are set after successful authentication
     */
    public $storage_url;
    public $cdnm_url;
    public $auth_token;

    /**
     * Class constructor (PHP 5 syntax)
     *
     * @param string $username Mosso username
     * @param string $api_key Mosso API Access Key
     * @param string $account  <i>Account name</i>
     * @param string $auth_host  <i>Authentication service URI</i>
     */
    function __construct($username = null, $api_key = null, $account = null, $auth_host = self::US_AUTHURL)
    {

        $this->dbug = False;
        $this->username = $username;
        $this->api_key = $api_key;
        $this->account_name = $account;
        $this->auth_host = $auth_host;

        $this->storage_url = NULL;
        $this->cdnm_url = NULL;
        $this->auth_token = NULL;

        $this->cfs_http = new Rackspace_Http(self::DEFAULT_CF_API_VERSION);
    }

    /**
     * Use the Certificate Authority bundle included with this API
     *
     * Most versions of PHP with cURL support include an outdated Certificate
     * Authority (CA) bundle (the file that lists all valid certificate
     * signing authorities).  The SSL certificates used by the Cloud Files
     * storage system are perfectly valid but have been created/signed by
     * a CA not listed in these outdated cURL distributions.
     *
     * As a work-around, we've included an updated CA bundle obtained
     * directly from cURL's web site (http://curl.haxx.se).  You can direct
     * the API to use this CA bundle by calling this method prior to making
     * any remote calls.  The best place to use this method is right after
     * the Rackspace_Authentication instance has been instantiated.
     *
     * You can specify your own CA bundle by passing in the full pathname
     * to the bundle.  You can use the included CA bundle by leaving the
     * argument blank.
     *
     * @param string $path Specify path to CA bundle (default to included)
     */
    function ssl_use_cabundle($path=NULL)
    {
        $this->cfs_http->ssl_use_cabundle($path);
    }

    /**
     * Attempt to validate Username/API Access Key
     *
     * Attempts to validate credentials with the authentication service.  It
     * either returns <kbd>True</kbd> or throws an Exception.  Accepts a single
     * (optional) argument for the storage system API version.
     *
     * Example:
     * <code>
     * # Create the authentication instance
     * #
     * $auth = new Rackspace_Authentication("username", "api_key");
     *
     * # Perform authentication request
     * #
     * $auth->authenticate();
     * </code>
     *
     * @param string $version API version for Auth service (optional)
     * @return boolean <kbd>True</kbd> if successfully authenticated
     * @throws Rackspace_Exception invalid credentials
     * @throws Rackspace_Exception invalid response
     */
    function authenticate($version = self::DEFAULT_CF_API_VERSION)
    {
        list($status,$reason,$surl,$curl,$atoken) = 
                $this->cfs_http->authenticate($this->username, $this->api_key,
                $this->account_name, $this->auth_host);

        if ($status == 401) {
            throw new Rackspace_Exception("Invalid username or access key.");
        }
        if ($status < 200 || $status > 299) {
            throw new Rackspace_Exception(
                "Unexpected response (".$status."): ".$reason);
        }

        if (!($surl || $curl) || !$atoken) {
            throw new Rackspace_Exception(
                "Expected headers missing from auth service.");
        }
        $this->storage_url = $surl;
        $this->cdnm_url = $curl;
        $this->auth_token = $atoken;
        return True;
    }
	/**
	 * Use Cached Token and Storage URL's rather then grabbing from the Auth System
         *
         * Example:
 	 * <code>
         * #Create an Auth instance
         * $auth = new Rackspace_Authentication();
         * #Pass Cached URL's and Token as Args
	 * $auth->load_cached_credentials("auth_token", "storage_url", "cdn_management_url");
         * </code>
	 * 
	 * @param string $auth_token A Cloud Files Auth Token (Required)
         * @param string $storage_url The Cloud Files Storage URL (Required)
         * @param string $cdnm_url CDN Management URL (Required)
         * @return boolean <kbd>True</kbd> if successful 
	 * @throws Rackspace_Exception If any of the Required Arguments are missing
         */
	function load_cached_credentials($auth_token, $storage_url, $cdnm_url)
    {
        if(!$storage_url || !$cdnm_url)
        {
                throw new Rackspace_Exception("Missing Required Interface URL's!");
                return False;
        }
        if(!$auth_token)
        {
                throw new Rackspace_Exception("Missing Auth Token!");
                return False;
        }

        $this->storage_url = $storage_url;
        $this->cdnm_url    = $cdnm_url;
        $this->auth_token  = $auth_token;
        return True;
    }
	/**
         * Grab Cloud Files info to be Cached for later use with the load_cached_credentials method.
         *
	 * Example:
         * <code>
         * #Create an Auth instance
         * $auth = new Rackspace_Authentication("UserName","API_Key");
         * $auth->authenticate();
         * $array = $auth->export_credentials();
         * </code>
         * 
	 * @return array of url's and an auth token.
         */
    function export_credentials()
    {
        $arr = array();
        $arr['storage_url'] = $this->storage_url;
        $arr['cdnm_url']    = $this->cdnm_url;
        $arr['auth_token']  = $this->auth_token;

        return $arr;
    }


    /**
     * Make sure the Rackspace_Authentication instance has authenticated.
     *
     * Ensures that the instance variables necessary to communicate with
     * Cloud Files have been set from a previous authenticate() call.
     *
     * @return boolean <kbd>True</kbd> if successfully authenticated
     */
    function authenticated()
    {
        if (!($this->storage_url || $this->cdnm_url) || !$this->auth_token) {
            return False;
        }
        return True;
    }

    /**
     * Toggle debugging - set cURL verbose flag
     */
    function setDebug($bool)
    {
        $this->dbug = $bool;
        $this->cfs_http->setDebug($bool);
    }
}
