<main class="container">
	
	<div class="row mt-2">
			<div class="col-md-12">
				<div class="d-grid gap-2">
					<button type="button" class="btn btn-primary text-white" style="cursor:default">Pelayanan <?= $detailLoket['nama'];?> (<?= $detailLoket['nama_pelayanan'];?>)</button>
				</div>
		</div>
	</div>

	<div class="row mt-4">

		<!-- Tampilan Sedang Dilayani -->
		<div class="col-md-5 mb-4">
			<div class="card text-center">
				<div class="card-header">
					Sedang Dilayani
				</div>
				<div class="card-body">
					<h1 class="card-title"><?= sedangDilayaniLoket(service('uri')->getSegment(4), $detailLoket['kode']);?></h1>
				</div>
			</div>
			<br>
			<?php if(sedangDilayaniLoket(service('uri')->getSegment(4), $detailLoket['kode'])!="Tidak Ada"){?>
				<div class="d-grid gap-2">
					<button type="button" class="btn btn-success text-white" onclick="selesaiLayan(<?= service('uri')->getSegment(4);?>)">Selesai</button>
				</div>
			<?php }?>
		</div>

		<!-- Daftar Antrian Selanjutnya -->
		<div class="col-md-7">
			<div class="d-grid gap-2">
				<button type="button" class="btn btn-warning" style="cursor:default">Daftar Antrian Selanjutnya</button>
			</div>
			<br>
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">Antrian</th>
						<th scope="col">Panggil</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($antrian->getResultArray() as $row){?> 
						<tr>
							<th scope="row"><?= $row['kode'];?>-<?= $row['no_antrian'];?></th>
							<td>
								<?php if($row['status']==0){?>
									<button type="button" class="btn btn-primary btn-sm" onclick="panggilAntrian(<?= $row['id'];?>, <?= service('uri')->getSegment(4);?>, '<?= $row['kode'];?>-<?= $row['no_antrian'];?>')">Panggil</button>
								<?php }else{?>
									<button type="button" class="btn btn-warning btn-sm" onclick="panggilLagi(<?= $row['id'];?>, '<?= $row['kode'];?>-<?= $row['no_antrian'];?>')">Panggil Lagi</button>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

</main>

<script>
	var base_url = "<?= base_url();?>";

	// Untuk Voice

	// Memanggil nomor antrian baru
	function panggilAntrian(id, loketId, noAntrian) {
		$.ajax({
			url: base_url+"/admin/antrian/panggil-antrian",
			type: "POST",
			data: {
				id: id,
				loketId: loketId,
			},
			success:function(kembali){
				if(kembali==1){
					Swal.fire({
						icon: 'success',
						title: `Berhasil`,
						text: `Panggilan Nomor Antrian ${noAntrian}`
					});
					// Voice
					responsiveVoice.speak(`Panggilan Kepada Nomor Antrian ${noAntrian}`, "Indonesian Male");
					setTimeout( function(){ window.location.reload(); }, 4000);
				}else{
					Swal.fire({
						icon: 'warning',
						title: 'Gagal Memanggil'
					});
				}
			}
		});
	}

	// Memanggil Lagi Nomor Antrian yang sedang dilayani
	function panggilLagi(id, noAntrian) {
		Swal.fire({
			icon: 'success',
			title: `Panggilan Nomor Antrian ${noAntrian}`
		});

		// Voice
		responsiveVoice.speak(`Panggilan Kepada Nomor Antrian ${noAntrian}`, "Indonesian Male");
	}

	function selesaiLayan(loketId) {
		Swal.fire({
			title: `Pelayanan Loket Selesai?`,
			showDenyButton: true,
			confirmButtonText: `Iya`,
			denyButtonText: `Batal`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+`/admin/antrian/panggil/selesai`,
					type: "POST",
					data: {
						loketId: loketId
					},
					success:function(kembali){
						if(kembali==1){
							Swal.fire({
								icon: 'success',
								title: 'Berhasil'
							});
							setTimeout( function(){ window.location.reload(); }, 600);
						}else{
							Swal.fire({
								icon: 'warning',
								title: 'Gagal'
							});
						}
					}
				});
			}
		})
	}
</script>