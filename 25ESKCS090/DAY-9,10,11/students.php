<?php 
include 'db_connect.php'; 
include 'header.php'; 
//indrajeet

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));
    $sql = "SELECT * FROM students WHERE name LIKE '%$search%' OR branch LIKE '%$search%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM students ORDER BY id DESC";
}
?>

<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white p-3">
            <div class="row align-items-center">
                <div class="col-md-6"><h4 class="mb-0 fw-bold">SKIT Registered Database</h4></div>
                <div class="col-md-6">
                    <form method="GET" action="students.php" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search by name or branch..." value="<?php echo $search; ?>">
                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th class="text-center">CGPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $row_class = ($row['cgpa'] >= 8.5) ? 'table-success fw-semibold' : '';
                            echo "<tr class='$row_class'>";
                            echo "<td class='text-center'><img src='".$row['photo']."' class='rounded-circle' width='45' height='45' style='object-fit:cover; border:1px solid #ddd;'></td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['branch'] . "</td>";
                            echo "<td class='text-center text-primary fw-bold'>" . $row['cgpa'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center text-muted py-4'>No matching student records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>