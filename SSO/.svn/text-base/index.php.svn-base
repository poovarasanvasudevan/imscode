<?php
// Version
define('VERSION', '1.5.6.4');

// Configuration
if (file_exists('config.php')) {
	require_once('config.php');
}  

// Install 
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// VirtualQMOD
require_once('./vqmod/vqmod.php');
VQMod::bootup();

// VQMODDED Startup
require_once(VQMod::modCheck(DIR_SYSTEM . 'startup.php'));

// Application Classes
require_once(VQMod::modCheck(DIR_SYSTEM . 'library/customer.php'));
require_once(VQMod::modCheck(DIR_SYSTEM . 'library/affiliate.php'));
require_once(VQMod::modCheck(DIR_SYSTEM . 'library/currency.php'));
require_once(VQMod::modCheck(DIR_SYSTEM . 'library/tax.php'));
require_once(VQMod::modCheck(DIR_SYSTEM . 'library/weight.php'));
require_once(VQMod::modCheck(DIR_SYSTEM . 'library/length.php'));
require_once(VQMod::modCheck(DIR_SYSTEM . 'library/cart.php'));

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Store
if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
	$store_query = $db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`ssl`, 'www.', '') = '" . $db->escape('https://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
} else {
	$store_query = $db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`url`, 'www.', '') = '" . $db->escape('http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
}

if ($store_query->num_rows) {
	$config->set('config_store_id', $store_query->row['store_id']);
} else {
	$config->set('config_store_id', 0);
}
		
// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0' OR store_id = '" . (int)$config->get('config_store_id') . "' ORDER BY store_id ASC");

foreach ($query->rows as $setting) {
	if (!$setting['serialized']) {
		$config->set($setting['key'], $setting['value']);
	} else {
		$config->set($setting['key'], unserialize($setting['value']));
	}
}

if (!$store_query->num_rows) {
	$config->set('config_url', HTTP_SERVER);
	$config->set('config_ssl', HTTPS_SERVER);	
}

// Url
$url = new Url($config->get('config_url'), $config->get('config_secure') ? $config->get('config_ssl') : $config->get('config_url'));	
$registry->set('url', $url);

// Log 
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}
		
	if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

// Error Handler
set_error_handler('error_handler');

// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression($config->get('config_compression'));
$registry->set('response', $response); 

// Cache
$cache = new Cache();
$registry->set('cache', $cache); 

// Session
$session = new Session();
$registry->set('session', $session);

// Language Detection
$languages = array();

$query = $db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE status = '1'"); 

foreach ($query->rows as $result) {
	$languages[$result['code']] = $result;
}

$detect = '';

if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && $request->server['HTTP_ACCEPT_LANGUAGE']) { 
	$browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']);
	
	foreach ($browser_languages as $browser_language) {
		foreach ($languages as $key => $value) {
			if ($value['status']) {
				$locale = explode(',', $value['locale']);

				if (in_array($browser_language, $locale)) {
					$detect = $key;
				}
			}
		}
	}
}

if (isset($session->data['language']) && array_key_exists($session->data['language'], $languages) && $languages[$session->data['language']]['status']) {
	$code = $session->data['language'];
} elseif (isset($request->cookie['language']) && array_key_exists($request->cookie['language'], $languages) && $languages[$request->cookie['language']]['status']) {
	$code = $request->cookie['language'];
} elseif ($detect) {
	$code = $detect;
} else {
	$code = $config->get('config_language');
}

if (!isset($session->data['language']) || $session->data['language'] != $code) {
	$session->data['language'] = $code;
}

if (!isset($request->cookie['language']) || $request->cookie['language'] != $code) {	  
	setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
}			

$config->set('config_language_id', $languages[$code]['language_id']);
$config->set('config_language', $languages[$code]['code']);

// Language	
$language = new Language($languages[$code]['directory']);
$language->load($languages[$code]['filename']);	
$registry->set('language', $language); 

// Document
$registry->set('document', new Document()); 		

// Customer
$registry->set('customer', new Customer($registry));

// Affiliate
$registry->set('affiliate', new Affiliate($registry));

if (isset($request->get['tracking'])) {
	setcookie('tracking', $request->get['tracking'], time() + 3600 * 24 * 1000, '/');
}
		
// Currency
$registry->set('currency', new Currency($registry));

// Tax
$registry->set('tax', new Tax($registry));

// Weight
$registry->set('weight', new Weight($registry));

// Length
$registry->set('length', new Length($registry));

// Cart
$registry->set('cart', new Cart($registry));

//OpenBay Pro
$registry->set('openbay', new Openbay($registry));

// Encryption
$registry->set('encryption', new Encryption($config->get('config_encryption')));
		
// Front Controller 
$controller = new Front($registry);

// Maintenance Mode
$controller->addPreAction(new Action('common/maintenance'));

// SEO URL's
$controller->addPreAction(new Action('common/seo_url'));	
	
// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('common/home');
}

// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();


if(!empty($_GET['code'])) {
	$code = $_GET['code'];
	$state = $_GET['state'];

	$json['access_token']="";
		$dvreq = curl_init() or die(curl_error()); 
		curl_setopt($dvreq, CURLOPT_POST,1);
		curl_setopt($dvreq, CURLOPT_POSTFIELDS,"code=".$code."&grant_type=authorization_code&redirect_uri=".HTTP_SERVER.'index.php');
		curl_setopt($dvreq, CURLOPT_URL,MYSRCM_AUTH_SERVER."o/token/");
		curl_setopt($dvreq, CURLOPT_USERPWD, MYSRCM_CLIENT_ID . ":" . MYSRCM_CLIENT_SECRET);
		curl_setopt($dvreq, CURLOPT_RETURNTRANSFER, 1);
		$dataret=curl_exec($dvreq) or die(curl_error($dvreq));

		$json = json_decode($dataret,true);

		$info = curl_getinfo($dvreq);

		//curl_exec($dvreq);
		curl_close($dvreq);
                
		$dvreq = curl_init() or die(curl_error());
		curl_setopt($dvreq, CURLOPT_HTTPHEADER,array("Authorization: Bearer ".$json['access_token']));
		//curl_setopt($dvreq, CURLOPT_HTTPAUTH,"Bearer ".$json['access_token']);
		curl_setopt($dvreq, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($dvreq, CURLOPT_URL,MYSRCM_AUTH_SERVER."api/me/");
		$dataret=curl_exec($dvreq) or die(curl_error($dvreq));
		curl_close($dvreq);

		$json = json_decode($dataret,true);
		
		$user_email=$json["results"][0]['user_email'];
		$user_id=$json["results"][0]['user_id'];

		
		$loader->model('account/customer');
		$customer_info = $loader->model_account_customer->getCustomerByMysrcmId($user_id,$user_email);
		//print_r($customer_info);
	
		if($customer_info==null){
			if(empty($user_email)){
				$this->redirect(MYSRCM_AUTH_SERVER."o/authorize?state=abc&response_type=code&client_id=".
					MYSRCM_CLIENT_ID."&redirect_uri=".HTTP_SERVER.'index.php');
			}

			$data['store']=0;
			$data['firstname']=$json["results"][0]["first_name"];
			$data['lastname']=$json["results"][0]["last_name"];
			$data['telephone']=$json["results"][0]["mobile"];
			$data['email']=$json["results"][0]["user_email"];
                        $data['email']=$json["results"][0]["fax"];
			$data['customer_group_id']=1;
			$data['status']=1;
			$data['approved']=1;
			$loader->model_account_customer->addCustomer($data);
			$customer_info = $loader->model_account_customer->getCustomerByMysrcmId($user_id,$user_email);
			
			$loader->customer->login($customer_info['email'], '', true);
		}else{
			$loader->customer->login($customer_info['email'], '', true);
			$data['firstname']=$json["results"][0]["first_name"];
			$data['lastname']=$json["results"][0]["last_name"];
			$data['telephone']=empty($json["results"][0]["mobile"])?$customer_info['telephone']:$json["results"][0]["mobile"];
			$data['email']=$json["results"][0]["user_email"];
			$loader->model_account_customer->editCustomer($data);
  
		}
	
}
?>