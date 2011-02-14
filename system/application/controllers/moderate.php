<?php 

class Moderate extends Controller {
	
	function Moderate() {
		parent::Controller();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->library('session');
		
		//Turn off authentication
		if (base_url() == "http://localhost/") {
			$this->data['dev'] = True;
		} else {
			$this->data['dev'] = False;
		}
		
		// Twitter OAuth keys
		$this->data['consumer_key'] = "";
		$this->data['consumer_secret'] = "";
		$this->data['authorized_key'] = "";
	}
	
	
	/*	Main controls	*/
	
	function index() {	
		if ($this->session->userdata('oauth_token_secret') == $this->data['authorized_key'] || $this->data['dev']) {
			// Load data model
			$this->load->model('vignettesmodel');
			$this->load->model('tagsmodel');
				
			// Configure pagination
			$config = $this->configurePagination(0);
			
			// Get results
			if ( $this->uri->segment($config['uri_segment']) ) {
				$data['query'] = $this->vignettesmodel->getVignetteQueue($config['per_page'], $this->uri->segment($config['uri_segment']));	
			} else {
				$data['query'] = $this->vignettesmodel->getVignetteQueue($config['per_page']);
			}
			
			// Collect additional data
			$data['title'] = "Moderate - how i knew you were the one";
			$data['paginationlinks'] = $config['links'];
			$data['tagindex'] = $this->tagsmodel->tagIndex;
			
			// Load view		
			$this->loadModerationViews($data);
		} else {
			redirect('mod/login');
		}
	}
	
	function edit() {	
		if ($this->session->userdata('oauth_token_secret') == "qdzTPLrevubjIsYPSGwcFk6lB6d281PjjAW1NKVCVH4" || $this->data['dev']) {
			// Load data model
			$this->load->model('vignettesmodel');
			$this->load->model('tagsmodel');
			
			// Configure pagination
			$config = $this->configurePagination(1, "mod/edit");
			
			// Get results
			if ( $this->uri->segment($config['uri_segment']) ) {
				$data['query'] = $this->vignettesmodel->getVignetteQueue($config['per_page'], $this->uri->segment($config['uri_segment']), 1);	
			} else {
				$data['query'] = $this->vignettesmodel->getVignetteQueue($config['per_page'], 0, 1);
			}
			
			// Collect additional data
			$data['title'] = "Edit - how i knew you were the one";
			$data['paginationlinks'] = $config['links'];
			$data['tagindex'] = $this->tagsmodel->tagIndex;
			
			// Load view		
			$this->loadModerationViews($data);	
		} else {
			redirect('mod/login');
		}
	}
	
	function rejects() {	
		if ($this->session->userdata('oauth_token_secret') == "qdzTPLrevubjIsYPSGwcFk6lB6d281PjjAW1NKVCVH4" || $this->data['dev']) {
			// Load data model
			$this->load->model('vignettesmodel');
			$this->load->model('tagsmodel');
			
			// Configure pagination	
			$config = $this->configurePagination(2, "mod/rejects");
			
			// Get results
			if ( $this->uri->segment($config['uri_segment']) ) {
				$data['query'] = $this->vignettesmodel->getVignetteQueue($config['per_page'], $this->uri->segment($config['uri_segment']), 2);	
			} else {
				$data['query'] = $this->vignettesmodel->getVignetteQueue($config['per_page'], 0, 2);
			}
			
			// Collect additional data
			$data['title'] = "Rejects - how i knew you were the one";
			$data['paginationlinks'] = $config['links'];
			$data['tagindex'] = $this->tagsmodel->tagIndex;
			
			// Load view		
			$this->loadModerationViews($data);	
		} else {
			redirect('mod/login');
		}
	}
	
	
	/*	Helper Functions	*/
	
	function configurePagination($status = NULL, $baseurl = "mod", $perpage = 5, $urisegment = 3) {
		// Load data models
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
		
		$config['base_url'] = site_url($baseurl);
		$config['total_rows'] = $this->vignettesmodel->countVignettes($status);
		$config['per_page'] = $perpage;
		$config['uri_segment'] = $urisegment; 
		
		$this->pagination->initialize($config);
		$config['links'] = $this->pagination->create_links();

		return $config;
	}
	
	function loadModerationViews($data) {
		$this->load->view('header', $data);
		$this->load->view('mod/navigation');
		$this->load->view('mod/body_moderate', $data);
		$this->load->view('footer');
	}
	
	
	/*	Authentication 	*/
	
	function login() {		
		$this->load->library('twitter_oauth', $this->data);
 		$token = $this->twitter_oauth->get_request_token();
	
 		$this->session->set_userdata('oauth_request_token', $token['oauth_token']);
		$this->session->set_userdata('oauth_request_token_secret', $token['oauth_token_secret']);
 
		$request_link = $this->twitter_oauth->get_authorize_URL($token);
 
		$data['link'] = $request_link;
		$data['title'] = "Login - how i knew you were the one.";

		$this->load->view('header', $data);
		$this->load->view('mod/body_login', $data);
		$this->load->view('footer');
	}
	
	function access() {
		$this->data['oauth_token'] = $this->session->userdata('oauth_request_token');
		$this->data['oauth_token_secret'] = $this->session->userdata('oauth_request_token_secret');

		$this->load->library('twitter_oauth', $this->data);

		$tokens = $this->twitter_oauth->get_access_token();

		$this->session->set_userdata('oauth_token', $tokens['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $tokens['oauth_token_secret']);	
		redirect('mod');
	}
	
 	function logout() {
		$this->session->sess_destroy();
		redirect('mod');
	}
	
	
	/*	API 	*/
	function approveVignette() {
		if ($this->session->userdata('oauth_token_secret') == $this->data['authorized_key'] || $this->data['dev']) {
			// Load data model
			$this->load->model('vignettesmodel');
			
			if ( $_POST && $_POST['id'] != NULL) {
				$id = $this->input->xss_clean($_POST['id']);
				$body = $this->input->xss_clean($_POST['body']);
				$tweet = $this->input->xss_clean($_POST['tweet']);
				$this->vignettesmodel->approveVignette($id, $body, $tweet);
				// Pre-seed Facebook Share
				$facebookshare = file_get_contents("http://developers.facebook.com/tools/lint/?url=".$this->base_url()."/id/".$id);
			} else {
				redirect('mod');
			}
		} else {
			redirect('mod');
		}
	}
	
	function rejectVignette() {
		if ($this->session->userdata('oauth_token_secret') == $this->data['authorized_key'] || $this->data['dev']) {
			// Load data model
			$this->load->model('vignettesmodel');
			
			if ( $_POST && $_POST['id'] != NULL ) {
				$id = $this->input->xss_clean($_POST['id']);
				$body = $this->input->xss_clean($_POST['body']);
				$tweet = $this->input->xss_clean($_POST['tweet']);
				$this->vignettesmodel->rejectVignette($id, $body, $tweet);
			} else {
				redirect('mod');
			}
		} else {
			redirect('mod');
		}
	}
	
	function editVignette() {
		if ($this->session->userdata('oauth_token_secret') == $this->data['authorized_key'] || $this->data['dev'] == True) {
			// Load data model
			$this->load->model('vignettesmodel');
			
			if ( $_POST && $_POST['id'] != NULL ) {
				$id = $this->input->xss_clean($_POST['id']);
				$body = $this->input->xss_clean($_POST['body']);
				$tweet = $this->input->xss_clean($_POST['tweet']);
				$this->vignettesmodel->editVignette($id, $body, $tweet);
			} else {
				redirect('mod');
			}
		} else {
			redirect('mod');
		}
	}
}

?>
