<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

// Load Model
use App\Models\HomeProsesModel;

class PanggilProses extends BaseController{

		// Inisialisasi Model
		protected $homeProsesModel;
		public function __construct(){
			$this->homeProsesModel = new HomeProsesModel();
		}
	
	public function panggil(){
		
		// Rules Form Validation
		$validate = [
			'id'		=> [
				'label'	=> 'ID',
				'rules'	=> 'required|is_not_unique[antrian.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique' => 'Id Tidak Ada' 
				]
			],
			'loketId'		=> [
				'label'	=> 'Loket Id',
				'rules'	=> 'required|is_not_unique[loket.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique' => 'Loket Tidak Ada' 
				]
			],
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			return redirect()->back()->withInput();
		}else{

			// Data From Form
			$id = $this->request->getPost('id');
			$loketId = $this->request->getPost('loketId');

			// Cek Loket Sibuk (Loket sedang melayani atau tidak)
			$kondisiCekLoketSibuk = [
				'status'	=> 1,
				'loket_id'=> $loketId
			];
			$cekLoketSibuk = $this->homeProsesModel->select("*")->where($kondisiCekLoketSibuk)->get()->getNumRows();

			if($cekLoketSibuk>0){

				// Jika Sibuk maka gagal untuk memanggil loket
				echo json_encode(0);
			}else{

				// Jika Tidak Sibuk

				// Detail Antrian
				$detailAntrian = $this->homeProsesModel->select("*")->where('id', $id)->get()->getRowArray();

				// Cek Status Antrian
				if($detailAntrian['status']==0){

					// Jika Antrian Berhasil Diambil

					// array update Database
					$dataUpdate = [
						'status' 				=> 1,
						'waktu_panggil'	=> date("Y-m-d H:i:s"),
						'loket_id'			=> $loketId,
					];

					// Update Database
					$query = $this->homeProsesModel->update($id, $dataUpdate);

					// Cek Eksekusi Query
					if($query){
						echo json_encode(1);
					}else{
						echo json_encode(0);
					}
				}else{

					// Jika Antrian Gagal Diambil (karena sudah diambil loket lain)
					echo json_encode(0);
				}
			}

		}
	}

	public function selesai(){
		// Rules Form Validation
		$validate = [
			'loketId'		=> [
				'label'	=> 'Loket Id',
				'rules'	=> 'required|is_not_unique[loket.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique' => 'Loket Tidak Ada' 
				]
			],
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			
			// Jika Salah
			echo json_encode(0);
		}else{
			
			// Variabel From Form
			$loketId = $this->request->getPost('loketId');

			// Get Antrian terakhir yang dilayani loket dengan status=1
			$kondisi = [
				'status'	=> 1,
				'loket_id'=> $loketId
			];
			$getAntrianTerakhir = $this->homeProsesModel->select("id")->where($kondisi)->orderBy('id', 'DESC')
			->limit(1)->get()->getRowArray();

			// Update status antrian ke 2 (selesai)
			$updateData = [
				'status'				=> 2,
				'waktu_selesai'	=> date("Y-m-d H:i:s"),
			];
			$kondisiUpdate = ['id'=>$getAntrianTerakhir['id']];
			$query = $this->homeProsesModel->update($kondisiUpdate, $updateData);

			// Cek Eksekusi Query Update Berhasil
			if($query){
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}
	}
}
