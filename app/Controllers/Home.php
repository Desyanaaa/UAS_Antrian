<?php

namespace App\Controllers;

// Load Model
use App\Models\PelayananProsesModel;
use App\Models\HomeProsesModel;
use App\Models\LoketProsesModel;

class Home extends BaseController{

	// Inisialisasi Model
	protected $pelayananProsesModel, $homeProsesModel, $loketProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
		$this->homeProsesModel = new HomeProsesModel();
		$this->loketProsesModel = new LoketProsesModel();
	}

	// Tampilan Ambil Antrian
	public function index(){
		$data['title'] = "SISTEM ANTRIAN";
		$data['pelayanan']	= $this->pelayananProsesModel->select("*")->orderBy('id', 'DESC')->get()->getResultArray();
		echo view('main/header', $data);
		echo view('ambil-antrian');
		echo view('main/footer');
	}

	// Tampilan Antrian Public
	public function antrian(){


		// Terakhir Dipanggil
		$data['panggilTerakhir'] = $this->homeProsesModel->select('antrian.*, a.kode, b.nama as nama_loket')
		->join('pelayanan a', 'antrian.pelayanan_id=a.id')
		->join('loket b', 'antrian.loket_id=b.id')->where('antrian.status', 1)
		->orderBy('antrian.waktu_panggil', 'DESC')->limit(1)->get();
		// Detail Loket
		$data['detailLoket']	= $this->loketProsesModel->select("loket.id, loket.nama, a.kode")
		->join('pelayanan a', 'loket.pelayanan_id=a.id')
		->orderBy('id', 'ASC')->get()->getResultArray();
		// Tampilan Antrian Public
		$data['title'] = "ANTRIAN";
		echo view('main/header', $data);
		echo view('antrian');
		echo view('main/footer');
	}
}
