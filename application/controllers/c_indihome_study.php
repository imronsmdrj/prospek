<?php 
class C_indihome_study extends CI_Controller{


	public function __construct(){
			parent::__construct();
			$this->load->model('m_indihome_study');
			$this->load->library('Excel');

	// 		if($this->session->userdata('role_id')!='1'){
	// 			$this->session->set_flashdata('pesan','<div class="alert alert-danger" role="alert">
	//   <strong>Anda belum Login !!!</strong>
	//   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	//     <span aria-hidden="true">&times;</span>
	//   </button>
	// </div>');
	// 			redirect('auth/login');
	// 		}
		}
	public function index (){
		

		$this->load->view('templates/header');
		if ($this->session->userdata('role_id') ==='1') {
			$this->load->view('templates/sidebar');
		}elseif($this->session->userdata('role_id') ==='2'){
			$this->load->view('templates/sidebar_user');
		}else{
			$this->session->set_flashdata('pesan','<div class="alert alert-danger" role="alert">
	   <strong>Anda belum Login !!!</strong>
	   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	     <span aria-hidden="true">&times;</span>
	   </button>
	 </div>');
	 			redirect('auth/login');
		}
		$this->load->view('indihome_study/v_indihome_study');
		$this->load->view('templates/footer');
	}

	public function view_indihome_study($id){
		$explode = explode('~', $id);
		$periode_awal = $explode[0];
		$periode_akhir = $explode[1];
		$data['indihome_study'] = $this->m_indihome_study->indihome_study($periode_awal, $periode_akhir);

		$this->load->view('indihome_study/view_list', $data);
	}

	public function import(){
		if(isset($_FILES["file"]["name"]))
			{
				$path = $_FILES["file"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					for($row=2; $row<=$highestRow; $row++)
					{   
				 		$witel		= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$ncli		= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$ndos		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$ndem		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$no_inet	= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
						$item		= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						$price		= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
						$tgl_va		= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
						$tgl_ps		= $worksheet->getCellByColumnAndRow(8, $row)->getValue();
						$kcontact	= $worksheet->getCellByColumnAndRow(9, $row)->getValue();

					$cek_duplicat = $this->m_indihome_study->chek_duplicat($no_inet);
					if ($cek_duplicat != NULL) {
						if ($cek_duplicat->no_inet == $no_inet) {
							$this->m_indihome_study->update_duplicat($witel, $ncli, $ndos, $ndem, $no_inet, $item, $price, $tgl_va, $tgl_ps, $kcontact);
						}else{
							$this->m_indihome_study->upload($witel, $ncli, $ndos, $ndem, $no_inet, $item, $price, $tgl_va, $tgl_ps, $kcontact);
						}
					}else{
						$this->m_indihome_study->upload($witel, $ncli, $ndos, $ndem, $no_inet, $item, $price, $tgl_va, $tgl_ps, $kcontact);
					}

					}
				}
				// $this->m_indihome_study->upload($data);
				redirect('c_dashboard_admin/dashboard');
				
			}
		}
}

 ?>