<?php
include 'db.php';

// DELETE refugee
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM refugees WHERE refugee_id = :id");
    $stmt->execute([':id' => $delete_id]);
    $message = "<div class='alert error'>Refugee ID $delete_id removed successfully.</div>";
}

// UPDATE refugee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $family_id = $_POST['family_id'] ?: null;

    $stmt = $pdo->prepare("
        UPDATE refugees 
        SET first_name = :first_name,
            last_name = :last_name,
            dob = :dob,
            age = :age,
            gender = :gender,
            family_id = :family_id
        WHERE refugee_id = :id
    ");
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':dob' => $dob,
        ':age' => $age,
        ':gender' => $gender,
        ':family_id' => $family_id,
        ':id' => $update_id
    ]);

    $message = "<div class='alert success'>Refugee ID $update_id updated successfully!</div>";
}

// FETCH all refugees
$refugees = $pdo->query("SELECT * FROM refugees ORDER BY refugee_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Refugee</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #004080, #0074D9);
  color: #fff;
  margin: 0;
  padding: 0;
}
header {
  background: rgba(0, 0, 0, 0.2);
  padding: 15px 25px;
  text-align: center;
  font-size: 1.8em;
  font-weight: 600;
  letter-spacing: 1px;
  color: #fff;
}
.container {
  max-width: 1000px;
  margin: 40px auto;
  background: #f8f9fb;
  border-radius: 12px;
  box-shadow: 0 4px 25px rgba(0,0,0,0.2);
  padding: 25px;
  color: #001f3f;
}
h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #004080;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 30px;
  border-radius: 10px;
  overflow: hidden;
}
th {
  background: #004080;
  color: #fff;
  text-transform: uppercase;
  font-size: 0.9rem;
}
td, th {
  padding: 12px 15px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}
tr:nth-child(even) {
  background: #f1f4f9;
}
tr:hover {
  background: #e0eafc;
  cursor: pointer;
}
button.delete {
  background-color: #dc3545;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 6px 10px;
  cursor: pointer;
  transition: 0.3s;
}
button.delete:hover {
  background-color: #b02a37;
}
form {
  background: linear-gradient(145deg, #ffffff, #f1f1f1);
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
label {
  display: block;
  margin-top: 15px;
  font-weight: 600;
  color: #004080;
}
input, select {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  margin-top: 6px;
  font-size: 1rem;
}
button.submit {
  margin-top: 20px;
  width: 100%;
  padding: 12px;
  font-size: 1.1rem;
  font-weight: 600;
  background-color: #004080;
  border: none;
  color: #fff;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s;
}
button.submit:hover {
  background-color: #002b5c;
}
.alert {
  text-align: center;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
  font-weight: 600;
}
.alert.success {
  background-color: #d4edda;
  color: #155724;
}
.alert.error {
  background-color: #f8d7da;
  color: #721c24;
}
footer {
  text-align: center;
  color: #fff;
  padding: 15px;
  margin-top: 40px;
  font-size: 0.9rem;
}
</style>
</head>
<body>

<header><i class="fa-solid fa-people-roof"></i> Refugee Management - Edit & Remove</header>

<div class="container">

  <?= $message ?? '' ?>

  <h2>Registered Refugees</h2>
  <table id="refugeeTable">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>DOB</th>
      <th>Age</th>
      <th>Gender</th>
      <th>Family ID</th>
      <th>Action</th>
    </tr>
    <?php foreach ($refugees as $r): ?>
      <tr onclick="fillForm(<?= htmlspecialchars(json_encode($r)) ?>)">
        <td><?= htmlspecialchars($r['refugee_id']) ?></td>
        <td><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?></td>
        <td><?= htmlspecialchars($r['dob']) ?></td>
        <td><?= htmlspecialchars($r['age']) ?></td>
        <td><?= htmlspecialchars($r['gender']) ?></td>
        <td><?= htmlspecialchars($r['family_id']) ?></td>
        <td>
          <a href="?delete_id=<?= $r['refugee_id'] ?>" onclick="return confirm('Are you sure you want to remove this refugee?')">
            <button class="delete"><i class="fa fa-trash"></i> Remove</button>
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <h2><i class="fa fa-pen-to-square"></i> Edit Refugee Information</h2>
  <form method="POST">
    <label for="update_id">Refugee ID:</label>
    <input type="number" name="update_id" id="update_id" required>

    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" required>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" required>

    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" id="dob" required>

    <label for="age">Age:</label>
    <input type="number" name="age" id="age" required>

    <label for="gender">Gender:</label>
    <select name="gender" id="gender" required>
      <option value="">--Select--</option>
      <option value="M">Male</option>
      <option value="F">Female</option>
      <option value="Other">Other</option>
    </select>

    <label for="family_id">Family ID:</label>
    <input type="number" name="family_id" id="family_id">

    <button class="submit" type="submit"><i class="fa fa-save"></i> Update Refugee</button>
  </form>
</div>

<footer>© <?= date('Y') ?> Rhino Camp Refugee Management System</footer>

<script>
function fillForm(refugee) {
  document.getElementById('update_id').value = refugee.refugee_id;
  document.getElementById('first_name').value = refugee.first_name;
  document.getElementById('last_name').value = refugee.last_name;
  document.getElementById('dob').value = refugee.dob;
  document.getElementById('age').value = refugee.age;
  document.getElementById('gender').value = refugee.gender;
  document.getElementById('family_id').value = refugee.family_id || '';
  window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
}
</script>

</body>
</html>
