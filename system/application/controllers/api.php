<?php 

class Api extends Controller {
	
	function Api() {
		parent::Controller();
		
		// Load data model
		$this->load->model('vignettesmodel');
		$this->load->model('heartsmodel');
	}
	
	/*	Endpoints	*/
	
	function index() {		
		//Get results
		$id = $this->input->xss_clean($this->uri->segment(2));
		$data['query'] = $this->vignettesmodel->getVignettes();
		$data['items'] = $this->createItems($data['query']);
		
		$this->loadApiViews($data);
	}
	
	function id() {
		//Get results
		$id = $this->input->xss_clean($this->uri->segment(2));
		$data['query'] = $this->vignettesmodel->getVignette($id);
		$data['items'] = $this->createItems($data['query']);
		$data['items'] = $data['items'][$id];
		
		$this->loadApiViews($data);
	}
	
	/* Helper Functions	*/
	
	function getTags($id, $limit = NULL) {
		$this->load->model('tagsmodel');
		$tags = $this->tagsmodel->getTagsWithCount($id, $limit)->result();
		foreach ($tags as $tag) {
			if ( !isset($taglist) ) {
				$taglist = $this->tagsmodel->getTag($tag->tag)." (".$tag->count."), ";
			} else {
				$taglist .= $this->tagsmodel->getTag($tag->tag)." (".$tag->count."), ";
			}
		}
		if ( !isset($taglist) ) {
			return False;
		} else {
			$tags['taglist'] = substr($taglist,0,-2);
			return $tags;
		}
	}
	
	function createItems($query) {
		$items = array();
		
		foreach ($query->result_array() as $item) {
			$items[$item['id']] = $item;
			$items[$item['id']]['hearts'] = $this->heartsmodel->countHearts($item['id']);
			$items[$item['id']]['title'] = $item['tweet']." - #".$item['id'];
			$items[$item['id']]['tags'] = $this->getTags($item['id']);
		}
		
		return $items;
	}
	
	function loadApiViews($data) {
		if ($this->input->xss_clean($this->uri->segment(2)) == "xml" || $this->input->xss_clean($this->uri->segment(3)) == "xml") {
			$this->load->view('api/xml', $data);
		} else {
			$this->load->view('api/json', $data);
		}
	}
}	
?>