<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desktopadm extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('Desktopm');
	}

	public function index()
	{
	}
	public function deleteElement($idm)
	{
		$json = array();
		$return = '';
		$status = 0;
		if(isset($idm) && strlen($idm)>0 ){
			$elems=$this->Desktopm->getElemById($idm);
			if ($elems->result()!=null && count($elems->result())>0) {
				$return = 'Elemento Encontrado';
				$status = 1;
				$imagen='';
				$elemd=$this->Desktopm->borra($idm);
				$elemf=$this->Desktopm->getElemById($idm);
				if ($elemf->result()!=null && count($elemf->result())>0) {
					$return = 'Elemento No borrado';
					$status = 0;
				} else {
					$destiny = './public/img/iconos_metro/';
					foreach ($elems->result() as $row)
					{
				        $imagen = $destiny.$row->imagen;
				        unlink($imagen);
				    }
					$return = 'Elemento borrado';
					$status = 1;
				}
			} else {
				$return = 'Elemento '.$idm.' NO Encontrado';
				$status = 0;
			}
		} else {
			$return = 'Elemento NO valido';
			$status = 0;
		}
		$json['estatus'] = json_encode($status);
		$json['msg'] = json_encode($return);
		echo json_encode($json);
		exit();
	}
	public function elementNew()
	{
		$json = array();
		$return = '';
		$status = 0;
		//$datos['imagen'] = $_POST['icono'];
		$idm = $_POST['idm'];
		$clase = $_POST['clase'];
		$enlace = $_POST['linku'];
		$titulo = $_POST['titulo'];
		$seccion=$_POST['seccion'];
		if ($_POST['open']==2) {
			$target = 2;
		} else {
			$target = 1;
		}
		if(!isset($idm) && strlen($idm)<=0 ){
			/* NUEVO ELEMENTO */
			if(isset($_POST) && count($_POST)>0){
				$this->load->model('Desktopm');
				$titulo_txt = str_replace(" ", "_", $titulo);
				$destiny = './public/img/iconos_metro/';
				$newfile = "" . $titulo_txt . ".jpg";
				$newfilet = "" . $titulo_txt . "_thumb.jpg";
				$uptodb=true;
				if(!file_exists($destiny)) {
					if(!mkdir($destiny,0777,true)) {
						$uptodb = false;
					}
				}

				$config['upload_path'] = $destiny;
				$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
				$config['file_name'] = $newfile;
				$config['overwrite'] = true;

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('icono'))
				{
					$error = array('error' => $this->upload->display_errors());
					$uptodb=false;
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$uptodb=true;
					if(file_exists($destiny . $newfile)){
						//$datos['enlace'] = $newfile;
						$size = GetImageSize($destiny . $newfile);
						$anchura=$size[0];
						$altura=$size[1];
						if($anchura==150 && $altura==150){} else {
							$config['image_library'] = 'gd2';
							$config['source_image'] = $destiny . $newfile;
							$config['create_thumb'] = TRUE;
							$config['maintain_ratio'] = TRUE;
							$config['width'] = 150;
							$config['height'] = 150;
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();
						}
					}
					if(file_exists($destiny.$newfilet)){
						if(unlink($destiny.$newfile)){
							rename($destiny.$newfilet, $destiny.$newfile);
						}else{
							$uptodb=false;
						}
					}else{
						//$uptodb=false;
					}
				}
				if($uptodb){
					$data = array("titulo" => $titulo,
								"id_seccion" => $seccion,
								"clase" => $clase,
								"imagen" => $newfile,
								"target" => $target,
								"enlace" => $enlace
								);
					$flag = $this->Desktopm->nuevo($data);
					if($flag===true){
						//$this->make_desktop_home();
						$status=1;
						$return = 'Datos guardados';
					} else {
						$return = $this->db->error();
						if(file_exists($destiny.$newfile)){
							unlink($destiny.$newfile);
						}
					}
				} else {
				}
			} else {
				$return = 'Datos NO valido';
				$status = 0;
			}
		} else {
			/* ACTUALIZACION DE ELEMENTO */
			$this->load->model('Desktopm');
			$elems=$this->Desktopm->getElemById($idm);
			$destiny = './public/img/iconos_metro/';
			if ($elems->result()!=null && count($elems->result())>0) {
				foreach ($elems->result() as $row)
				{
			        $imagen = $destiny.$row->imagen;
			        if(file_exists($imagen)) {
			        	$imagen_ren = $destiny."rm_".$row->imagen;
			        	rename($imagen,$imagen_ren);
			    	}
			    }

				$flag=true;
			}
			$numrandom = rand(0, 10);
			$titulo_txt = str_replace(" ", "_", $titulo);
			$newfile = "" . $titulo_txt . "_". $numrandom . ".jpg";
			$newfilet = "" . $titulo_txt . "_". $numrandom . "_thumb.jpg";
			$uptodb=true;
			if(!file_exists($destiny)) {
				if(!mkdir($destiny,0777,true)) {
					$uptodb = false;
				}
			}

			$config['upload_path'] = $destiny;
			$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
			$config['file_name'] = $newfile;
			$config['overwrite'] = true;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('icono')){
				/*$error = array('error' => $this->upload->display_errors());
				$uptodb=false;*/
			} else {
				$data = array('upload_data' => $this->upload->data());
				$uptodb=true;
				if(file_exists($destiny . $newfile)){
					//$datos['enlace'] = $newfile;
					$size = GetImageSize($destiny . $newfile);
					$anchura=$size[0];
					$altura=$size[1];
					if($anchura==150 && $altura==150){} else {
						$config['image_library'] = 'gd2';
						$config['source_image'] = $destiny . $newfile;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 150;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();
					}
				}
				if(file_exists($destiny.$newfilet)){
					if(unlink($destiny.$newfile)){
						rename($destiny.$newfilet, $destiny.$newfile);
					}else{
						$uptodb=false;
					}
				}else{
					//$uptodb=false;
				}
			}
			if($uptodb){
				$data = array("titulo" => $titulo,
							"id_seccion" => $seccion,
							"clase" => $clase,
							"imagen" => $newfile,
							"target" => $target,
							"enlace" => $enlace
							);
				$flag = $this->Desktopm->actualiza($idm,$data);
				if($flag==true){
					//$this->make_desktop_home();
					$status=1;
					$return = 'Datos guardados';
					if(file_exists($imagen_ren)){
						unlink($imagen_ren);
					}
				} else {
					$return = 'Datos NO guardados';
					$status = 0;
					$return = $this->db->error();
					if(file_exists($imagen_ren)){
						rename($imagen_ren,$imagen);
					}
				}
			} else {
				$return = 'Datos NO valido';
				$status = 0;
			}

		}

		$json['estatus'] = json_encode($status);
		$json['msg'] = json_encode($return);
		echo json_encode($json);
		exit();
	}
	public function elementEdit($idm)
	{
		$json = array();
		$return = '';
		$status = 0;
		//$datos['imagen'] = $_POST['icono'];
		$idm = $_POST['idm'];
		$clase = $_POST['clase'];
		$enlace = $_POST['linku'];
		$titulo = $_POST['titulo'];
		$seccion=$_POST['seccion'];
		if ($_POST['open']=='2') {
			$target = 2;
		} else {
			$target = 1;
		}
		$flag = false;
		//var_dump($_POST); exit();
		if(isset($_POST) && count($_POST)>0){
			if(isset($idm) && strlen($idm)>0 ){
				$this->load->model('Desktopm');
				$elems=$this->Desktopm->getElemById($idm);
				$destiny = './public/img/iconos_metro/';
				if ($elems->result()!=null && count($elems->result())>0) {
					foreach ($elems->result() as $row)
					{
				        $imagen = $destiny.$row->imagen;
				        $imagen_ren = $destiny."rm_".$row->imagen;
				        rename($imagen,$imagen_ren);
				    }

					$flag=true;
				}

				$titulo_txt = str_replace(" ", "_", $titulo);
				$newfile = "" . $titulo_txt . ".jpg";
				$newfilet = "" . $titulo_txt . "_thumb.jpg";
				$uptodb=true;
				if(!file_exists($destiny)) {
					if(!mkdir($destiny,0777,true)) {
						$uptodb = false;
					}
				}

				$config['upload_path'] = $destiny;
				$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
				$config['file_name'] = $newfile;
				$config['overwrite'] = true;

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('icono'))
				{
					/*$error = array('error' => $this->upload->display_errors());
					$uptodb=false;*/
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$uptodb=true;
					if(file_exists($destiny . $newfile)){
						//$datos['enlace'] = $newfile;
						$size = GetImageSize($destiny . $newfile);
						$anchura=$size[0];
						$altura=$size[1];
						if($anchura==150 && $altura==150){} else {
							$config['image_library'] = 'gd2';
							$config['source_image'] = $destiny . $newfile;
							$config['create_thumb'] = TRUE;
							$config['maintain_ratio'] = TRUE;
							$config['width'] = 150;
							$config['height'] = 150;
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();
						}
					}
					if(file_exists($destiny.$newfilet)){
						if(unlink($destiny.$newfile)){
							rename($destiny.$newfilet, $destiny.$newfile);
						}else{
							$uptodb=false;
						}
					}else{
						//$uptodb=false;
					}
				}
				if($uptodb){
					$data = array("titulo" => $titulo,
								"id_seccion" => $seccion,
								"clase" => $clase,
								"imagen" => $newfile,
								"target" => $target,
								"enlace" => $enlace
								);
					$flag = $this->Desktopm->actualiza($idm,$data);
					if($flag===true){
						//$this->make_desktop_home();
						$status=1;
						$return = 'Datos guardados';
						if(file_exists($imagen_ren)){
							unlink($imagen_ren);
						}
					} else {
						$return = $this->db->error();
						if(file_exists($imagen_ren)){
							rename($imagen_ren,$imagen);
						}
					}
				} else {
				$return = 'Datos NO valido';
				$status = 0;
				}
			} else {
				$return = 'Datos NO valido';
				$status = 0;
			}
		}

		$json['estatus'] = json_encode($status);
		$json['msg'] = json_encode($return);
		echo json_encode($json);
		exit();
	}
	public function secciones(){
		$json = array();
		$elems=$this->Desktopm->consultacat();
		if ($elems->result()!=null && count($elems->result())>0) {
			$json['post'] = $elems->result();
		} else {
			$json['post'] = '';
		}
		echo json_encode($json);
		exit();
	}
	/*
	* Funcion para crear xml del desktop
	*/
	public function json_desktop(){
		$dir = "public/json/";
		if (file_exists($dir)){
		} else {
			mkdir($dir,0777,true);
		}
		$url = $dir . 'idesktop.json';
		if(!file_exists($url)){
			$this->load->model('desktopm');
			$categ = $this->desktopm->consultacattodesk();
			if($categ->num_rows()>0){
				$i=0;
				$cfin = $categ->num_rows() -1;
				$valor = 'var desktopJson=[';
				foreach($categ->result() as $cat): 
					$valor .= '{'
							.'"id":"' . $cat->idSeccion . '",'
							.'"title": "' . stripslashes($cat->descrip) . '",'
							.'"content": [';
						$elems = $this->desktopm->consultaxcat($cat->idSeccion);
						if($elems->num_rows()>0){
							$j=0;
							$efin = $elems->num_rows()-1;
							foreach($elems->result() as $elem):
								$valor .= '{'
										.'"id":"' . $elem->id . '",'
										.'"ItemImage": "' . stripslashes($elem->imagen) . '",'
										.'"ItemClass": "' . stripslashes($elem->clase) . '",'
										.'"ItemTarget": "' . stripslashes($elem->target) . '",'
										.'"ItemLink": "' . stripslashes($elem->enlace) . '"'
										.'}';
								if ($j<$efin) {
									$valor .= ',';
								}
								$j++;
							endforeach;
						}
					$valor .= ']}';
					if ($i<$cfin) {
						$valor .= ',';
					}
					$i++;
				endforeach;
				$valor.= ']';
			}
			$fileHandle = @fopen($url, 'w'); 
			fwrite($fileHandle, $valor); 
			fclose($fileHandle); 
		}
	}
	/*
	* Funcion para re-generar los xml que se ocupan en el home del desktop
	*/
	public function make_desktop_home(){
		$dir = 'public/json/';
		$namefile = "idesktop";
		$url = $dir . $namefile. '.json';
		if(file_exists($url)){
			rename($url, $dir . 'r_'.$namefile.'.json');
		}

		$this->json_desktop();

		if(file_exists($url)){
			unlink($dir . 'r_'.$namefile.'.json');
		}else{
			rename($dir . 'r_'.$namefile.'.json',$url);
		}
		exit();
		redirect(base_url().'desktop', 'location', 301);
	}

}
