<main class="container">
	<div class="row mt-2">
		<div class="col-md-12 mb-2">
			<button type="button" style="float:right;" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Pelayanan</button>
		</div>
		<div class="col-md-12">
			<div style="overflow-x:auto;">
				<table class="table table-hover" id="tablePelayanan">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Kode</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($pelayanan as $row){?>
							<tr>
								<th scope="row"><?= $no++;?></th>
								<td><?= $row['nama'];?></td>
								<td><?= $row['keterangan'];?></td>
								<td><?= $row['kode'];?></td>
								<td><button type="button" class="btn btn-outline-danger" onclick="hapusPelayanan(<?= $row['id'];?>, '<?= $row['nama'];?>')">Hapus</button> <button type="button" class="btn btn-outline-warning" onclick="editPelayanan(<?= $row['id'];?>, '<?= $row['nama'];?>', '<?= $row['keterangan'];?>', '<?= $row['kode'];?>')">Edit</button></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</main>


<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Pelayanan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?= form_open('/admin/pelayanan/tambah', 'autocomplate="off"'); ?>
				<div class="modal-body">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('nama');?></span>
					</div>
					<div class="mb-3">
						<label for="keterangan" class="form-label">Keterangan</label>
						<input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= old('keterangan');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('keterangan');?></span>
					</div>
					<div class="mb-3">
						<label for="kode" class="form-label">Kode</label>
						<input type="text" class="form-control" id="kode" name="kode" value="<?= old('kode');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('kode');?></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-danger">Reset</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			<?= form_close();?>
		</div>
	</div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Pelayanan <label id="titleEdit"></label></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?= form_open('/admin/pelayanan/update', 'autocomplate="off"'); ?>
				<input type="hidden" id="idEdit" name="idEdit" required>
				<div class="modal-body">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" class="form-control" id="namaEdit" name="namaEdit" value="<?= old('namaEdit');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('namaEdit');?></span>
					</div>
					<div class="mb-3">
						<label for="keterangan" class="form-label">Keterangan</label>
						<input type="text" class="form-control" id="keteranganEdit" name="keteranganEdit" value="<?= old('keteranganEdit');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('keteranganEdit');?></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-danger">Reset</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			<?= form_close();?>
		</div>
	</div>
</div>


<!-- Script -->
<script>
	var base_url  = "<?= base_url();?>";
	var errorForm = "<?= session()->getFlashdata('errorForm');?>";
	var errorFormEdit = "<?= session()->getFlashdata('errorFormEdit');?>";


	$(document).ready(function(){

		$('#pelayanan').addClass('active');

		// Membuat DataTable
		$('#tablePelayanan').DataTable();

		// Jika Form Terdapat Error
		if(errorForm){
			$('#modalTambah').modal('show');
			Swal.fire(
				'Gagal',
				'Data Gagal Ditambahkan',
				'warning'
			)
		}

		// Jika Form Edit Terdapat Error
		if(errorFormEdit){
			$('#modalEdit').modal('show');

			Swal.fire(
				'Gagal',
				'Data Gagal Diupdate',
				'warning'
			)
		}
	});

	function hapusPelayanan(id, pelayanan){
		Swal.fire({
			title: `Hapus Pelayanan?`,
			text: `Pelayanan ${pelayanan} akan terhapus permanent`,
			showDenyButton: true,
			confirmButtonText: `Hapus`,
			denyButtonText: `Batal`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+`/admin/pelayanan/hapus/`,
					type: "POST",
					data: {
						id:id
					},
					success:function(kembali){
						if(kembali==1){
							Swal.fire({
								icon: 'success',
								title: 'Pelayanan Berhasil Dihapus'
							});
							setTimeout( function(){ window.location.reload(); }, 600);
						}else{
							Swal.fire({
								icon: 'warning',
								title: 'Pelayanan Gagal Dihapus'
							});
							setTimeout( function(){ window.location.reload(); }, 600);
						}
					}
				});
			} else if (result.isDenied) {
				Swal.fire('Batal', 'Data Tidak Terhapus', 'info');
			}
		})
	}

	function editPelayanan(id, nama, keterangan, kode){
		$('#idEdit').val(id);
		$('#namaEdit').val(nama);
		$('#keteranganEdit').val(keterangan);
		$('#kodeEdit').val(kode);
		$('#titleEdit').html(nama);
		$('#modalEdit').modal('show');
	}
</script>