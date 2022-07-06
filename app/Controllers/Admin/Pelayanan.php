<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

// Load Model
use App\Models\PelayananProsesModel;

class Pelayanan extends BaseController{

	// Inisialisasi Model
	protected $pelayananProsesModel, $loketProsesModel, $homeProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
	}

	// Tampilan CRUD Pelayanan
	public function index(){
		$data['title'] = "Pelayanan";
		$data['pelayanan']	= $this->pelayananProsesModel->select("*")->orderBy('id', 'DESC')->get()->getResultArray();
		$data['validation']	= $this->validation;
		echo view('main/header', $data);
		echo view('admin/pelayanan');
		echo view('main/footer');
	}
}
