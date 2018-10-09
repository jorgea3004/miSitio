<?php
class Entrada extends CI_Model {

   function __construct(){
      parent::__construct();
   }

	function nuevo($datos){
		$ci =& get_instance();
		$ci->db->insert("entradas",$datos);
	}
   	function todos(){
		$ci =& get_instance();
		$rquery = $ci->db->order_by("id","DESC");
		$rquery = $ci->db->group_by("hua");
		$rquery = $ci->db->get("entradas");  
		return $rquery;
	}
   	function todosxdate($dateini,$datefin){
		$ci =& get_instance();
		$tquery = $ci->db->where("fecha <=",$datefin);
		$tquery = $ci->db->where("fecha >=",$dateini);
		$rquery = $ci->db->count_all_results("entradas");  
		return $rquery;
	}

}
?>