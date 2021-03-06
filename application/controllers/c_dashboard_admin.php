<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard_admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('m_dashboard_admin');

		if($this->session->userdata('role_id')!='1'){
			$this->session->set_flashdata('pesan','<div class="alert alert-danger" role="alert">
  <strong>Anda belum Login !!!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
			redirect('auth/login');
		}
	}
	public function dashboard()
	{
		$data['indihome'] 		= $this->m_dashboard_admin->indihome();
		$data['movin']			= $this->m_dashboard_admin->movin();
		$data['indihome_gamer'] = $this->m_dashboard_admin->indihome_gamer();
		$data['ott'] 			= $this->m_dashboard_admin->ott();
		$data['indihome_music'] = $this->m_dashboard_admin->indihome_music();
		$data['video_call'] 	= $this->m_dashboard_admin->video_call();
		$data['indi_storage'] 	= $this->m_dashboard_admin->indi_storage();
		$data['indi_server'] 	= $this->m_dashboard_admin->indi_server();
		$data['plc'] 			= $this->m_dashboard_admin->plc();
		$data['wifi_extender'] 	= $this->m_dashboard_admin->wifi_extender();
		$data['indihome_smart'] = $this->m_dashboard_admin->indihome_smart();
		$data['indihome_study'] = $this->m_dashboard_admin->indihome_study();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('v_dashboard_admin', $data);
		$this->load->view('templates/footer');


	}
}
