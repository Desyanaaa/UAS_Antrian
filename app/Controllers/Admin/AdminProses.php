<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminProsesModel;

class AdminProses extends BaseController{

	protected $adminProsesModel;
	public function __construct(){
		$this->adminProsesModel = new AdminProsesModel();
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
			'username'	=> [
				'label'	=> 'Username',
				'rules'	=> 'required|alpha|min_length[5]|is_unique[admin.username]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal Karakter 5',
					'alpha'			=> "Hanya Huruf",
					'is_unique'	=> "Username sudah digunakan",
				]
			],
			'password'	=> [
				'label'	=> 'Password',
				'rules'	=> 'required|min_length[8]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal 8 Karakter',
				]
			]
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			session()->setFlashData('errorForm', '1');
			return redirect()->back()->withInput();
		}else{
			$this->adminProsesModel->insert([
				'nama'		=> $this->request->getPost("nama"),
				'username'=> $this->request->getPost("username"),
				'password'=> $this->request->getPost("password"),
			]);

			return redirect('admin');
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
			$data = $this->adminProsesModel->where('id', $id)->delete();

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
			'passwordEdit'	=> [
				'label'	=> 'Password',
				'rules'	=> 'required|min_length[8]',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
					'min_length'=> 'Minimal 8 Karakter',
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
				'password'=> $this->request->getPost("passwordEdit"),
			];

			// Eksekusi Query ke DB
			$query = $this->adminProsesModel->update($id, $dataUpdate);

			// CEK HASIL Query
			if($query){

				// Berhasil
				echo "<script>alert('Update Berhasil');window.location.href='/admin'</script>";
			}else{

				// Gagal
				echo "<script>alert('Update Gagal');window.location.href='/admin'</script>";
			}
		}
	}
}
