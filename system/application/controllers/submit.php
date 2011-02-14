<?php 

class Submit extends Controller {
	
	function Submit() {
		parent::Controller();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('recaptcha');
		$this->lang->load('recaptcha');
		
		$this->form_validation->set_rules('body', 'Body', 'trim|required|min_length[5]|max_length[500]|xss_clean');
		$this->form_validation->set_rules('sex', 'Sex', 'trim|required|min_length[1]|max_length[3]|xss_clean');
		$this->form_validation->set_rules('geolocation', 'Location', 'trim|min_length[5]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('recaptcha_response_field', 'reCAPTCHA', 'required|callback_check_captcha');
	}
	
	function index() {
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "how i knew you were the one - submit";
			
			// Load views
			$this->load->view('header', $data);
			$this->load->view('navigation');
			$this->load->view('body_submitform', array('recaptcha'=>$this->recaptcha->get_html()));
			$this->load->view('footer');
		
		} else {
			// Load data model
			$this->load->model('vignettesmodel');
                        
			$data['body'] = $this->input->post('body');
			$data['geolocation'] = $this->input->post('geolocation');
			$data['ip'] = $this->input->ip_address();
			$data['sex'] = $this->input->post('sex');
			$this->vignettesmodel->addVignette($data);

			redirect('/submit/thankyou');
		}
	}

	function thankyou() {
		// Load views
		$data['title'] = "how i knew you were the one - thank you";
                        
		// Load views
		$this->load->view('header', $data);
		$this->load->view('navigation');
		$this->load->view('body_submitsuccess');
		$this->load->view('footer');
	}

	function sms() {
		//Load data model
		$this->load->model('vignettesmodel');
		
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
		$this->load->view('sms');
	}
	
	function check_captcha($val) {
	  if ($this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$val)) {
	    return TRUE;
	  } else {
	    $this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
	    return FALSE;
	  }
	}
}

?>	

