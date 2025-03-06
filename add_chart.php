<?php
// add_chart.php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chart_name = trim($_POST['chart_name'] ?? '');
    $chart_type = trim($_POST['chart_type'] ?? '');
    $data_url = trim($_POST['data_url'] ?? '');

    if ($chart_name && $chart_type && $data_url) {
        $stmt = $db->prepare("INSERT INTO charts (user_id, chart_name, chart_type, data_url) VALUES (:user_id, :chart_name, :chart_type, :data_url)");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':chart_name' => $chart_name,
            ':chart_type' => $chart_type,
            ':data_url' => $data_url
        ]);
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Chart</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <h1>Add New Chart</h1>
  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>
  <form method="post" action="add_chart.php">
    <label>Chart Name: <input type="text" name="chart_name" required></label><br>
    <label>Chart Type:
      <select name="chart_type" required>
        <option value="bar">Bar Chart</option>
        <option value="line">Line Chart</option>
        <option value="pie">Pie Chart</option>
        <option value="ring">Ring Chart</option>
        <option value="stacked">Stacked Bar Chart</option>
        <option value="gauge">Radial Gauge Chart</option>
      </select>
    </label><br>
    <label>Data URL: <input type="text" name="data_url" required></label><br>
    <input type="submit" value="Add Chart">
  </form>
  <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>

