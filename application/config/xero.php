<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Configuration options for Xero private application
 */

$config = array(
	'consumer'	=> array(
    	'key'		=> 'WXZ0EO7BQTXNLD3RPZNSYPG30JDJBH',
    	'secret'	=> 'GOLPC7KTRXINB9VJKI88BIMXE2ECOB'
    ),
    'certs'		=> array(
    	'private'  	=> APPPATH.'certs/privatekey.pem',
    	'public'  	=> APPPATH.'certs/publickey.cer'
    ),
    'format'    => 'xml'
);