<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $anonymous = isset($_POST['anonymous']) ? 1 : 0;
    $aid_item = $_POST['aid_item'];
    $quantity = $_POST['quantity'];
    $note = $_POST['note'];

    if (empty($aid_item) || $quantity <= 0) {
        die("Invalid input.");
    }

    $stmt = $pdo->prepare("
        INSERT INTO donations 
        (donor_name, anonymous, donation_type, item_name, quantity, note) 
        VALUES 
        (:donor_name, :anonymous, 'HealthAid', :item_name, :quantity, :note)
    ");

    $stmt->execute([
        ':donor_name' => $name,
        ':anonymous' => $anonymous,
        ':item_name' => $aid_item,
        ':quantity' => $quantity,
        ':note' => $note
    ]);

    echo "Thank you for donating $quantity of $aid_item!";
}
?>
