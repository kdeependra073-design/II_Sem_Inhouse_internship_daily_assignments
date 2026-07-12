<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "admin@skit.ac.in" && $password == "12345") {
        $_SESSION['username'] = "SKIT Admin";
        header("Location: students.php");
        exit();
    } else {
        $error = "Invalid SKIT Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SKIT Portal Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-secondary d-flex align-items-center" style="height: 100vh;">
<div class="container" style="max-width: 400px;">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white text-center py-3">
            <h5 class="mb-0 fw-bold">SKIT Portal Login</h5>
        </div>
        <div class="card-body p-4">
            <?php if(!empty($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email (admin@skit.ac.in)</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password (12345)</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">Login to Portal</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>