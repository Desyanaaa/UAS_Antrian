<main class="container">
	<div class="row mt-2">
		<div class="col-md-12 mb-2">
			<button type="button" style="float:right;" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Admin</button>
		</div>
		<div class="col-md-12">
			<div style="overflow-x:auto;">
				<table class="table table-hover" id="tableAdmin">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Username</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($admin as $row){?>
							<tr>
								<th scope="row"><?= $no++;?></th>
								<td><?= $row['nama'];?></td>
								<td><?= $row['username'];?></td>
								<td><button type="button" class="btn btn-outline-danger" onclick="hapusAdmin(<?= $row['id'];?>)">Hapus</button> <button type="button" class="btn btn-outline-warning" onclick="editAdmin(<?= $row['id'];?>, '<?= $row['nama'];?>', '<?= $row['password'];?>')">Edit</button></td>
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
				<h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?= form_open('/admin/tambah', 'autocomplate="off"'); ?>
				<div class="modal-body">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('nama');?></span>
					</div>
					<div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" class="form-control" id="username" name="username" value="<?= old('username');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('username');?></span>
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" class="form-control" id="password" name="password" value="<?= old('password');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('password');?></span>
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
				<h5 class="modal-title" id="exampleModalLabel">Edit Admin <label id="titleEdit"></label></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?= form_open('/admin/update', 'autocomplate="off"'); ?>
				<div class="modal-body">
					<input type="hidden" id="idEdit" name="idEdit" required>
					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" class="form-control" id="namaEdit" name="namaEdit" value="<?= old('namEdit');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('namaEdit');?></span>
					</div>
					<div class="mb-3">
						<label for="passwordEdit" class="form-label">Password</label>
						<input type="text" class="form-control" id="passwordEdit" name="passwordEdit" value="<?= old('passwordEdit');?>" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('passwordEdit');?></span>
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
		// Membuat Table Menjadi Datatable
		$('#tableAdmin').DataTable();

		// Jika Form Tambah Terdapat Error
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

	function hapusAdmin(id){
		Swal.fire({
			title: `Hapus Admin?`,
			text: `Admin akan terhapus permanent`,
			showDenyButton: true,
			confirmButtonText: `Hapus`,
			denyButtonText: `Batal`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+`/admin/hapus/`,
					type: "POST",
					data: {
						id:id
					},
					success:function(kembali){
						if(kembali==1){
							Swal.fire({
								icon: 'success',
								title: 'User Berhasil Dihapus'
							});
							setTimeout( function(){ window.location.reload(); }, 600);
						}else{
							Swal.fire({
								icon: 'warning',
								title: 'User Gagal Dihapus'
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

	function editAdmin(id, nama, password){
		$('#idEdit').val(id);
		$('#namaEdit').val(nama);
		$('#passwordEdit').val(password);
		$('#titleEdit').html(nama);
		$('#modalEdit').modal('show');
	}
</script>