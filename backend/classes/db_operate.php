<?php
class Operation{
	
	public function __construct(){
		include 'db_config.php';
		include 'db_function.php';
		
		$this->db = new Database;
	}
	
	public function record_select($in_event){

		$this->db->query('SELECT event_id FROM event WHERE event_key = :eKey');
		$this->db->bind(':eKey', $in_event);

	return $this->db->single();	
	}	
	
	public function record_insert_email($in_event,$in_email){
		
		$this->db->query('INSERT INTO record (event_id, email) VALUES (:eid, :email)');
		$this->db->bind(':eid', $in_event);
		$this->db->bind(':email', $in_email);

		$this->db->execute();
	}	

	public function record_insert_tel($in_event,$in_tel){
		
		$this->db->query('INSERT INTO record (event_id, tel) VALUES (:eid, :tel)');
		$this->db->bind(':eid', $in_event);
		$this->db->bind(':tel', $in_tel);

		$this->db->execute();
	}		
}
?>