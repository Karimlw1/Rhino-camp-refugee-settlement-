<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $family_name = trim($_POST['family_name']);
    $head_of_family = trim($_POST['head_of_family']); 

    if (empty($family_name)) {
        die("Family name cannot be empty.");
    }
    if (empty($head_of_family)) {
        die("Head of family name cannot be empty.");
    }

    
    $stmt = $pdo->prepare("INSERT INTO family (family_name, head_of_family) VALUES (:family_name, :head_of_family)");
    $stmt->execute([
        ':family_name' => $family_name,
        ':head_of_family' => $head_of_family
    ]);

    echo "Family '$family_name' with Head of Family '$head_of_family' has been added successfully!<br>";
    echo "<a href='add_family_form.html'>Add Another Family</a> | <a href='see_families.php'>View Families</a>";
}
?>
