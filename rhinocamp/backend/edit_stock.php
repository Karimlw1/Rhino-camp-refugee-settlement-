<?php
include 'db.php';

// Handle edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stock_id'])) {
    $stmt = $pdo->prepare("UPDATE stock SET item_name = ?, quantity = ?, description = ? WHERE stock_id = ?");
    $stmt->execute([
        $_POST['item_name'],
        $_POST['quantity'],
        $_POST['description'],
        $_POST['stock_id']
    ]);
    header("Location: edit_stock.php");
    exit;
}

// Fetch all stock items
$stmt = $pdo->query("SELECT * FROM stock ORDER BY stock_id DESC");
$stock_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Edit Stock - Rhino Camp</title>
<link rel="shortcut icon" href="camp-rhino-header.jpg" type="image/x-icon" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #ffffff, #e9ecf0, #e7edf3);
  color: #0a4d8c;
  min-height: 100vh;
}
header {
  width: 100%;
  background: #0a4d8c;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  position: sticky;
  top: 0;
  z-index: 10;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}
header img.banklogo { width: 260px; border-radius: 8px; border: 2px solid #00bfff; }
.nav-links2 a {
  color: #eee; text-decoration: none; padding: 10px 16px; margin: 0 4px;
  border-radius: 6px; font-weight: 500; transition: 0.3s ease;
}
.nav-links2 a:hover { background: rgba(255, 255, 255, 0.15); color: #00d4ff; }
.nav-links2 a.active { background: #0a4d8c; color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.3); }
.header3 button {
  background: linear-gradient(90deg, #00bfff, #0040ff); border: none; color: white; padding: 8px 15px;
  border-radius: 6px; cursor: pointer; font-weight: 600; transition: 0.3s;
}
.header3 button:hover { background: #0078d7; transform: translateY(-2px); }
.container { max-width: 1000px; margin: 70px auto 40px; padding: 20px; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.15);}
th, td { padding: 12px; border-bottom: 1px solid #ccc; text-align: left; }
th { background: #0a4d8c; color: #fff; }
tr:hover { background: #e0f0ff; }
input[type="text"], input[type="number"] {
  width: 100%; padding: 6px 8px; border-radius: 5px; border: 1px solid #ccc;
}
.btn {
  background: #00bfff; color: white; border: none; padding: 6px 12px;
  border-radius: 5px; cursor: pointer; font-weight: 500; transition: 0.3s; text-decoration: none;
}
.btn:hover { background: #0078d7; }
.btn-delete { background: #ff4d4d; }
.btn-delete:hover { background: #cc0000; }
h1 { text-align: center; margin-top: 40px; color: #23496d; }
</style>
</head>
<body>
<header>
  <div class="header1">
    <img class="banklogo" src="camp-rhino-header.jpg" alt="Rhino Logo" />
  </div>
  <div class="header2">
    <nav class="nav-links2">
      <a href="admin.html"><i class="fa fa-home"></i> Home</a>
      <a href="refugees.html"><i class="fa fa-users"></i> Refugees</a>
      <a href="inventory&logistics.html" class="active"><i class="fa fa-boxes"></i> Inventory and logistics</a>
      <a href="Aid.html"><i class="fa fa-hand-holding-heart"></i> Aid distribution</a>
      <a href="Stuff.html"><i class="fa fa-user-tie"></i> Staff</a>
    </nav>
  </div>
  <div class="header3">
    <a href="index.html"><button><i class="fa fa-sign-out-alt"></i> Log Out</button></a>
  </div>
</header>

<h1>Edit Stock Items</h1>
<div class="container">
  <table>
    <thead>
      <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($stock_items as $item): ?>
      <tr>
        <form method="POST" action="edit_stock.php">
          <td><input type="text" name="item_name" value="<?= htmlspecialchars($item['item_name']) ?>" required></td>
          <td><input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" required></td>
          <td>
                <textarea name="description" rows="2"><?= htmlspecialchars($item['description'], ENT_QUOTES) ?></textarea>
         </td>

          <td>
            <input type="hidden" name="stock_id" value="<?= $item['stock_id'] ?>">
            <button type="submit" class="btn"><i class="fa fa-edit"></i> Save</button>
            <a href="delete_stock.php?id=<?= $item['stock_id'] ?>" 
               onclick="return confirm('Are you sure you want to delete this item?');" 
               class="btn btn-delete"><i class="fa fa-trash"></i> Delete</a>
          </td>
        </form>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($stock_items)): ?>
      <tr><td colspan="4" style="text-align:center;">No stock items found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
