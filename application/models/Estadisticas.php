<?php
/**
* Modelo para registrar logs de visita de Galerias y Fotos
* owner = jorgea3004@gmail.com
*/
class Estadisticas extends CI_Model {

   public function __construct(){
      parent::__construct();
   }

	public function getTopByGaleria($limit){
		$rquery = $this->db->query("select l.id_galeria, g.description, count(*) as cuenta from log_fotos as l inner join galerias g on l.id_galeria=g.id where id_foto=0 group by id_galeria order by cuenta desc limit 10;");
		return $rquery;
	}
	public function getTopByFotos($limit){
		$rquery = $this->db->query("select l.id_galeria, l.id_foto, f.description, count(*) as cuenta from log_fotos as l inner join fotos f on l.id_foto=f.id where l.id_foto!=0 group by l.id_foto order by cuenta desc limit 10;");
		return $rquery;
	}
}
?>