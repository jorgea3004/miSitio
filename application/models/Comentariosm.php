<?php
/**
* Modelo para administrar la tablas Galerias y Fotos
* owner = jorgea3004@gmail.com
*/
class Comentariosm extends CI_Model {

   public function __construct(){
      parent::__construct();
   }

	public function insertEntry($datos){
		$this->db->insert("comments",$datos);
	}
	public function getAllById(){
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("comments");  
		return $rquery;
	}
   	public function getAllByPage($ini,$lim){
		$rquery = $this->db->limit($lim,$ini);
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("comments");  
		return $rquery;
	}
   	public function getAllNew(){
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->where("status",0);
		$rquery = $this->db->get("comments");  
		return $rquery;
	}
	public function deleted($user){
		$this->db->where("id",$user);
		$this->db->delete("comments");  
	}
	public function update_entries(){
		$insert = array('status' => 1);
		$rquery = $this->db->where("status",0);
		$rquery = $this->db->update("comments",$insert);  
	}
   	public function getById($id){
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->where("id",$id);
		$rquery = $this->db->get("comments");  
		return $rquery;
	}
}
?>