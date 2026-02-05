<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $family_id = $_POST['family_id'] ?? null;

    if (!$first_name || !$last_name || !$dob || !$gender) {
        die("Please fill all required fields.");
    }

    $stmt = $pdo->prepare("INSERT INTO refugees (first_name, last_name, dob, age, gender, family_id) 
                           VALUES (:first_name, :last_name, :dob, :age, :gender, :family_id)");
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':dob' => $dob,
        ':age' => $age,
        ':gender' => $gender,
        ':family_id' => $family_id ?: null
    ]);

    echo "Refugee $first_name $last_name registered successfully!";
}
?>
