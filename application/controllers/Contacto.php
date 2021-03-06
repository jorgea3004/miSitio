<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

class Contacto extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/welcome
	 *	- or -
	 * 		http://example.com/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper('cookie');
		$this->load->helper('url');
		$data['menu_active'] = 4;
		$data['page_title'] = ' | Cont&aacute;cto';
		$csrf = array(
        	'name' => $this->security->get_csrf_token_name(),
        	'hash' => $this->security->get_csrf_hash()
		);
		$dataForm['csrf']=$csrf;
		$validForm=1;
		$msgForm='';
		if (!is_null(get_cookie("frmCntcto")) ){
			$validForm=0;
			$msgForm = "Gracias por tu mensaje.";
		}
		$dataForm['msgForm']=$msgForm;
		$dataForm['validForm']=$validForm;
		
		$this->load->view('headers/header',$data);
		$this->load->view('contacto/index',$dataForm);
		$this->load->view('headers/footer');
	}
	public function validate(){
		$this->load->helper('cookie');
		$this->load->helper('security');
		$this->load->helper('url');
		$this->load->model('comentariosm');

		$rest_json = file_get_contents("php://input");
		$_POST = json_decode($rest_json, true);
		$nombre = $_POST['nombre'];
		$email = $_POST['email'];
		$url = $_POST['url'];
		$coment = $_POST['message'];

		$respuesta=array();
		$fecha = date("Y-m-d H:i:s");
		if (isset($url) && strlen($url)>0 ) {
			$coment = $url . " _n_ " . $coment;
		}

		if (strlen($nombre)>0 && strlen($email)>0 && strlen($coment)>0) {
			$datos = array("nombre" => $nombre,
								"email" => $email,
								"comment" => $coment,
								"fecha" => $fecha,
								"status" => 0
								);
			$this->comentariosm->insertEntry($datos);
	        //set_cookie("frmCntcto", "frmCntcto", 3600 );
	        $respuesta['message']='Gracias por tu mensaje.';
			$respuesta['frmlog']=true;
		}else{
	        $respuesta['message']='Error: Datos incompletos, favor de poner Nombre, Correo y un Mensaje.';
			$respuesta['frmlog']=false;
		}
		echo json_encode($respuesta);
	}
}
