<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $role       = trim($_POST['role'] ?? '');
    $status     = $_POST['status'] ?? 'Active';
    $hire_date  = $_POST['hire_date'] ?? '';
    $fire_date  = !empty($_POST['fire_date']) ? $_POST['fire_date'] : null;

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($role) || empty($hire_date)) {
        die("Please fill in all required fields.");
    }

    try {
        // Insert into staff table
        $stmt = $pdo->prepare("INSERT INTO staff (first_name, last_name, email, role, status, hire_date, fire_date) 
                               VALUES (:first_name, :last_name, :email, :role, :status, :hire_date, :fire_date)");
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name'  => $last_name,
            ':email'      => $email,
            ':role'       => $role,
            ':status'     => $status,
            ':hire_date'  => $hire_date,
            ':fire_date'  => $fire_date
        ]);

        // Redirect back to staff dashboard
        header("Location: StaffDashboard.php?success=1");
        exit;

    } catch (PDOException $e) {
        die("Error adding staff member: " . $e->getMessage());
    }
} else {
    // Invalid access
    header("Location: StaffDashboard.php");
    exit;
}
?>
