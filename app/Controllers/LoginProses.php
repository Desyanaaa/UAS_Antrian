<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginProsesModel;

class LoginProses extends BaseController{
	
	protected $loginProsesModel;
	public function __construct(){
		$this->loginProsesModel = new LoginProsesModel();
	}

	public function login(){
		
		// Rules Form Validation
		$validate = [
			'username'		=> [
				'label'	=> 'Username',
				'rules'	=> 'required|is_not_unique[admin.username]',
				'errors'=> [
					'required'			=> 'Kolom Wajib Diisi',
					'is_not_unique'	=> 'Username Tidak Ada'
				]
			],
			'password'	=> [
				'label'	=> 'Password',
				'rules'	=> 'required',
				'errors'=> [
					'required'	=> 'Kolom Wajib Diisi',
				]
			]
		];

		// Cek Validasi
		if(!$this->validate($validate)){
			return redirect()->back()->withInput();
		}else{

			// Variabel Form
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			// Cek Password Benar
			$kondisi = [
				'username'	=> $username,
				'password'	=> $password
			];
			$query = $this->loginProsesModel->select('*')->where($kondisi)->get();
			if($query->getNumRows()<1){

				// Jika Password Salah
				session()->setFlashData('passwordSalah', 'Password Salah');
				return redirect()->back()->withInput();
			}else{

				// Jika Username & Password Benar

				// Set Session
				$detailUser = $query->getRowArray();
				session()->set([
					'id'		=> $detailUser['id'],
					'nama'	=> $detailUser['nama'],
					'username' => $detailUser['username'],
					'login'	=> True
				]);

				return redirect()->to('/');
			}
		}
	}

	public function logout(){
		session()->destroy();
		return redirect()->to('/login');
	}
}
