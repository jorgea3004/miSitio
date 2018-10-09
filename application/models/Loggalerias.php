<?php
/**
* Modelo para registrar logs de visita de Galerias y Fotos
* owner = jorgea3004@gmail.com
*/
class Loggalerias extends CI_Model {

   public function __construct(){
      parent::__construct();
   }

	public function registerEntry($idGaleria,$idFoto){
		$data = array(
		        'id_galeria' => $idGaleria,
		        'id_foto' => $idFoto,
		        'fecha' => date('Y-m-d H:i:s')
		);
		$this->db->insert("log_fotos",$data);
	}
	public function getAllById(){
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("log_fotos");  
		return $rquery;
	}
	public function getAllByGaleria(){
		$rquery = $this->db->query("select id_galeria, count(*) as cuenta from log_fotos where id_foto=0 and id_galeria!=0 group by id_galeria order by id_galeria desc;");
		return $rquery;
	}
	public function getAllByFotos(){
		$rquery = $this->db->query("select id_galeria, id_foto, count(*) as cuenta from log_fotos where id_foto!=0 and id_galeria!=0 group by id_foto order by cuenta desc, id_galeria desc;");
		return $rquery;
	}
   	public function getAllByPage($ini,$lim){
		$rquery = $this->db->limit($lim,$ini);
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("log_fotos");  
		return $rquery;
	}
   	public function getLastInsertedTime(){
		$rquery = $this->db->limit(1,0);
		$rquery = $this->db->order_by("id","DESC");
		$rquery = $this->db->get("log_fotos");
		$fecha='2000-01-01 00:00:00';
        if($rquery->num_rows()>0): 
            foreach($rquery->result() as $res): 
                $fecha = $res->fecha;
            endforeach;
        endif;
		return $fecha;
	}
}
?>