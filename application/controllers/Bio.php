<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bio extends CI_Controller {

	public function index()
	{
		$data['menu_active'] = 1;
		$data['page_title'] = ' | Bio';
		$this->load->view('headers/header',$data);
		$this->load->view('bio/index');
		$this->load->view('headers/footer');
	}
}
