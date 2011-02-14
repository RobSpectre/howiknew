<?php 

class Heart extends Controller {
	
	function Heart() {
		parent::Controller();
		
		$this->load->helper('url');
		$this->load->library('form_validation');
	}
	
	function index() {
		// Load data model
		$this->load->model('heartsmodel');
		
		if ( $_POST && $_POST['id'] != NULL) {
			$data['vid'] = $this->input->xss_clean($_POST['id']);
			$data['ip'] = $this->input->ip_address();
			$this->heartsmodel->addHeart($data);
		} else {
			redirect('');
		}
		
	}
}	
?>