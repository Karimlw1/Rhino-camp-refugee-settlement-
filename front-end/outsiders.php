<?php
// see_contacts.php
require_once 'db.php'; // make sure $pdo is defined here

// Fetch all contact submissions
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY submitted_at DESC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rhino Camp - Contact Submissions</title>
  <link rel="shortcut icon" href="camp-rhino-header.jpg" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #ffffff, #e9ecf0, #e7edf3);
      color: #0a4d8c;
      min-height: 100vh;
    }

    header {
      width: 100%;
      background: #0a4d8c;
      backdrop-filter: blur(6px);
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
      color: #eee; text-decoration: none;
      padding: 10px 16px; margin: 0 4px; border-radius: 6px;
      font-weight: 500; transition: 0.3s ease;
    }
    .nav-links2 a:hover { background: rgba(255,255,255,0.15); color: #00d4ff; }
    .nav-links2 a.active { background: #0a4d8c; color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.3);}
    .header3 button {
      background: linear-gradient(90deg, #00bfff, #0040ff);
      border: none; color: white; padding: 8px 15px; border-radius: 6px;
      cursor: pointer; font-weight: 600; transition: 0.3s;
    }
    .header3 button:hover { background: #0078d7; transform: translateY(-2px); }

    .container {
      max-width: 1200px;
      margin: 70px auto 40px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .card {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      transition: all 0.3s ease;
    }

    .card:hover { transform: translateY(-3px); background: rgba(255,255,255,0.15); }

    .card h3 { margin-bottom: 10px; color: #23496d; }
    .card p { margin-bottom: 5px; font-size: 0.95rem; color: #555; }
    .card small { font-size: 0.8rem; color: #888; }

    @media (max-width: 768px) {
      header { flex-direction: column; padding: 15px 20px; }
      .nav-links2 { margin-top: 10px; display: flex; flex-wrap: wrap; justify-content: center; }
      .header3 { margin-top: 10px; }
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
          <a href="refugees.html" class="active"
            ><i class="fa fa-users"></i> Refugees</a
          >
          <a href="inventory&logistics.html"
            ><i class="fa fa-boxes"></i> Inventory & Logistics</a
          >
          <a href="aid_distribution.php"
            ><i class="fa fa-hand-holding-heart"></i> Aid distubution</a
          >
          <a href="stuff.php"><i class="fa fa-user-tie"></i> Staff</a>
          <a href="outsiders.php" class="active"><i class="fa fa-phone"></i> OUTSIDERS</a>
        </nav>
      </div>

      <div class="header3">
        <a href="index.html"
          ><button><i class="fa fa-sign-out-alt"></i> Log Out</button></a
        >
      </div>
    </header>
  <h1 style="text-align:center; margin-top:40px;">Contact Submissions</h1>
  <div class="container">
    <?php if(count($contacts) === 0): ?>
      <p style="text-align:center; color:#555;">No submissions yet.</p>
    <?php else: ?>
      <?php foreach($contacts as $c): ?>
        <div class="card">
          <h3><?= htmlspecialchars($c['name']) ?> <?= !empty($c['anonymous']) ? '(Anonymous)' : '' ?></h3>
          <p><strong>Email:</strong> <?= htmlspecialchars($c['email']) ?></p>
          <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($c['message'])) ?></p>
          <small>Submitted at: <?= date('d M Y, H:i', strtotime($c['submitted_at'])) ?></small>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
