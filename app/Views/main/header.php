<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title;?></title>
	<script src="/assets/jquery.js"></script>
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
	<script src="https://code.responsivevoice.org/responsivevoice.js?key=6UoEN13s"></script>
	<style>
		body {
			padding-top: 4.5rem;
		}
	</style>
</head>
<body class="d-flex flex-column h-100">
	<nav class="navbar navbar-expand-md bg-light fixed-top">
		<div class="container">
			<a class="navbar-brand" href="<?= base_url();?>">Antrian</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item" id="detailAntrian">
							<a class="nav-link" href="/antrian">Detail Antrian</a>
						</li>
						<?php if(session()->login){?>
							<li class="nav-item" id="admin">
								<a class="nav-link" href="/admin">Admin</a>
							</li>
							<li class="nav-item" id="pelayanan">
								<a class="nav-link" href="/admin/pelayanan">Pelayanan</a>
							</li>
							<li class="nav-item" id="loket">
								<a class="nav-link" href="/admin/loket">Loket</a>
							</li>
							<li class="nav-item" id="logout">
								<a class="nav-link" href="/logout">Logout</a>
							</li>
						<?php } ?>
					</ul>
			</div>
		</div>
	</nav>