<?php
require_once(APPPATH . 'libraries/twitter/OAuth.php');
class Twitter_oauth {
	var $consumer;
	var $token;
	var $method;
	var $http_status;
	var $last_api_call;
  
	function Twitter_oauth($data) {
		$this->method = new OAuthSignatureMethod_HMAC_SHA1();
		$this->consumer = new OAuthConsumer($data['consumer_key'], $data['consumer_secret']);
		if (!empty($data['oauth_token']) && !empty($data['oauth_token_secret'])) {
			$this->token = new OAuthConsumer($data['oauth_token'], $data['oauth_token_secret']);
		} else {
			$this->token = NULL;
		}
	}

	function get_request_token() {
		$args = array();
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, 'GET', "https://api.twitter.com/oauth/request_token", $args);
		$request->sign_request($this->method, $this->consumer, $this->token);
		$request = $this->http($request->to_url());
		
		$token = $this->parse_request($request);
 
		$this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
 
		return $token;	
	}

	function http($url, $post_data = null) {
		$ch = curl_init();

		if ( defined("CURL_CA_BUNDLE_PATH") ) {
			curl_setopt($ch, CURLOPT_CAINFO, CURL_CA_BUNDLE_PATH);
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 
		if ( isset($post_data) ) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}
 
		$response = curl_exec($ch);
		$this->http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$this->last_api_call = $url;
		curl_close($ch);
 
		return $response;
	}
	
	function parse_request($string) {
		$args = explode("&", $string);
		$args[] = explode("=", $args['0']);
		$args[] = explode("=", $args['1']);
		
		$token[$args['3']['0']] = $args['3']['1'];
		$token[$args['4']['0']] = $args['4']['1'];

		return $token;
	}
	
	function get_access_token() {
		$args = array();

		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, 'GET', "https://api.twitter.com/oauth/access_token", $args);
		$request->sign_request($this->method, $this->consumer, $this->token);
		$request = $this->http($request->to_url());
 
		$token = $this->parse_access($request);
 
		$this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
 
		return $token;
	}
	
	function parse_access($string) {
		$r = array();

		foreach(explode('&', $string) as $param) {
			$pair = explode('=', $param, 2);
			if(count($pair) != 2) continue;
			$r[urldecode($pair[0])] = urldecode($pair[1]);
		}
		return $r;
	}
	
	function debug_info() {
		echo("Last API Call: ".$this->last_api_call."<br />\n");
		echo("Response Code: ".$this->http_status."<br />\n");
	}

 	function get_authorize_URL($token) {
 		if(is_array($token)) $token = $token['oauth_token'];
		return "https://api.twitter.com/oauth/authorize?oauth_token=" .
		$token;
	}
}
?>