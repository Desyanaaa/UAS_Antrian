<main class="container">
	<!-- Nomor Antrian Sekarang & Video -->
	<div class="row mt-2">
		<div class="col-md-5">
			<div class="card text-center">
				<div class="card-header">
					Panggilan Antrian
				</div>
				<div class="card-body">
					<h1 class="card-title"><?= ($panggilTerakhir->getNumRows()<1)?"Tidak Ada":$panggilTerakhir->getRowArray()['kode']."-".$panggilTerakhir->getRowArray()['no_antrian'];?></h1>
				</div>
				<!-- Cek Ada Panggilan Terakhir -->
				<?php if($panggilTerakhir->getNumRows()>0){?>
					<div class="card-footer text-muted">
						<?= $panggilTerakhir->getRowArray()['nama_loket'];?>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="col-md-7">
			<div class="card text-center">
				<div class="card-body">
					<iframe width="550" height="275" src="https://www.youtube.com/embed/yw6i1SAHetc?autoplay=1"  allow="autoplay" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
	<!-- END Nomor Antrian Sekarang & Video -->

	<!-- Daftar Loket & Nomor Antrian Aktif -->
	<div class="row mt-2">
		<?php foreach ($detailLoket as $row) {?>
			<div class="col-md-3 col-xs-6">
				<div class="card text-center">
					<div class="card-body">
						<h1 class="card-title"><?= sedangDilayaniLoket($row['id'], $row['kode']);?></h1>
					</div>
					<div class="card-footer text-muted">
						<?= $row['nama'];?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<!-- END Daftar Loket & Nomor Antrian Aktif -->

</main>