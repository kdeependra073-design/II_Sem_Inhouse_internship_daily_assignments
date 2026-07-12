<?php 
include 'db_connect.php'; 
include 'header.php'; 
?>

<div class="container">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0 fw-bold">SKIT Registered Students List</h4>
            <a href="index.php" class="btn btn-warning btn-sm fw-bold">Add New Student</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th class="text-center">CGPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM students ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $row_class = ($row['cgpa'] >= 8.5) ? 'table-success fw-semibold' : '';
                            echo "<tr class='$row_class'>";
                            echo "<td class='text-center'>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['branch'] . "</td>";
                            echo "<td class='text-center text-primary fw-bold'>" . $row['cgpa'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center text-muted py-4'>No student records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>