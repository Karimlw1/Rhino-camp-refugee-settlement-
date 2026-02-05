<?php
include 'db.php';

// Make sure donation_id is passed
if (!isset($_GET['id'])) {
    die("Donation ID not specified.");
}

$donation_id = intval($_GET['id']); // sanitize input

// Use the correct column name
$stmt = $pdo->prepare("DELETE FROM donations WHERE donation_id = :donation_id");
$stmt->execute([':donation_id' => $donation_id]);

// Redirect back to pending donations
header("Location: pending_donations.php");
exit;
?>
