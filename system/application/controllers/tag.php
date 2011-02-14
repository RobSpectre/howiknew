<?php 

class Tag extends Controller {
	
	function Tag() {
		parent::Controller();
		
		$this->load->helper('url');
		
		// Load data model
		$this->load->model('tagsmodel');
	}
	
	function index() {
		if ( isset($_POST['tag']) ) {
			$data['vid'] = $this->input->post('id');
			$data['ip'] = $this->input->ip_address();
			$data['tag'] = $this->input->post('tag');
			$this->tagsmodel->addTag($data);
		} else {
			redirect('');
		}
		
	}
}	
?>