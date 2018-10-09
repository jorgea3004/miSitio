<?php
class Usuariosm extends CI_Model {

   function __construct(){
      parent::__construct();
   }
	
	function todos(){
		$query = $this->db->get("usuarios");  
		return $query;
	}
	function todospagm($inicio,$limit){
		$rquery = $this->db->limit($limit,$inicio);
		$rquery = $this->db->order_by("idusuarios","DESC");
		$rquery = $this->db->get("usuarios");  
		return $rquery;
	}
	function nuevo($insert){
		$this->db->insert("usuarios",$insert);
	}
	function lastInserted(){
		$query = $this->db->limit(1);
		$query = $this->db->order_by("idusuarios","DESC");
		$query = $this->db->get("usuarios");  
		foreach($query->result() as $row):
			$last = $row->idusuarios;
		endforeach;
		return $last;
	}
	
	function actualiza($iduser,$insert){
		$query = $this->db->where("idusuarios",$iduser);
		$query = $this->db->update("usuarios",$insert);  
	}
	function borra($id){
		$this->db->where("idusuarios",$id);
		$this->db->delete("usuarios");
	}
	function validuser($user,$pass){
		$dquery = $this->db->where("username",$user);
		$dquery = $this->db->where("passwor",$pass);
		$dquery = $this->db->get("usuarios");
		return $dquery;
	}
}
?>