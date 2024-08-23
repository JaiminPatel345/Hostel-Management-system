<?php include 'includes/header.php'; ?>

<script type="text/javascript">
	function valid() {
		if (document.registration.password.value != document.registration.cpassword.value) {
			alert("Password and Re-Type Password Field do not match  !!");
			document.registration.cpassword.focus();
			return false;
		}
		return true;
	}
</script>
<div class="ts-main-content">
	<?php include 'includes/sidebar.php'; ?>
	<div class="content-wrapper">
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-12">

					<h1 class="page-title"></h1>
					<h1 class="page-title">User Login </h1>

					<div class="row ">
						<div class="col-md-6 col-md-offset-3">
							<div class="well row pt-2x pb-3x bk-light">
								<div class="col-md-8 col-md-offset-2">

									<form action="" class="mt" method="post">
										<label for="" class="text-uppercase text-sm">Email</label>
										<input type="text" placeholder="Email" name="email" class="form-control mb">
										<label for="" class="text-uppercase text-sm">Password</label>
										<input type="password" placeholder="Password" name="password" class="form-control mb">


										<input type="submit" name="login" class="btn btn-primary btn-block" value="login">
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>