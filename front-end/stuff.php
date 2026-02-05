<?php
include 'db.php';

// Fetch all staff members
$stmt = $pdo->query("SELECT * FROM staff ORDER BY hire_date DESC");
$staffList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Staff Dashboard - Rhino Camp</title>
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
table { width: 120%;justify-self:center;
   border-collapse: collapse; margin-top: 20px; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.15);}
th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
th { background: #0a4d8c; color: #fff; }
tr:hover { background: #e0f0ff; }
.action-btn { background: #00bfff; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; font-weight: 500; transition: 0.3s; text-decoration: none; }
.action-btn:hover { background: #0078d7; }
.form-container { width: 120%;justify-self:center;  background: #fff; padding: 20px; margin-top: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
.form-container label { display: block; margin-top: 10px; font-weight: 500; }
.form-container input, .form-container select { width: 100%; padding: 8px; margin-top: 4px; border-radius: 4px; border: 1px solid #ccc; }
.form-container button { margin-top: 15px; background: #0a4d8c; color: white; padding: 10px 18px; border-radius: 6px; border: none; cursor: pointer; transition: 0.3s; }
.form-container button:hover { background: #0078d7; }
.status-active { color: green; font-weight: bold; }
.status-inactive { color: red; font-weight: bold; }
  .bg {
        background-image: url("staff-bg.jpg");
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
      <a href="refugees."><i class="fa fa-users"></i> Refugees</a>
      <a href="inventory&logistics.html"><i class="fa fa-boxes"></i> Inventory and logistics</a>
      <a href="aid_distribution.php"><i class="fa fa-hand-holding-heart"></i> Aid distribution</a>
      <a href="Stuff.php" class="active"><i class="fa fa-user-tie"></i> Staff</a>
      <a href="outsiders.php"><i class="fa fa-phone"></i> OUTSIDERS</a>
    </nav>
  </div>
  <div class="header3">
    <a href="index.html"><button><i class="fa fa-sign-out-alt"></i> Log Out</button></a>
  </div>
</header>

        <div class="bg"></div>

<h1 style="text-align: center; margin-top: 590px">Staff Management Dashboard</h1>

<div class="container">

  <table>
    <thead>
      <tr>
        <th>Full Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Hire Date</th>
        <th>Fire Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($staffList as $staff): ?>
      <tr>
        <td><?= htmlspecialchars($staff['first_name'].' '.$staff['last_name']) ?></td>
        <td><?= htmlspecialchars($staff['email']) ?></td>
        <td><?= htmlspecialchars($staff['role']) ?></td>
        <td class="<?= strtolower($staff['status'])=='active' ? 'status-active':'status-inactive' ?>">
          <?= htmlspecialchars($staff['status']) ?>
        </td>
        <td><?= htmlspecialchars($staff['hire_date']) ?></td>
        <td><?= htmlspecialchars($staff['fire_date'] ?? 'N/A') ?></td>
        <td>
          <a href="edit_staff.php?id=<?= $staff['staff_id'] ?>" class="action-btn"><i class="fa fa-edit"></i> Edit</a>
          <a href="delete_staff.php?id=<?= $staff['staff_id'] ?>" onclick="return confirm('Delete this staff member?');" class="action-btn" style=" background-color:red ; margin-right: 20px"><i class="fa fa-trash"></i> Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($staffList)): ?>
        <tr><td colspan="7" style="text-align:center;">No staff members yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Add Staff Form -->
  <div class="form-container">
    <h2>Add New Staff Member</h2>
    <form method="POST" action="process_staff.php">
      <label for="first_name">First Name:</label>
      <input type="text" name="first_name" id="first_name" required />

      <label for="last_name">Last Name:</label>
      <input type="text" name="last_name" id="last_name" required />

      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required />

      <label for="role">Role:</label>
      <input type="text" name="role" id="role" placeholder="e.g., Volunteer, Nurse, Admin" required />

      <label for="status">Status:</label>
      <select name="status" id="status" required>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <label for="hire_date">Hire Date:</label>
      <input type="date" name="hire_date" id="hire_date" required />

      <label for="fire_date">Fire Date (optional):</label>
      <input type="date" name="fire_date" id="fire_date" />

      <button type="submit"><i class="fa fa-plus"></i> Add Staff</button>
    </form>
  </div>
</div>
</body>
</html>
