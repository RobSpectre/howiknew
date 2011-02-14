<?php 

class TagsModel extends Model {
	
	function TagsModel() {
		parent::Model();
		
		// Define tag index values
		$this->tagIndex = array("sweet", "funny", "lovely", "tearjerking", "epic", "singular", "touching", "heartbreaking");
	}

	function addTag($data) {	
		return $this->db->insert('tags', $data);
	}
	
	function countTags($id, $tag = NULL) {
		$this->db->where('vid', $id);
		$this->db->from('tags');
		return $this->db->count_all_results();
	}
	
	function getTags($id, $tag = NULL) {
		$this->db->select('id, timestamp, vid, tag');
		$this->db->where('vid', $id);
		
		return $this->db->get('tags');
	}
	
	function getTagsWithCount($id, $num = NULL) {
		$this->db->select('tag, count(*) as count');
		$this->db->group_by('tag');
		$this->db->where('vid', $id);
		$this->db->limit($num);
		$this->db->orderby('count', "desc");
		
		return $this->db->get('tags');
	}
	
	function getTag($tag) {
		return $this->tagIndex[$tag];
	}
	
	function getVignettesWithTag($tag, $num = NULL) {
		$this->db->select('vid, count(*) as count');
		$this->db->group_by('tag');
		$this->db->where('tag', $tag);
		$this->db->groupby('vid');
		$this->db->limit($num);
		$this->db->orderby('count', 'desc');
		
		return $this->db->get('tags');
	}
}