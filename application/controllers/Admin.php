<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->helper('url');
		$this->load->library('session');
		$usnme = $this->session->userdata('username');
	}

	public function index()
	{
		$hdatos['extraHeaders']='<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
		$hdatos['usnme'] = $this->session->userdata('username');
		$vdatos['txt']='';
		$this->load->view('headers/header_admin',$hdatos); 
		$this->load->view('admins/index',$vdatos); 
		$this->load->view('headers/footer_admin'); 
	}
	
	public function valida()
	{
		$user = md5($_POST['user']);
		$pass = md5($_POST['pass']);
        $this->load->helper('security');
		$this->load->helper('session');
		if(isset($user) && strlen($user)>0 && isset($pass) && strlen($pass)>0 ){
			$this->load->model('usuariosm');
			$vuser=$this->usuariosm->validuser($user,$pass);
			if ($vuser->result()!=null && count($vuser->result())>0) {
				$return = 'Usuario aceptado';
				$status = 1;
				$newdata = array(
							   'username'  => $user,
							   'logged_in' => TRUE,
							   'errsesn'  => 0
							   );
				$this->session->set_userdata($newdata);
			} else {
				$return = 'Usuario NO aceptado';
				$status = 0;
			}
		} else {
			$return = 'Usuario NO valido';
			$status = 0;
		}
		$json['estatus'] = json_encode($status);
		$json['msg'] = json_encode($return);
		echo json_encode($json);
		exit();
	}
	
	public function getMenuJson($page)
	{
		$this->load->model('Desktopm');
		if ($page<1) {
			$page=1;
		}
		$limite = 20;
		$inicio = ($page*$limite)-$limite;
		$elems=$this->Desktopm->listadoJsonByPage($inicio,$limite);
		$json = array();
		if ($elems->result_array()!=null && count($elems->result_array())>0) {
			$json['post'] = $elems->result_array();
		}
		echo json_encode($json);
		exit();
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */