<?php
/**
* Modelo para administrar la tablas Galerias y Fotos
* owner = jorgea3004@gmail.com
*/
class Galeriasm extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

   /**
	* function galerias.
	* Obtiene el(los) registro(s) de la tabla. 
	* return = registros.
	*/
   	function galerias(){
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("galerias");  
		return $rquery;
	}
   	function galeriasTotal(){
		return $this->db->count_all_results('galerias');
	}
   	function galeriaslim($inicio,$limite){
		$sql = "select f.id_galeria, f.description as portada, g.description as name_gal "
			 . "from fotos f "
			 . "inner join galerias g on f.id_galeria=g.id "
			 . "where f.alto_ancho = 1 "
			 . "group by g.id "
			 . "order by g.id DESC, f.description DESC "
			 . "LIMIT " . $inicio . "," . $limite . ";";
		$rquery = $this->db->query($sql);
		return $rquery;
	}
	
	function galeriabyid($gal){
		$rquery = $this->db->order_by("id","ASC");
		$rquery = $this->db->where("id",$gal);  
		$rquery = $this->db->get("galerias");  
		return $rquery;
	}
	function lastGal(){
		$rquery = $this->db->limit(1,0);
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("galerias");
		if($rquery->num_rows()>0): 
			foreach($rquery->result() as $row): 
				$id = $row->id;
			endforeach;
		endif;
		return $id;
	}

   /**
	* function fotos.
	* Obtiene el(los) registro(s) que coinciden con el id_amigo. 
	* @gal = el id del registro en la tabla galerias.
	* return = registro coincidente.
	*/
   	function gfotos($gal,$ini,$lim){
		$rquery = $this->db->limit($lim,$ini);
		$rquery = $this->db->order_by("id","ASC");
		$rquery = $this->db->where("alto_ancho !=",2);
		$rquery = $this->db->where("id_galeria",$gal);  
		$rquery = $this->db->get("fotos");  
		return $rquery;
	}
   	function genfotos($gal){
		$rquery = $this->db->where("alto_ancho !=",2);
		$rquery = $this->db->where("id_galeria",$gal);
		$rquery = $this->db->get("fotos");  
		return $rquery;
	}

   	function gfotouni($id){
		$rquery = $this->db->order_by("id","ASC");
		$rquery = $this->db->where("id",$id);  
		$rquery = $this->db->get("fotos");  
		return $rquery;
	}
	
	function lastIdByGal($idgal){
		$rquery = $this->db->limit(1,0);
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->where("alto_ancho !=",2);
		$rquery = $this->db->where("id_galeria",$idgal);  
		$rquery = $this->db->get("fotos");  
		if($rquery->num_rows()>0): 
			foreach($rquery->result() as $row): 
				$id = $row->id;
			endforeach;
		endif;
		return $id;
	}
   	function galSqlPqd($sql){
   		if(isset($sql)){
			$rquery = $this->db->query($sql);
		} else { $rquery= false; }
		return $rquery;
	}
	function presentacionHomeSection($inicio,$limite){
		$sql = "SELECT distinct(f.id_galeria) as idGalFoto, f.id as idFoto, f.description as descripFoto, f.alto_ancho as altoaAnchoFoto, "
			 . "g.id as idGal, g.description as galeria, g.fotos as total "
			 . "FROM fotos f "
			 . "inner join galerias as g on g.id=f.id_galeria "
			 . "where f.alto_ancho = 1 "
			 . "group by f.id_galeria "
			 . "order by f.id_galeria desc, f.id desc "
			 . "limit " . $inicio .",". $limite . ";";
		$rquery = $this->db->query($sql);
		return $rquery;
	}
   	function recentGals($cantidad){
		$rquery = $this->db->limit($cantidad,0);
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("galerias");
		return $rquery;
	}
	function presentacionHome_size_num($idgal,$intsize,$num){
		$sql = "SELECT f.id as id, f.id_galeria as id_galeria, f.description as fdescription, g.description as name_galeria "
			 . "FROM fotos f "
			 . "LEFT JOIN galerias g ON g.id=f.id_galeria "
			 . "WHERE f.id_galeria=".$idgal." AND f.alto_ancho=" .  $intsize . " "
			 . "ORDER BY id ASC LIMIT ".$num . ";";
		$rquery = $this->db->query($sql);
		return $rquery;
	}

	function deleteGgaleria($id){
		$this->db->where('id', $id);
		$this->db->delete('galerias');
	}
	function deleteandoFotos($idgaleria){
		$this->db->where('id_galeria', $idgaleria);
		$this->db->delete('fotos');
	}
}
?>