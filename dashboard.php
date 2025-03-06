<?php
// dashboard.php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch charts for this user
$stmt = $db->prepare("SELECT * FROM charts WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$charts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Charts Control Panel</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
  <p><a href="logout.php">Logout</a></p>
  <h2>Your Charts</h2>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>Chart Name</th>
      <th>Chart Type</th>
      <th>Data URL</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($charts as $chart): ?>
    <tr>
      <td><?php echo htmlspecialchars($chart['id']); ?></td>
      <td><?php echo htmlspecialchars($chart['chart_name']); ?></td>
      <td><?php echo htmlspecialchars($chart['chart_type']); ?></td>
      <td><?php echo htmlspecialchars($chart['data_url']); ?></td>
      <td>
        <a href="edit_chart.php?id=<?php echo $chart['id']; ?>">Edit</a> |
        <a href="delete_chart.php?id=<?php echo $chart['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  <p><a href="add_chart.php">Add New Chart</a></p>

  <!-- Optional: Place for previewing charts (integrate charts.js rendering) -->
  <div id="chartsDisplay">
    <h2>Charts Preview</h2>
    <div id="chartGrid" class="grid-container">
      <!-- Charts will be rendered here by JavaScript -->
    </div>
  </div>
  <script src="js/charts.js"></script>
  <script src="js/codigo.js"></script>
</body>
</html>

