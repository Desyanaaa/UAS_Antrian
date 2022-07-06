<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

// Load Model
use App\Models\LoketProsesModel;
use App\Models\PelayananProsesModel;

class Loket extends BaseController{

	// Inisialisasi Model Loket dan Pelayanan
	protected $loketProsesModel, $pelayananProsesModel;
	public function __construct(){
		$this->loketProsesModel = new LoketProsesModel();
		$this->pelayananProsesModel = new PelayananProsesModel();
	}

	public function index(){
		
		$data['title']      = "Loket";

		// Load Data Validasi Form
		$data['validation'] = $this->validation;

		// Load Data Loket untuk Table
		$data['loket']      = $this->loketProsesModel->select("loket.*, pelayanan.nama as nama_pelayanan")->JOIN('pelayanan', 'loket.pelayanan_id=pelayanan.id')->orderBy("id", "DESC")->get()->getResultArray();

		// Load Data Pelayanan untuk Select
		$data['pelayanan']	= $this->pelayananProsesModel->select('*')->orderBy('id', 'DESC')->get()->getResultArray();

		// Tampilan Loket
		echo view('main/header', $data);
		echo view('admin/loket');
		echo view('main/footer');
	}
}
