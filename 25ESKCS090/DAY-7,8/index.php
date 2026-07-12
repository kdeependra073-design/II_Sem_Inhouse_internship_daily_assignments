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

    if (empty($name)) { $errors[] = "Name fill karna mandatory hai."; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "Valid SKIT Email ID daalein."; }
    if (empty($branch)) { $errors[] = "Apni branch select karein."; }
    if (!is_numeric($cgpa) || $cgpa < 0 || $cgpa > 10) { $errors[] = "CGPA 0.00 se 10.00 ke bich honi chahiye."; }

    if (count($errors) == 0) {
        $sql = "INSERT INTO students (name, email, branch, cgpa) VALUES ('$name', '$email', '$branch', '$cgpa')";
        if (mysqli_query($conn, $sql)) {
            $success_msg = "Student $name successfully register ho gaya hai.";
        } else {
            $errors[] = "Error: Email pehle se exist karta hai! " . mysqli_error($conn);
        }
    }
}
?>

<div class="container" style="max-width: 600px;">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0 fw-bold">SKIT Student Registration Form</h4>
        </div>
        <div class="card-body p-4">
            <?php 
            if (!empty($errors)) {
                echo '<div class="alert alert-danger"><ul class="mb-0">';
                foreach ($errors as $error) { echo '<li>'.$error.'</li>'; }
                echo '</ul></div>';
            }
            if (!empty($success_msg)) {
                echo '<div class="alert alert-success fw-bold">'.$success_msg.'</div>';
            }
            ?>
            <form method="POST" action="index.php">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="username@skit.ac.in" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Branch</label>
                    <select name="branch" class="form-select" required>
                        <option value="">-- Select Department --</option>
                        <option value="Computer Science">Computer Science (CSE)</option>
                        <option value="Information Technology">Information Technology (IT)</option>
                        <option value="Electronics & Comm.">Electronics & Comm. (ECE)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Current CGPA</label>
                    <input type="number" step="0.01" name="cgpa" class="form-control" placeholder="e.g. 8.75" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Register Student</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>