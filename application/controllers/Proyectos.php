<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyectos extends CI_Controller {

	public function index()
	{
		$data['menu_active'] = 3;
		$data['page_title'] = ' | Proyectos';
		$this->load->view('headers/header',$data);
		$this->load->view('proyectos/index');
		$this->load->view('headers/footer');
	}
}
