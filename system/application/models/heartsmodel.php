<?php 

class HeartsModel extends Model {
	
	function HeartsModel() {
		parent::Model();
	}
	
	function addHeart($data) {	
		return $this->db->insert('hearts', $data);
	}
	
	function countHearts($id) {
		$this->db->where('vid', $id);
		$this->db->from('hearts');
		return $this->db->count_all_results();
	}
	
	function getMostLovedIds($num = 6) {
		$this->db->select('vid, count(*) as count');
		$this->db->group_by('vid');
		$this->db->orderby('count', "desc");
		$this->db->limit($num);
		
		return $this->db->get('hearts');
	}
}

?>