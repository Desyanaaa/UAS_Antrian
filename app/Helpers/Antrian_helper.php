<?php
	// Load Model
	$GLOBALS['baseModel'] = new \App\Models\HomeProsesModel;


	// Total Antrian yang menunggu setiap layanan
	function getAntrianDepan($id){
		$kondisi = [
			'status'  => 0,
			'pelayanan_id' => $id
		];
		$tanggalSekarang = date("Y-m-d");

		return $GLOBALS['baseModel']->select('COUNT(id) as jumlah')->where($kondisi)->like('tanggal', $tanggalSekarang)->get()->getRowArray()['jumlah'];
	}

	// Melihat loket sedang melayani antrian nomor berapa
	function sedangDilayaniLoket($loketId, $kode){
		$kondisi = [
			'status'  => 1,
			'loket_id'=> $loketId
		];

		$antrian = $GLOBALS['baseModel']->select('no_antrian')->where($kondisi)->orderBY('id', 'DESC')->limit(1)->get();
		if($antrian->getNumRows()<1){
			return "Tidak Ada";
		}else{
			$antrian = $antrian->getRowArray();
			return $kode."-".$antrian['no_antrian'];
		}
	}