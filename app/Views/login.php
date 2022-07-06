<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title;?></title>
	<script src="/assets/jquery.js"></script>
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<script src="/assets/js/bootstrap.min.js"></script>
	<style>
		html,
		body {
			height: 100%;
		}

		body {
			display: flex;
			align-items: center;
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
		}

		.form-signin {
			width: 100%;
			max-width: 330px;
			padding: 15px;
			margin: auto;
		}

		.form-signin .checkbox {
			font-weight: 400;
		}

		.form-signin .form-floating:focus-within {
			z-index: 2;
		}

		.form-signin input[type="email"] {
			margin-bottom: -1px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}

		.form-signin input[type="password"] {
			margin-bottom: 10px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
	</style>
</head>
<body class="text-center">
	<main class="form-signin">
		<?= form_open('/login/proses', 'autocomplate="off"'); ?>
			<h1 class="h3 mb-3 fw-normal">Silahkan Login</h1>
			<div class="form-floating">
				<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= old('username');?>" required>
				<label for="user">User</label>
				<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('username');?></span>
			</div>
			<br>
			<div class="form-floating">
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?= old('password');?>" required>
				<label for="password">Password</label>
				<span class="form-text" style="color:#e74c3c;"><?= session()->getFlashdata('passwordSalah');?></span>
			</div>
			<br>
			<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
		<?= form_close();?>
	</main>
</body>
</html>