<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

// Load Model
use App\Models\PelayananProsesModel;

class PelayananProses extends BaseController{

	// Inisialisasi Model
	protected $pelayananProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
	}
	
	// Tambah Pelayanan
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
					'min_length'=> 'Minimal 10 Karakter',
				]
			],
			'kode'	=> [
				'label'	=> 'Kode',
				'rules'	=> 'required|min_length[2]|is_unique[pelayanan.kode]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal 2 Karakter',
					'is_unique'	=> 'Kode Sudah Digunakan',
				]
			]
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			session()->setFlashData('errorForm', '1');
			return redirect()->back()->withInput();
		}else{
			$this->pelayananProsesModel->insert([
				'nama'			=> $this->request->getPost("nama"),
				'keterangan'=> $this->request->getPost("keterangan"),
				'kode'			=> $this->request->getPost("kode"),
			]);

			return redirect('admin/pelayanan');
		}
	}

	// Hapus Pelayanan
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
			$data = $this->pelayananProsesModel->where('id', $id)->delete();

			// Cek Data
			if($data){
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}
	}

	// Update Pelayanan
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
					'min_length'=> 'Minimal 10 Karakter',
				]
			],
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
			];

			// Eksekusi Query ke DB
			$query = $this->pelayananProsesModel->update($id, $dataUpdate);

			// CEK HASIL Query
			if($query){

				// Berhasil
				echo "<script>alert('Update Berhasil');window.location.href='/admin/pelayanan'</script>";
			}else{

				// Gagal
				echo "<script>alert('Update Gagal');window.location.href='/admin/pelayanan'</script>";
			}
		}
	}
}
