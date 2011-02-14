<?php 

class Vignettes extends Controller {
	
	function Vignettes() {
		parent::Controller();
		
		$this->load->helper('url');
		$this->load->library('pagination');
	}
	
	
	/*	Dynamic content	*/
	
	function index() {			
		// Configure pagination
		$config = $this->configurePagination(1);
		
		// Get paged results
		$data = $this->getPagedVignettes($config);
		
		// Load view
		$this->loadVignettesViews($data);
	}
	
	function mostloved() {
		// Load data models
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
		
		// Get most loved vignettes.
		$ids = $this->heartsmodel->getMostLovedIds();
		$index = array();
		foreach ($ids->result() as $id) {
			$index[] = $id->vid;
		}
		
		// Retrieve vignettes.
		$data['query'] = $this->vignettesmodel->getVignettesById($index);
		foreach ($data['query']->result() as $item) {
			$data['hearts'][$item->id] = $this->heartsmodel->countHearts($item->id);
			$data['tags'][$item->id] = $this->getTags($item->id, 4);
			if ($data['hearts'][$item->id] >= 10) {
				$data['temp'][$item->id] = "hot";
			} else if ($data['hearts'][$item->id] >= 5) {
				$data['temp'][$item->id] = "warm";
			} else {
				$data['temp'][$item->id] = "cold";
			}
		}

		$data['tagindex'] = $this->tagsmodel->tagIndex;
		$data['title'] = "how i knew you were the one - most loved";
		
		// Load view
		$this->loadVignettesViews($data);
	}

	function rss() {
		// Load data models
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
		
		// Get results
		$data['query'] = $this->vignettesmodel->getVignettes(20);
		foreach ($data['query']->result() as $item) {
				$data['hearts'][$item->id] = $this->heartsmodel->countHearts($item->id);
			}
		$data['title'] = "how i knew you were the one - RSS";
		
		//Load view
		$this->load->view('rss', $data);
	}
	
	function id() {	
		// Load data models
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
		
		//Get results
		$id = $this->input->xss_clean($this->uri->segment(2));
		$data['query'] = $this->vignettesmodel->getVignette($id);
		foreach ($data['query']->result() as $item) {
				$data['hearts'][$item->id] = $this->heartsmodel->countHearts($item->id);
				$data['title'] = "$item->tweet - #$item->id";
				$data['tags'][$item->id] = $this->getTags($item->id);
				if ($data['hearts'][$item->id] >= 10) {
					$data['temp'][$item->id] = "hot";
				} else if ($data['hearts'][$item->id] >= 5) {
					$data['temp'][$item->id] = "warm";
				} else {
					$data['temp'][$item->id] = "cold";
				}
			}
		$data['tagindex'] = $this->tagsmodel->tagIndex;

		// Load view
		$this->loadVignettesViews($data);
	}
	
	function random() {
		// Load data models
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
		
		//Get results
		$data['query'] = $this->vignettesmodel->getRandomVignette();
		foreach ($data['query']->result() as $item) {
				$data['hearts'][$item->id] = $this->heartsmodel->countHearts($item->id);
				$data['title'] = "$item->tweet - #$item->id";
				$data['tags'][$item->id] = $this->getTags($item->id);
				if ($data['hearts'][$item->id] >= 10) {
					$data['temp'][$item->id] = "hot";
				} else if ($data['hearts'][$item->id] >= 5) {
					$data['temp'][$item->id] = "warm";
				} else {
					$data['temp'][$item->id] = "cold";
				}
			}
		$data['tagindex'] = $this->tagsmodel->tagIndex;

		// Load view
		$this->loadVignettesViews($data);
	}
	
	function tag() {
		// Load data models
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
		$this->load->model('tagsmodel');
		
		$tag = $this->input->xss_clean($this->uri->segment(2));		
		
		// Get most loved vignettes.
		$ids = $this->tagsmodel->getVignettesWithTag($tag);
		
		$index = array();
		foreach ($ids->result() as $id) {
			$index[] = $id->vid;
		}
		
		// Retrieve vignettes.
		$data['query'] = $this->vignettesmodel->getVignettesById($index);
		foreach ($data['query']->result() as $item) {
			$data['hearts'][$item->id] = $this->heartsmodel->countHearts($item->id);
			$data['tags'][$item->id] = $this->getTags($item->id, 4);
			if ($data['hearts'][$item->id] >= 10) {
				$data['temp'][$item->id] = "hot";
			} else if ($data['hearts'][$item->id] >= 5) {
				$data['temp'][$item->id] = "warm";
			} else {
				$data['temp'][$item->id] = "cold";
			}
		}

		$data['tagindex'] = $this->tagsmodel->tagIndex;
		$data['title'] = "how i knew you were the one - ".$this->tagsmodel->getTag($tag);
		
		//Load view
		$this->loadVignettesViews($data);
	}
	
	
	/*	Helper functions	*/
	
	function configurePagination($status = NULL, $baseurl = "page", $perpage = 6, $urisegment = 2) {
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
	
	function getPagedVignettes($config, $orderby = "publishtimestamp") {
		// Load data models
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
		
		// Return appropriate page
		if ( $this->uri->segment($config['uri_segment']) ) {
			// Get paged results
			$data['query'] = $this->vignettesmodel->getVignettes($config['per_page'], $this->uri->segment($config['uri_segment']), $orderby);
			foreach ($data['query']->result() as $item) {
				$data['hearts'][$item->id] = $this->heartsmodel->countHearts($item->id);
				$data['tags'][$item->id] = $this->getTags($item->id, 4);
				if ($data['hearts'][$item->id] >= 10) {
					$data['temp'][$item->id] = "hot";
				} else if ($data['hearts'][$item->id] >= 5) {
					$data['temp'][$item->id] = "warm";
				} else {
					$data['temp'][$item->id] = "cold";
				}
			}
			$data['title'] = "how i knew you were the one - Page ".$this->uri->segment($config['uri_segment']);
		} else {
			// Get first page
			$data['query'] = $this->vignettesmodel->getVignettes($config['per_page']);
			foreach ($data['query']->result() as $item) {
				$data['hearts'][$item->id] = $this->heartsmodel->countHearts($item->id);
				$data['tags'][$item->id] = $this->getTags($item->id, 4);
				if ($data['hearts'][$item->id] >= 10) {
					$data['temp'][$item->id] = "hot";
				} else if ($data['hearts'][$item->id] >= 5) {
					$data['temp'][$item->id] = "warm";
				} else {
					$data['temp'][$item->id] = "cold";
				}
			}
			$data['title'] = "how i knew you were the one";
		}
		
		$data['paginationlinks'] = $config['links'];
		$data['tagindex'] = $this->tagsmodel->tagIndex;
		
		return $data;
	}
	
	function getTags($id, $limit = NULL) {
		$this->load->model('tagsmodel');
		$tags = $this->tagsmodel->getTagsWithCount($id, $limit)->result();
		foreach ($tags as $tag) {
			if ( !isset($taglist) ) {
				$taglist = "<a href=\"http://howiknew.dreamnotoftoday.pvt/tag/".$tag->tag."\">".$this->tagsmodel->getTag($tag->tag)."</a>"." (".$tag->count."), ";
			} else {
				$taglist .= "<a href=\"http://howiknew.dreamnotoftoday.pvt/tag/".$tag->tag."\">".$this->tagsmodel->getTag($tag->tag)."</a>"." (".$tag->count."), ";
			}
		}
		if ( !isset($taglist) ) {
			return False;
		} else {
			$tags['taglist'] = substr($taglist,0,-2);
			return $tags;
		}
	}
	
	function loadVignettesViews($data) {	
		$this->load->view('header', $data);
		$this->load->view('navigation', $data);
		$this->load->view('body_vignettes', $data);
		$this->load->view('footer');
	}
	
	
	/*	Static content	*/
	
	function about() {
		$data['title'] = "how i knew you were the one - about";
		
		// Load view
		$this->load->view('header', $data);
		$this->load->view('navigation');
		$this->load->view('body_about');
		$this->load->view('footer');
	}
	
	function questions() {
		$data['title'] = "how i knew you were the one - questions";
		
		// Load view		
		$this->load->view('header', $data);
		$this->load->view('navigation');
		$this->load->view('body_questions');
		$this->load->view('footer');
	}
	
	function privacy() {
		$data['title'] = "how i knew you were the one - privacy";
		
		// Load view		
		$this->load->view('header', $data);
		$this->load->view('navigation');
		$this->load->view('body_privacy');
		$this->load->view('footer');
	}
	
	function contact() {
		$data['title'] = "how i knew you were the one - contact";
		
		// Load view		
		$this->load->view('header', $data);
		$this->load->view('navigation');
		$this->load->view('body_contact');
		$this->load->view('footer');
	}
}

?>
