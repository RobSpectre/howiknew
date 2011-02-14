<?php 

class VignettesModel extends Model {
	
	function VignettesModel() {
		parent::Model();
	}
	
	function getVignettes($num = "10", $offset = NULL, $orderby = "publishtimestamp") {
		$this->db->select('id, publishtimestamp, body, geolocation, sex, tweet');
		$this->db->where('status', 1);
		$this->db->orderby($orderby, 'desc');
		$this->db->limit($num, $offset);
		
		return $this->db->get("vignettes");
	}
	
	function getVignette($id) {
		$this->db->select('id, publishtimestamp, body, geolocation, sex, tweet');
		$this->db->where('id', $id);
		$this->db->orderby('timestamp', 'desc');
		
		return $this->db->get("vignettes");
	}

	function getRandomVignette() {
		$this->db->select('id, publishtimestamp, body, geolocation, sex, tweet');
		$this->db->where('status', 1);
		$this->db->orderby('rand()');
		$this->db->limit(1);

		return $this->db->get("vignettes");
	}
	
	function countVignettes($status=1) {
		$this->db->where('status', $status); 
		$this->db->from('vignettes');
		return $this->db->count_all_results();
	}
	
	function getVignetteQueue($num = NULL, $offset = NULL, $status=0) {
		$this->db->select('id, timestamp, body, geolocation, ip, sex, publishtimestamp, tweet');
		$this->db->where('status', $status);
		$this->db->orderby('timestamp', 'desc');
		$this->db->limit($num, $offset);
		
		return $this->db->get("vignettes");
	}
	
	function getVignettesById($index) {
		$whereclause = "WHERE ";
		$orderbyclause = "ORDER BY FIELD(id, ";
		
		foreach ($index as $id) {
			$whereclause .= "id = ".$id." OR ";
			$orderbyclause .= $id.", ";
		}
		
		$whereclause = substr($whereclause,0,-3);
		$orderbyclause = substr($orderbyclause,0,-2);
		$orderbyclause .= ")";
		
		$query = "SELECT id, publishtimestamp, body, geolocation, sex, tweet FROM vignettes ".$whereclause." ".$orderbyclause;
		return $this->db->query($query);
	}
	
	function approveVignette($id, $body, $tweet) {
		$this->db->set('status', 1);
		$this->db->set('body', $body);
		$this->db->set('tweet', $tweet);
		$this->db->set('publishtimestamp', date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		return $this->db->update('vignettes');
	}
	
	function rejectVignette($id, $body, $tweet) {
		$this->db->set('status', 2);
		$this->db->set('body', $body);
		$this->db->set('tweet', $tweet);
		$this->db->set('publishtimestamp', date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		return $this->db->update('vignettes');
	}
	
	function editVignette($id, $body, $tweet) {
		$this->db->set('body', $body);
		$this->db->set('tweet', $tweet);
		$this->db->set('publishtimestamp', date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		return $this->db->update('vignettes');
	}
	
	function addVignette($data) {
		return $this->db->insert('vignettes', $data);
	}
}

?>
