<?php

class Sms extends Controller {

	function Sms() {
		parent::Controller();
		
		$this->load->helper('url');
		
		//Load data model
		$this->load->model('vignettesmodel');
	}

	function index() {
		// If user inputs LAST, return the last published vignette
		if ($this->input->post('Body') == "LAST") {
			// Get vignette
			$query = $this->vignettesmodel->getVignettes(1);
			
			foreach ($query->result() as $item) {
				if ($item->sex == 0) {
					$preamble = "How I knew she was the one: ";
				} else {
					$preamble = "How I knew he was the one: ";
				}
				$body = $item->tweet;
				if ($item->geolocation) {
					$geolocation = "- from $item->geolocation.";
				} else {
					$geolocation = "";
				}
			}
			
			$message['message'] = $preamble.$body.$geolocation;
			$this->load->view('sms', $message);
		// If user inputs RANDOM, return the last published vignette
		} elseif ($this->input->post('Body') == "RANDOM") {
            // Get vignette
            $query = $this->vignettesmodel->getRandomVignette();

            foreach ($query->result() as $item) {
                if ($item->sex == 0) {
                        $preamble = "How I knew she was the one: ";
                } else {
                        $preamble = "How I knew he was the one: ";
                }
                $body = $item->tweet;
                if ($item->geolocation) {
                        $geolocation = "- from $item->geolocation.";
                } else {
                        $geolocation = "";
                }
            }
            
            $message['message'] = $preamble.$body.$geolocation;
			$this->load->view('sms', $message);
		// If string is unrecognized, treat as a submission.
		} else {
	        //Clean input and map
	        $data['body'] = $this->input->post('Body');
	        $city = $this->input->post('FromCity');
	        $state = $this->input->post('FromState');
	        $data['geolocation'] = ucwords(strtolower($city)).", ".$state;
	        $data['ip'] = $this->input->post('From');
	        $data['sex'] = $this->uri->segment(2);
	
	        //Add vignette
	        $this->vignettesmodel->addVignette($data);
	
	        //Load view
			$message['message'] = "Thank you for sharing your moment.  It will be reviewed and published soon.";
	        $this->load->view('sms', $message);
		}
	}
}
