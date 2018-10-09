<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graphicas extends CI_Controller {

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
	/*
	* Funcion para crear registro de entrada
	*/
	public static function index()
	{
		$ci =& get_instance();
		$datah['extraHeaders'] = '<link rel="stylesheet" href="'.base_url().'public/css/metro.css" type="text/css">';
		$ci->load->view('layouts/header_admin',$datah);
		$ci->load->view('graphicas/index');
		$ci->load->view('layouts/footer_admin');
	}
	public static function topgalerias()
	{
		$ci =& get_instance();
		$ci->load->model('estadisticas');
		$datah['extraHeaders'] = '<link rel="stylesheet" href="'.base_url().'public/css/metro.css" type="text/css">';
		$data['galsdirectory'] = $ci->funciones->galsDirectory();
		$data['resultados'] = $ci->estadisticas->getTopByGaleria(10);
		$ci->load->view('layouts/header_admin',$datah);
		$ci->load->view('graphicas/topgalerias',$data);
		$ci->load->view('layouts/footer_admin');
	}
	public static function topfotos()
	{
		$ci =& get_instance();
		$ci->load->model('estadisticas');
		$datah['extraHeaders'] = '<link rel="stylesheet" href="'.base_url().'public/css/metro.css" type="text/css">';
		$data['galsdirectory'] = $ci->funciones->galsDirectory();
		$data['resultados'] = $ci->estadisticas->getTopByFotos(10);
		$ci->load->view('layouts/header_admin',$datah);
		$ci->load->view('graphicas/topfotos',$data);
		$ci->load->view('layouts/footer_admin');
	}

}
