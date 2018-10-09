<?php
/**
* Modelo para administrar la tabla cat_secciones
* owner = jorgea3004@gmail.com
*/
class Categoriasm extends CI_Model {

   function __construct(){
        parent::__construct();
   }

   /**
	* function listadoById.
	* Obtiene el(los) registro(s) ordenados por ID. 
	* @user = el id del registro en la tabla amigos.
	* return = registro coincidente.
	*/
   	function listadoById(){
		$rquery = $this->db->order_by("id","ASC");
		$rquery = $this->db->get("cat_secciones");  
		return $rquery;
	}

   /**
	* function listadoByDesc.
	* Obtiene el(los) registro(s) ordenados por descripcion. 
	* return = registro coincidente.
	*/
   	function listadoByDesc(){
		$rquery = $this->db->order_by("descripcion","ASC");
		$rquery = $this->db->get("cat_secciones");  
		return $rquery;
	}

	/**
	* function borrar.
	* Borra el(los) registro(s) que coinciden con el id.
	*/
	function borrar($id){
		$this->db->where("id",$id);
		$this->db->delete("cat_secciones");  
	}

	/**
	* function nuevoRed.
	* Inserta nuevo registro.
	* @insert = Los valores a insertar en el registro.
	*/
	function nuevo($insert){
		$this->db->insert("cat_secciones",$insert);
	}

	/**
	* function actualiza.
	* Actualiza el registro.
	* @id = id de la tabla.
	* @insert = Los valores a actualizar en el registro.
	*/
	function actualiza($id,$insert){
		$query = $this->db->where("id",$id);
		$query = $this->db->update("cat_secciones",$insert); 
	}
	
	/**
	* function getElemById.
	* Busca un registro.
	* @id = id de la tabla.
	*/
	function getElemById($id){
		$rquery = $this->db->where("id",$id);
		$rquery = $this->db->get("cat_secciones");  
		return $rquery;
	}
}
?>