<?php
include 'includes/header.php';

$mysqli = new mysqli('localhost', 'root', '', 'hostel');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Connected successfully"; // Check if this message appears
}

function validatePassword($pass)
{
    return strlen($pass) >= 8;
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validateMobileNumber($mobile)
{
    return preg_match('/^[0-9]{10}$/', $mobile) === 1;
}

function checkStudentExistence($mysqli, $email, $mobile)
{
    $stmt = $mysqli->prepare("SELECT email, contact_no FROM users WHERE email = ? OR contact_no = ?");
    $stmt->bind_param("ss", $email, $mobile);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count === 0;
}

function checkStudentExistenceName($mysqli, $fullname)
{
    $stmt = $mysqli->prepare("SELECT full_name FROM users WHERE full_name = ?");
    $stmt->bind_param("s", $fullname);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count === 0;
}

function register($mysqli, $fullname, $mobile, $parentmob, $email, $password, $dob, $hobbies, $skills, $english, $blood_group, $mediclaim, $college, $field, $per_10, $per_12, $diploma, $bachelor, $master, $image)
{
    $hashpass = password_hash($password, PASSWORD_DEFAULT);
    $targetDir = "img/user_photo/";
    $imageName = basename($image['name']);
    $targetFile = $targetDir . $imageName;

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($image['type'], $allowedTypes) || $image['size'] > 1048576) {
        echo "<script>alert('Invalid image type or size. Only JPEG/PNG/JPG under 1MB allowed.');</script>";
        return;
    }

    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        $stmt = $mysqli->prepare("INSERT INTO users (full_name, contact_no, parent_no, email, password, dob, hobbies, skills, English, blood_group, mediclaim, college, field, per_10, per_12, diploma, bachelor, master, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        if (!$stmt->bind_param("sssssssssssssssssss", $fullname, $mobile, $parentmob, $email, $hashpass, $dob, $hobbies, $skills, $english, $blood_group, $mediclaim, $college, $field, $per_10, $per_12, $diploma, $bachelor, $master, $imageName)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            exit;
        }

        if ($stmt->execute()) {
            echo "<script>
                swal({
                    title: 'Registered',
                    text: 'You have successfully registered!',
                    icon: 'success'
                }).then((result) => {
                    if (result) {
                        window.location.href = 'index.php';
                    }
                });
            </script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error uploading image.')</script>";
    }
}

if (isset($_POST['verify'])) {
    $fullname = isset($_POST['full-name']) ? trim($_POST['full-name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mobile = isset($_POST['contact']) ? trim($_POST['contact']) : '';
    $parent_mobile = isset($_POST['Parents-contact']) ? trim($_POST['Parents-contact']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $cPassword = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';
    $dob = isset($_POST['bday']) ? $_POST['bday'] : '';
    $hobbies = isset($_POST['hobbies']) ? $_POST['hobbies'] : '';
    $skills = isset($_POST['skills']) ? $_POST['skills'] : '';
    $english = isset($_POST['english']) ? $_POST['english'] : '';
    $blood_group = isset($_POST['blood-group']) ? $_POST['blood-group'] : '';
    $mediclaim = isset($_POST['mediclaim']) ? $_POST['mediclaim'] : '';
    $college_name = isset($_POST['college-name']) ? $_POST['college-name'] : '';
    $field = isset($_POST['study']) ? $_POST['study'] : '';
    $per_10 = isset($_POST['10th-percentage']) ? $_POST['10th-percentage'] : '';
    $per_12 = isset($_POST['12th-percentage']) ? $_POST['12th-percentage'] : '';
    $diploma = isset($_POST['Dsem']) ? $_POST['Dsem'] : '';
    $bachelor = isset($_POST['Bsem']) ? $_POST['Bsem'] : '';
    $master = isset($_POST['Msem']) ? $_POST['Msem'] : '';

	if (empty($email) || empty($mobile) || empty($parent_mobile) || empty($cPassword) || empty($password)) {
		echo "<script>Swal.fire({
			title: 'Error',
			text: 'Please fill out all required fields.',
			icon: 'error',
			confirmButtonText: 'OK'
		});</script>";
	} elseif (!validateEmail($email)) {
		echo "<script>Swal.fire({
			title: 'Error',
			text: 'Email is invalid.',
			icon: 'error',
			confirmButtonText: 'OK'
		});</script>";
	} elseif (!validateMobileNumber($mobile)) {
		echo "<script>Swal.fire({
			title: 'Error',
			text: 'Mobile number is not valid.',
			icon: 'error',
			confirmButtonText: 'OK'
		});</script>";
	} elseif (!validatePassword($password)) {
		echo "<script>Swal.fire({
			title: 'Error',
			text: 'Password criteria does not match. It should contain at least:\n1 Uppercase letter\n1 Special Character\nMinimum 8 characters.',
			icon: 'error',
			confirmButtonText: 'OK'
		});</script>";
	} elseif (strcasecmp($password, $cPassword) !== 0) {
		echo "<script>Swal.fire({
			title: 'Error',
			text: 'Password and confirm password do not match.',
			icon: 'error',
			confirmButtonText: 'OK'
		});</script>";
	} elseif (!checkStudentExistence($mysqli, $email, $mobile)) {
		echo "<script>Swal.fire({
			title: 'Warning',
			text: 'Email or Mobile number is already registered.',
			icon: 'warning',
			confirmButtonText: 'OK'
		});</script>";
	} elseif (!checkStudentExistenceName($mysqli, $fullname)) {
		echo "<script>Swal.fire({
			title: 'Warning',
			text: 'Name is already registered.',
			icon: 'warning',
			confirmButtonText: 'OK'
		});</script>";
	} else {
		if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
			register($mysqli, $fullname, $mobile, $parent_mobile, $email, $password, $dob, $hobbies, $skills, $english, $blood_group, $mediclaim, $college_name, $field, $per_10, $per_12, $diploma, $bachelor, $master, $_FILES['photo']);
			echo "<script>Swal.fire({
				title: 'Success!',
				text: 'You have successfully registered!',
				icon: 'success',
				confirmButtonText: 'OK'
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = 'index.php';
				}
			});</script>";
		} else {
			echo "<script>Swal.fire({
				title: 'Error',
				text: 'Image upload failed.',
				icon: 'error',
				confirmButtonText: 'OK'
			});</script>";
		}
	}
	
	
}

$mysqli->close();
?>


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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdn.tailwindcss.com"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
										<form method="post" enctype="multipart/form-data" action="" name="registration" class="form-horizontal">



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
												<label class="col-sm-2 control-label" for="skills" for="bday">Extra skill other than school/college learning</label>
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
												<label class="col-sm-2 control-label" for="Dsem"> How Many semesters of Diploma do you complete ? </label>
												<div class="col-sm-8">
													<input type="number" name="Dsem" id="Dsem" placeholder="leave blank if Not applicable">
												</div>
											</div>

											<div id="diploma-container" class="form-group"></div>



											<div class="form-group">
												<label class="col-sm-2 control-label" for="Bsem"> How Many semesters of Bachelor's do you complete ? </label>
												<div class="col-sm-8">
													<input type="number" name="Bsem" id="Bsem" placeholder="leave blank if Not applicable">
												</div>
											</div>

											<div id="bachelor-container" class="form-group"></div>



											<div class="form-group">
												<label class="col-sm-2 control-label" for="Msem"> How Many semesters of Master's do you complete ? </label>
												<div class="col-sm-8">
													<input type="number" name="Msem" id="Msem" placeholder="leave blank if Not applicable">
												</div>
											</div>

											<div id="master-container" class="form-group"></div>



											<!-- <div class="form-group">
												<label class="col-sm-2 control-label" for="bachelor-spi" for="bachelor-spi">SPI of Bachelor/Diploma in all semester </label>
												<div class="col-sm-8">
													<textarea name="bachelor-spi" class="form-control" required="required" id="bachelor-spi" placeholder="sem 1 : 9.00
sem 2 : 9.20
sem 3 : 9.99" rows="7"></textarea>

												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-2 control-label" for="master-spi" for="master-spi">SPI of Master in all semester (If applicable) </label>
												<div class="col-sm-8">
													<textarea name="master-spi" class="form-control" required="required" id="master-spi" placeholder="sem 1 : 9.00
sem 2 : 9.20
sem 3 : 9.99" rows="7"></textarea>

												</div>
											</div> -->


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
												<input type="submit" name="verify" Value="Register" class="btn btn-primary">
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
	</html>

	<script>
		//Diploma
		const Dsem = document.getElementById("Dsem");
		const Dcontainer = document.getElementById("diploma-container");
		Dsem.addEventListener("input", () => {
			const n = parseInt(Dsem.value);
			makeTextFides(n, "diploma-sem-", Dcontainer, "Diploma");
		})

		//Bachelor
		const Bsem = document.getElementById("Bsem");
		const Bcontainer = document.getElementById("bachelor-container");
		Bsem.addEventListener("input", () => {
			const n = parseInt(Bsem.value);
			makeTextFides(n, "diploma-sem-", Bcontainer, "Bachelor");
		})

		//Master
		const Msem = document.getElementById("Msem");
		const Mcontainer = document.getElementById("master-container");
		Msem.addEventListener("input", () => {
			const n = parseInt(Msem.value);
			makeTextFides(n, "diploma-sem-", Mcontainer, "Master");
		})

		function makeTextFides(n, name, container, print) {
			container.innerHTML = '';
			for (let i = 0; i < n; i++) {
				let div = document.createElement("div");
				div.className = "form-group"


				let label = document.createElement('label');
				label.className = 'col-sm-2 control-label';
				label.for = name + i;
				label.textContent = `${print} sem ${parseInt(i) + 1} SPI`;
				div.appendChild(label);

				let innerDiv = document.createElement("div");
				innerDiv.className = "col-sm-8";

				let input = document.createElement('input');
				input.type = 'text';
				input.name = name + i;
				input.id = name + i;
				input.className = 'form-control';
				input.placeholder = `9.00`;
				innerDiv.appendChild(input);
				div.appendChild(innerDiv);
				container.appendChild(div);

			}
		}
	</script>

	<?php include 'includes/footer.php'; ?>