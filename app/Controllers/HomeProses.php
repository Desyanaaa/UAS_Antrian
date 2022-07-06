<?php

namespace App\Controllers;

use App\Controllers\BaseController;

// Load Model
use App\Models\HomeProsesModel;
use App\Models\PelayananProsesModel;

class HomeProses extends BaseController{

	// Inisialisasi Model
	protected $homeProsesModel, $pelayananProsesModel;
	public function __construct(){
		$this->homeProsesModel = new HomeProsesModel();
		$this->pelayananProsesModel = new PelayananProsesModel();
	}

	public function ambilAntrian(){
		$validate = [
			'id'		=> [
				'label'	=> 'ID',
				'rules'	=> 'required|is_not_unique[pelayanan.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique'	=> 'ID Tidak Tersedia', 
				]
			],
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			echo json_encode(0);
		}else{
			$id = $this->request->getPost('id');

			// Get Antrian Terakhir Hari Ini
			$antrianTerakhir = $this->homeProsesModel->select('*')->where('pelayanan_id', $id)->like('tanggal', date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();

			// Cek Ada Antrian Terakhir Hari Ini atau Tidak
			if($antrianTerakhir->getNumRows()<1){

				// Jika Tidak Ada
				$noAntrian = 1;
			}else{

				// Jika Ada

				// Buat Array
				$antrianTerakhir = $antrianTerakhir->getRowArray();

				// Buat Nomor Antrian
				$noAntrian = $antrianTerakhir['no_antrian']+1;
			}

			// Array Untuk Table antrian
			$dataDatabase = [
				'tanggal' => date("Y-m-d H:i:s"),
				'no_antrian'	=> $noAntrian,
				'status'	=> 0,
				'waktu_panggil' => null,
				'waktu_selesai'	=> null,
				'pelayanan_id'	=> $id,
				'loket_id'			=> null,
			];

			// Data ke Database
			$query = $this->homeProsesModel->insert($dataDatabase);
			
			// Cek Query Berhasil
			if($query){

				// Get Detail Pelayanan
				$detailPelayanan = $this->pelayananProsesModel->select('kode')->where('id', $id)->get()->getRowArray();
				
				$dataKembali = [
					'noAntrian' => $detailPelayanan['kode']."-".$noAntrian,
					'status'		=> 1
				];

				echo json_encode($dataKembali);
			}else{
				echo json_encode(0);
			}
		}
	}
}
