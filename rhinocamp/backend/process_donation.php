<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donation_id = $_POST['donation_id'];

    // Get donation details
    $stmt = $pdo->prepare("SELECT * FROM donations WHERE donation_id = ?");
    $stmt->execute([$donation_id]);
    $donation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($donation) {
        // Insert into stock
        $stmt2 = $pdo->prepare("INSERT INTO stock (item_name, quantity, source) VALUES (?, ?, 'Donation')");
        $stmt2->execute([$donation['item_name'], $donation['quantity']]);

        // Mark donation as processed
        $stmt3 = $pdo->prepare("UPDATE donations SET status = 'Processed' WHERE donation_id = ?");
        $stmt3->execute([$donation_id]);

        header("Location: pending_donations.php");
        exit;
    } else {
        echo "Donation not found.";
    }
}
?>
