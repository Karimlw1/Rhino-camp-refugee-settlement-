<?php
include 'db.php';

// Fetch all distributions
$stmt = $pdo->query("SELECT * FROM aid_distribution ORDER BY distribution_date DESC");
$distributions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch stock items for dropdown
$stockStmt = $pdo->query("SELECT item_name, category, quantity 
                          FROM stock 
                          WHERE quantity > 0");
$stockItems = $stockStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aid Distribution - Rhino Camp</title>
  <link rel="shortcut icon" href="camp-rhino-header.jpg" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #ffffff, #e9ecf0, #e7edf3); color: #0a4d8c; min-height: 100vh; }
    header { width: 100%; background: #0a4d8c; display: flex; justify-content: space-between; align-items: center; padding: 15px 40px; position: sticky; top: 0; z-index: 10; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25); }
    header img.banklogo { width: 260px; border-radius: 8px; border: 2px solid #00bfff; }
    .nav-links2 a { color: #eee; text-decoration: none; padding: 10px 16px; margin: 0 4px; border-radius: 6px; font-weight: 500; transition: 0.3s ease; }
    .nav-links2 a:hover { background: rgba(255,255,255,0.15); color: #00d4ff; }
    .nav-links2 a.active { background: #0a4d8c; color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.3); }
    .header3 button { background: linear-gradient(90deg, #00bfff, #0040ff); border: none; color: white; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: 600; transition: 0.3s; }
    .header3 button:hover { background: #0078d7; transform: translateY(-2px); }
    .container { max-width: 1000px; margin: 70px auto 40px; padding: 20px; }
    h1 { text-align: center; margin-top: 40px; color: #23496d; }
    table { width: 140%; justify-self:center; border-collapse: collapse; margin-top: 20px; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.15);}
    th, td { padding: 12px; border-bottom: 1px solid #ccc; text-align: left; }
    th { background: #0a4d8c; color: #fff; }
    tr:hover { background: #e0f0ff; }
    .action-btn { background: #00bfff; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; font-weight: 500; transition: 0.3s; text-decoration: none; }
    .action-btn:hover { background: #0078d7; }
    .form-container { width: 140%; justify-self:center; ;background: #fff; padding: 20px; margin-top: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
    .form-container label { display: block; margin-top: 10px; font-weight: 500; }
    .form-container input, .form-container select { width: 100%; padding: 8px; margin-top: 4px; border-radius: 4px; border: 1px solid #ccc; }
    .form-container button { margin-top: 15px; background: #0a4d8c; color: white; padding: 10px 18px; border-radius: 6px; border: none; cursor: pointer; transition: 0.3s; }
    .form-container button:hover { background: #0078d7; }
      .bg {
        background-image: url("RF1438388.webp");
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        width: 100%;
        height: 60vh;
        position: absolute;
        z-index: -1;
      }
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
      <a href="inventory&logistics.html"><i class="fa fa-boxes"></i> Inventory and logistics</a>
      <a href="aid_distribution.php" class="active"><i class="fa fa-hand-holding-heart"></i> Aid distribution</a>
      <a href="stuff.php"><i class="fa fa-user-tie"></i> Staff</a>
      <a href="outsiders.php"><i class="fa fa-phone"></i> OUTSIDERS</a>
    </nav>
  </div>
  <div class="header3">
    <a href="index.html"><button><i class="fa fa-sign-out-alt"></i> Log Out</button></a>
  </div>
</header>

     <div class="bg"></div>

<h1 style="text-align: center; margin-top: 590px">Aid Distribution Dashboard</h1>

<div class="container">
  <table>
    <thead>
      <tr>
        <th>Item Name</th>
        <th>Category</th>
        <th>Available</th>
        <th>Distributed</th>
        <th>Recipient ID</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($distributions as $dist): ?>
      <tr>
        <td><?= htmlspecialchars($dist['item_name']) ?></td>
        <td><?= htmlspecialchars($dist['item_type'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($dist['quantity_available'] ?? 0) ?></td>
        <td><?= htmlspecialchars($dist['quantity_distributed']) ?></td>
        <td><?= htmlspecialchars($dist['distributed_to'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($dist['distribution_date']) ?></td>
        <td>
          <a href="edit_distribution.php?id=<?= $dist['distribution_id'] ?>" class="action-btn"><i class="fa fa-edit"></i> Edit</a>
          <a href="delete_distribution.php?id=<?= $dist['distribution_id'] ?>" onclick="return confirm('Delete this distribution?');" class="action-btn"><i class="fa fa-trash"></i> Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($distributions)): ?>
        <tr><td colspan="7" style="text-align:center;">No distributions yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Add Distribution Form -->
  <div class="form-container">
    <h2>Add New Distribution</h2>
    <form method="POST" action="process_distribution.php">
      <label for="item_name">Select Item:</label>
      <select name="item_name" id="item_name" required>
        <option value="">-- Select --</option>
        <?php foreach($stockItems as $item): ?>
          <option value="<?= htmlspecialchars($item['item_name']) ?>">
            <?= htmlspecialchars($item['item_name']) ?> (<?= $item['category'] ?>) - <?= $item['quantity'] ?> available
          </option>
        <?php endforeach; ?>
      </select>

      <label for="quantity">Quantity to Distribute:</label>
      <input type="number" name="quantity" id="quantity" min="1" required />

      <label for="recipient">Recipient ID (optional):</label>
      <input type="number" name="recipient" id="recipient" placeholder="Leave blank if unknown" />

      <button type="submit"><i class="fa fa-plus"></i> Distribute</button>
    </form>
  </div>
</div>
</body>
</html>
