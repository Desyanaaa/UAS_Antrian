<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

// Load Model
use App\Models\LoketProsesModel;

class LoketProses extends BaseController{

	// Inisialisasi Model Loket dan Pelayanan
	protected $loketProsesModel;
	public function __construct(){
		$this->loketProsesModel = new LoketProsesModel();
	}

	public function tambah(){
		
		// Rules Form Validation
		$validate = [
			'nama'	=> [
				'label'	=> 'Nama',
				'rules'	=> 'required|min_length[5]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal 5 Karakter',
				]
			],
			'keterangan'	=> [
				'label'	=> 'Keterangan',
				'rules'	=> 'required|min_length[10]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal Karakter 10',
				]
			],
			'pelayanan'	=> [
				'label'	=> 'Pelayanan',
				'rules'	=> 'required|numeric|is_not_unique[pelayanan.id]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'numeric'		=> 'Wajib Berisi Angka',
					'is_not_unique' => 'Jenis Pelayanan Tidak Ada'
				]
			]
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			session()->setFlashData('errorForm', '1');
			return redirect()->back()->withInput();
		}else{
			
			// Input Data
			$this->loketProsesModel->insert([
				'nama'		=> $this->request->getPost("nama"),
				'keterangan'=> $this->request->getPost("keterangan"),
				'pelayanan_id'=> $this->request->getPost("pelayanan"),
			]);

			return redirect('admin/loket');
		}
	}

	public function hapus(){
		
		// Deklarasi Validasi
		$validate = [
			'id'	=> [
				'label'	=> 'id',
				'rules'	=> 'required|numeric',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
				]
			]
		];

		// Validasi
		if(!$this->validate($validate)){
			return redirect()->back()->withInput();
		}else{
			$id = $this->request->getPost('id');
			$data = $this->loketProsesModel->where('id', $id)->delete();

			// Cek Data
			if($data){
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}
	}

	public function update(){
		
		// Rules Form Validation
		$validate = [
			'idEdit'		=> [
				'label'	=> 'ID',
				'rules'	=> 'required',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'numeric'	=> 'Harus Angka', 
				]
			],
			'namaEdit'	=> [
				'label'	=> 'Nama',
				'rules'	=> 'required|min_length[5]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal 5 Karakter',
				]
			],
			'keteranganEdit'	=> [
				'label'	=> 'Keterangan',
				'rules'	=> 'required|min_length[10]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal Karakter 10',
				]
			],
			'pelayananEdit'	=> [
				'label'	=> 'Pelayanan',
				'rules'	=> 'required|numeric|is_not_unique[pelayanan.id]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'numeric'		=> 'Wajib Berisi Angka',
					'is_not_unique' => 'Jenis Pelayanan Tidak Ada'
				]
			]
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			session()->setFlashData('errorFormEdit', '1');
			return redirect()->back()->withInput();
		}else{

			// Variabel Form
			$id = $this->request->getPost('idEdit');

			// Data Update Database
			$dataUpdate = [
				'nama'		=> $this->request->getPost("namaEdit"),
				'keterangan'=> $this->request->getPost("keteranganEdit"),
				'pelayanan_id'=> $this->request->getPost("pelayananEdit"),
			];

			// Eksekusi Query ke DB
			$query = $this->loketProsesModel->update($id, $dataUpdate);

			// CEK HASIL Query
			if($query){

				// Berhasil
				echo "<script>alert('Update Berhasil');window.location.href='/admin/loket'</script>";
			}else{

				// Gagal
				echo "<script>alert('Update Gagal');window.location.href='/admin/loket'</script>";
			}

		}
	}
}
