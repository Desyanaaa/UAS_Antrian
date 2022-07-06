<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

// Load Model
use App\Models\PelayananProsesModel;
use App\Models\LoketProsesModel;
use App\Models\HomeProsesModel;

class Panggil extends BaseController{

	// Inisialisasi Model
	protected $pelayananProsesModel, $loketProsesModel, $homeProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
		$this->loketProsesModel = new LoketProsesModel();
		$this->homeProsesModel = new HomeProsesModel();
	}

	// Tampilan Panggil Antrian
	public function panggil($id){

		// CEK LOKET TERSEDIA ATAU TIDAK
		$detailLoket = $this->loketProsesModel->select("loket.*, a.nama as nama_pelayanan, a.kode")->join('pelayanan a', 'loket.pelayanan_id=a.id')->where('loket.id', $id)->get();

		if($detailLoket->getNumRows()<1){
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}else{
			// Detail Loket
			$data['detailLoket']	= $detailLoket->getRowArray();

			// Get Antrian Berdasarkan Loket Id
			$kondisi = [
				'status <='  => '1',
				'pelayanan_id' => $data['detailLoket']['pelayanan_id']
			];
			$loket = [$id, null];
			// var_dump($loket);
			$tanggalSekarang	= date("Y-m-d");
			$data['antrian']	= $this->homeProsesModel->select("antrian.*, a.kode as kode")
			->join('pelayanan a', 'antrian.pelayanan_id=a.id')->groupStart()->where('loket_id', $id)->orWhere('loket_id', null)->groupEnd()
			->where($kondisi)->like('antrian.tanggal', $tanggalSekarang)->limit(5)->get();

			// Tampilan Panggil Antrian
			$data['title']				= "Pelayanan ".$data['detailLoket']['nama'];
			echo view('main/header', $data);
			echo view('admin/pelayanan-panggil');
			echo view('main/footer');
		}
	}
}
