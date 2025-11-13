<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = (int)$_POST['quantity'];
    $unit = $_POST['unit'];
    $category = $_POST['category'];

    if (empty($item_name) || $quantity <= 0) {
        die("Invalid input.");
    }

    $stmt = $pdo->prepare("INSERT INTO stock (item_name, quantity, unit, category, added_by) VALUES (:item_name, :quantity, :unit, :category, 'Internal')");
    $stmt->execute([
        ':item_name' => $item_name,
        ':quantity' => $quantity,
        ':unit' => $unit,
        ':category' => $category
    ]);

    echo "Stock added successfully: $quantity $unit of $item_name.";
}
?>
