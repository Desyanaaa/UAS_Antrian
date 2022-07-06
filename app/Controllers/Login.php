<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController{

	public function index(){
		$data['title'] = "Login";
		$data['validation'] = $this->validation;
		echo view('login', $data);
	}
}
