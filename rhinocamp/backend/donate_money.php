<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donor_name = !empty($_POST['name']) ? $_POST['name'] : 'Anonymous';
    $amount = floatval($_POST['amount']);

    if ($amount <= 0) {
        die("Invalid donation amount.");
    }

    $stmt = $pdo->prepare("INSERT INTO donations (donor_name, donation_type, amount) VALUES (:donor_name, 'Money', :amount)");
    $stmt->execute([
        ':donor_name' => $donor_name,
        ':amount' => $amount
    ]);

    echo "Thank you for your donation of €" . number_format($amount, 2);
}
?>
