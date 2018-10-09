<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desktop extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('comentariosm');
	}
	
	public function index()
	{
		$dir = 'public/json/idesktop.json';
		if (!file_exists($dir)){
			$this->load->library('../controllers/Desktopadm');
			$this->Desktopadm->json_desktop();
		}
		$query = $this->comentariosm->getAllNew();
		$datos['newcom'] = $query->num_rows();
		$datosHeader['extraHeaders'] = '<link rel="stylesheet" type="text/css" href="'.base_url().'public/css/metro.css" />';
		$this->load->view('headers/header_admin',$datosHeader);
		$this->load->view('desktop/index',$datos);
		$this->load->view('headers/footer_admin');
	}
	public function comments()
	{
		$query = $this->comentariosm->getAllNew();
		$newcom = $query->num_rows();
		if ($newcom>0) {
			$comments = $this->comentariosm->getAllNew();
			$this->comentariosm->update_entries();
			$titulo = 'Nuevos Comentarios';
		} else {
			$comments = $this->comentariosm->getAllByPage(0,10);
			$titulo = 'Comentarios Anteriores';
		}
		$datos['coments'] = $comments;
		$datos['titulo'] = $titulo;
		$datosHeader['extraHeaders'] = '<link rel="stylesheet" type="text/css" href="'.base_url().'public/css/desktop.estilo.css" />';
		$this->load->view('headers/header_admin',$datosHeader);
		$this->load->view('desktop/comentarios',$datos);
		$this->load->view('headers/footer_admin');
	}
	public function commentsDelete($id)
	{
		$query = $this->comentariosm->getById($id);
		$newcom = $query->num_rows();
		if ($newcom>0) {
			$this->comentariosm->deleted($id);
		} else {
		}
		redirect(base_url().'desktop/comments', 'location', 301);
	}
	public  function visitsonline()
	{
		$this->load->model('entrada');
		$axo_fin = date("Y");
		$mes_fin = date("m");
		$axo_ini = $axo_fin-1;
		$mes_ini = $mes_fin;
		$b=$mes_ini;
		$i=0;
		for($a=$axo_ini;$a<=$axo_fin;$a++){
			while($b<=12){
				if(strlen($b)==1) {$c="0".$b;}else{$c="".$b;}
				$axomes = $a . "-" . $c;
				$dateini = $a . "-" . $c . "-01 00:00:00";
				$datefin = $a . "-" . $c . "-31 23:59:59";
				$datos['axomes'][$i] = $axomes;
				$datos['resul'][$i] = $this->entrada->todosxdate($dateini,$datefin);
				if($b==$mes_fin && $a==$axo_fin) $b=13;
				$b++;
				$i++;
			}
			$b=1;
		}
		$headers = '<link rel="stylesheet" type="text/css" href="'.base_url().'public/css/metro.css" />';
		$footers = '<script type="text/javascript">
			$(function() {
				var puntos=[];
				var textos=[];
				';
				for($a=0;$a<count($datos['axomes']);$a++){
					$footers .= "puntos.push(" . $datos['resul'][$a] . ");";
				}
				for($b=0;$b<count($datos['axomes']);$b++){
					$footers .= "textos.push('" . $datos['axomes'][$b] . "');";
				}
				
				$footers .= 'var alto = $("#mycanvas").height()-20;
				var ancho = $("#mycanvas").width();
				var valorX = 0;
				var valorY = alto;
				var valorXo = 0;
				var valorYo = alto;
				var rangoX = Math.round(ancho / (puntos.length + 1))-1;
				var clone = puntos.slice(0);
				clone.sort(function(a,b){return b-a});
				var rangoY = clone[0] + 1;
				clone=puntos.slice(puntos.length);

				spot = document.getElementById("mycanvas").getContext("2d");
				spot.fillStyle="#FFFFFF";
				spot.fillRect(0,0,ancho,alto); 
				spot.fillStyle="#000000";
				spot.fillRect(0,alto-2,ancho,alto);
				for (var i = 0; i < puntos.length; i++) {
					valorX = valorX+50;
					valorY = alto - Math.round((alto*puntos[i])/rangoY);
					spot.beginPath();
					spot.arc(valorX, valorY, 5, 0, Math.PI*2, true);
					spot.fill();
					spot.closePath();
					spot.beginPath();
					spot.moveTo(valorXo, valorYo);
					spot.lineTo(valorX, valorY);
					spot.stroke();
					spot.closePath();
					spot.beginPath();
					var text = textos[i] + "[" + puntos[i] + "]";
					var metrics = spot.measureText(text);
					var width = valorX - (metrics.width / 2);
					spot.fillText(text,width,valorY-10);
					spot.closePath();
					valorXo=valorX;
					valorYo=valorY;
				};
			});
			</script>';
		$datosHeader['extraHeaders'] = $headers;
		$datosFooter['extrafooters'] = $footers;
		$this->load->view('headers/header_admin',$datosHeader);
		$this->load->view('desktop/visitas',$datos);
		$this->load->view('headers/footer_admin',$datosFooter);
	}

	public function admin()
	{
        $this->load->model('desktopm');
        $query = $this->desktopm->listado();
		$datos['query'] = $query;
		$datosHeader['extraHeaders'] = '<link rel="stylesheet" type="text/css" href="'.base_url().'public/css/desktop.estilo.css" />';
		$this->load->view('headers/header_admin',$datosHeader);
		$this->load->view('desktop/admin',$datos);
		$this->load->view('headers/footer_admin');
	}

	public function nuevo()
	{
        $this->load->model('desktopm');
        $this->load->helper('security');
		$this->load->helper('cookie');
		$csrf = array(
        	'name' => $this->security->get_csrf_token_name(),
        	'hash' => $this->security->get_csrf_hash()
		);
		$datos['csrf']=$csrf;
        $categ = $this->desktopm->consultacat();
		$datos['categ'] = $categ;
		$this->load->view('desktop/nuevo',$datos);
	}

	public function guardar()
	{
		$this->load->helper('cookie');
		$this->load->helper('security');
		$this->load->helper('url');
		$this->load->model('desktopm');
		$msg="OK";

		$titulo = trim($_POST['titulo']);
		$seccion = trim($_POST['seccion']);
		$clase = trim($_POST['clase']);
		$target = trim($_POST['target']);
		$enlace = trim($_POST['enlace']);
		$titulo = str_replace(" ", "", $titulo);
		$titulo = str_replace("_", "", $titulo);
		$titulo = str_replace("-", "", $titulo);
		$titulo = strtolower($titulo);

		$newfile = "" . $titulo . ".jpg";
		$newfilet = "" . $titulo . "_thumb.jpg";
		$destiny = 'public/img/iconos_metro/';
		$uptodb=true;
		if(!file_exists($destiny)) {
			if(!mkdir($destiny,0777,true)) {
				$uptodb = false;
				$msg="No dir";
			}
		}
		echo "POST: " .$titulo. " -> " .$seccion. " -> " .$clase. " -> " .$target. " -> " .$enlace. "<br>";
		$config['upload_path'] = $destiny;
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
		$config['file_name'] = $newfile;
		$config['max_size'] = '2000';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['overwrite'] = true;
		echo "Config<br>";

		$this->load->library('upload', $config);
		echo "Lib Upload<br>";

		try {
			echo "Inicio TRY<br>";
			var_dump($this->upload->do_upload('userfile'));
			if ( ! $this->upload->do_upload('userfile'))
			{
				$error = $this->upload->display_errors('<p>', '</p>');
				$uptodb=false;
				$msg="No file upload";
				echo $error."<br>";
			}
			else
			{
			echo "Uploading<br>";
				$data = array('upload_data' => $this->upload->data());
				$uptodb=true;
				if(file_exists($destiny . $newfile)){
					$size = GetImageSize($destiny . $newfile);
					$anchura=$size[0];
					$altura=$size[1];
					if($anchura==150 && $altura==150){} else {
						$configi['image_library'] = 'gd2';
						$configi['source_image'] = $destiny . $newfile;
						$configi['create_thumb'] = TRUE;
						$configi['maintain_ratio'] = TRUE;
						$configi['width'] = 150;
						$configi['height'] = 150;
						$this->load->library('image_lib', $configi);
						$this->image_lib->resize();
					}
				}
				if(file_exists($destiny.$newfilet)){
					if(unlink($destiny.$newfile)){
						rename($destiny.$newfilet, $destiny.$newfile);
					}else{
						$uptodb=false;
						$msg="No borrar imagen";
					}
				}else{
					//$uptodb=false;
				}
			}
			echo "Proced to Saving...<br>";
			if($uptodb){
				$data = array("titulo" => $titulo,
							"id_seccion" => $seccion,
							"clase" => $clase,
							"imagen" => $newfile,
							"target" => $target,
							"enlace" => $enlace
							);
				if($this->desktopm->nuevo($data)){
					$msg="Guardado";
					$this->xml_desktop();
				} else {
					$msg="Error";
					if(file_exists($destiny.$newfile)){
						unlink($destiny.$newfile);
					}
				}
			} else {
				$msg="Error: No archivo";
			}
		} catch (Exception $e) {
			echo "ERROR:: " . $e->getMessage;
		}

		echo $msg;
		exit();

		redirect(base_url().'desktop/', 'location', 301);
	}
	/*
	* Funcion para crear xml del desktop
	*/
	public function xml_desktop(){
		$intsize = 1;
		$num = 10;
		$int = 1;
		$dir = "public/xml/";
		if (file_exists($dir)){
		} else {
			mkdir($dir,0777,true);
		}
		$url = $dir . 'idesktop.xml';
		if(!file_exists($url)){
			$this->load->model('desktopm');
			$categ = $this->desktopm->consultacat();
			if($categ->num_rows()>0): 
				$valor= '<?xml version="1.0"?><desktop>';
				$valor.= '<Articulo id="menulat">';
				foreach($categ->result() as $cat): 
					if($cat->id > 1){
						$valor .= '<Item>'
								.'<ItemId>' . $cat->id . '</ItemId>'
								.'<ItemImage>' . $cat->imagen . '</ItemImage>'
								.'<ItemClass>' . stripslashes($cat->descripcion) . '</ItemClass>'
								.'<ItemTarget>#</ItemTarget>'
								.'<ItemLink>#</ItemLink>'
								.'</Item>';
					}
				endforeach;
				$valor.= '</Articulo>';
				foreach($categ->result() as $row): 
					$idgal = $row->id;
					$elem = $this->desktopm->consultaxcat($idgal);
					if($elem->num_rows()>0): 
						if($row->id==1){
							$clase=$row->descripcion;
						} else {
							$clase="#";
						}
						$valor.= '<Articulo id="'.$row->descripcion.'">';
						foreach($elem->result() as $rowf): 
							if($rowf->target==1){$destino = "opnblank";}
							if($rowf->target==2){$destino = "opnDiv";}
							$valor.= '<Item>'
									.'<ItemId>'.$rowf->id.'</ItemId>'
									.'<ItemImage>'.$rowf->imagen.'</ItemImage>'
									.'<ItemClass>'.$rowf->clase.'</ItemClass>'
									.'<ItemTarget>'.$destino.'</ItemTarget>'
									.'<ItemLink>'.stripslashes($rowf->enlace).'</ItemLink>'
								.'</Item>';
							$int++;
						endforeach;
						$valor.= '</Articulo>';
					endif;
				endforeach;
				$valor.= '</desktop>';
			endif;
			$fileHandle = @fopen($url, 'w'); 
			fwrite($fileHandle, $valor); 
			fclose($fileHandle); 
		}
	}
	/*
	* Funcion para re-generar los xml que se ocupan en el home del desktop
	*/
	public function make_desktop_home(){
		$dir = "public/xml/";
		$namefile = "idesktop";
		$url = $dir . $namefile. '.xml';
		if(file_exists($url)){
			rename($url, $dir . 'r_'.$namefile.'.xml');
		}

		$this->xml_desktop();

		if(file_exists($url)){
			unlink($dir . 'r_'.$namefile.'.xml');
		}else{
			rename($dir . 'r_'.$namefile.'.xml',$url);
		}
		redirect(base_url().'desktop', 'location', 301);
	}

	public function opncateg($id){
		$this->load->model('desktopm');
		$categ = $this->desktopm->consultacat();
		echo '<select id="fseccion" name="fseccion">';
		if($categ->num_rows()>0): 
			foreach($categ->result() as $cat): 
				if($id==$cat->id){$sel = 'SELECTED';} else {$sel = '';}
            	echo '<option value="'.$cat->id.'" '.$sel.'>'.$cat->descripcion.'</option>';
			endforeach;
		endif;
		exit();
	}

	public function del_elem($id){
		$this->load->model('desktopm');
		$elem = $this->desktopm->getElemById($id);
		$categ = false;
		if($elem->num_rows()>0): 
			foreach($elem->result() as $cat): 
            	$imgn = $cat->imagen;
			endforeach;
           	$logo = "public/img/iconos_metro/" . $imgn;
           	if(strlen($imgn)>0){
	           	if(file_exists($logo)){
	           		if(unlink($logo)){
	  					$categ = $this->desktopm->borra($id);
						$this->make_desktop_home();
	           		} else {
	  					$categ = 2;
	           		}
	           	}else {
  					$categ = 3;
           		}
           	}else {
				$categ = 4;
       		}
		endif;
		echo $categ;
		exit();
	}

	public function actualizar(){
		$destiny = 'public/img/iconos_metro/';
		$this->load->model('desktopm');
		$id = trim($_POST['clv']);
		$titulo = addslashes(trim($_POST['ftitulo']));
		$titula = trim($_POST['ftitulo']);
		$seccion = trim($_POST['fseccion']);
		$target = trim($_POST['ftarget']);
		$enlace = addslashes(trim($_POST['fenlace']));

		$elem = $this->desktopm->getElemById($id);
		if($elem->num_rows()>0): 
			foreach($elem->result() as $cat): 
            	$oldimg = $cat->imagen;
			endforeach;
			rename($destiny.$oldimg, $destiny."r_".$oldimg);
		endif;

		$newfile = $id . "_" . date("s") . "_icon.jpg";
		$newfilet = $id . "_" . date("s") . "_icon_thumb.jpg";

		$config['upload_path'] = $destiny;
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
		$config['file_name'] = $newfile;
		$config['overwrite'] = true;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('fimagen'))
		{
			//$error = array('error' => $this->upload->display_errors());
			//$uptodb=false;
			rename($destiny."r_".$oldimg, $destiny.$oldimg);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$uptodb=true;
			if(file_exists($destiny . $newfile)){
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
				}
			}
			if(file_exists($destiny.$newfile)){
				unlink($destiny."r_".$oldimg);
				$datos['imagen']=$newfile;
			}
		}
		if(strlen($titulo)>0) { $datos['titulo']=$titulo; }
		if(strlen($seccion)>0) { $datos['id_seccion']=$seccion; }
		if(strlen($target)>0) { $datos['target']=$target; }
		if(strlen($enlace)>0) { $datos['enlace']=$enlace; }

		if(strlen($id)>0 && count($datos)>0){
			$this->desktopm->actualiza($id,$datos);
			$this->make_desktop_home();
		}
		redirect(base_url().'desktop/admin', 'location', 301);
	}


	public function carrusel()
	{
		$this->load->model('fotos');
		//$idfg = $this->fotos->lastGalInserted();
		$idfg = 21;
		$page=1;
		$limit=10;

		$datos['query'] = $this->fotos->gfotos($idfg,0,$limit);
		$datos['galeria'] = $idfg;

		$queryt = $this->fotos->genfotos($idfg);
		$datos['queryt'] = $queryt->num_rows();

		$this->load->view('desktop/carrusel',$datos);
	}
	public function carruselquery($idfg,$page,$limit)
	{
		$inicio = ($page * $limit) - $limit;
		$this->load->model('fotos');
		$datos['queryp'] = $this->fotos->gfotos($idfg,$inicio,$limit);
		$this->load->view('desktop/carruselq',$datos);
	}

	/*
	*
	*
	* Administracion de Categorias del Desktop
	*
	*/
	public function admincat()
	{
        $this->load->model('categoriasm');
        $query = $this->categoriasm->listadoById();
		$datos['query'] = $query;
		$this->load->view('desktop/categorias',$datos);
	}
	public function nuevocat()
	{
		$this->load->view('desktop/nuevocat');
	}
	public function guardarcat()
	{
		$this->load->model('categoriasm');
		$titulo = trim($_POST['titulo']);
		$titulo = str_replace(" ", "", $titulo);
		$titulo = str_replace("_", "", $titulo);
		$titulo = str_replace("-", "", $titulo);
		$titulo = strtolower($titulo);

		$newfile = "" . $titulo . ".jpg";
		$newfilet = "" . $titulo . "_thumb.jpg";
		$destiny = 'uploads/iconos_metro/';
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

		if ( ! $this->upload->do_upload('imagen'))
		{
			$error = array('error' => $this->upload->display_errors());
			$uptodb=false;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$uptodb=true;
			if(file_exists($destiny . $newfile)){
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
			$data = array("descripcion" => $titulo,
						"imagen" => $newfile
						);
			if($this->categoriasm->nuevo($data)){
			} else {
				if(file_exists($destiny.$newfile)){
				}
			}
		} else {
		}

		redirect(base_url().'desktop/admincat', 'location', 301);
	}
	public function del_elem_cat($id){
		$this->load->model('categoriasm');
		$elem = $this->categoriasm->getElemById($id);
		$categ = false;
		if($elem->num_rows()>0): 
			foreach($elem->result() as $cat): 
            	$imgn = $cat->imagen;
			endforeach;
           	$logo = "uploads/iconos_metro/" . $imgn;
           	if(strlen($imgn)>0){
	           	if(file_exists($logo)){
	           		if(unlink($logo)){
	  					$this->categoriasm->borrar($id);
	  					$categ = 1;
	           		} else {
	  					$categ = 2;
	           		}
	           	}else {
  					$categ = 3;
           		}
           	}else {
				$categ = 4;
       		}
		endif;
		echo $categ;
		exit();
	}
	public function edt_elem_cat($id){
		$this->load->model('categoriasm');
		$elem = $this->categoriasm->getElemById($id);
		if($elem->num_rows()>0): 
			foreach($elem->result() as $cat): 
            	$datos['idn'] = $cat->id;
            	$datos['imagen'] = $cat->imagen;
				$datos['titulo'] = $cat->descripcion;
			endforeach;
		endif;
		$this->load->view('desktop/editarcat',$datos);
	}
	public function actualizacat()
	{
		$this->load->model('categoriasm');
		$idn = trim($_POST['idn']);
		$titulo = trim($_POST['titulo']);
		$titulo = str_replace(" ", "", $titulo);
		$titulo = str_replace("_", "", $titulo);
		$titulo = str_replace("-", "", $titulo);
		$titulo = strtolower($titulo);

		$newfile = "" . $titulo . ".jpg";
		$newfilet = "" . $titulo . "_thumb.jpg";
		$destiny = 'uploads/iconos_metro/';
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

		if ( ! $this->upload->do_upload('imagen'))
		{
			//$error = array('error' => $this->upload->display_errors());
			//$uptodb=false;
			$elem = $this->categoriasm->getElemById($idn);
			$imgn=$newfile;
			if($elem->num_rows()>0): 
				foreach($elem->result() as $cat): 
	            	$imgn = $cat->imagen;
				endforeach;
			endif;
			$newfile = "" . $imgn . "";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$uptodb=true;
			if(file_exists($destiny . $newfile)){
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
			$data = array("descripcion" => $titulo,
						"imagen" => $newfile
						);
			if($this->categoriasm->actualiza($idn,$data)){
			} else {
				if(file_exists($destiny.$newfile)){
				}
			}
		} else {
		}

		redirect(base_url().'desktop/admincat', 'location', 301);
	}
	public function baja(){
		$this->load->view('desktop/download');
	}
	public function videoti($id=0){
		$url = "http://feeds.esmas.com/data-feeds-esmas/appjs/videos_tvsaint_total.js";
		$contents = file_get_contents($url);
		$contents = utf8_encode($contents);
		$results = json_decode($contents, TRUE); 
		$j = $id+1-1;

		if(isset($j) && $j>=0){ } else { $j=0; }

		$video = $results['items'][$j]['id'];
		$brightcove_id = $results['items'][$j]['brightcove_id'];
		$title = $results['items'][$j]['title'];
		$total=count($results['items'])-1;
		echo "Viendo: " . $j . " - " . $total . "<br>";
		$videon = $j+1;
		$videop = $j-1;
		if($j>=$total){
			$videon = 0;
		}
		if($j<0){
			$videop = $total-1;
		} else {
			if($j==0){
				$videop=$total;
			}
		}
		$res = "";
		for ($s=0; $s <= $total; $s++) { 
			$svideo = $results['items'][$s]['id'];
			$sbrightcove_id = $results['items'][$s]['brightcove_id'];
			$stitle = $results['items'][$s]['title'];
			$cad = $s . "- " . $svideo . " - ". $sbrightcove_id . " - " . $stitle;
			$res .= '<option value="'.$s.'">'.$cad.'</option>';
		}

		$datos['j'] = $j;
		$datos['video'] = $video;
		$datos['brightcove_id'] = $brightcove_id;
		$datos['title'] = $title;
		$datos['videon'] = $videon;
		$datos['videop'] = $videop;
		$datos['res'] = $res;

		$this->load->view('desktop/videoplayer',$datos);
	}
	public function procesa(){
		$this->load->model('galeriasm');
		/*$sql = "SELECT * FROM desktop d where enlace like '%yorch3004%';";
		$res = $this->galeriasm->galSqlPqd($sql);
		if($res->num_rows()>0): 
			foreach($res->result() as $row): 
				$link = $row->enlace;
				//echo $link . "<br>";
				$newLink = str_replace(".com/",".com/",$link);
				$newLink = str_replace("indexc","home",$newLink);
				//echo $newLink . " in " . $row->id . "<br>";
				$upd = "update desktop set enlace='".$newLink."' where id=".$row->id.";";
				echo $upd . "<br>";
				$this->galeriasm->galSqlPqd($upd);
			endforeach;
		endif;
		//exit();
		redirect(base_url().'desktop/', 'location', 301);*/
				$intsize = 2;
				$num = 10;
				$int = 1;
				$gals = $this->galeriasm->recentGals(4);
				if($gals->num_rows()>0): 
					$valor= '<?xml version="1.0"?><Fotos>';
					foreach($gals->result() as $row): 
						$idgal = $row->id;
						$fots = $this->galeriasm->presentacionHome_size_num($idgal,2,$num);
						if($fots->num_rows()>0): 
							foreach($fots->result() as $rowf): 
								$valor.= ''.$int.'<br>
										'.$rowf->fdescription.'<br>
										'.$rowf->fdescription.'<br>
										'.$rowf->id_galeria.'<br>
										'.$rowf->name_galeria.'<br>
								';
								$int++;
							endforeach;
						endif;
						if($fots->num_rows()<$num): 
							$numNew = $num-$fots->num_rows();
							$fotsExtra = $this->galeriasm->presentacionHome_size_num($idgal,1,$numNew);
							if($fotsExtra->num_rows()>0): 
								foreach($fotsExtra->result() as $rowg): 
									$valor.= '<Item>
											'.$int.'<br>
											'.$rowg->fdescription.'<br>
											'.$rowg->fdescription.'<br>
											'.$rowg->id_galeria.'<br>
											'.$rowg->name_galeria.'<br>
									';
									$int++;
								endforeach;
							endif;
						endif;
					endforeach;
					$valor.= '</Fotos>';
				endif;
		echo "".$valor;
		exit();
		redirect(base_url().'desktop/', 'location', 301);
	}
}

/* End of file Desktop.php */
/* Location: ./application/controllers/desktop.php */