<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$data['menu_active'] = 1;
		$data['page_title'] = '';
		if (!file_exists('public/json/carrusel.json')) {
			$this->generaJsonCarrusel();
		}
		if (!file_exists('public/json/galerias.json')) {
			$this->generaJsonGalerias();
		}
		$this->load->view('headers/header',$data);
		$this->load->view('home/index');
		$this->load->view('headers/footer');
	}

	public function generaJsonCarrusel(){
		$intsize = 2;
		$num = 10;
		$int = 1;
		$dir = "public/json/";
		if (file_exists($dir)){
		} else {
			mkdir($dir,0777,true);
		}
		$url = $dir . 'carrusel.json';
		if(!file_exists($url)){
			$this->load->model('galeriasm');
			$gals = $this->galeriasm->recentGals(4);
			if($gals->num_rows()>0): 
		    	$valores= array();
				foreach($gals->result() as $row): 
					$idgal = $row->id;
					$fots = $this->galeriasm->presentacionHome_size_num($idgal,1,$num);
					if($fots->num_rows()>0): 
						foreach($fots->result() as $rowf): 
							if (file_exists("public/uploads/galerias/" . $rowf->id_galeria."/hd_".$rowf->fdescription)) {
								$srcPhoto = "hd_".$rowf->fdescription;
							} else {
								$srcPhoto = "".$rowf->fdescription;
							}
							$valores[]= array(
								'id' => $int,
								'foto' => $srcPhoto,
								'link' => $srcPhoto,
								'gal' => $rowf->id_galeria,
								'title' => $rowf->name_galeria
								);
							$int++;
						endforeach;
					endif;
				endforeach;
			endif;
			$valor = array('items' => $valores);
			$fileHandle = @fopen($dir . 'carrusel.json', 'w'); 
			fwrite($fileHandle, json_encode($valor)); 
			fclose($fileHandle); 
		}
	}
	/*
	* Funcion para crear el xml de las galerias en el home
	*/
	public function generaJsonGalerias(){
		$int = 1;
		$dir = "public/json/";
		if (file_exists($dir)){
		} else {
			mkdir($dir,0777,true);
		}
		$url = $dir . 'galerias.json';
		if(!file_exists($url)){
			$this->load->model('galeriasm');
			$gals = $this->galeriasm->recentGals(4);
			if($gals->num_rows()>0): 
				$valores= array();
				foreach($gals->result() as $row): 
					$idgal = $row->id;
					$queryft = $this->galeriasm->gfotos($idgal,0,1);
					$foto='';
					foreach($queryft->result() as $rowf): 
						$foto = $rowf->description;
					endforeach;
					$valores[]= array(
						'id' => $int,
						'foto' => $foto,
						'link' => $foto,
						'gal' => $idgal,
						'title' => $row->description
						);
					$int++;
				endforeach;
			endif;
			$valor = array('items' => $valores);
			$fileHandle = @fopen($dir . 'galerias.json', 'w'); 
			fwrite($fileHandle, json_encode($valor)); 
			fclose($fileHandle); 
		}
	}
}
