<?php 
require_once(APPPATH . 'libraries/twilio/twilio.php');

class Twilio_sms {
	function __construct() {
		/* Twilio REST API version */
		$this->ApiVersion = "2010-04-01";

		/* Set our AccountSid and AuthToken */
		$this->AccountSid = "";
		$this->AuthToken = "";
		$this->Number = "";
	}
	
	function send($phonenumber, $message) {
		$response = $client->request("/$this->ApiVersion/Accounts/$this->AccountSid/SMS/Messages",
            "POST", array(
            "To" => $phonenumber,
            "From" => $this->Number,
            "Body" => "$message"
        ));
        if($response->IsError)
            echo "Error: {$response->ErrorMessage}";
        else
            echo "Sent message to $phonenumber";
	}
}

?>
