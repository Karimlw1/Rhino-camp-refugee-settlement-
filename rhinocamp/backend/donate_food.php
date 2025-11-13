

<?php
$donation_type = $_POST['donation_type'] ?? '';
$name = $_POST['name'] ?? '';
$anonymous = $_POST['anonymous'] ?? 0;
$amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;

if ($donation_type === 'Money') {
    $stmt = $pdo->prepare("
        INSERT INTO donations (donor_name, anonymous, donation_type, amount)
        VALUES (:donor_name, :anonymous, 'Money', :amount)
    ");
    $stmt->execute([
        ':donor_name' => $name,
        ':anonymous' => $anonymous,
        ':amount' => $amount
    ]);
    echo "Thank you for donating $" . $amount . "!";
} elseif ($donation_type === 'HealthAid' || $donation_type === 'Food') {
    $item_name = $_POST['item_name'] ?? '';
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $note = $_POST['note'] ?? '';

    if (empty($item_name) || $quantity <= 0) die("Invalid input.");

    // Insert into donations
    $stmt = $pdo->prepare("
        INSERT INTO donations (donor_name, anonymous, donation_type, item_name, quantity, note)
        VALUES (:donor_name, :anonymous, :donation_type, :item_name, :quantity, :note)
    ");
    $stmt->execute([
        ':donor_name' => $name,
        ':anonymous' => $anonymous,
        ':donation_type' => $donation_type,
        ':item_name' => $item_name,
        ':quantity' => $quantity,
        ':note' => $note
    ]);

    // Add to stock
    $stmt2 = $pdo->prepare("
        INSERT INTO stock (item_name, quantity, unit, category, added_by)
        VALUES (:item_name, :quantity, 'pcs', :category, 'Donation')
    ");
    $stmt2->execute([
        ':item_name' => $item_name,
        ':quantity' => $quantity,
        ':category' => $donation_type
    ]);

    // Mark donation as processed
    $donation_id = $pdo->lastInsertId();
    $stmt3 = $pdo->prepare("UPDATE donations SET processed = 1 WHERE donation_id = :id");
    $stmt3->execute([':id' => $donation_id]);

    echo "Thank you! $quantity unit(s) of $item_name have been added to $donation_type stock.";
} else {
    die("Unknown donation type.");
}
?>
