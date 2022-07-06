<main class="container">
	<div class="row mt-2">
		<div class="col-md-12 mb-2">
			<button type="button" style="float:right;" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Loket</button>
		</div>
		<div class="col-md-12">
			<div style="overflow-x:auto;">
				<table class="table table-hover" id="tableLoket">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Pelayanan</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($loket as $row){?>
							<tr>
								<th scope="row"><?= $no++;?></th>
								<td><a href="/admin/antrian/panggil/<?= $row['id'];?>"><?= $row['nama'];?></a></td>
								<td><?= $row['keterangan'];?></td>
								<td><?= $row['nama_pelayanan'];?></td>
								<td><button type="button" class="btn btn-outline-danger" onclick="hapusLoket(<?= $row['id'];?>, '<?= $row['nama'];?>')">Hapus</button> <button type="button" class="btn btn-outline-warning" onclick="editLoket(<?= $row['id'];?>, '<?= $row['nama'];?>', '<?= $row['keterangan'];?>', <?= $row['pelayanan_id'];?>)">Edit</button></td>
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
				<h5 class="modal-title" id="exampleModalLabel">Tambah Loket</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?= form_open('/admin/loket/tambah', 'autocomplate="off"'); ?>
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
						<label for="pelayanan" class="form-label">Pelayanan</label>
						<select class="form-select" aria-label="pelayanan" name="pelayanan" id="pelayanan" required>
							<option value="">~~~Pilih Pelayanan~~~</option>
							<?php foreach($pelayanan as $row){?>
								<option value="<?= $row['id'];?>"><?= $row['nama'];?></option>
							<?php } ?>
						</select>
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
				<h5 class="modal-title" id="exampleModalLabel">Edit Loket <label id="titleEdit"></label></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?= form_open('/admin/loket/update', 'autocomplate="off"'); ?>
			<div class="modal-body">
				<input type="hidden" name="idEdit" id="idEdit" required>
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
					<div class="mb-3">
						<label for="pelayanan" class="form-label">Pelayanan</label>
						<select class="form-select" aria-label="pelayanan" name="pelayananEdit" id="pelayananEdit" required>
							<option value="">~~~Pilih Pelayanan~~~</option>
							<?php foreach($pelayanan as $row){?>
								<option value="<?= $row['id'];?>"><?= $row['nama'];?></option>
							<?php } ?>
						</select>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('pelayananEdit');?></span>
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
		$('#tableLoket').DataTable();

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

	function hapusLoket(id, loket){
		Swal.fire({
			title: `Hapus Loket?`,
			text: `Loket ${loket} akan terhapus permanent`,
			showDenyButton: true,
			confirmButtonText: `Hapus`,
			denyButtonText: `Batal`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+`/admin/loket/hapus/`,
					type: "POST",
					data: {
						id:id
					},
					success:function(kembali){
						if(kembali==1){
							Swal.fire({
								icon: 'success',
								title: 'Loket Berhasil Dihapus'
							});
							setTimeout( function(){ window.location.reload(); }, 600);
						}else{
							Swal.fire({
								icon: 'warning',
								title: 'Loket Gagal Dihapus'
							});
							setTimeout( function(){ window.location.reload(); }, 600);
						}
					}
				});
			} else if (result.isDenied) {
				Swal.fire('Batal', 'Data Tidak Terhapus', 'info');
			}
		});
	}

	function editLoket(id, nama, keterangan, pelayanan){
		$('#idEdit').val(id);
		$('#namaEdit').val(nama);
		$('#keteranganEdit').val(keterangan);
		$('#pelayananEdit').val(pelayanan)
		$('#titleEdit').html(nama);
		$('#modalEdit').modal('show');
	}
</script>