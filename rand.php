<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$mysqli = mysqli_connect('localhost', 'root', '', 'hostel');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Connected successfully"; // Check if this message appears
}

function validatePassword($pass)
{
    $hasMinLength = strlen($pass) >= 8;
    $hasUppercase = preg_match('/[A-Z]/', $pass);
    $hasLowercase = preg_match('/[a-z]/', $pass);
    $hasNumber = preg_match('/[0-9]/', $pass);
    $hasSpecialChar = preg_match('/[!@#\$%\^&*\(\){}\>\<,\.\?\/\+\-\=\[\]\~\`\\\\|;:\'"]/', $pass);

    return $hasMinLength && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar;
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validateMobileNumber($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile) === 1;
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

if (!$stmt->bind_param("siissssssssssssssss", $fullname, $mobile, $parentmob, $email, $hashpass, $dob, $hobbies, $skills, $english, $blood_group, $mediclaim, $college, $field, $per_10, $per_12, $diploma, $bachelor, $master, $imageName)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    exit;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
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

    echo " $mobile <br>";
    echo "$parent_mobile<br>";
    echo "$password<br>";
    echo "$hobbies<br>";
    echo "$mediclaim<br>";
    echo "$college_name<br>";
    echo "$field<br>";
    echo "$per_10<br>";
    echo "$per_12<br>";
    echo "$diploma<br>";
    echo "$bachelor<br>";
    echo "$fullname<br>";

    if (empty($email) || empty($mobile) || empty($parent_mobile) || empty($cPassword) || empty($password)) {
        echo "<script>alert('Please fill out all required fields.')</script>";
    } elseif (!validateEmail($email)) {
        echo "<script>swal('Email is invalid');</script>";
    } elseif (!validateMobileNumber($mobile)) {
        echo "<script>swal('Mobile no. is not valid.')</script>";
    } elseif (!validatePassword($password)) {
        echo "<script>swal('Password criteria does not match','It should contain at least \\n1 Uppercase \\n1 Special Character \\nMinimum 8 characters ')</script>";
    } elseif (strcasecmp($password, $cPassword) !== 0) {
        echo "<script>swal({
            title: 'Password and confirm password do not match.',
            icon: 'error',
            buttons: {
                confirm: {
                    className: 'alert-button'
                }
            }
        });</script>";
    } elseif (!checkStudentExistence($mysqli, $email, $mobile)) {
        echo "<script>swal('Error','Email or Mobile no. is already registered.','warning')</script>";
    } elseif (!checkStudentExistenceName($mysqli, $fullname)) {
        echo "<script>swal('Error','Name is already registered.','warning')</script>";
    } else {
        if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            register($mysqli,$fullname, $mobile, $parent_mobile, $email, $password, $dob, $hobbies, $skills, $english, $blood_group, $mediclaim, $college_name, $field, $per_10, $per_12, $diploma, $bachelor, $master, $_FILES['photo']);
        } else {
            echo "<script>alert('Image upload failed.')</script>";
        }
    }
}

mysqli_close($mysqli);
?>

</body>
</html>