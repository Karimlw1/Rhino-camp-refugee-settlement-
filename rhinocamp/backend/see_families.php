<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM family ORDER BY family_id ASC");
$families = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>See Families</title>
<style>
  body { font-family: Arial, sans-serif; margin: 0; background: #f0f4f8; color: #001f3f; }
  header { background: #004080; padding: 15px 20px; color: white; display: flex; justify-content: space-between; align-items: center; }
  header nav a { color: white; margin: 0 10px; text-decoration: none; }
  .container { max-width: 800px; margin: 80px auto; padding: 20px; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; }
  th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
  th { background: #0a4d8c; color: white; }
</style>
</head>
<body>
<header>
  <div class="logo"><h1>Rhino Camp</h1></div>
  <nav>
    <a href="refugees_dashboard.html">&larr; Dashboard</a>
  </nav>
</header>

<div class="container">
  <h2>Families List</h2>
  <table>
    <thead>
      <tr>
        <th>Family ID</th>
        <th>Family Name</th>
        <th>Head of Family</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($families as $f): ?>
      <tr>
        <td><?= htmlspecialchars($f['family_id']) ?></td>
        <td><?= htmlspecialchars($f['family_name']) ?></td>
        <td><?= htmlspecialchars($f['head_of_family']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
