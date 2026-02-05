<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Rhino Camp - Stock</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

* { box-sizing: border-box; margin:0; padding:0; }
body { font-family:"Poppins", sans-serif; background: linear-gradient(135deg,#ffffff,#e9ecf0,#e7edf3); color:#0a4d8c; min-height:100vh;}
header { width:100%; background:#0a4d8c; display:flex; justify-content:space-between; align-items:center; padding:15px 40px; position:sticky; top:0; z-index:10; box-shadow:0 4px 10px rgba(0,0,0,0.25);}
header img.banklogo { width:260px; border-radius:8px; border:2px solid #00bfff;}
.nav-links2 a { color:#eee; text-decoration:none; padding:10px 16px; margin:0 4px; border-radius:6px; font-weight:500; transition:0.3s ease; }
.nav-links2 a:hover { background: rgba(255,255,255,0.15); color:#00d4ff; }
.nav-links2 a.active { background:#0a4d8c; color:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.3); }

.container { max-width:1000px; margin:70px auto 40px; padding:20px; display:grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap:20px; }

.dashboard-card { background: rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); border-radius:10px; padding:25px 15px; text-align:center; color:#0a4d8c; transition:all 0.3s ease; box-shadow:0 2px 8px rgba(0,0,0,0.15); text-decoration:none;}
.dashboard-card:hover { transform:translateY(-5px); background: rgba(255,255,255,0.15); box-shadow:0 6px 15px rgba(0,0,0,0.25);}
.dashboard-card i { font-size:2rem; margin-bottom:10px; color:#00bfff; }
.dashboard-card h3 { margin:0; font-size:1.1rem; font-weight:500; color:#23496d; }
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
      <a href="inventory&logistics.html" class="active"><i class="fa fa-boxes"></i> Inventory</a>
    </nav>
  </div>
</header>

<h1 style="text-align:center; margin-top:40px;">CURRENT STOCK</h1>
<div class="container">
<?php
include 'db.php';
$stmt = $pdo->query("SELECT * FROM stock ORDER BY added_at DESC");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<a class="dashboard-card">';
    echo '<i class="fa fa-box"></i>';
    echo '<h3>'.htmlspecialchars($row['item_name']).'</h3>';
    echo '<p>Qty: '.htmlspecialchars($row['quantity']).' '.htmlspecialchars($row['unit']).'</p>';
    if(!empty($row['category'])) echo '<p>Category: '.htmlspecialchars($row['category']).'</p>';
    echo '<p>Added by: '.htmlspecialchars($row['added_by']).'</p>';
    echo '</a>';
}
?>
</div>
</body>
</html>
