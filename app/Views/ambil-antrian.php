<main class="container">
	<div class="row mt-2">
		<div class="col-md-12">
			<h2 style="text-align:center">Menu Antrian</h2>
		</div>
	</div>
	<div class="row">
		<?php foreach ($pelayanan as $row) {?>
			<div class="col-md-6 col-xs-12 mb-2">
				<div class="card text-center">
					<div class="card-header">
						<?= $row['nama'];?>
					</div>
					<div class="card-body">
						<button onclick="ambilAntrian(<?= $row['id'];?>)" class="btn btn-primary">Ambil Antrian</button>
						<p class="card-text"><?= $row['keterangan'];?></p>
					</div>
					<div class="card-footer text-muted">
						<?= getAntrianDepan($row['id']);?> Antrian
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</main>

<script>
	var base_url = "<?= base_url();?>";

	function ambilAntrian(id){
		$.ajax({
			url: base_url+`/ambil-antrian`,
			type: "POST",
			data: {
				id:id
			},
			success:function(kembali){
				var responseData = $.parseJSON(kembali);
				if(responseData.status=='1'){
					Swal.fire({
						icon: 'success',
						title: `Nomor Antrian anda adalah ${responseData.noAntrian}`
					});
					setTimeout( function(){ window.location.reload(); }, 1000);
				}else{
					Swal.fire({
						icon: 'warning',
						title: `Antrian gagal, silahkan ambil lagi`
					});
					setTimeout( function(){ window.location.reload(); }, 1000);
				}
			}
		});
	}
</script>