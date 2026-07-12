<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKIT Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="index.php">SKIT Jaipur Portal</a>
        <div class="navbar-nav ms-auto align-items-center">
            <span class="text-white-50 me-3">Welcome, <?php echo $_SESSION['username']; ?></span>
            <a class="nav-link text-white btn btn-sm btn-outline-primary px-3 me-2" href="index.php">Register</a>
            <a class="nav-link text-white btn btn-sm btn-outline-success px-3 me-2" href="students.php">Student List</a>
            <a class="btn btn-sm btn-danger px-3 text-white" href="logout.php">Logout</a>
        </div>
    </div>
</nav>