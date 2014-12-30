<?php


class EventDocker {

	const VERSION = "1.0";

	const URL = 'http://trk.maildocker.io/event';

	static private $useSSL = true;

	static private $appId = null;

	static private $user = array();

	static public function setAppID($appId){
		self::$appId = $appId;
	}

	static public function getAppID(){
		return self::$appId;
	}

	static public function setUser($email, $name = null){
		self::$user = array(
				'email' => $email,
				'name' => $name
			);
	}

	static public function getUser(){
		return self::$user;
	}


	static public function init($params = array()){

		
		if(is_null(self::$appId)){
			throw new \Exception('Parameter "app_id" not defined!');
		}

		$post = array();
		$post['app_id'] = self::$appId;
		$post['referer'] = 'application/php';
		$post['user_data'] = array(
			'email' => self::$user['email'],
			'name' => self::$user['name'],
			'language' => 'pt-BR'

		);

		if(count($params)>0){
			$post['user_data']['custom_attributes'] = $params;
		}

		$response = self::post($params);
		//print_r($response);
		return $response;


	}

	static private function post($data){

		$header = array();
		$header['X-MD-LIB'] = 'PHP';
		$header['X-MD-VERSION'] = self::URL;

		$response = \Unirest::post(self::URL, $header, json_encode($data));

    	return $response;
	}

	/*static public function track(){
		
	}*/


	static public function disableSSL(){
		self::$useSSL = false;
		\Unirest::verifyPeer(false);
	}

	static public function enableSSL(){
		self::$useSSL = true;
		\Unirest::verifyPeer(true);
	}

	static public function isSSL(){
		return self::$useSSL;
	}

	public static function register_autoloader() {
    	spl_autoload_register(array('EventDocker', 'autoloader'));
  	}

  	public static function autoloader($class) {
		// Check that the class starts with "EventDocker"
		if ($class == 'EventDocker' || stripos($class, 'EventDocker\\') === 0) {
	  		$file = str_replace('\\', '/', $class);

  			if (file_exists(dirname(__FILE__) . '/' . $file . '.php')) {
    			require_once(dirname(__FILE__) . '/' . $file . '.php');
  			}
		}
  	}
}