<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galerias extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('galeriasm');
	}

	public function index($page='')
	{
		if(strlen($page)<=0) {$page=1;}
		$data['menu_active'] = 2;
		$data['page_title'] = ' | Galerias';
		$data['title_share'] = 'Galerias';
		$data['desc_share'] = 'Galerias';
		$data['urlshare'] = 'http://yorch3004.xyz/galerias';
		$elemxpage = 12;
		$int=0;
		$inicio = ($page*$elemxpage)-$elemxpage;
		if($inicio<0){$inicio=0;}
		$totpages=$this->funciones->getNumPages($this->galeriasm->galeriasTotal(),$elemxpage);
		$query = $this->galeriasm->galeriaslim($inicio,$elemxpage);
    	$valor= '';
        if($query->num_rows()>0): 
            foreach($query->result() as $row): 
				$valor .= '{'
					.'id: "'.$int.'",'
					.'foto: "'.$row->portada.'",'
					.'link: "'.$row->portada.'",'
					.'gal: "'.$row->id_galeria.'",'
					.'title: "'.$row->name_gal.'"'
					.'},';
					$int++;
            endforeach;
			$cta = strlen($valor)-1;
			$valor = substr($valor, 0,$cta);
			$valor.= '';
        endif;

		$dataIndex['jsonGaleria'] = $valor;
		$dataIndex['paginador'] = $this->funciones->getPaging(base_url().'galerias/index','', $totpages,3,$page,4);
		$data['urlsharefb'] = $this->funciones->codeStringToShare('http://yorch3004.xyz/galerias');

		$this->load->view('headers/header',$data);
		$this->load->view('galerias/index',$dataIndex);
		$this->load->view('headers/footer');
	}
	public function detalle($idgal='',$page=1){
		$this->load->model('loggalerias');
		if(strlen($page)<=0) {$page=1;}
		$last=$this->galeriasm->lastGal();
		if(strlen($idgal)<=0) {$idgal=$last;}
		if ($idgal<3 || $idgal>$last) {
			$idgal=$last;
		}
		$data['menu_active'] = 2;
		$detalle=$this->galeriasm->galeriabyid($idgal);
		$nombre = '';
        if($detalle->num_rows()>0): 
            foreach($detalle->result() as $row): 
                $nombre = $row->description;
            endforeach;
        endif;
		$data['page_title'] = ' | Galerias | ' . $nombre;
		$data['title_share'] = 'Galerias | '.$nombre;
		$data['desc_share'] = $nombre;
		$data['urlshare'] = 'http://yorch3004.xyz/galerias/detalle/'.$idgal.'/'.$page;
		$data['image_share'] = 'http://yorch3004.xyz/public/img/miappicon.jpg';
		$elemxpage = 12;
		$inicio = ($page*$elemxpage)-$elemxpage;
		if($inicio<0){$inicio=0;}
		$querydet=$this->galeriasm->genfotos($idgal);
		$lasInsTime = $this->loggalerias->getLastInsertedTime();
		$differencia = $this->funciones->restaFechas($lasInsTime,date('Y-m-d H:i:s'));
		if($differencia>10){
			$this->loggalerias->registerEntry($idgal,0);
		}

		$totpages=$this->funciones->getNumPages($querydet->num_rows(),$elemxpage);
		$query = $this->galeriasm->gfotos($idgal,$inicio,$elemxpage);
		$valor= '';
		if($query->num_rows()>0):
            foreach($query->result() as $row): 
				$valor .= '{'
					.'id: "'.$row->id.'",'
					.'foto: "'.$row->description.'",'
					.'link: "'.$row->description.'",'
					.'gal: "'.$row->id_galeria.'",'
					.'title: "'.$row->description.'"'
					.'},';
            endforeach;
			$cta = strlen($valor)-1;
			$valor = substr($valor, 0,$cta);
			$valor.= '';
        endif;
		$dataIndex['nombre'] = $nombre;
		$dataIndex['jsonGaleria'] = $valor;
		//$dataIndex['paginador'] = $this->funciones->paginador(base_url().'galerias/detalle/'.$idgal.'/',$page,$totpages);
		$dataIndex['paginador'] = $this->funciones->getPaging(base_url().'galerias/detalle/'.$idgal,'', $totpages,3,$page,4);
		$dataIndex['urlsharefb'] = $this->funciones->codeStringToShare('http://yorch3004.xyz/galerias/detalle/'.$idgal.'/'.$page);

		$this->load->view('headers/header',$data);
		$this->load->view('galerias/detalle',$dataIndex);
		$this->load->view('headers/footer');
	}
	
}
