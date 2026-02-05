<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) die("Distribution ID missing");

// Fetch distribution
$stmt = $pdo->prepare("SELECT * FROM aid_distribution WHERE distribution_id = ?");
$stmt->execute([$id]);
$dist = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$dist) die("Distribution not found");

// Fetch stock items for dropdown
$stockStmt = $pdo->query("SELECT item_name, item_type, quantity_available FROM stock");
$stockItems = $stockStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = (int) $_POST['quantity'];
    $recipient = !empty($_POST['recipient']) ? (int) $_POST['recipient'] : null;

    // Calculate change in distributed quantity
    $change = $quantity - $dist['quantity_distributed'];

    // Check if enough stock if increasing
    if ($change > 0) {
        $stockCheck = $pdo->prepare("SELECT quantity_available FROM stock WHERE item_name = ?");
        $stockCheck->execute([$dist['item_name']]);
        $stock = $stockCheck->fetch(PDO::FETCH_ASSOC);
        if ($change > $stock['quantity_available']) die("Not enough stock to increase quantity");
    }

    // Update distribution
    $update = $pdo->prepare("UPDATE aid_distribution SET quantity_distributed = ?, distributed_to = ? WHERE distribution_id = ?");
    $update->execute([$quantity, $recipient, $id]);

    // Update stock
    $updateStock = $pdo->prepare("UPDATE stock SET quantity_available = quantity_available - ? WHERE item_name = ?");
    $updateStock->execute([$change, $dist['item_name']]);

    header("Location: Aid.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Distribution</title>
</head>
<body>
<h2>Edit Distribution</h2>
<form method="POST">
    <label>Item: <?= htmlspecialchars($dist['item_name']) ?></label><br>
    <label>Quantity:</label>
    <input type="number" name="quantity" value="<?= $dist['quantity_distributed'] ?>" required /><br>
    <label>Recipient (Refugee ID):</label>
    <input type="number" name="recipient" value="<?= $dist['distributed_to'] ?>" /><br>
    <button type="submit">Update</button>
</form>
</body>
</html>
