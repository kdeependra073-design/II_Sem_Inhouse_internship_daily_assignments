<?php 
include 'db_connect.php'; 
include 'header.php'; 

$errors = [];
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $cgpa = trim($_POST['cgpa']);
    $photo_name = "default.png"; 

    // Photo Upload Check
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $photo_name = time() . "_" . $filename;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_name);
        } else {
            $errors[] = "Only JPG, JPEG, and PNG images allowed!";
        }
    }

    if (empty($name)) { $errors[] = "Name fill karna zaroori hai."; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "Valid email address daalein."; }

    if (count($errors) == 0) {
        $sql = "INSERT INTO students (name, email, branch, cgpa, photo) VALUES ('$name', '$email', '$branch', '$cgpa', '$photo_name')";
        if (mysqli_query($conn, $sql)) {
            $success_msg = "Student registered successfully with Photo!";
        } else {
            $errors[] = "Database failed: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0 fw-bold">SKIT Student Registration Form</h4>
        </div>
        <div class="card-body p-4">
            <?php 
            if (!empty($errors)) {
                echo '<div class="alert alert-danger"><ul class="mb-0">';
                foreach ($errors as $error) { echo '<li>'.$error.'</li>'; }
                echo '</ul></div>';
            }
            if (!empty($success_msg)) { echo '<div class="alert alert-success">'.$success_msg.'</div>'; }
            ?>
            <form method="POST" action="index.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Branch</label>
                    <select name="branch" class="form-select" required>
                        <option value="Computer Science">Computer Science (CSE)</option>
                        <option value="Information Technology">Information Technology (IT)</option>
                        <option value="Electronics">Electronics (ECE)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">CGPA</label>
                    <input type="number" step="0.01" name="cgpa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Student Profile Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Register Student</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>