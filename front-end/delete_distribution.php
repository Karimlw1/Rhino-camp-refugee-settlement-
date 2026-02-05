<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) die("Distribution ID missing");

// Fetch distribution to restore stock
$stmt = $pdo->prepare("SELECT item_name, quantity_distributed FROM aid_distribution WHERE distribution_id = ?");
$stmt->execute([$id]);
$dist = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$dist) die("Distribution not found");

// Delete distribution
$del = $pdo->prepare("DELETE FROM aid_distribution WHERE distribution_id = ?");
$del->execute([$id]);

// Restore stock
$updateStock = $pdo->prepare("UPDATE stock SET quantity_available = quantity_available + ? WHERE item_name = ?");
$updateStock->execute([$dist['quantity_distributed'], $dist['item_name']]);

header("Location: Aid.html");
exit;
?>
