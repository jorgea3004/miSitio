<?php
/**
* Modelo para administrar la tablas Desktop y cat_desktop
* owner = jorgea3004@gmail.com
*/
class Desktopm extends CI_Model {

   function __construct(){
      parent::__construct();
   }

	function nuevo($datos){
		return $this->db->insert("desktop",$datos);
	}
	function consultaxcat($cat){
		$rquery = $this->db->order_by("id_seccion","ASC");
		$rquery = $this->db->order_by("id","ASC");
		$rquery = $this->db->where("id_seccion",$cat);
		$rquery = $this->db->get("desktop");  
		return $rquery;
	}
   	function consultaxpag($ini,$lim){
		$rquery = $this->db->limit($lim,$ini);
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("desktop");  
		return $rquery;
	}
	function borra($id){
		$this->db->where("id",$id);
		return $this->db->delete("desktop");
	}
	function actualiza($id,$data){
		$query = $this->db->where("id",$id);
		return $this->db->update("desktop",$data);
	}
	function getElemById($id){
		$rquery = $this->db->where("id",$id);
		$rquery = $this->db->get("desktop");  
		return $rquery;
	}


	function consultacat(){
		$sql = 'SELECT c.id as idSeccion, c.descripcion as descrip FROM cat_secciones c where c.id>1 order by c.id desc';
		$rquery = $this->db->query($sql);  
		return $rquery;
	}
	function consultacattodesk(){
		$sql = 'SELECT c.id as idSeccion, c.descripcion as descrip FROM cat_secciones c order by c.id asc';
		$rquery = $this->db->query($sql);  
		return $rquery;
	}

	function listado(){
		$sql = 'SELECT d.id_seccion as categoria, c.descripcion, d.id, d.titulo, d.imagen, d.target, d.enlace '
			 . 'FROM desktop d '
			 . 'join cat_secciones c on c.id=d.id_seccion '
			 . 'order by d.id_seccion, d.id';
		$rquery = $this->db->query($sql);  
		return $rquery;
	}

	function listadoJson(){
		$sql = 'SELECT d.id_seccion as categoria, c.descripcion, d.id as ItemID, d.titulo as ItemDescription, '
			 . 'd.imagen as ItemImage, d.target as ItemTarget, d.enlace as ItemLink, d.clase as ItemClass '
			 . 'FROM desktop d '
			 . 'join cat_secciones c on c.id=d.id_seccion '
			 . 'order by d.id desc';
		$rquery = $this->db->query($sql);  
		return $rquery;
	}
	function listadoJsonByPage($inicio,$limite){
		$sql = 'SELECT d.id_seccion as categoria, c.descripcion, d.id as ItemID, d.titulo as ItemDescription, '
			 . 'd.imagen as ItemImage, d.target as ItemTarget, d.enlace as ItemLink, d.clase as ItemClass '
			 . 'FROM desktop d '
			 . 'join cat_secciones c on c.id=d.id_seccion '
			 . 'order by d.id desc limit ' . $inicio .','. $limite . ';';
		$rquery = $this->db->query($sql);  
		return $rquery;
	}
}
?>