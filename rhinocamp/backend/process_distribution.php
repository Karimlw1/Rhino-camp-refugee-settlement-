<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = (int) $_POST['quantity'];
    $recipient = !empty($_POST['recipient']) ? (int) $_POST['recipient'] : null;

    // Fetch stock info
    $stmt = $pdo->prepare("SELECT category, quantity FROM stock WHERE item_name = ?");
    $stmt->execute([$item_name]);
    $stock = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$stock) {
        die("Item not found in stock.");
    }

    if ($quantity > $stock['quantity']) {
        die("Not enough stock available. Max available: {$stock['quantity']}");
    }

    // Insert into aid_distribution
    $insert = $pdo->prepare("INSERT INTO aid_distribution 
        (item_name, item_type, quantity_available, quantity_distributed, distributed_to) 
        VALUES (:item_name, :item_type, :quantity_available, :quantity_distributed, :distributed_to)");

    $insert->execute([
        ':item_name' => $item_name,
        ':item_type' => $stock['category'], // map stock.category to aid_distribution.item_type
        ':quantity_available' => $stock['quantity'] - $quantity,
        ':quantity_distributed' => $quantity,
        ':distributed_to' => $recipient
    ]);

    // Update stock table
    $updateStock = $pdo->prepare("UPDATE stock SET quantity = quantity - ? WHERE item_name = ?");
    $updateStock->execute([$quantity, $item_name]);

    header("Location: aid_distribution.php");
    exit;
}
?>
