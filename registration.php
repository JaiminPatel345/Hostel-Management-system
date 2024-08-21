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
</head>

<body>

	<div class="ts-main-content">
		<?php include 'includes/sidebar.php'; ?>
		<div class="content-wrapper">
			<div class="container-fluid ">

				<div class="row mt-5 ml-10 ">
					<div class="col-md-12 ">

						<h2 class="page-title">Student Registration </h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">Fill all Info</div>
									<div class="panel-body">
										<form method="post" action="" name="registration" class="form-horizontal" onSubmit="return valid();">



											<div class="form-group">
												<label class="col-sm-2 control-label" for="name"> Full Name </label>
												<div class="col-sm-8">
													<input type="text" name="full-name" id="full-name" class="form-control" placeholder="YourName FatherName Surname" required="required">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="contact">Contact No </label>
												<div class="col-sm-8">
													<input type="text" name="contact" id="contact" class="form-control" placeholder="Do not add +91" required="required">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="Parents-contact"> Parents Contact No </label>

												<div class="col-sm-8">
													<input type="text" name="Parents-contact" id="Parents-contact" class="form-control" required="required">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="email">Email Id </label>
												<div class="col-sm-8">
													<input type="email" name="email" id="email" class="form-control" onBlur="checkAvailability()" required="required">
													<span id="user-availability-status" style="font-size:12px;"></span>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="password">Password </label>
												<div class="col-sm-8">
													<input type="password" name="password" id="password" class="form-control" required="required">
												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-2 control-label" for="confirm-password">Confirm Password </label>
												<div class="col-sm-8">
													<input type="password" name="confirm-password" id="confirm-password" class="form-control" required="required">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="bday" for="bday">Birthday Date </label>
												<div class="col-sm-8">
													<input type="date" name="bday" id="bday" class="form-control" required="required">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="hobbies" for="bday">Hobbies </label>
												<div class="col-sm-8">
													<textarea name="hobbies" class="form-control" required="required" id="hobbies" placeholder="Chess , Swimming"></textarea>

												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="hobbies" for="bday">Extra skill other than school/college learning</label>
												<div class="col-sm-8">
													<textarea name="skills" class="form-control" required="required" id="skills" placeholder=" Musical instrument, Cooking, Software, GK, English, Acting, experience of professional work for any type of work" rows="5"></textarea>

												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="english" for="skills">Your English Proficiency
												</label>
												<div class="col-sm-8">
													<input type="radio" name="english" id="english1" class="form-control-input" value="Beginner">
													<label for="english1">Beginner</label>

													<input type="radio" name="english" id="english2" class="form-control-input" value="Intermediate">
													<label for="english2">Intermediate</label>

													<input type="radio" name="english" id="english3" class="form-control-input" value="Advance">
													<label for="english3">Advance</label>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="blood-group" for="skills">Blood Group
												</label>
												<div class="col-sm-8">
													<select name="blood-group" id="blood-group" class="form-control">
														<option value="">Select Blood Group</option>
														<option value="A+">A+</option>
														<option value="A-">A-</option>
														<option value="B+">B+</option>
														<option value="B-">B-</option>
														<option value="AB+">AB+</option>
														<option value="AB-">AB-</option>
														<option value="O+">O+</option>
														<option value="O-">O-</option>
													</select>
												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-2 control-label" for="mediclaim">Have you any Mediclaim from your home ? </label>
												<div class="col-sm-8">
													<input type="radio" name="mediclaim" id="mediclaim1" class="form-control-input" value="Yes">
													<label for="mediclaim1">Yes</label>

													<input type="radio" name="mediclaim" id="mediclaim2" class="form-control-input" value="No">
													<label for="mediclaim2">No</label>
													<input type="radio" name="mediclaim" id="mediclaim3" class="form-control-input" value="Not Sure">
													<label for="mediclaim3">Not Sure</label>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="college-name"> College Name </label>
												<div class="col-sm-8">
													<input type="text" name="college-name" id="college-name" class="form-control" required="required">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label" for="study"> Study With Year </label>
												<div class="col-sm-8">
													<input type="text" name="study" id="study" class="form-control" placeholder=" 3rd Year, Computer  Engineering" required="required">
												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-2 control-label" for="10th-percentage">10th Percentage </label>
												<div class="col-sm-8">
													<input type="text" name="10th-percentage" id="10th-percentage" class="form-control" placeholder="85%" required="required">
												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-2 control-label" for="12th-percentage">12th Percentage </label>
												<div class="col-sm-8">
													<input type="text" name="12th-percentage" id="12th-percentage" class="form-control" placeholder="90%" required="required">
												</div>
											</div>



											<div class="form-group">
												<label class="col-sm-2 control-label" for="hobbies" for="bachelor-spi">SPI of Bachelor in all semester </label>
												<div class="col-sm-8">
													<textarea name="bachelor-spi" class="form-control" required="required" id="bachelor-spi" placeholder="sem 1 : 9.00
sem 2 : 9.20
sem 3 : 9.99" rows="7"></textarea>

												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-2 control-label" for="hobbies" for="master-spi">SPI of Master in all semester (If applicable) </label>
												<div class="col-sm-8">
													<textarea name="master-spi" class="form-control" required="required" id="master-spi" placeholder="sem 1 : 9.00
sem 2 : 9.20
sem 3 : 9.99" rows="7"></textarea>

												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-2 control-label" for="photo">Passport Size Photo </label>
												<div class="col-sm-8">
													<input type="file" name="photo" id="photo" class="form-control" required="required">
													<p>
														( <b><u>Warning</u></b> : Make it clear)
													</p>
													<p>
														<b>Maximum size: 1 mb</b>
													</p>
													<p>
														<b>No PDF, ONLY PNG/JPEG/JPG</b>
													</p>
												</div>
											</div>





											<div class="col-sm-6 col-sm-offset-4">
												<input type="submit" name="submit" Value="Register" class="btn btn-primary">
											</div>
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